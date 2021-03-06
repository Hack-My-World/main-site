<!DOCTYPE html>
<html lang="en">

    <?php
      include('../includes/headers.php');
      include('../includes/navbar.php');
      include('../includes/footers.php');
      print getHeaders('MMA-2016',1);
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
                        <h1>MMA CTF</h1>
                        <h2 class="subheading">Tokyo Westerns/MMA CTF 2nd 2016</h2>
                        <span class="meta">Posted by <a href="#">kablaa</a> September, 2016</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- begn challenge list -->
    <div class="container">
        <div class = "row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <div claa = "list-group">
                        <a href="#judgement" class = "list-group-item">Judgement <span class ="badge">Pwn-50</span></a>
                    </div>
                    <div claa = "list-group">
                        <a href="#reverse_box" class = "list-group-item">Reverse Box <span class ="badge">Reversing-50</span></a>
                    </div>
                    <div claa = "list-group">
                        <a href="#palindrome" class = "list-group-item">Palindrome <span class ="badge">Programming-50</span></a>
                    </div>
                    <div claa = "list-group">
                        <a href="#ninth" class = "list-group-item">Ninth <span class ="badge">Misc-100</span></a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">

<!-- Judgement -->

    <h1 id="judgement">Judgement (Pwn-50)</h1>

    <p>
    After opening the binary up in IDA, it was pretty obvious that we needed to exploit a format string vulnerability.
    <img src="../img/mma.2016.judgement.main.png" alt="main" align = "middle" >
    It looks like the flag was declared as a global variable, which means it will have a static address in the <code>.bss</code> Section. This definitely makes our lives easier.
        <img src="../img/mma.2016.judgement.flag.png" alt="flag" align = "middle" >
    So the flag is at <code>0x804a0a0</code>. At first I thought I could supply the format string
    <code>
        \xa0\xa0\x04\x08%4$s
    </code>
    which would just print the flag, but then I realized that would not work, since the <code>getline()</code> function ensures that every character is printable.
     <img src="../img/mma.2016.judgement.getline.png" alt="get-line" align = "middle" >

        The next thing I checked was if the address of the flag is anywhere on the stack when <code>printf()</code> is called.
        <pre>
python -c 'print "%x"*30' | ./judgement | grep 804a0a0
Input flag >> 3cf779ead0f7776b48110f7756000f7618c55f778886af7602209f760210df779e00080482e83fa1f75af298f7756d60f76041b8f77886eb804a00021fffb95b8f778ef1084290a0f7633390804a0a0f779e9181
        </pre>
        Great! After a bit of trial and error, I found out that the address I wanted was the 28th value  on the stack. We don't even need a script for this one.

        <pre>
Input flag >> %28$s
        </pre>
        will give us the flag!
    </p>


<!-- Reverse Box -->

    <h1 id="reverse_box">Reverse Box (Reversing-50)</h1>
    <p>
        I found an unintended solution to this one, so I was pretty happy about that. The contents of the flag leads me to believe that I was intended to reverse a substitution cypher. But anyways, here is my solution. It was pretty obvious that I was dealing with some kind of cypher.

        <img src="../img/mma.2016.reverse_box.main.png" alt="" align = "middle" >
        The most important function here is the one that I named <code>getRandStuff()</code>. All it seemed to do was populate <code>v5</code> with random bytes, which would then be used as substitutions for the characters in the flag and printed. However, the only entropy used to generate the random bytes was <code>srand(time(NULL))</code>.
        <img src="../img/mma.2016.reverse_box.original.png" alt="010" align = "middle" >
    </p>
    <p>
    Instead of just the raw binary, they gave us a .7z file. 7-zip preserves the timestamp of the creation of the file. So I figured I should look into that. Running <code>stat</code> on the binary produced the following results:
    <pre>
  File: 'reverse_box'
  Size: 5604        Blocks: 16         IO Block: 4096   regular file
  Device: 801h/2049d  Inode: 1063811     Links: 1
  Access: (0755/-rwxr-xr-x)  Uid: ( 1000/tylerlukasiewicz)   Gid: ( 1000/tylerlukasiewicz)
  Access: 2016-09-06 22:37:38.000000000 -0400
  Modify: 2016-09-02 10:23:53.000000000 -0400
  Change: 2016-09-06 22:37:38.224477030 -0400
 Birth: -
    </pre>

    </p>

<p>
So we know when the binary was created. I went to an <a href="http://www.epochconverter.com/">online unix timestamp converter</a>, which told me that <code>2016-09-02 10:23:53</code> corresponds to the epoch timestamp <code>1472811833</code>, which is <code>0x57c95339</code> in hex. My plan was to patch the binary so that instead of the <code>rand()</code> function being seeded by <code>time(NULL)</code>, it would be seeded by <code>0x57c95339</code>. Then, since each byte in the
hash is independent of every other byte, I would be able to brute force the hash byte by byte.
</p>
<p>
The op-code to move a value into <code>eax</code> is just <code>B8</code>, followed by the four byte value. Of course we have to keep endianness in mind. Since there is extra space between the function prologue and <code>srand()</code>, I just filled all of the extra bytes with <code>0x90</code>.
    <img src="../img/mma.2016.reverse_box.010.png" alt="010" align = "middle" >
        Here is what the assembly looks like after the patch.
    <img src="../img/mma.2016.reverse_box.patched.png" alt="patched" align = "center" >
    Everything looks good to go!
</p>

<p>
The only trouble is that the hash for the flag probably was not created in the same second as when the binary was compiled. This meant I would also have to do a bit of brute forcing on the timestamp. My guess was that the hash was made fairly soon after the binary, so I figured I could probably get away with only brute forcing the least significant bit. So every value between <code>0x57c95339</code> and <code>0x57c953ff</code>
</p>

<p>
Here is my final solution, which (much to my surprise) worked quite splendidly
</p>

    <pre>
    <code class = "language-python">
from pwn import *

def patch(byte):
#getting position of byte to patch
     sequence = '\xE9\x73\xFF\xFF\xFF\x55\x89\xE5\x83\xec\x28\xb8'
     f = open("reverse_box",'rb')
     bts = f.read()
     pos = bts.find(sequence)
     pos = pos + len(sequence)

#createing a temporary list for asignment
     tmp = list(bts)

#patching the byte
     tmp[pos]=chr(byte)

#writing to a temporary test file
     newFile = open('test.elf','w')
     newFile.write("".join(tmp))
#changing permissions so we can test the patch
     subprocess.call(['chmod', '+x','test.elf'])
     f.close()
     newFile.close()

def brute():
    hsh = "95eeaf95ef94234999582f722f492f72b19a7aaf72e6e776b57aee722fe77ab5ad9aaeb156729676ae7a236d99b1df4a"

    bts = []
    i = 0
    while i < len(hsh):
        bts.append(hsh[i:i+2])
        i = i+2

    flag =""
    for byte in bts:
        found = False
        for c in range(0x20,0x7f):
            p = process(['./test.elf' , chr(c)])
            resp =  p.recvline()
            resp = resp.strip('\n')
            if resp == byte:
                flag += chr(c)
                found = True
                break
            print flag
            p.close()
        if found == False:
            print "bad time stamp :("
            return False
    return True

for toPatch in range(0x39,0xff):
    patch(toPatch)
    if brute() == True:
        print "FUCK YEA"
        exit()
        </code>
    </pre>

    <pre>
    TWCTF{5UBS717U710N_C1PH3R_W17H_R4ND0M123D_5-B0X}
    </pre>

<!-- Palindrome -->

    <h1 id="palindrome">Palindrome (Programming-50)</h1>
    <pre>
Your task is to make a palindrome string by rearranging and concatenating given words.

Input Format: N ...

Answer Format: Rearranged words separated by space.

Each words contain only lower case alphabet characters.

Example Input: 3 ab cba c

Example Answer: ab c cba

You have to connect to ppc1.chal.ctf.westerns.tokyo:31111(TCP) to answer the problem.

$ nc ppc1.chal.ctf.westerns.tokyo 31111

Time limit is 3 minutes.

The maximum number of words is 10.

There are 30 cases. You can get flag 1 on case 1. You can get flag 2 on case 30.
    </pre>
     <p>Here is my solution.</p>
    <pre>
    <code class ="language-python">
from itertools import permutations
from pwn import *
import time

def ispalindrome(word):
    return word == word[::-1]


con = remote('ppc1.chal.ctf.westerns.tokyo',31111)

for i in range(1,31):
    con.recvuntil("Case: #%d\nInput: " % i)
    strings =  con.recvline().strip('\n')
    inputList= strings.split(' ')
    con.recvuntil('Answer: ')

    for p in permutations(inputList[1:]):
        concat = ""
        for string in p:
            concat += string
        if  ispalindrome(concat) == True:
            final = ""
            for w in p:
                final += w + " "
            final += '\n'
            print "[+] sending " + final
            con.send(final)
            print con.recvline()
            break
    </code>
    </pre>



    <h1 id="ninth">Ninth (Misc-100)</h1>
    <p>
    I thought this one was a bit easy for the amount of points it was worth. Just use some <a href="http://binwalk.org/">binwalk</a> magic:
    <pre>
        binwalk -e ninth
        cat _ninth.extracted/63
        ...
        ...
        TWCTF{WAMP_Are_You_Ready?}
    </pre>
    </p>
    </article>

    <hr>

    <!-- Footer -->
<?php
      print getFooters();
?>

</body>

</html>
