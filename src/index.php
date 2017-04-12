<!DOCTYPE html>
<html lang="en">

    <?php
      include('includes/headers.php');
      include('includes/navbar.php');
      include('includes/footers.php');
      print getHeaders('Hack My World',0);
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
                        <h1>Hack My World</h1>
                        <span class="subheading">
                            "We shall not cease from exploration, and the end of all our exploring will be to arrive where we started and know the place for the first time." - T.S. Eliot
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <p>
                        <ul class="list-inline text-center">
                            <a href="https://www.bitcoin.com/">BTC: 1NShkkR36bpdnd2d8GSXFWD7hrrwuJt3qb</a>
                        </ul>
                    </p>
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
