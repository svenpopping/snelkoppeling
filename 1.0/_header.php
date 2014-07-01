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
    	
    	<link rel="dns-prefetch" href="//cdn.regner.us">
    	<link rel="dns-prefetch" href="//ajax.googleapis.com">
	    <link rel="dns-prefetch" href="//platform.twitter.com">
	    <link rel="dns-prefetch" href="//connect.facebook.net" />
	    <link rel="dns-prefetch" href="//www.google-analytics.com">

        <title>De beste gratis dating matches uit jouw omgeving! | Snelkoppeling Dating</title> <!-- Pagina titel -->
		
        <link rel="stylesheet" href="//snelkoppeling.info/css/style.css"> <!-- Laad de reset stylesheet. -->
        <link rel="stylesheet" href="//snelkoppeling.info/css/snelkoppeling.css"> <!-- Laad de stylesheet. -->
        
        
        <link rel="shortcut icon" href="//snelkoppeling.info/favicon.ico">
		<link rel="apple-touch-icon-precomposed" href="//snelkoppeling.info/favicon.ico">
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
		<meta property="og:image" content="//snelkoppeling.info/snelkoppeling_ogimage.png" />
		<meta property="og:site_name" content="Snelkoppeling" />
		
		<meta property="fb:app_id" content="248846045219138" />

        <script type="text/javascript" src="//cdn.regner.us/js/head.js"></script>
        <script type="text/javascript" src="//localhost/jquery.localscroll-1.2.7-min.js"></script>
        
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
							<a href="//snelkoppeling.info" rel="home" title="De beste gratis matches uit jouw omgeving!">
								<img src="//snelkoppeling.info/images/snelkoppeling-32.png" alt="Snelkoppeling" /> Snelkoppeling</a>
						</h1>
						<h5 class="tagline">De beste gratis matches uit jouw omgeving!</h5>
					</hgroup>				
												
				</div>
				<div role="section">
					<nav id="navigation">
						<!-- Wanneer een gebruiker is ingelogd een Loguit button geven en anders een Homepagina button -->
						<?php 
							if (!empty($_SESSION['user_name'])) {
								echo '<a href="//snelkoppeling.info/login/sessions/destroy/" class="button">Uitloggen</a>';
							}
							else echo '<a href="//snelkoppeling.info/" class="button"><i class="home"></i> Homepagina</a>';
						 ?>
					</nav>
				</div>
			</section>
		</header>

		<br /><hr />
		
		<!-- Main Content -->
		
		<section id="main hfeed" role="main">