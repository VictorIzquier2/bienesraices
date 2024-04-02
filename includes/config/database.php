<?php
  function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', 'Mindfulnes2018*', 'bienesraices_crud');
    if(!$db){
      echo "Error de conexión";
      exit;
    }
    return $db;
  };
?>