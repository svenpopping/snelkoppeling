<?php
  require_once("../login/classes/Login.php");
  require_once('../config.php');

  // Check if user logged in
  $login = new Login();

  if ($login->isUserLoggedIn() == false) {
    header("Location: ".$main_path);
  }

  // Enanble for admins to see other peoples matches
  if(isset($_SESSION['enable_admin']) && $_SESSION['enable_admin'] === 1) {
    if(isset($_REQUEST['get_matches'])) {
      $user_id = $_REQUEST['person_id'];
    } else {
      $user_id = $_SESSION['user_id'];
    }
  } else {
    $user_id = $_SESSION['user_id'];
  }

  // The query to create a new view with all the matches of the user
  $create_view_select_all_match_ids_query = "CREATE VIEW select_all_matches AS
                        SELECT matches.B AS match_id, matches.match
                          FROM matches
                            WHERE A = '".$user_id."'
                        UNION ALL
                        SELECT matches.A AS match_id, matches.match
                          FROM matches
                            WHERE B = '".$user_id."'
                        ORDER BY `match` DESC";
  // Execute query to create view
  $mysqli->query($create_view_select_all_match_ids_query) or die($mysqli->error);

  // The select query to select all the matches with their personal info
  if($_SESSION['verified'] == 1) {
    $get_matches_query = "SELECT * FROM gegevens INNER JOIN select_all_matches ON gegevens.id = select_all_matches.match_id";
  } else {
    $get_matches_query = "SELECT * FROM gegevens INNER JOIN select_all_matches ON gegevens.id = select_all_matches.match_id LIMIT 0, 10";
  }

  // Execute query
  $get_matches = $mysqli->query($get_matches_query) or die($mysqli->error);

  // Drop view
  $mysqli->query("DROP VIEW select_all_matches") or die($mysqli->error);
  ?>

  <script type="text/javascript" src="<?= $main_path ?>library/jquery/jquery.bxslider.js"> </script>
  <script type="text/javascript" src="<?= $main_path ?>library/jquery/get_matches.js"></script>

  <h3 id="matches">Snelkoppeling Matches <var class="score"><?= $get_matches->num_rows; ?></var></h3>
  
  <dl role="list">
    <ul class="bxslider">
  <?php
  // A while loop to print all the matches
  $i = 1;
  while($matches = $get_matches->fetch_array(MYSQLI_ASSOC)) {
    if($matches['match'] > 0) {
      if((($i - 1) % 10) == 0) {
        echo "<li>";
      }
      ?>
      <div class="all">
        <dt class="name">
          <?= (isset($_SESSION['verified']) AND $_SESSION['verified'] == 1) ? '<a data-href="http:'.$main_path.'user_profile/get_profile.php?user='.urlencode($matches['username']).'">' : ""; ?>
          <?= ($i).". " ?>
            <?= ($matches['username'] == "bouke" || $matches['username'] == "svenpopping") ? '<img src="../library/images/crown-gold-icon.png" style="margin-top: -4px;" title="Administrator" alt="Administrator" /> ' : "" ?>
            <?= ($matches['username'] == "Hiemstra" || $matches['username'] == "sietse") ? '<img src="../library/images/crown-silver-icon.png" style="margin-top: -4px;" title="Overseer" alt="Overseer" /> ' : ""; ?>
          
          <?= ucwords($matches['name']); ?>
          <?= (isset($_SESSION['verified']) AND $_SESSION['verified'] == 1) ? '</a>' : ""; ?>
          <?= (isset($_SESSION['enable_admin']) AND $_SESSION['enable_admin'] == 1) ? '<a href="http:'.$main_path.'user_profile/?user='.urlencode($matches['username']).'&person_id='.$matches['id'].'">=></a>' : ""; ?>
        </dt>
        <dd class="matches">
          <?php echo ($matches['picture'] != "") ? '<a href="//snelkoppeling.info/server/_/large/'.$matches['picture'].'" class="view"><img src="//snelkoppeling.info/server/_/thumbnail/'.$matches['picture'].'" alt="'.$matches['name'].'" class="profile-picture-small" /></a>' : '<img src="//snelkoppeling.info/images/nopicture_thumbnail.jpg" alt="Onbekend" class="profile-picture-small" />'
          ?>
          <div class="info">
            <div class="progress-bar__container">
              <span class="progress" style="width:<?= $matches['match']; ?>%" data-width="<?= $matches['match']; ?>"></span>
            </div> 
            <span><var class="score"><?= $matches['match'] ?>% match</var> met <?= $matches['name']; ?> (<?= $matches['age']; ?> jaar).</span>
            <div class="clear"></div>
          </div>
        </dd>
      </div>
      <div class="clear"></div>
      <?php
      if(($i % 10) == 0) {
        echo "</li>";
      }
      $i++;
    }
  }
  ?>
    </ul>
    <script type="text/javascript">
      $(document).ready(function () {
        $("fieldset ul li.next a").addClass("button");
        $("fieldset ul li.prev a").addClass("button");
      });
    </script>
    <fieldset class="form-actions prev-next" style="margin-top: 20px;">
      <ul>
        <li class="prev"></li>
        <li class="next"></li>
      </ul>
    </fieldset>
  </dl>

