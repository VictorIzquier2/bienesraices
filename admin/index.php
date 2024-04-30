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
  require '../includes/app.php';
  use App\Propiedad;
  use App\Vendedor;
  
  /* INICIALIZACIÓN DE VARIABLES */
  autentificado();  
  
  /* ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ */  
  
  /* CONSULTAR LA BASE DE DATOS PARA MOSTRAR LAS PROPIEDADES */
  $propiedades = Propiedad::all();
  $vendedores = Vendedor::all();
  
  /* MUESTRA MENSAJE CONDICIONAL */
  $resultado = $_GET['resultado'] ?? null;


   /* REVISTAR EL REQUEST METHOD */
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $id = $_POST['id'];
      $id = filter_var($id, FILTER_VALIDATE_INT);

      if($id){
        $tipo = $_POST['tipo'];
        if(validarTipoContenido($tipo)) {
          // Compara lo que vamos a Eliminar
          if($tipo === 'vendedor'){
            $vendedor = Vendedor::findOne($id);
            $vendedor->deleteOne();

          }else if($tipo === 'propiedad'){
            $propiedad = Propiedad::findOne($id);
            $propiedad->deleteOne();
          }
        }
      }
    }

    incluirTemplate('header');

?>

<!-- ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ -->

<!-- HTML -->

<main class="contenedor seccion">
  <h1>Administrador de Bienes Raíces</h1>
  <?php
    mostrarNotificacion($resultado);
  ?>

  <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
  <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

  <h2>Propiedades</h2>

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
    <?php foreach($propiedades as $propiedad):?>
      <tr>
        <td><?php echo $propiedad->id; ?></td>
        <td><?php echo $propiedad->titulo; ?></td>
        <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen Propiedad" class="imagen-tabla"></td>
        <td><?php echo $propiedad->precio; ?> €</td>
        <td>
          <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
          <form method="POST" class="w-100">
            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>"/>
            <input type="hidden" name="tipo" value="propiedad"/>
            <input type="submit" class="boton-rojo-block" value="Eliminar" />
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h2>Vendedores</h2>

  <table class="propiedades">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Acciones</th>
      </tr>
    </thead>
    
    <tbody><!-- Mostrar los resultados de la BBDD en la tabla -->
    <?php foreach($vendedores as $vendedor):?>
      <tr>
        <td><?php echo $vendedor->id; ?></td>
        <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
        <td><?php echo $vendedor->telefono; ?></td>
        <td>
          <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
          <form method="POST" class="w-100">
            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>"/>
            <input type="hidden" name="tipo" value="vendedor"/>
            <input type="submit" class="boton-rojo-block" value="Eliminar" />
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>

<?php
  incluirTemplate('footer');
?>