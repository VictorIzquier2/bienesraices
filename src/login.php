<?php
  require '../includes/app.php';
  $db = conectarDB();
  $errores = [];
  
  /* AUTENTIFICAR EL USUARIO */
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);
    
    if(!$email){array_push($errores, "El email es obligatorio o no es válido");}
    if(!$password){array_push($errores, "El password es obligatorio o no es válido");}
    
    if(empty($errores)){
      // Revisar si el usuario existe 
      $query = "SELECT * FROM usuarios WHERE email = '$email';";
      $resultado = mysqli_query($db, $query);
      
      
      if($resultado->num_rows){
        // Revisar si el password es correcto 
        $usuario = mysqli_fetch_assoc($resultado);
        // Verificar si el password es correcto o no 
        $auth = password_verify($password, $usuario['password']);
        if($auth) {
          // El usuario está autentificado
          session_start();
          
          // Llenar el arreglo de la sesion 
          $_SESSION['usuario'] = $usuario['email'];
          $_SESSION['login'] = true;
          
          header('Location: /admin/index.php');
        } else {
          $errores[] = "El password es incorrecto";
        }
      }else{
        $errores[] = "El usuario no existe";
      }
    }
  }
  
  incluirTemplate('header');
  ?>

<main class="contenedor seccion contenido-centrado">
  <h1>Iniciar Sesión</h1>
  <?php foreach($errores as $error): ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach; ?>
  <form class="formulario" method="POST" novalidate>
    <fieldset>
      <legend>Email y Password</legend>

      <label for="email">Email</label>
      <input type="email" placeholder="Tu Email" id="email" name="email" />

      <label for="password">Password</label>
      <input type="password" placeholder="Tu password" id="password" name="password" />
    </fieldset>
      <input type="submit" value="Iniciar Sesión" class=" boton boton-verde">
  </form>
</main>

<?php
  incluirTemplate('footer');
?>