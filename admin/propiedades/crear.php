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
  use App\Propiedad;
  use App\Vendedor;
  use Intervention\Image\ImageManager;
  use Intervention\Image\Drivers\Imagick\Driver;
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */

  /* INICIALIZACIÓN DE VARIABLES */
  autentificado();
  $propiedad = new Propiedad;

  // Consulta para obtener todos los vendedores 
  $vendedores = Vendedor::all();

  // Arreglo con mensajes de errores
  $errores = Propiedad::getErrores();

  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */

  /* CÓDIGO */

  // Ejecutar el código después de que el usuario envia el formulario
  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    /** Crea una nueva instancia */
    $propiedad = new Propiedad($_POST['propiedad']);

    /** SUBIDA DE ARCHIVOS */

    // Generar un nombre único
    $nombre_imagen = md5( uniqid( rand(), true ) ) . ".jpg";

    // Setear la imagen 
    // Resize a la imagen con intervention 
    if($_FILES['propiedad']['tmp_name']['imagen']){
      $manager = new ImageManager(Driver::class);
      $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600, 'center');
      $propiedad->setImagen($nombre_imagen);
    }

    // Validar
    $errores = $propiedad->validar(); // Validar por tamaño (0,35Mb máximo) - 350000
    
    // Revisar que el array de errores esté vacío
    if(empty($errores)){
      
      // Crear una carpeta si no existe
      if(!is_dir(CARPETA_IMAGENES)){ mkdir(CARPETA_IMAGENES); }
      
      // Guardar la imagen en el servidor 
      $image->toJpeg()->save(CARPETA_IMAGENES . $nombre_imagen);
      
      // Guarda en la base de datos 
      $propiedad->guardar();
      
    }
  }
  incluirTemplate('header');
?>

  <main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin/index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
      <?php include '../../includes/templates/formulario_propiedades.php' ?>

      <input type="submit" value="Crear Propiedad" class="boton-verde">

    </form>
  </main>

<?php
  incluirTemplate('footer');
?>