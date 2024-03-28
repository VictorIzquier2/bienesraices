<?php
  require '../includes/funciones.php';
  incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
      <h1>Casa en Venta frente al bosque</h1>
      <picture>
        <source srcset="../build/img/destacada.webp" type="image/webp"/>
        <source srcset="../build/img/destacada.jpg" type="image/jpeg"/>
        <img src="../build/img/destacada.jpg" alt="Imagen de la Propiedad">
      </picture>
      <div class="resumen-propiedad">
        <p class="precio">3.000.000€</p>
        <ul class="iconos-caracteristicas">
          <li>
            <img class="icono" src="../build/img/icono_wc.svg" alt="icono wc">
            <p>3</p>
          </li>
          <li>
            <img class="icono" src="../build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
            <p>3</p>
          </li>
          <li>
            <img class="icono" src="../build/img/icono_dormitorio.svg" alt="icono dormitorio">
            <p>4</p>
          </li>
        </ul>
        <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores, molestiae fugit nihil itaque eaque quibusdam! Nemo odit aspernatur ducimus mollitia provident, nulla non dolor illum beatae dolorum harum esse vitae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi veniam distinctio velit magnam, natus amet alias et, sint doloribus quos id inventore omnis esse qui doloremque dolor aperiam enim earum. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eos itaque optio possimus odit maiores, unde at laborum quidem dolore inventore dolor doloribus illum commodi ducimus delectus enim ipsum numquam deleniti? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium incidunt reprehenderit voluptatem perspiciatis repudiandae reiciendis odio. Iure iusto voluptate fugit ipsam voluptatibus aliquid consectetur rerum voluptatum optio totam, asperiores unde.</p>

        <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, amet perferendis, doloribus quibusdam consequatur dicta rem esse non dolores asperiores nobis? Assumenda tempora beatae harum enim! Excepturi recusandae et velit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium aliquid molestias iure doloremque aliquam ab quo esse cumque dolore nobis similique minima reiciendis, blanditiis veniam porro error obcaecati dolor eveniet!</p>
      </div>
    </main>
   <?php
  include '../includes/templates/footer.php';
?>