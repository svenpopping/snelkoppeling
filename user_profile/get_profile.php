<?php
require_once("../login/classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == false) {
  header("Location: //localhost/snelkoppeling/2.0.1/");
}

require_once('../config.php');

if(isset($_SESSION['enable_admin']) && $_SESSION['enable_admin'] === 1) {
  if(isset($_REQUEST['get_profile'])) {
    $user_name = $_REQUEST['user'];
  } else {
    if(isset($_GET['user'])) {
      $user_name = $_GET['user'];
    } else {
      $user_id = $_SESSION['user_name'];
      $user_email = $_SESSION['user_email'];
    }
  }
} else {
  if(isset($_GET['user'])) {
    $user_id = $_SESSION['user_id'];
  } else {
    $user_id = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
  }
}

if (isset($_SESSION['enable_admin']) && $_SESSION['enable_admin'] === 1 && isset($_REQUEST['user'])) {
  $personal_info = $mysqli->query('SELECT * FROM gegevens WHERE username="'.$user_name.'"')->fetch_array(MYSQLI_ASSOC);
} else if( isset($_GET['user']) ) {
  if($_SESSION['verified'] == 1) {
    $check_if_match = $mysqli->query('SELECT * FROM matches WHERE (A = "'.$user_id.'" AND B = (SELECT id FROM gegevens WHERE username="'.$_GET['user'].'")) OR (B = "'.$user_id.'" AND A = (SELECT id FROM gegevens WHERE username="'.$_GET['user'].'"))')->num_rows or die($mysqli->error);
    if($check_if_match == 1) {
      $personal_info = $mysqli->query('SELECT * FROM gegevens WHERE username="'.$_GET['user'].'"')->fetch_array(MYSQLI_ASSOC);
    } else {
      echo "error";
    }
  } else {
    $personal_info = $mysqli->query('SELECT * FROM gegevens WHERE username="'.$user_id.'" AND email = "'.$user_email.'"')->fetch_array(MYSQLI_ASSOC);
  }
} else {
  $personal_info = $mysqli->query('SELECT * FROM gegevens WHERE username="'.$user_id.'" AND email = "'.$user_email.'"')->fetch_array(MYSQLI_ASSOC);
}
?>

<!-- <script type="text/javascript" src="//localhost/snelkoppeling/2.0.1/library/jquery/jquery-2.0.2.min.js"> </script> -->
<script type="text/javascript" src="//localhost/snelkoppeling/2.0.1/library/jquery/jquery-te-1.4.0.min.js"> </script>
<script type="text/javascript" src="//localhost/snelkoppeling/2.0.1/library/jquery/get_profile.js"></script>

  
</script>
<div role="section">
    <?= ($personal_info['picture'] != "") ? '<img src="http://snelkoppeling.info/server/_/large/'.$personal_info['picture'].'" alt="'.$personal_info['name'].'" class="profile-picture" />' : '<img src="//snelkoppeling.info/images/nopicture_large.jpg" alt="Onbekend" class="profile-picture" />' ?>
    <?php if (!isset($_GET['user'])) { ?>
    <a href="#" id="change-profile-pic">Profielfoto bewerken</a>
    <form enctype="multipart/form-data" method="POST" action="" id="profile-pic-form" class="questions-form hidden">
      <fieldset>
        <input type="file" id="profielfoto" name="profielfoto" />
      </fieldset>
      <fieldset>
        <input type="submit" id="submit" value="Bewerken" name="submit_profil_pic" />
      </fieldset>
    </form>
    <?php } ?>
  </div>
  <div role="section">  
    <dl role="list">
      <dt>Naam</dt>
        <dd>
          <?php 
            echo ($personal_info['username'] == "bouke" || $personal_info['username'] == "svenpopping") ? '<img src="../library/images/crown-gold-icon.png" style="margin-top: -4px;" title="Administrator" alt="Administrator" /> ' : "";
            echo ($personal_info['username'] == "Hiemstra" || $personal_info['username'] == "sietse") ? '<img src="../library/images/crown-silver-icon.png" style="margin-top: -4px;" title="Overseer" alt="Overseer" /> ' : "";
            echo ucwords($personal_info['name']) 
          ?>
        </dd>
      <dt>Geslacht</dt>
        <dd><?= ($personal_info['gender'] == 0)? "Man" : (($personal_info['gender'] == 1) ? "Vrouw" : "Onbekend") ?></dd>
      <dt>Geaardheid</dt>
        <dd><?= ($personal_info['sexse'] == 0)? "Heteroseksueel" : (($personal_info['sexse'] == 1) ? "Homosexueel" : "Bisexueel") ?></dd>
      <dt>Provincie</dt>
        <dd> <?= $states_names[$personal_info['state']]; ?> </dd>
      <dt>Leeftijd</dt>
        <dd><?=$personal_info['age'] ?> jaar</dd>
      <dt>Email</dt>
        <dd><a href="mailto:<?= $personal_info['email'] ?>"><?= $personal_info['email'] ?></a></dd>
    </dl>             
  </div>
  <dl role="list" style="width: 100%">
    <dt>Over jezelf</dt>
      <dd class="about_yourself" style="padding: 0 10px 0 0;"><?=$personal_info['about_me'] ?></dd>
      <a href="" class="about_yourself_save button" style="display: inline-block;">Save</a>
    </dl>