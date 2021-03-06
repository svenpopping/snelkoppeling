<?php

/**
 *  Things to change.
 */
$mysqli = mysqli_connect("localhost", "root", "AA3x8-fpe50-m8eeq-w4x7v-x6r8f", "snelkoppeling") or die(mysqli_error($connect));
$main_path = "//localhost/snelkoppeling/2.0.1/";

// Error when something goes wrong with the database connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

/**
 * Creates a random string
 * @param length length of the string, by default 10
 */
function random($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

/**
 * List of states
 */
$states_names = array(
  0 => "Friesland",
  1 => "Groningen",
  2 => "Drenthe",
  3 => "Noord-Holland",
  4 => "Flevoland",
  5 => "Overijssel",
  6 => "Gelderland",
  7 => "Utrecht",
  8 => "Zuid-Holland",
  9 => "Zeeland",
  10 => "Noord-Brabant",
  11 => "Limburg"
);

/**
 * List of surrounding states
 */
$states = array(
  0 => array(0, 1, 2, 3, 4),      /* friesland */
  1 => array(1, 0, 2),        /* groningen */
  2 => array(2, 0, 1, 5),       /* drenthe */
  3 => array(3, 0, 4, 7, 8),      /* noord-holland */
  4 => array(4, 0, 5, 6, 3, 7),   /* flevoland */
  5 => array(5, 6, 4, 2, 0),      /* overijssel */
  6 => array(6, 5, 4, 7, 8, 10, 11),  /* gelderland */
  7 => array(7, 3, 8, 5, 6),      /* utrecht */
  8 => array(8, 9, 10, 6, 7, 3),    /* zuid-holland */
  9 => array(9, 8, 10),         /* zeeland */
  10 => array(10, 9, 8, 6, 11),     /* noord-brabant */
  11 => array(11, 10, 6)        /* limburg */
);

/**
 * List of the importance and it's score
 */
$importance = array(
    0 => 0,
      1 => 0,     /*Irrelevant*/
      2 => 3,     /*Een beetje belangrijk*/
      3 => 7,     /*Enigszins belangrijk*/
      4 => 20,    /*Heel belangrijk*/
      5 => 55     /*Bindend/Verplicht*/
  );
?>