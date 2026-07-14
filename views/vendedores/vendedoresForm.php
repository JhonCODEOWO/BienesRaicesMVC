<fieldset>
    <legend>Información general</legend>
        <label for="">Nombre del vendedor</label>
        <input type="text" name="vendedor[nombre]" id=""
    value="<?php echo $vendedor->nombre ?? null ?>" placeholder="Nombre del vendedor">
        <?php if(isset($errors)): ?>
            <p class="text-xs text-red-500"><?php echo $errors->getFrom('vendedor.nombre') ?></p>
        <?php endif ?>

        <label for="">Apellidos del vendedor</label>
        <input type="text" name="vendedor[apellido]" id="" value="<?php echo $vendedor->apellido ?? null ?>" placeholder="Apellidos del vendedor">
        <?php if(isset($errors)): ?>
            <p class="text-xs text-red-500"><?php echo $errors->getFrom('vendedor.apellido') ?></p>
        <?php endif ?>

        <label for="">Teléfono del vendedor</label>
        <input type="text" name="vendedor[telefono]" id="" value="<?php echo $vendedor->telefono ?? null ?>" placeholder="Teléfono del vendedor">
        <?php if(isset($errors)): ?>
            <p class="text-xs text-red-500"><?php echo $errors->getFrom('vendedor.telefono') ?></p>
        <?php endif ?>
</fieldset>
<input type="submit" class="" value="Enviar datos">