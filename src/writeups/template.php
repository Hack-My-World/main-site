<!DOCTYPE html>
<html lang="en">

    <?php
      include('../../includes/headers.php');
      include('../../includes/navbar.php');
      include('../../includes/footers.php');
      include('../../includes/Parsedown.php');
      print getHeaders('ctf-name',2);
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
                            <img src="logo-img-goes-here" width="" height="" alt="logo" align="">
                        </h2>
                        <span class="meta">Posted by <a href="#">kablaa</a> date </span>
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
                        <a href="#chall-name" class = "list-group-item">chall-name<span class ="badge">cat-pts</span></a>
                    </div>
                </div>
        </div>
    </div>
    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <h1 id="#chall-name">chall-name (cat-pts)</h1>
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
