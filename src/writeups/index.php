<!DOCTYPE html>
<html lang="en">

    <?php
      include('../includes/headers.php');
      include('../includes/navbar.php');
      include('../includes/footers.php');
      print getHeaders('Writeups');
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
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Writeups</h1>
                        <span class="subheading">Get dem flags, yo</span>
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
                    <a href="Codegate-Prequals-2017.php">
                        <h2 class="post-title">
                            Codegate Prequals 2017
                        </h2>
                        <h3 class="post-sub-title">Feb 14, 2017</h3>
                    </a>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="RC3-2016.php">
                        <h2 class="post-title">
                            RC3-CTF 2016
                        </h2>
                        <h3 class="post-sub-title">November 22nd, 2016</h3>
                    </a>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="Hitcon-2016.php">
                        <h2 class="post-title">
                            HITCON-CTF 2016
                        </h2>
                        <h3 class="post-sub-title">October 8th, 2016</h3>
                    </a>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="TUM-2016.php">
                        <h2 class="post-title">
                            TUM-CTF 2016
                        </h2>
                        <h3 class="post-sub-title">September 30th, 2016</h3>
                    </a>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="CSAW-Quals-2016.php">
                        <h2 class="post-title">
                            CSAW CTF Qualification Round 2016
                        </h2>
                        <h3 class="post-sub-title">September 16th, 2016</h3>
                    </a>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="MMA-2016.php">
                        <h2 class="post-title">
                            Tokyo Westerns/MMA CTF 2nd 2016
                        </h2>
                        <h3 class="post-sub-title">September 03, 2016</h3>
                    </a>
                </div>
                <hr>
                </p>
                <!-- <1!-- Pager --1> -->
                <!-- <ul class="pager"> -->
                <!--     <li class="next"> -->
                <!--         <a href="#">Older Posts &rarr;</a> -->
                <!--     </li> -->
                <!-- </ul> -->
            <!-- </div> -->
        </div>
    </div>

    <!- add the hr when i do more -->
    <!-- <hr> -->


<?php
    print getFooters();
?>


</body>
</html>
