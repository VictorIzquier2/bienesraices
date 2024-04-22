<?php
  if(!isset($_SESSION)){
    session_start();
  }
  $auth = $_SESSION['login'] ?? false;

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienes Raices</title>
  <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
  <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
    <div class="contenedor contenido-header">
      <div class="barra">
        <a href="/src/index.php">
          <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">
        </a>

        <div class="mobile-menu">
          <img src="/build/img/barras.svg" alt="icono menu responsive">
        </div>

        <div class="derecha">
          <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Dark mode">
          <nav class="navegacion">
            <a href="/src/nosotros.php">Nosotros</a>
            <a href="/src/anuncios.php">Anuncios</a>
            <a href="/src/blog.php">Blog</a>
            <a href="/src/contacto.php">Contacto</a>
            <?php if($auth): ?>
              <a href="/src/cerrar.php">Salir</a>
            <?php endif; ?>
          </nav>
        </div>

      </div>
      <?php echo $inicio ? '<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>' : ''; ?>
    </div>
  </header>