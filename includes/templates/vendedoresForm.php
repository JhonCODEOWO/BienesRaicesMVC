<?php
    $editing = $editing ?? false;
    $submitText = (!$editing)?
        'Registrar vendedor(a)': 'Actualizar vendedor(a)';
?>

<fieldset>
    <legend>Información general</legend>
    <input type="text" name="vendedor[nombre]" id=""
    value="<?php echo $vendedor->nombre ?? null ?>">
    <input type="text" name="vendedor[apellido]" id="" value="<?php echo $vendedor->apellido ?? null ?>">
    <input type="text" name="vendedor[telefono]" id="" value="<?php echo $vendedor->telefono ?? null ?>">
</fieldset>
<input type="submit" class="" value="<?php echo $submitText ?>">