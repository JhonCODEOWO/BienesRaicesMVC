<main class="xl:w-1/2 mx-auto my-0">
    <div class="relative">
        <h1 class="absolute text-center bg-gradient-to-b from-neutral-800/50 to-neutral-800/50 left-0 right-0 bg-opacity"><?php echo $propiedad->titulo; ?></h1>
        <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen Anuncio">
    </div>
    <div class="resumen-propiedad flex flex-col md:flex-row justify-between p-5 items-center">
        <p class="text-green-500 text-4xl">Precio: $<?php echo $propiedad->precio; ?></p>
        <ul class="iconos-caracteristicas flex gap-x-4 text-center">
            <li class="flex flex-col">
                <img src="/assets/icono_wc.svg" alt="icono wc">
                <p class="mt-auto"><?php echo $propiedad->wc; ?></p>
            </li>
            <li class="flex flex-col">
                <img src="/assets/icono_estacionamiento.svg" alt="icono autos">
                <p class="mt-auto"><?php echo $propiedad->estacionamiento; ?></p>
            </li>
            <li class="flex flex-col">
                <img src="/assets/icono_dormitorio.svg" alt="icono habitaciones">
                <p class="mt-auto"><?php echo $propiedad->habitaciones; ?></p>
            </li>
        </ul>
    </div>
    <!--.resumen-propiedad-->
    <div class="p-5">
        <h2 class="font-bold text-3xl">Descripción de la propiedad</h2>
        <p class="mt-3"><?php echo $propiedad->descripcion; ?></p>
    </div>
</main>