<main class="contenedor seccion contenido-centrado">
    <h1 class="fw-300 centrar-texto">Iniciar Sesión</h1>

    <form method="POST" class="formulario" novalidate action="/login">
        <fieldset>
            <legend>Email y Password</legend>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Tu Email" >
            <?php if(isset($errors)): ?>
                <p class="text-xs text-red-600"><?php echo $errors->getFrom('email') ?></p>
            <?php endif ?>

            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Tu Password" >
            <?php if(isset($errors)): ?>
                <p class="text-xs text-red-600"><?php echo $errors->getFrom('password') ?></p>
            <?php endif ?>
        </fieldset>
        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>