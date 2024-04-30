<?php

  /*

  __   ___           __               ___                                       ___    
 |  | /  /___ ___ __/ /_  ___  ____  (   )___   ____  __   ___ ___ __  ____ ___/  /___ 
 |  |/  //__/´ __)_   __)´__ \´  __) /  //__  )´ __ \/  / /  //__/ _ `´  __) __  /´__ \ 
 `     //  /  /_  /  / / /_/ /  /   /  /_ ´ _´  /_/ /  /_/  //  /  __/  //  /_/ / /_/ /
  \___//__/\____)/__/  \____/__/   (___)_____)\_____)_____ ´/__/\___/__/ \_____´\____/ 
    ______ __  __ __  ___     _____ ______  ____   ___  __   __   _____  _____ ___  __  
   /  ____/ / / ´  / ´  /    ´  ___/_   __/´ _  \´  __)´  /´  ´  /  __ \/  ___/  / / /  
  /  ___)  /_/ /  /_/  /_   (__   ) /  / /  _   /  /_ /  _  <   /  /_/ /  ___)  └´  /    
 /__/   \____ ´_____)____) /____ ´ /__/ /__//__/\____)__/ \__\  `____ ´_____/ \___ ´    
                                                                                       
  
  */
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */
  
  /* DEPENDENCIAS */
  require '../../includes/app.php';
  use App\Vendedor;
  autentificado();

  $id = $_GET['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);

  if(!$id){
    header('Location: /admin');
  }

  // Obtener el vendedor de la BBDD
  $vendedor = Vendedor::findOne($id);

  $errores = Vendedor::getErrores();

  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Asignar los valores 
    $args = $_POST['vendedor'];

    // Sincronizar objeto en memoria con lo que el usuario escribio
    $vendedor->sincronizar($args);

    // Validacion 
    $errores = $vendedor->validar();

    if(empty($errores)){
      $vendedor->guardar();
    }
  }

  incluirTemplate('header');
?>

<main class="contenedor seccion">
  <h1>Actualizar Vendedor</h1>
  <a href="/admin/index.php" class="boton boton-verde">Volver</a>

  <?php foreach($errores as $error): ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach; ?>

  <form class="formulario" method="POST">
    <?php include '../../includes/templates/formulario_vendedores.php' ?>

    <input type="submit" value="Guardar Cambios" class="boton-verde">

  </form>
</main>

<?php
  incluirTemplate('footer');
?>






  
