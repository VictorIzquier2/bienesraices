<?php
  session_start();
  
  $_SESSION = [];
  
  // echo "<pre>";
  // var_dump($_SESSION);
  // echo "</pre>";

  header('Location: /src/index.php');

?>