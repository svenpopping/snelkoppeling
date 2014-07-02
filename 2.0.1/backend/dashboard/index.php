<?php
  require_once("../../login/classes/Login.php");
  $login = new Login();

  if ($login->isAdminLoggedIn() == false) {
    header("Location: //localhost/snelkoppeling/2.0.1/");
  }

  require_once("../../_header.php");

  function deleteID($delete) {
    global $mysqli;

    $mysqli->query("DELETE FROM gegevens WHERE id = {$delete}") or die($mysqli->error);
    $mysqli->query("DELETE FROM answers WHERE person_id = {$delete}") or die($mysqli->error);
    $mysqli->query("DELETE FROM importance WHERE person_id = {$delete}") or die($mysqli->error);
    $mysqli->query("DELETE FROM desired WHERE person_id = {$delete}") or die($mysqli->error);
    $mysqli->query("DELETE FROM matches WHERE A = {$delete} OR B = {$delete}") or die($mysqli->error);
  }

  if(isset($_GET['delete']) && $_GET['delete'] == true) {
    $delete = (isset($_GET['id'])) ? $_GET['id'] : "";
    deleteID($delete);
  }
?>
  <style>
    .stats {
      display: inline-block;
      margin-bottom: 8px;
    }

    .stats .item {
      display: inline-block;

      margin: 0 auto;
      padding:  10px 15px;
      background-color: rgb(187, 45, 35);
      color: #ccc;

      margin-bottom: 10px;
    }

    .stats .item span {
      color: #fff;
    }

    .list_members {
      display: block;
      width: 640px;
      font-size: 12px;
    }

    .list_members thead tr th {
      border-bottom: 1px solid #ccc;
      text-align: left;
      padding: 4px 8px;
      background-color: #ccc;
      font-weight: bold;
    }

    .list_members tbody tr td {
      padding: 4px 8px;
      border-left: 1px dashed #ccc;
    }

    .list_members tbody tr td:last {
      border-right: 1px dashed #ccc;
    }

    .list_members tbody tr:nth-child(2n){
      background-color: #eee;
    }

    .list_members tbody tr:nth-child(2n + 1){
      background-color: #fff;
    }
  </style>
  <section class="stats">
    <div class="item">Totaal leden: 
      <span><?= $mysqli->query("SELECT COUNT(*) FROM gegevens")->fetch_row()[0]; ?></span>
    </div>
    <div class="item">Mannen: 
      <span><?= $mysqli->query("SELECT COUNT(*) FROM gegevens WHERE gender=0")->fetch_row()[0]; ?></span>
    </div>
    <div class="item">Vrouwen: 
      <span><?= $mysqli->query("SELECT COUNT(*) FROM gegevens WHERE gender=1")->fetch_row()[0]; ?></span>
    </div>
    <div class="item">Aantal matches: 
      <span><?= $mysqli->query("SELECT COUNT(*) FROM matches")->fetch_row()[0]; ?></span>
    </div>
    <div class="item">Gemiddeld aantal matches: 
      <span><?= round($mysqli->query("SELECT COUNT(*) FROM matches")->fetch_row()[0] / $mysqli->query("SELECT COUNT(*) FROM gegevens")->fetch_row()[0]); ?></span>
    </div>
    <div class="item">Blocked IPs: 
      <span><?= $mysqli->query("SELECT COUNT(*) FROM blocked_ip")->fetch_row()[0]; ?></span>
    </div>
    <div class="item">Berichten: 
      <span>0</span>
    </div>
  </section>

  <br /><hr />

  <table class="list_members">
    <thead>
      <tr>
        <th>#</th>
        <th>Naam</th>
        <th>Gebruikersnaam</th>
        <th>E-mail Adres</th>
        <th>IP-adres</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql_getMembers = $mysqli->query("SELECT * FROM gegevens");
        $i = 0;
        while($result = $sql_getMembers->fetch_array(MYSQLI_ASSOC)) {
          echo "<tr>
                  <td>".$i."</td>
                  <td>".$result['name']."</td>
                  <td>".$result['username']."</td>
                  <td>".$result['email']."</td>
                  <td>".$result['ip']."</td>
                  <td><a href=?id=".$result['id']."&delete=true>X</a></td>
                </tr>";
          $i++;
        }
      ?>  
    </tbody>
  </table>
<?php
  require_once("../../_footer.php");
?>