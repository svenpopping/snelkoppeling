<?php
require_once("../login/classes/Login.php");
require_once("../config.php");
$login = new Login();

if ($login->isUserLoggedIn() == false) {
  header("Location: ".$main_path);
}

require_once('../_header.php');
require_once('../functions.php');

if($_SESSION['verified'] == 0) {
  echo '<div role="alert" class="info"><strong>Let op!</strong><small>U heeft uw e-mailadres nog niet bevestigd. Om gebruikt te kunen maken van de extra mogelijkheden, bevestig dan uw e-mailadres.</small></div><br />';
}

echo '<div role="alert" class="info"><strong>Let op!</strong><small>E-mails verstuurd via snelkoppeling.info kunnen in uw spamfolder terechtkomen. Controleer deze, misschien heeft u wel een berichtje gekregen.</small></div><br />'; 
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('a.back').hide();

    var person_id = "<?= (isset($_GET['person_id'])) ? '?person_id='.$_GET['person_id'].'&get_matches=true' : ''; ?>";
    var user = "<?= (isset($_GET['user'])) ? '?user='.$_GET['user'].'&get_profile=true' : ''; ?>";
    
    var url_profile = "<?= $main_path ?>user_profile/get_profile.php" + user;
    var url_matches = "<?= $main_path ?>user_profile/get_matches.php" + person_id;

    $("#columns__profile").load(url_profile, function(response, status, xhr) {
      if (status == "error") {
        var msg = "Sorry but there was an error: ";
        console.log(msg + xhr.status + " " + xhr.statusText);
      }
    });
    $("#columns__matches").load(url_matches, function(response, status, xhr) {
      if (status == "error") {
        var msg = "Sorry but there was an error: ";
        console.log(msg + xhr.status + " " + xhr.statusText);
      }
    });
  });
</script>
<div style="display: inline-block; margin-bottom: 20px;">
  <a class="back button" style="display: inline-block; width: 39px; margin-right: 10px">Terug</a>
  <h3 style="display: inline-block; padding-top: 3px;">Gebruikersprofiel</h3>
</div>
<section id="columns__profile" class="columns columns__profile" role="structure">
  
</section>

<section id="columns__matches" role="structure"></section>


<?php 
require_once("../_footer.php");
?>