<?php if(count($propiedades) === 0) { ?>
    <p class="text-center">No hay elementos para mostrar</p>
<?php } else {?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 px-1.5">
        <?php foreach($propiedades as $propiedad): ?>
                <div class=" bg-neutral-800 rounded overflow-hidden">
                    <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Anuncio casa en el lago">
                    <div class="flex flex-col gap-y-2.5 p-1.5">
                        <div>
                            <h3 class="text-3xl"><?php echo $propiedad->titulo; ?></h3>
                            <p><?php echo $propiedad->descripcion; ?></p>
                        </div>
                        <p class="text-green-400 text-2xl">$ <?php echo $propiedad->precio; ?></p>

                        <ul class="flex justify-evenly px-5 text-center">
                            <li>
                                <img src="assets/icono_wc.svg" alt="icono wc">
                                <p><?php echo $propiedad->wc; ?></p>
                            </li>
                            <li>
                                <img src="assets/icono_estacionamiento.svg" alt="icono autos">
                                <p><?php echo $propiedad->estacionamiento; ?></p>
                            </li>
                            <li>
                                <img src="assets/icono_dormitorio.svg" alt="icono habitaciones">
                                <p><?php echo $propiedad->habitaciones; ?></p>
                            </li>
                        </ul>


                        <a href="anuncio.php?id=<?php echo $propiedad->idPropiedades; ?>" class="p-2 bg-green-700 rounded block">Ver Propiedad</a>
                    </div>
                </div>
        <?php endforeach;  ?>
        <div class="ver-todas">
            <a href="anuncios.php" class="boton boton-verde">Ver Todas</a>
        </div>
    </div>
<?php } ?>