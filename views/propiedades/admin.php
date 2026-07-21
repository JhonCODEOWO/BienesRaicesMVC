<h1 class="text-3xl font-bold">Administración</h1>

<main>
    <?php if($mensaje != null): ?>
        <p class="p-3 bg-blue-500 text-white rounded my-3"><?php echo getErrorMessage(intval($mensaje)) ?></p>
    <?php endif ?>

    <a href="/propiedades/create" class="btn btn-success">Nueva Propiedad</a>
    <a href="/vendedores/create" class="btn btn-error">Nuevo vendedor</a>

    <h2>Propiedades</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($propiedades as $propiedad): ?>
            <tr>
                <td><?php echo $propiedad->idPropiedades; ?></td>
                <td><?php echo $propiedad->titulo; ?></td>
                <td class="flex justify-center">
                    <img src="/imagenes/<?php echo $propiedad->imagen; ?>" width="100" class="imagen-tabla">
                </td>
                <td>$ <?php echo $propiedad->precio; ?></td>
                <td>
                <form method="POST" action="/propiedades/delete/<?php echo $propiedad->idPropiedades ?>">
                    <input type="hidden" name="id_eliminar" value="<?php echo $propiedad->idPropiedades; ?>">
                    <input type="hidden" name="type" value="propiedad">
                    <input type="submit" class="boton boton-rojo" value="Borrar">
                </form>
                    
                    <a href="/propiedades/edit/<?php echo $propiedad->idPropiedades; ?>" class="boton boton-verde">Actualizar</a>
                </td>
            </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Vendedores</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($vendedores as $vendedor): ?>
            <tr>
                <td><?php echo $vendedor->idVendedor; ?></td>
                <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                <td><?php echo $vendedor->telefono; ?></td>
                <td>
                <form method="POST" action="/vendedores/delete/<?php echo $vendedor->idVendedor; ?>">
                    <input type="hidden" name="id_eliminar" value="<?php echo $vendedor->idVendedor; ?>">
                    <input type="hidden" name="type" value="vendedor">
                    <input type="submit" class="boton boton-rojo" value="Borrar">
                </form>
                    
                    <a href="/vendedores/edit/<?php echo $vendedor->idVendedor; ?>" class="boton boton-verde">Actualizar</a>
                </td>
            </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

</main>