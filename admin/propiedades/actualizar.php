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
  use App\Propiedad;
  use App\Vendedor;
  use Intervention\Image\ImageManager;
  use Intervention\Image\Drivers\Imagick\Driver;
  require '../../includes/app.php';

  /* INICIALIZACIÓN DE VARIABLES */
  autentificado();
  
  $id = $_GET['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */
  
  if(!$id){ header('Location: /admin/index.php');};
  
  // Consultar para obtener la propiedad a actualizar
  $propiedad = Propiedad::findOne($id);

  // Consulta para obtener los vendedores 
  $vendedores = Vendedor::all();
  
  // Arreglo con mensajes de errores
  $errores = Propiedad::getErrores();
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */
  
  /* CÓDIGO */
  
  // Validar el ID tomado del $_GET
  $id = filter_var($id, FILTER_VALIDATE_INT);
  if(!$id) { header('Location: /admin');}
  
  // Ejecutar el código después de que el usuario envia el formulario
  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Asignar los atributos 
    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    // Validacion
    $errores = $propiedad->validar();

    /* SUBIDA DE ARCHIVOS */
    
    // Generar un nombre único
    $nombre_imagen = md5( uniqid( rand(), true ) ) . ".jpg";

    if($_FILES['propiedad']['tmp_name']['imagen']){
      $manager = new ImageManager(Driver::class);
      $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600, 'center');
      $propiedad->setImagen($nombre_imagen);
    }

    
    // Revisar que el array de errores esté vacío
    if(empty($errores)){
      if($_FILES['propiedad']['tmp_name']['imagen']) {
        // Almacenar la imagen 
        // Crear una carpeta si no existe
        if(!is_dir(CARPETA_IMAGENES)){ mkdir(CARPETA_IMAGENES); }
        
        // Guardar la imagen en el servidor 
        $image->toJpeg()->save(CARPETA_IMAGENES . $nombre_imagen);
      }

      /* ACTUALIZAR VALORES EN LA BBDD */
      
      $propiedad->guardar();

    }
  }
?>

<!-- ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ -->

<!-- HTML -->

<?php
  incluirTemplate('header');
?>

  <main class="contenedor seccion">
    <h1>Actualizar</h1>
    <a href="/admin/index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
      <?php include '../../includes/templates/formulario_propiedades.php'; ?>

      <input type="submit" value="Actualizar Propiedad" class="boton-verde">

    </form>
  </main>

<?php
  incluirTemplate('footer');
?>