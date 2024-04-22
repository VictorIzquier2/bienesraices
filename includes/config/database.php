<?php
  function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', 'Mindfulnes2018*', 'bienesraices_crud');
    if(!$db){
      echo "Error de conexión";
      exit;
    }
    return $db;
  };
?>