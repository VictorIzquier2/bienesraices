<?php
  require '../includes/app.php';
  incluirTemplate('header');
?>
  <main class="contenedor seccion">
    <h1>Conoce sobre Nosotros</h1>
    <div class="contenido-nosotros">
      <div class="imagen">
        <picture>
          <source srcset="../build/img/nosotros.webp" type="image/webp" />
          <source srcset="../build/img/nosotros.jpg" type="image/jpeg" />
          <img src="../build/img/nosotros.jpg" alt="Sobre Nosotros">
        </picture>
      </div>
      <div class="texto-nosotros">
        <blockquote>
          25 Años de Experiencia
        </blockquote>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus modi, beatae animi corporis obcaecati deleniti illo cupiditate ad quae repellendus distinctio. Expedita dolor dolorum optio architecto beatae neque inventore itaque?. Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, distinctio quis. Eaque tenetur nemo illum. Ut saepe quibusdam veniam expedita perspiciatis velit nobis. Illum, molestias sit asperiores repudiandae vel dolore. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam officiis odio ea corrupti animi vel, ipsum sed quibusdam soluta obcaecati excepturi consequuntur, eaque modi tempora sapiente odit corporis accusantium temporibus. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tenetur minima voluptatem dolorem vero debitis, officia optio, facilis accusamus blanditiis tempore at sunt. Saepe a qui maxime natus? Nostrum, a ipsam?</p>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea explicabo esse illum molestias, rerum delectus amet vitae rem architecto fuga facilis deleniti enim qui ducimus voluptas nobis nemo consectetur quidem. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Assumenda laudantium corporis ab, nostrum molestias magnam temporibus quos vel iusto dolor nisi sit similique voluptatem, quasi architecto praesentium dolores porro veniam!</p>
      </div>
    </div>
  </main>

  <section class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>
    <div class="iconos-nosotros">
      <div class="icono">
        <img src="../build/img/icono1.svg" alt="Icono Seguridad" />
        <h3>Seguridad</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, soluta porro nisi rem molestias ipsa adipisci ducimus earum architecto quaerat quam beatae. Blanditiis laborum minima ipsa fuga doloremque voluptatum tempora?</p>
      </div>
      <div class="icono">
        <img src="../build/img/icono2.svg" alt="Icono Precio" />
        <h3>Precio</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, soluta porro nisi rem molestias ipsa adipisci ducimus earum architecto quaerat quam beatae. Blanditiis laborum minima ipsa fuga doloremque voluptatum tempora?</p>
      </div>
      <div class="icono">
        <img src="../build/img/icono3.svg" alt="Icono Tiempo" />
        <h3>Tiempo</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, soluta porro nisi rem molestias ipsa adipisci ducimus earum architecto quaerat quam beatae. Blanditiis laborum minima ipsa fuga doloremque voluptatum tempora?</p>
      </div>
    </div><!-- Fin Iconos-nostros -->
  </section>

<?php
  incluirTemplate('footer');
?>