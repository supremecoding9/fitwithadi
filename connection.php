<?php


  header('Content-Type: text/html; charset=utf-8');
  ini_set("default_charset", "UTF-8");
  mb_internal_encoding("UTF-8");
 # iconv_set_encoding("internal_encoding", "UTF-8");
#  iconv_set_encoding("output_encoding", "UTF-8");
  
  
  $conn = new mysqli('localhost', 'fitw_adi', '6i-tEkEo7pgm*N7y', 'fitw_adi');
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
    
  ###########################################################################################
  $dsn = "mysql:host=localhost;dbname=fitw_adi;charset=utf8mb4";
  $options = [
    PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
  ];
  try {
    $pdo = new PDO($dsn, "fitw_adi", "6i-tEkEo7pgm*N7y", $options);
  } catch (Exception $e) {
    error_log($e->getMessage());
    exit('Something weird happened'); //something a user can understand
  }
  ################################################################################################
 