<!DOCTYPE html>
<html lang="en">

    <?php
      include('../../includes/headers.php');
      include('../../includes/navbar.php');
      include('../../includes/footers.php');
      include('../../includes/Parsedown.php');
      print getHeaders('Boston Key Party 2017',2);
    ?>

<body>

    <?php
      print getNavbar(2);
    ?>

    <header class="intro-header" >
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h2>
                            <img src="../../img/bkp-2017-logo.png" width="" height="" alt="logo" align="">
                            Boston Key Party 2017
                        </h2>
                        <span class="meta">Posted by <a href="#">kablaa,</a> March 2017 </span>
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
                        <a href="#sss" class = "list-group-item">Signed Shell Server<span class ="badge">pwn-200</span></a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <h1 id="sss">Signed Shell Server (pwn-200)</h1>
                        <?
                            $f = fopen('sss.md','r');
                            $pd = new Parsedown();
                            echo $pd->text(fread($f,filesize('sss.md')));
                        ?>
                        <pre>
                            <code class='language-python'>
                                <?
                                  $f = fopen('sss-exploit.py','r');
                                  echo fread($f,filesize('sss-exploit.py'));
                                  fclose($f);
                                ?>
                            </code>
                        </pre>
                        <pre>
bkp{and you did not even have to break sha1}
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
