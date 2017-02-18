<!DOCTYPE html>
<html lang="en">

    <?php
      include('../includes/headers.php');
      include('../includes/navbar.php');
      include('../includes/footers.php');
      print getHeaders('KABLAA!!');
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
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>About Me</h1>
                        <span class="subheading">Who is this kablaa person anyways</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="post-body col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <img src="imgs/rock.jpg" align= "right" width=300 alt="" />
                    <p>
                        Hi there! Welcome to my small corner of the internet. My name is Tyler Lukasiewicz. I began my journey into the world of security in 2013, when I joined the cyber security club at my university, <a href="https://hackucf.org">Hack UCF</a>. At the time, I was a technological illiterate and I was overwhelmed with the wealth of knowledge and skill that I saw in the club. I knew that this was something I wanted to be a part of. After many <b>many</b> hours of banging my head against my keyboard and yelling at my monitor I was able to build up the skills I needed to participate in CTF competitions with my school team, Knightsec. 
                    </p>
                    <p>
                        As time went on, I saw tremendous growth in both my club and myself. In 2016 I was elected Vice President of Hack UCF and the captain of Knightsec. That same year we were granted a sponsorship of $75,000 from Northrop Grumman. At this time I was also becoming more confident in my skills, especially with respect to reverse engineering and binary exploitation. In the summer of 2016, I was given an internship at <a href="http://www.raytheon.com/">Raytheon SI Government Solutions</a>, where I did vulnerability research on Qualcomm's Secure Execution Environment, <a href="http://bits-please.blogspot.com/2016/04/exploring-qualcomms-secure-execution.html">TrustZone</a>. In February 2017, I accepted a full time position as a <b>insert position and company here</b>
                    </p>
<img src="imgs/check.jpg" align="center" width=500 alt="" />
                <hr />
                </div>
            </div>
        </div>
    </article>

    <!-- <hr> -->

    <?php
      print getFooters();
    ?>


</body>
