<?php 

// Importar la conexión 
require '../includes/config/database.php';
$db = conectarDB();

// Crear un email y password  
$email = 'mail@mail.com';
$password = '234567';

$password_hash = password_hash($password, PASSWORD_BCRYPT);

echo "<pre>";
var_dump($password_hash);
echo "</pre>";

// Query para crear el usuario 
$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$password_hash');";

//echo $query;

mysqli_query($db, $query);

// Agregarlo a la base de datos 


?>