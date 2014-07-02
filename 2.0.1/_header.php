<?php
  $sid = session_id();
  if(!$sid) session_start();

  require_once("config.php");

  $blocked = "SELECT ip FROM blocked_ip";
  if(!$result = $mysqli->query($blocked)) {
      trigger_error('Fout in query: '.$mysqli->error);
  } else {
    while($block = $result->fetch_array(MYSQLI_ASSOC)){
      if($_SERVER['REMOTE_ADDR'] == $block['ip']) {
        die ("Your IP Address has been blocked");
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
      <meta charset="utf-8">
      
      <!--[if lt IE 7 ]><script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script><script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script><![endif]-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
      <meta http-equiv="cleartype" content="on" />
      
      

        <title>De beste gratis dating matches uit jouw omgeving! | Snelkoppeling Dating</title> <!-- Pagina titel -->
    
        <link rel="stylesheet" href="//localhost/snelkoppeling/2.0.1/library/css/style.css"> <!-- Laad de reset stylesheet. -->
      <link rel="stylesheet" href="//localhost/snelkoppeling/2.0.1/library/css/snelkoppeling.css"> <!-- Laad de stylesheet. -->
        
        
        <link rel="shortcut icon" href="//localhost/snelkoppeling/2.0.1/library/images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="//localhost/snelkoppeling/2.0.1/library/images/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Snelkoppeling">
    
    
    <!-- Metadata voor zoekmachines en Facebook. -->
    
    <meta name="description" content="In jouw omgeving altijd gratis en snel de leukste dates bij Snelkoppeling Dating. De beste dating resultaten in jou eigen provincie.">
    <meta name="keywords" content="Snelkoppeling, Gratis Online Dating, Dating, Gratis Dating Site, Gratis Singles Site, Online Dating, Informatica, Popping, Regnerus, Drachtster Lyceum, Matches, Lokaal, Omgeving, Provincie" />
      
    <meta name="author" content="Sven Popping, Bouke Regnerus" />
    <meta name="Copyright" content="Copyright Sven Popping, Bouke Regnerus (regner.us) Snelkoppeling Dating 2013. All Rights Reserved." />
    
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@snelkoppeling_">
    <meta name="twitter:creator" content="@snelkoppeling_">

    <meta property="og:title" content="De beste gratis matches uit jouw omgeving! | Snelkoppeling Dating" />
    <meta property="og:description" content="In jouw omgeving altijd gratis en snel de leukste dates bij Snelkoppeling Dating. De beste dating resultaten in jou eigen provincie." />
    <meta property="og:url" content="http://snelkoppeling.info" />
    <meta property="og:image" content="//localhost/snelkoppeling/2.0.1/library/images/snelkoppeling_ogimage.png" />
    <meta property="og:site_name" content="Snelkoppeling" />
    
    <meta property="fb:app_id" content="248846045219138" />

    <script type="text/javascript" src="//cdn.regner.us/js/head.js"></script>
    <script type="text/javascript" src="//localhost/snelkoppeling/2.0.1/library/jquery/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="//localhost/snelkoppeling/2.0.1/library/jquery/jquery.bxslider.js"> </script>
    
    <!-- Google niet uiniet  tracker -->
    <script>window._gaq = [['_setAccount', 'UA-39994580-1'],['_trackPageview']];</script>
  </head>
  <body>
  
  <div id="wrapper" class="wrapper">
    <header id="header" role="banner">
      <section class="columns" role="structure">
        <div role="section">
          <hgroup>
            <!-- Titel en logo afbeelding -->
            <h1>
              <a href="./" rel="home" title="De beste gratis matches uit jouw omgeving!">
                <img src="//localhost/snelkoppeling/2.0.1/library/images/snelkoppeling-32.png" alt="Snelkoppeling" /> Snelkoppeling</a>
            </h1>
            <h5 class="tagline">De beste gratis matches uit jouw omgeving!</h5>
          </hgroup>       
                        
        </div>
        <div role="section">
          <nav id="navigation">
            <!-- Wanneer een gebruiker is ingelogd een Loguit button geven en anders een Homepagina button -->
            <?php 
              if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
                      echo '<a href="//localhost/snelkoppeling/2.0.1/login/index.php?logout" class="button">Uitloggen</a>';
                  }
             ?>
          </nav>
        </div>
      </section>
    </header>

    <br /><hr />
    
    <!-- Main Content -->
    
    <section id="main hfeed" role="main">