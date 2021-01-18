<?php

  session_start();  //Start the session

  session_unset();  //unset the data
  /*or
   $_SESSION = array();
  */

  session_destroy(); //Distory the seesion

  header('location: index.php');
  exit();

