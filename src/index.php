<!DOCTYPE html>
<html lang="en">

    <?php
      include('includes/headers.php');
      include('includes/navbar.php');
      include('includes/footers.php');
      print getHeaders('KABLAA!!');
    ?>

<body>

    <!-- Navigation -->
    <?php
    print getNavbar(0);
    ?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" >
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Kablaa</h1>
                        <hr class="small">
                        <span class="subheading">The life and times</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->

    <!-- <hr> -->

    <?php
      print getFooters();
    ?>


</body>
