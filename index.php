<?php
  require_once("login/classes/Login.php");
  require_once("config.php");

  $login = new Login();
  if ($login->isUserLoggedIn() == true) {
    header("Location: ".$main_path."user_profile/");
  }

  if (isset($login)) {
    if ($login->errors) {
      foreach ($login->errors as $error) {
        echo $error;
      }
    }
    if ($login->messages) {
      foreach ($login->messages as $message) {
        echo $message;
      }
    }
  }

  require_once("_header.php");
?>

<nav id="navigation" role="navigation sitemap g two-thirds">
  <!-- Inlog formulier voor bestaande gebruikers -->
  <form method="post" action="<?= $main_path ?>login/index.php" name="loginform">
      <ul class="form-fields multi-list  three-cols">
        <li class="float-left">
          <input id="login_input_username" class="text-input login_input" type="text" name="user_name" placeholder="Gebruikersnaam" required />
        </li>
          <li class="float-left">
            <input id="login_input_password" class="text-input login_input" type="password" name="user_password" placeholder="Wachtwoord" autocomplete="off" required />
          </li>
          <li><input type="submit" class="btn btn--longer btn--login" name="login" value="Inloggen" /></li>
      </ul>  
  </form>       
</nav>  

<script type="text/javascript">
  $(document).ready(function() {
    $('fieldset ul li input').focusout( function() {
      if (!$(this).val()) {
        $(this).addClass('error');
      } else if ($(this).val()) {
        $(this).removeClass('error');
      }
    });

    $('form.landing__box').submit(function( event ) {
      if ($('input#day').val() && $('select#month').val() != '0' && $('input#year').val()) {
        return;
      }
      $('fieldset ul li input').addClass('error');
      event.preventDefault();
    });
  }); 
</script>

<section class="landing__background">
  <!-- Aanmeld formulier voor nieuwe klanten -->
  <form action="question_list/" class="landing__box" method="post">
    <h2><img src="library/images/snelkoppeling-64.png" alt="Snelkoppeling" /> De beste gratis matches uit jouw omgeving!</h2>
    
    <!-- Geslacht -->
    <fieldset>
      <label for="gender">Ik ben een</label>
      <select name="gender" id="gender" class="form-control input-sm">
          <option value="0" selected>Man</option>
          <option value="1">Vrouw</option>
      </select>
    </fieldset>
    
    <!-- Geaardheid -->
    <fieldset>
      <label for="orientation">Mijn geaardheid is</label>
      <select name="orientation" id="orientation" class="form-control input-sm">
          <option value="0" selected>Heteroseksueel</option>
          <option value="1">Homosexueel</option>
          <option value="2">Biseksueel</option>
      </select>
    </fieldset>
    
    <!-- Geboortedatum -->
    <fieldset>
      <label for="birth">Mijn geboorte datum is</label>
      
      <ul class="multi-list  three-cols">
        <li class="float-left">
            <input type="number" class="text-input required" id="day" placeholder="Dag" maxlength="2" name="day">
        </li>
          <li class="float-left">
            <select name="month" id="month" class="form-control input-sm">
              <option value="0" disabled selected>Maand</option>
              <option value="01">Januari</option>
              <option value="02">Februari</option>
              <option value="03">Maart</option>
              <option value="04">April</option>
              <option value="05">Mei</option>
              <option value="06">Juni</option>
              <option value="07">Juli</option>
              <option value="08">Augustus</option>
              <option value="09">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
            <p class="form-help hidden" id="error-month">Selecteer een maad.</p>
          </li>
          <li>
              <input type="number" class="text-input required" id="year" placeholder="Jaar" maxlength="4" name="year">
          </li>
      </ul> 
    </fieldset>
  
    <!-- Verstuur knop -->
    <fieldset class="form-actions">
      <input type="submit" id="aanmelden" name="signup" value="Aanmelden" />
    </fieldset>
  </form>
</section>

</section>

<?php
  require_once("_footer.php");
?>