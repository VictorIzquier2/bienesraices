<?php 

require '../includes/app.php';

// Importar la conexión 
$db = conectarDB();

// Crear un email y password  
$email = 'mail@mail.com';
$password = '234567';

$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Query para crear el usuario 
$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$password_hash');";

//echo $query;

// Agregarlo a la base de datos 
mysqli_query($db, $query);