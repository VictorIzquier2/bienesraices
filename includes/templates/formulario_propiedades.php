

  <fieldset>
    <legend>Información General</legend>
    
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Título de la propiedad" value="<?php echo escapar($propiedad->titulo); ?>" />

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio de la propiedad" value="<?php echo escapar($propiedad->precio); ?>"/>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png" />
    <?php if($propiedad->imagen):?>
      <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small" />
    <?php endif;?>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo escapar($propiedad->descripcion); ?></textarea>
  </fieldset>
  
  <fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="99" value="<?php echo escapar($propiedad->habitaciones); ?>"/>

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 1" min="1" max="99" value="<?php echo escapar($propiedad->wc); ?>"/>

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 1" min="0" max="99" value="<?php echo escapar($propiedad->estacionamiento); ?>" />
  </fieldset>

  <fieldset>
    <legend>Vendedor</legend>
    <label for="vendedores_id">Vendedor</label>
    <select id="vendedores_id" name="propiedad[vendedores_id]">
      <option value="" disabled selected >— Seleccione —</option>
      <?php foreach($ as $vendedor): ?>
        <option 
          <?php echo $propiedad->vendedores_id === $vendedor->id ? 'selected' : ''; ?>
          value ="<?php echo escapar($vendedor->id); ?>"
          ><?php echo escapar($vendedor->nombre) . " " . escapar($vendedor->apellido); ?></option>
      <?php endforeach; ?>
    </select>
  </fieldset>