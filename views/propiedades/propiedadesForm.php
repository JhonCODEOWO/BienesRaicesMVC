<fieldset>
    <legend>Información General</legend>
    <label for="titulo">Titulo:</label>
    <input name="titulo" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo safe($propiedad->titulo); ?>">
    <?php if(isset($errores)): ?> 
        <p class="text-error text-xs text-red-500"><?php echo $errores->getFrom('titulo') ?></p>
    <?php endif?> 

    <label for="precio">Precio: </label>
    <input name="precio" type="number" id="precio" placeholder="Precio" value="<?php echo safe($propiedad->precio); ?>">
    <?php if(isset($errores)): ?> 
        <p class="text-error text-xs text-red-500"><?php echo $errores->getFrom('precio') ?></p>
    <?php endif?>

    <label for="imagen">Imagen: </label>
    <?php if(isset($_GET['id'])): ?>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" alt="">
    <?php endif ?>
    <input name="imagen" type="file" id="imagen">

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion"><?php echo safe($propiedad->descripcion); ?></textarea>
    <?php if(isset($errores)): ?> 
        <p class="text-error text-xs text-red-500"><?php echo $errores->getFrom('descripcion') ?></p>
    <?php endif?> 

</fieldset>


<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input name="habitaciones" type="number" min="1" max="10" step="1" id="habitaciones" value="<?php echo safe($propiedad->habitaciones); ?>">
    <?php if(isset($errores)): ?> 
        <p class="text-error text-xs text-red-500"><?php echo $errores->getFrom('habitaciones') ?></p>
    <?php endif?> 

    <label for="wc">Baños:</label>
    <input name="wc" type="number" min="1" max="10" step="1" id="wc" value="<?php echo safe($propiedad->wc); ?>">
    <?php if(isset($errores)): ?> 
        <p class="text-error text-xs text-red-500"><?php echo $errores->getFrom('wc') ?></p>
    <?php endif?> 

    <label for="estacionamiento">Estacionamiento:</label>
    <input name="estacionamiento" type="number" min="1" max="10" step="1" id="estacionamiento" value="<?php echo safe($propiedad->estacionamiento); ?>">
    <?php if(isset($errores)): ?> 
        <p class="text-error text-xs text-red-500"><?php echo $errores->getFrom('estacionamiento') ?></p>
    <?php endif?> 

    <legend>Información Vendedor:</legend>
    <label for="nombre_vendedor">Nombre:</label>

    <select name="idVendedor" id="idVendedor">
        <option selected value="">-- Seleccione --</option>
        <?php foreach ($vendedores as $vendedor) : ?>
            <option <?php echo safe($propiedad->idVendedor) == $vendedor->idVendedor ? 'selected' : '' ?> value="<?php echo $vendedor->idVendedor; ?>"><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?>
            <?php endforeach; ?>
    </select>
    <?php if(isset($errores)): ?> 
        <p class="text-error text-xs text-red-500"><?php echo $errores->getFrom('idVendedor') ?></p>
    <?php endif?> 
</fieldset>