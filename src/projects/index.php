<!DOCTYPE html>
<html lang="en">

    <?php
      include('../includes/headers.php');
      include('../includes/navbar.php');
      include('../includes/footers.php');
      print getHeaders('Projects',1);
    ?>

<body>

    <!-- Navigation -->
    <?php
      print getNavbar(1)
    ?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" >
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Projects</h1>
                        <span class="subheading">Sleeping is for Thursdays</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <p>
                <div class="post-preview">
                    <a href="https://i.blackhat.com/us-18/Thu-August-9/us-18-Lukasiewicz-WebAssembly-A-New-World-of-Native_Exploits-On-The-Web-wp.pdf">
                        <h2 class="post-title">
                            WebAssembly Research
                        </h2>
                        <h3 class="post-sub-title">September, 2018</h3>
                    </a>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="https://youtu.be/75gBFiFtAb8">
                        <h2 class="post-title">
                            x86 Assembly Crash Course Video
                        </h2>
                        <h3 class="post-sub-title">September 2016</h3>
                    </a>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="tutorial.php">
                        <h2 class="post-title">
                            An Introduction to CTFs
                        </h2>
                        <h3 class="post-sub-title">September 2016</h3>
                    </a>
                </div>
                <hr>
                </p>
        </div>
    </div>


    <?php
      print getFooters();
    ?>



</body>
