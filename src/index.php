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
                       <div style="font-size:16px;margin:0 auto;width:300px" class="blockchain-btn" data-address="1NShkkR36bpdnd2d8GSXFWD7hrrwuJt3qb" data-shared="false">
                           <div class="blockchain stage-begin">
                               <img src="https://blockchain.info/Resources/buttons/donate_64.png"/>
                           </div>
                           <div class="blockchain stage-loading" style="text-align:center">
                               <img src="https://blockchain.info/Resources/loading-large.gif"/>
                           </div>
                           <div class="blockchain stage-ready">
                                <p align="center">Please Donate To Bitcoin Address: <b>[[address]]</b></p>
                                <p align="center" class="qr-code"></p>
                           </div>
                           <div class="blockchain stage-paid">
                                Donation of <b>[[value]] BTC</b> Received. Thank You.
                           </div>
                           <div class="blockchain stage-error">
                               <font color="red">[[error]]</font>
                           </div>
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
