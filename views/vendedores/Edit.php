<h1>Editando vendedor</h1>

<form action="/vendedores/update/<?php echo $vendedor->idVendedor ?>" method="post">
    <?php require __DIR__.'/vendedoresForm.php' ?>
</form>