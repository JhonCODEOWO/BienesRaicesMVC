<div class="flex items-center gap-x-3 mb-3">
    <a href="/admin" class="btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
            <path d="M0 0h12v24H0z" fill="none" />
            <path fill="currentColor" fill-rule="evenodd" d="m3.343 12l7.071 7.071L9 20.485l-7.778-7.778a1 1 0 0 1 0-1.414L9 3.515l1.414 1.414z" />
        </svg>
    </a>
    <h1 class="fw-300 centrar-texto flex-1 text-center">Actualizando Propiedad</h1>
</div>

<main class="contenedor seccion contenido-centrado">


    <form class="formulario" method="POST" enctype="multipart/form-data" action="/propiedades/update/<?php echo $propiedad->idPropiedades ?>">
        
        <?php include __DIR__.'/propiedadesForm.php'; ?>

        <input type="submit" value="Crear Propiedad" class="btn btn-success">
    </form>

</main>