<?php
  require '../includes/funciones.php';
  incluirTemplate('header');

  require '../includes/config/database.php';
  $db = conectarDB();

  $query = "SELECT * FROM propiedades ORDER BY id;";

  $resultado = mysqli_query($db, $query);
?>
    <main class="contenedor seccion">
      <h2>Casas y Departamentos en Venta</h2>
      <div class="contenedor-anuncios">
        <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
        <div class="anuncio">
          <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="Anuncio">
          <div class="contenido-anuncio">
            <h3><?php echo $propiedad['titulo']; ?></h3>
            <p><?php echo $propiedad['descripcion']; ?></p>
            <p class="precio"><?php echo $propiedad['precio']; ?></p>
            <ul class="iconos-caracteristicas">
              <li>
                <img class="icono" src="../build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $propiedad['wc']; ?></p>
              </li>
              <li>
                <img class="icono" src="../build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $propiedad['estacionamiento']; ?></p>
              </li>
              <li>
                <img class="icono" src="../build/img/icono_dormitorio.svg" alt="icono dormitorio">
                <p><?php echo $propiedad['habitaciones']; ?></p>
              </li>
            </ul>
            <a href="anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Ver Propiedad</a>
          </div><!-- .contenido-anuncio -->
        </div><!-- .anuncio -->
        <?php endwhile; ?>
      </div><!-- .contenedor-anuncios -->
        <?php
          mysqli_close($db);
        ?>
    </main>
<?php
  include '../includes/templates/footer.php';
?>