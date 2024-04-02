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

  require '../includes/funciones.php';
  
  $auth = autentificado();  
  incluirTemplate('header');

  if(!$auth){header('Location: /src/index.php');};
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */
  
  /* MUESTRA MENSAJE CONDICIONAL */
  
  $resultado = $_GET['resultado'] ?? null;
  
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */  
  
  /* CONSULTAR LA BASE DE DATOS PARA MOSTRAR LAS PROPIEDADES */
  
  // Importar la conexión
  require '../includes/config/database.php';
  $db = conectarDB();

  // Escribir el query 
  $query = "SELECT * FROM propiedades ORDER BY id;";

  // Consultar la BBDD
  $resultado_db = mysqli_query($db, $query);

   /* REVISTAR EL REQUEST METHOD */
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $id = $_POST['id'];
      $id = filter_var($id, FILTER_VALIDATE_INT);
      if($id){
        // Eliminar el archivo
        $query = "SELECT imagen FROM propiedades WHERE id = {$id};";
        
        $resultado = mysqli_query($db, $query);
        var_dump($resultado);
        $propiedad = mysqli_fetch_assoc($resultado);

        unlink('../imagenes/' . $propiedad['imagen']);

        // Eliminar propiedad
        $query = "DELETE FROM propiedades WHERE id = {$id};";
        $resultado = mysqli_query($db, $query);
        if($resultado){ header('location: /admin?resultado=3'); }
      }
    }

?>

<!-- ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ -->

<!-- HTML -->

<main class="contenedor seccion">
  <h1>Administrador de Bienes Raíces</h1>
  <?php
    switch ($resultado) {
      case '1':
        echo '<p class="alerta exito">Propiedad registrada correctamente</p>';
        break;
      case '2':
        echo '<p class="alerta exito">Propiedad actualizada correctamente</p>';
        break;
      case '3':
        echo '<p class="alerta exito">Propiedad eliminada correctamente</p>';
        break;
      default:
        echo '';
        break;
    }
  ?>
</main>

<a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

<table class="propiedades">
  <thead>
    <tr>
      <th>ID</th>
      <th>Titulo</th>
      <th>Imagen</th>
      <th>Precio</th>
      <th>Acciones</th>
    </tr>
  </thead>

  <tbody><!-- Mostrar los resultados de la BBDD en la tabla -->
    <?php while($propiedad = mysqli_fetch_assoc($resultado_db)):?>
      <tr>
        <td><?php echo $propiedad['id']; ?></td>
        <td><?php echo $propiedad['titulo']; ?></td>
        <td><img src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="Imagen Propiedad" class="imagen-tabla"></td>
        <td><?php echo $propiedad['precio']; ?></td>
        <td>
          <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
          <form method="POST" class="w-100">
            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>"/>
            <input type="submit" class="boton-rojo-block" value="Eliminar" />
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php
  // Cerrar la conexión a la BBDD
  mysqli_close($db);

  incluirTemplate('footer');
?>