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

  require '../../includes/config/database.php';
  require '../../includes/funciones.php';

  $auth = autentificado();
  $db = conectarDB();
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */
  
  /* INICIALIZACIÓN DE VARIABLES */
  if(!$auth){ header('Location: /src/index.php');};
  
  $id = $_GET['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);

  if(!$id){ header('Location: /admin/index.php');};

  // Consultar para obtener la propiedad a actualizar
  $consulta_propiedad = "SELECT * FROM propiedades WHERE id = {$id}";
  $resultado_propiedad = mysqli_query($db, $consulta_propiedad);
  $propiedad = mysqli_fetch_assoc($resultado_propiedad);
  
  // Consultar para obtener los vendedores
  $consulta_vendedores = "SELECT * FROM vendedores";
  $resultado_vendedores = mysqli_query($db, $consulta_vendedores);
  
  // Arreglo con mensajes de errores
  $errores = [];
  
  $titulo = $propiedad['titulo'];
  $precio = $propiedad['precio'];
  $imagenPropiedad = $propiedad['imagen'];
  $descripcion = $propiedad['descripcion'];
  $habitaciones = $propiedad['habitaciones'];
  $wc = $propiedad['wc'];
  $estacionamiento = $propiedad['estacionamiento'];
  $vendedores_id = $propiedad['vendedores_id'];
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */
  
  /* CÓDIGO */
  
  // Validar el ID tomado del $_GET
  $id = filter_var($id, FILTER_VALIDATE_INT);
  if(!$id) { header('Location: /admin');}
  
  // Ejecutar el código después de que el usuario envia el formulario
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $imagen = $_FILES['imagen']; // Asignar archivo hacia una variable
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $creado = date('Y/m/d');
    $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedores_id']);

    /* VALIDACIONES */
    // Validar por tamaño (0,35Mb máximo)
    $medida = 350000;

    if(!$titulo){array_push($errores, "El título es obligatorio");};
    if(!$precio){array_push($errores, "El precio es obligatorio");};
    if($imagen['size'] > $medida){array_push($errores, "La imagen debe ser menor que 350kb");};
    if(!$descripcion){array_push($errores, "La descripción es obligatoria");};
    if(!$habitaciones){array_push($errores, "El nº de habitaciones es obligatorio");};
    if(!$wc){array_push($errores, "El nº de baños es obligatorio");};
    if(!$estacionamiento){array_push($errores, "El nº de estacionamientos es obligatorio");};
    if(!$vendedores_id){array_push($errores, "El id del vendedor es obligatorio");};

    // Revisar que el array de errores esté vacío
    if(empty($errores)){

      /** SUBIDA DE ARCHIVOS **/
      
      // Crear una carpeta
      $carpeta_imagenes = '../../imagenes/';
      if(!is_dir($carpeta_imagenes)){ mkdir($carpeta_imagenes); }

      $nombre_imagen = '';

      if($imagen['name']){
        // Eliminar la imagen previa
        unlink($carpeta_imagenes . $propiedad['imagen']);

        // // Generar un nombre único
        $nombre_imagen = md5( uniqid( rand(), true ) ) . ".jpg";
  
        // // Subir la imagen 
        move_uploaded_file($imagen['tmp_name'], $carpeta_imagenes . $nombre_imagen);
      } else {
        $nombre_imagen = $propiedad['imagen'];
      }


      /* ACTUALIZAR VALORES EN LA BBDD */
      
      $query = "UPDATE propiedades SET titulo = '{$titulo}', precio = {$precio}, imagen = '{$nombre_imagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedores_id = {$vendedores_id} WHERE id = {$id}
      ;";
      //echo $query;
      $resultado = mysqli_query($db, $query);
      //echo $resultado ? "Registro actualizado correctamente" : "Error al actualizar el registro en la BBDD";

      /* REDIRECCIONAR */

      if($resultado){
        // Redireccionar al usuario 
        header('Location: /admin?resultado=2');
      }
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
      <fieldset>
        <legend>Información General</legend>
        
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Título de la propiedad" value="<?php echo $titulo; ?>" />

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" placeholder="Precio de la propiedad" value="<?php echo $precio; ?>"/>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" />

        <img src="../../imagenes/<?php echo $imagenPropiedad; ?>" class="imagen-small" />

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea>
      </fieldset>
      
      <fieldset>
        <legend>Información Propiedad</legend>

        <label for="habitaciones">Habitaciones:</label>
        <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="99" value="<?php echo $habitaciones; ?>"/>

        <label for="wc">Baños:</label>
        <input type="number" id="wc" name="wc" placeholder="Ej: 1" min="1" max="99" value="<?php echo $wc; ?>"/>

        <label for="estacionamiento">Estacionamiento:</label>
        <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 1" min="1" max="99" value="<?php echo $estacionamiento; ?>" />
      </fieldset>

      <fieldset>
        <legend>Vendedor</legend>

        <select id="vendedores_id" name="vendedores_id">
          <option value="" disabled selected>— Seleccione —</option>
          <?php while( $vendedor = mysqli_fetch_assoc($resultado_vendedores) ): ?>
            <option 
              <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> 
              value="<?php echo $vendedor['id']; ?>">
              <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>
          </option>
          <?php endwhile; ?>
        </select>
      </fieldset>

      <input type="submit" value="Actualizar Propiedad" class="boton-verde">

    </form>
  </main>

<?php
  incluirTemplate('footer');
?>