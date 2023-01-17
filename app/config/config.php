<?php

// echo "Current Current working dir bootstrap.php: <br/>";
// echo getcwd() . "<br/>";

  //DB Params
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '123456');
  define('DB_NAME', 'invtrack2');
  
  // App root
  define('APPROOT', dirname(__DIR__));
  //define('APPROOT', dirname(dirname((__FILE__))); //should be the same 
  //echo APPROOT . "<br/>";
  
  //URL root
  define('URLROOT', 'http://localhost/api-invtrack');

  //Site name
  define('SITENAME', 'MVC FRAMEWORK');

  //App version
  define('APPVERSION', '1.0.0');

?>