<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $nombre ?></h1>
    <h2><?php echo $telefono . ' - ' . $email ?></h2>

    <h3>Asunto:</h3>
    <p>
        "<?php echo $mensaje ?>"
    </p>

    <strong>Contactar por: <?php echo $tipo_contacto ?></strong>

    <?php if($tipo_contacto === 'telefono'): ?>
        <p><strong>Cita:</strong><?php echo " $hora - $fecha"?></p>
    <?php endif ?>
</body>
</html>