<?php
function getHeaders($title){
    $head =
    "
    <head>

        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>$title</title>
        <link rel='icon' type='image/x-icon' href='favicon.ico' />

        <!-- Bootstrap Core CSS -->
        <link href='../css/bootstrap.min.css' rel='stylesheet'>

        <!-- Custom CSS -->
        <link href='../css/clean-blog.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../css/custom.css'>

        <!-- jQuery -->
        <script src='../js/jquery.js'></script>

        <!-- Bootstrap Core JavaScript -->
        <script src='../js/bootstrap.min.js'></script>

        <!-- Custom Theme JavaScript -->
        <script src='../js/clean-blog.min.js'></script>

        <!-- Prism -->
        <link rel='stylesheet' href='../css/prism.css' >
        <script src='../js/prism.js'> </script>

        <!-- Custom Fonts -->
        <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
            <script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
        <![endif]-->

    </head>
    ";
return $head;
}
?>
