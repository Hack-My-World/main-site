<!DOCTYPE html>
<html lang="en">


    <?php
      include('../includes/headers.php');
      include('../includes/navbar.php');
      include('../includes/footers.php');
      print getHeaders('Hack My World - projects',1);
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
                <div class="col-lg-12 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1>An Introduction To CTFs</h1>
                        <span class="subheading">Knowledge should be shared, not hoarded</span>
                        <span class="meta">Posted by <a href="#">kablaa</a> September, 2016</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- index -->
    <div class="container">
        <div class = "row">
                <div class="post-body col-lg-12 col-lg-offset-0 col-md-10 col-md-offset-1">
                    <div claa = "list-group">
                        <a href="#welcome" class = "list-group-item">Introduction</a>
                        <a href="#linux" class = "list-group-item">Linux</a>
                        <a href="#assembly" class = "list-group-item">Assembly / Reverse Engineering </a>
                        <a href="#python" class = "list-group-item">Python Scripting</a>

                        <a href="#tools" class = "list-group-item">Tools</a>
                    </div>
                </div>
        </div>
    </div>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-12 col-lg-offset-0 col-md-10 col-md-offset-1">

<h1 id="welcome">Welcome!</h1>

<p>This is a guide that was written with intention of taking you through the process of learning how to play <a href="https://en.wikipedia.org/wiki/Capture_the_flag#Computer_security">Capture the Flag</a> (CTF). This is by no means intended to be a comprehensive tutorial. Our intention here is simply to provide you with the tools you need to become familiar with the game and get started on your quest to become a leet hacker.</p>

<h3>Prerequisites</h3>

<p>This guide assumes that you have a working knowledge of the C programming language. We do not expect you to be an enterprise level developer; however, we will assume a working knowledge of functions, variables, pointers, etc. A basic understanding of <a href="http://www.python.org">Python</a> is also highly recommended. While we will be going over the aspects of Python scripting that are most important to CTFs, reading through a few <a href="http://www.tutorialspoint.com/python">tutorials</a> will be extremely helpful. If you have never programmed before, or do not feel you are comfortable with these concepts, the great interwebs is full of comprehensive <a href="http://www.tutorialspoint.com/computer_programming/">tutorials and guides</a>. A computer capable of handling a Linux virtual machine is also required.</p>

<h3>What is Capture the Flag?</h3>

<p>CTFs are competitions in which players are given challenges related to several fields of cyber security. <a href="http://www.github.com/ctfs">Challenges</a> usually fall into one of the following categories:</p>

<ul>
<li><a href="https://en.wikipedia.org/wiki/Reverse_engineering">Reverse Engineering</a></li>
<li><a href="https://en.wikipedia.org/wiki/Executable">Binary</a> Exploitation</li>
<li>Web</li>
<li>Cryptography</li>
<li>Forensics</li>
</ul>

<p>Normally, players will specialize in one of these categories. Although it is possible to have a basic knowledge of all of them, we suggest you begin by focusing on the one that interests you most. This guide will be focusing On Binary Exploitation.</p>


<h1 id="linux">Get yo-self some Linux</h1>

<p>Pretty much any CTF worth it's salt is going to require a working knowledge of <a href="https://en.wikipedia.org/wiki/Linux">Linux</a>. Binary exploitation challenges in particular are almost exclusively limited to the Linux environment. What is Linux you ask? Well, it's an operating System. However, unlike Windows or the Apple OS, Linux is <a href="https://en.wikipedia.org/wiki/Open_source">open source</a>, so it's completely free! Also, because Linux is open source, developers have the opportunity to create various styles or flavors of Linux. These styles of Linux are referred to as Distributions. We recommend getting <a href="http://www.ubuntu.com">Ubuntu</a>, as it is the most popular and beginner friendly distro.</p>

<p>When it comes to getting Linux, you basically you have four options:</p>

<ul>

   <li>Wipe your current OS and replace it with Linux,</li>
   <li>Dual boot your Current OS with Linux</li>
   <li>Boot Linux off of a USB driver</li>
   <li>Get a <a href="https://en.wikipedia.org/wiki/Virtual_machine">Virtual Machine</a></li>
</ul>


<p>We suggest getting a virtual machine. Learning your way around the Linux environment can be a daunting task if you are new to computers or are not familiar with using a terminal, so having a disposable system on which you can practice and experiment is incredibly advantageous.</p>

<h3>Setting up your virtual machine</h3>

<p>In theory, setting up an Ubuntu virtual machine should be relatively easy; however, you may encounter one of several bugs or errors due to no fault of your own. Because every situation is different, we will not be able to enumerate every possible challenge you may come across while setting up your VM. As with everything else in Computer Science, <a href="http://www.google.com">Google</a> is your best friend. Make sure to read all errors carefully and to search for any error codes.</p>

<p>The first thing you need to do is <a href="http://www.virtualbox.org">download</a> some virtualization software. The next thing you will need is a <a href="http://www.ubuntu.com/download/desktop">.iso file</a>. Once you have successfully acquired both of those things, you can follow one of several <a href="https://jtreminio.com/2012/04/setting-up-an-ubuntu-vm-step-by-step/">tutorials</a> to get your VM up and running.</p>

<h3>Enabling Virtualization</h3>

<p>Due to the infinite wisdom of many hardware manufacturers these days, you may need to enable virtualization on your motherboard.
<a href="http://www.howtogeek.com/213795/how-to-enable-intel-vt-x-in-your-computers-bios-or-uefi-firmware/">here</a> is a tutorial on how to do that.</p>

<h3>Virtualbox Guest Additions</h3>

<p>If you successfully get your virtual machine up and running, you may notice that you can not maximize the screen. This is because you need to install the <a href="http://askubuntu.com/questions/22743/how-do-i-install-guest-additions-in-a-virtualbox-vm">virtualbox guest additions</a>. If you can successfully do this, you should a very nice desktop environment to work with.</p>

<h3>Learning Linux Commands</h3>

<p><a href="http://www.linuxcommand.org">Learning the Linux command line</a> is absolutely vital to cyber security of any kind. Pretty much every executable in a CTF will be run via the command line, and most tools available for CTFs are command line based. Plus, you can make the text green and look just like those super leet hackers you see in the movies all the time. If you haven't used a terminal before, we would highly recommend spending some time learning your way around the Linux environment. In particular, opening and <a href="https://en.wikipedia.org/wiki/Vim_%28text_editor%29">editing files</a>, running executables, and using <a href="https://git-scm.com/">git</a> will be essential for the remainder of this guide.</p>


<h1 id= "assembly">Learn Yo-Self Some Assembly</h1>

<p>Learning <a href="http://www.swansontec.com/sprogram.html">Assembly</a> is probably the most difficult and time consuming challenge for noobies. It can be incredibly intimidating to see hundreds of lines of low level system instructions. But take heart! The truth is, while reading and understanding Assembly can be very time consuming and tedious, it's not very complicated. There are really only a handful of instructions that you need to know off the top of your head. The real challenge is understanding and being able to visualize the stack. This is a topic that is disgracefully glossed over by most introductory programming classes and tutorials. However, with practice and patience, you will find that reading assembly can become almost second nature.</p>
<iframe width="560" height="315" src="https://www.youtube.com/embed/75gBFiFtAb8" frameborder="0" allowfullscreen></iframe>
<p>This video took...a long time to make. I have always felt that the quality of most Youtube tutorials are absolutely abysmal. I hope you enjoy this video and learn something from it. Before continuing with this guide, please study and do your best to understand everything that is covered. Once you feel you have a decent understanding, go to <a href="https://gcc.godbolt.org/">this</a> site and try decompiling some programs. Make sure to set the compiler type to <code>x86 clang 3.7.1</code>, put <code>-m32</code>in the compiler options box,  and set the syntax to <code>Intel</code> Start off with a simple <code>hello_world</code> program. Once you feel you understand what is happening in the assembly, try writing a program with some if-then statements and loops. While at first you may feel confused, keep experimenting.</p>

<p>Again, Google is your best friend. The best advise for learning</p>

<h3>Getting Some Tools</h3>

<h3>Objdump</h3>

<p><code>objdump</code> is a critical tool for most things regarding executables. It allows you to convert the executable into it's assembly equivalent, allowing you to read the instructions it will be executing when it is running. The main command that will be used is:</p>

<p><pre>objdump -d -M intel &lt;input file name&gt; &gt; dump.asm</pre></p>

<p>After you have decompiled the binary, you may open up <code>dump.asm</code> in your favorite text editor. Then, search for the <code>&lt;main&gt;</code>function.</p>

<h3>Strings</h3>

<p><code>strings</code> is a standard tool for most Linux systems that allows you to search for all strings within a particular file. This is very handy for finding bits and pieces of static data within a binary, as you do not have to search for it by hand in a hex editor. For options and how to use them, <code>man strings</code> will tell you everything you need to know (really, its an easy tool to use).</p>

<h3>File</h3>

<p><code>file</code> is a tool that attempts to provide basic information regarding what type of file you provide it. This can be helpful for identifying how to approach a particular binary. An example can be seen below, where we run it against a basic executable:
<pre>
redacted@ubuntu:~$ file a.out
a.out: ELF 64-bit LSB  executable, x86-64, version 1 (SYSV), dynamically linked (uses shared libs), for GNU/Linux 2.6.24, BuildID[sha1]=beb27b3da4fc2e516f2e0279f5c83b4e046fad5f, not stripped
</pre></p>

<h3>Dynamic Analysis</h3>

<p>Performing Dynamic Analysis involves examining and attempting to understand the inner workings of a binary while it is being run. This process usually involves using a <a href="https://en.wikipedia.org/wiki/Debugger">debugger</a> to examine the states of registers, the stack, and the program flow at certain points during execution.</p>

<h3>GDB</h3>

<p><a href="https://www.gnu.org/software/gdb/">GDB</a> is the standard for debugging Linux executables. While learning GDB can be a daunting task for beginners, it is an incredibly powerful tool. There are several <a href="http://www.unknownroad.com/rtfm/gdbtut/">tutorials</a> available for reference and practice. If it does not already come pre-installed on your distro, you can usually get it from an official repository. On Ubuntu, simply run</p>

<pre><code>  sudo apt-get install gdb
</code></pre>

<h3>GDB-PEDA</h3>

<p>PEDA stands for Python Exploit Development Assistance. This tool will make your life exceptionally easier during the debugging process. You can clone it from the <a href="https://github.com/longld/peda">github repository</a> and follow the installation instructions on the README. For more information on PEDA, check out <a href="http://security.cs.pub.ro/hexcellents/wiki/kb/toolset/peda">this</a> tutorial. Note that PEDA requires Python version 2.x, so if you are currently using Python 3.x, you will have to switch your version.</p>

<h3>Practice</h3>

<p>Reversing binaries is inherently difficult, and learning to do it efficiently takes a great deal of time and practice. We suggest spending as much time as possible on sites like <a href="http://reversing.kr/">reversing.kr</a> as well as writing and reversing your own binaries. There are even several <a href="http://www.ece.ualberta.ca/~marcin/aikonsoft/reverse.pdf">books</a> and <a href="http://manoharvanga.com/hackme/">tutorials</a> written and on the subject of reversing Linux binaries.</p>





<h1 id = "python">Python Scripting</h1>

<p>Knowing at least one scripting language will make your life exceptionally easier no matter which field of Computer Science you choose to pursue. Playing CTFs without knowing one is almost impossible. Before we get into Python, let's get this out of the way...</p>

<h3>I Don't Care If You Think Python Sucks</h3>

<p>We chose to go over Python because we felt like it. If you have a problem with that, you can open up EMACS, write your own CTF guide in LaTeX, and talk about how much you love Ruby there. Ok, now that that's over with lets talk about sockets.  </p>

<h3>Sockets</h3>

<p>Most CTFs are going to be hosted on a remote server. For binary challenges, the flag will typically be in the same directory as the binary. You will have to find a way to exploit the binary and get a <a href="https://en.wikipedia.org/wiki/Unix_shell">shell</a>. Once you have the shell, you will usually run</p>

<pre><code>cat flag
</code></pre>

<p>which will print out the contents of the flag. So how do we interact with the binary if it's on another server? The answer is <a href="https://en.wikipedia.org/wiki/Network_socket">sockets</a>. A socket is essentially a network connection between your computer and another computer. Because multiple processes will often require access to a socket at the same time, we use <a href="https://simple.wikipedia.org/wiki/Network_port">ports</a> so that we can connect to whichever specific process we want. There are several ports that are reserved for specific processes such as <a href="https://en.wikipedia.org/wiki/Secure_Shell">SSH</a> (port 22), <a href="https://en.wikipedia.org/wiki/Transmission_Control_Protocol">TCP</a> (port 25), and <a href="https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol">HTTP</a> (port 80). You can go <a href="http://www.tutorialspoint.com/unix_sockets/what_is_socket.htm">here</a> for more information on networking ports.</p>

<p>As far as CTFs go, we have what are referred to as <em>general purose</em> ports. These are just ports that are not being used by any other service. Each challenge will be associated with a specific port. You will typically see something like</p>

<pre>
Challenge:
someCTF.coolhackerurl.we p-6666
</pre>

So what you will have to do is connect to<code>someCTF.coolhackerurl.we</code> on <code>port 6666</code>. Then, instead of the output of the binary being written to <a href="https://en.wikipedia.org/wiki/Standard_streams">stdout</a>, it will be sent though the socket to your computer. Likewise, you will need to send your exploit through the socket.</p>

<p>So how do we connect to sockets? One way is to use <a href="https://www.digitalocean.com/community/tutorials/how-to-use-netcat-to-establish-and-test-tcp-and-udp-connections-on-a-vps">Netcat</a>. Netcat is the simplest way to connect to a socket. Just run</p>

<pre><code>nc someCTF.coolhackerurl.we 6666
</code></pre>

<p>Now, it will be just like you are running the executable on your home machine. You can send input and get output just like you normally would. However, what if you want to send something that can't be typed on a keyboard, like a hexadecimal value?</p>

<h3>Sockets in Python</h3>

<p>Python will allow you to connect to a socket on a port and send whatever data you want, as well as receive data through the socket. Before continuing with this guide, read though a few <a href="http://www.tutorialspoint.com/python/python_networking.htm">tutorials</a> on socket programming in Python. Write some example programs and test out the various types of things you can do with sockets. Remember, you only need a very high level of understanding of sockets in order to play CTFs. So if you find yourself reading about Ethernet II on Wikipedia, you have probably gone too deep.</p>

<h3>Hexadecimal Values in Python</h3>

<p>For most binary challenges, you will need to input <a href="https://en.wikipedia.org/wiki/Hexadecimal">hexadecimal</a> values for a variety of reasons. To do this with python you must create string of hex values and send that string to your executable. For example, in your <code>exploit.py</code>, you can write</p>

<p>
    <pre>
        <code class = "language-python">
myHexString = "\xde\xad\xbe\xef"
print myHexString
        </code>
    </pre>
</p>

<p>and then from the command line,</p>

<p>
    <pre>
python exploit.py | ./&lt;binary&gt;
    </pre>
</p>

<p>This will <a href="http://ryanstutorials.net/linuxtutorial/piping.php">pipe</a> the output of your <code>exploit.py</code> script into your binary.</p>




<h1 id="bof">Buffer Overflows</h1>

<p>A <a href="https://www.owasp.org/index.php/Buffer_overflow_attack">buffer overflow</a> is one of the simplest types of binary exploits. It is usually the first thing that is taught to aspiring hackers, so it will be the first thing we go over in this guide. There are many many <a href="http://www.thegeekstuff.com/2013/06/buffer-overflow/">examples</a>, and <a href="http://ehsandev.com/pico2014/binary_exploitation/overflow1.html">writeups</a> available online. My personal favorite is this
<a href="https://free.codebashing.com/free-content/cplus/c_stack_p1#/lesson/stack overflows/objectives?_k=hqlzvq">interactive buffer overflow</a>, which provides an excellent visualization of exactly what is happening during the exploit.</p>


<h1 id = "tools">Tools</h1>

<p>Now that you have a decent understanding of basic concepts, we can start making your life easer with some tools.</p>

<h3>struct.pack()</h3>

<p>If you are having problems with <a href="http://www.geeksforgeeks.org/little-and-big-endian-mystery/">endianness</a>, you can use <code>struct.pack()</code> to make your life easier.  We suggest reading though a few <a href="https://docs.python.org/2/library/struct.html#examples">examples</a> and <a href="https://pymotw.com/2/struct/">tutorials</a> to better understand this function and what it does. A basic example would be</p>

<pre>
<code class = language-python>
from struct import *
myHexString = struct.pack("&ltI",0xdeadbeef)
print myHexString
</code>
</pre>



<h3>pwntools</h3>

<p><a href="https://github.com/Gallopsled/pwntools">pwntools</a> is awesome. Once you start using it, you will wonder how you ever lived without it. Socket programming, packing hex values, and just about every other aspect of CTFs is made easier by this wonderful tool. For example, instead of using <code>struct.pack()</code>, you can do</p>

<pre>
    <code class="language-python">
from pwn import *
myHexString = p32(0xdeadbeeef)
print myHexString
    </code>
</pre>

<p>To find out more, read through <a href="https://docs.pwntools.com/en/stable/">the documentation</a>.</p>

<h3>Python and GDB</h3>

<p>While being able to pipe your exploit into a binary is good, sometimes your exploit won't work and you will have no idea why. To see what is happening, from the command line you can run</p>

<pre><code>python test.py &gt; in
gdb ./&lt;binary&gt;
</code></pre>

<p>Then, in gdb</p>

<pre><code>r &lt; in
</code></pre>

<p>Now, you can step though the assembly and see what happens. If you are playing a <a href="http://pwnable.kr/">wargame</a> and need to pass <a href="http://www.tutorialspoint.com/cprogramming/c_command_line_arguments.htm">command line arguments</a>, in gdb, run</p>

<pre><code>r $(python -c 'print "whatever you want" ')
</code></pre>




<h2>More Resources:</h2>

<p><a href="https://avicoder.me/2016/02/01/smashsatck-revived/">Smash the Stack</a></p>

<p><a href="http://www.cs.fsu.edu/~redwood/OffensiveComputerSecurity/lectures.html">Owen Redwood Lectures</a></p>

<p><a href="https://www.youtube.com/watch?v=iyAyN3GFM7A&amp;list=PLhixgUqwRTjxglIswKp9mpkfPNfHkzyeN">Really good Youtube series</a></p>


    </article>
    <hr>

    <!-- Footer -->
<?php
      print getFooters();
?>

</body>

</html>
