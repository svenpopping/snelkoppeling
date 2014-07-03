<?php
  require_once('../config.php');
  /*
    Generates and send mail to client for verification
  */
  function sendMail($email_adress, $person_id, $person_name) {
    $message='Geachte "'.$person_name.'", 

    Wij van Snelkoppeling.info zijn heel erg blij met uw inschrijving. Wij hopen dat u hier uw ware liefde vindt, om deze zoektocht makkelijker te maken
    hebben wij elke extra features voor uw in petto. U kunt toegang krijgen tot deze features door op de onderstaande link te klikken.

    Klik op onderstaande link om toegang te krijgen tot de extra features:
    http:'.$main_path.'register.php?verifyMail=true&verification_id="'.($person_id * 435472).'"

    Team Snelkoppeling.info';


    $subject = 'the subject';
    $headers = 'From: no-reply@snelkoppeling.info' . "\r\n" .
              'Reply-To: svenpopping@hotmail.com' . "\r\n" .
              'X-Mailer: PHP/' . phpversion();

    mail($email_adress, 'Verificatie email-adres Snelkoppeling.info', $message, $headers);
  }

  /*
    Verifies the email adres
  */
  function verifyMail($verification_id) {
    global $mysqli;
    $person_id = $verification_id / 435472;

    $sql = "UPDATE gegevens SET verified = 1 WHERE id = '".$person_id."'";
    $mysqli->query($sql);
  }

  /*
    Main method
  */
  

  if(isset($_REQUEST['sendMail']) && $_REQUEST['sendMail'] == true) {
    $person_id = (isset($_REQUEST['person_id'])) ? $_REQUEST['person_id'] : die("Geen toegang");
    $email_adress = (isset($_REQUEST['email_adress'])) ? $_REQUEST['email_adress'] : die("Geen toegang");
    $person_name = (isset($_REQUEST['person_name'])) ? $_REQUEST['person_name'] : die("Geen toegang");

    sendMail($email_adress, $person_id, $person_name);
  } else if (isset($_REQUEST['verifyMail'])) {
    $verification_id = (isset($_REQUEST['verification_id'])) ? $_REQUEST['verification_id'] : die("Geen toegang");

    verifyMail($verification_id);
  } else {
    die("Access denied");
  }

?>