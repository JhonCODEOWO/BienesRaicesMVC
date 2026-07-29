<h1 class="fw-300 centrar-texto">Contacto</h1>
<img src="/assets/destacada3.jpg" alt="Imagen Principal">

<main class="contenedor seccion contenido-centrado">
    <h2 class="fw-300 centrar-texto">Llena el formulario de Contacto</h2>

    <form class="formulario" action="/contactUs" method="POST">
        <fieldset>
            <legend>Información Personal</legend>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" placeholder="Tu Nombre" name="nombre">
            <?php if(isset($errors)): ?>
                <p class="text-xs text-red-500"><?php echo $errors->getFrom('nombre') ?></p>
            <?php endif ?>

            <label for="mensaje">Mensaje: </label>
            <textarea id="mensaje" name="mensaje" ></textarea>
            <?php if(isset($errors)): ?>
                <p class="text-xs text-red-500"><?php echo $errors->getFrom('mensaje') ?></p>
            <?php endif ?>

        </fieldset>


        <fieldset>
            <legend>Información sobre Propiedad</legend>
            <label for="opciones">Vende o Compra</label>
            <select id="opciones" name="opciones">
                <option value="" disabled selected >-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>
            <?php if(isset($errors)): ?>
                <p class="text-xs text-red-500"><?php echo $errors->getFrom('opciones') ?></p>
            <?php endif ?>

            <label for="cantidad">Cantidad:</label>
            <input type="number" min="0" max="100" step="5" name="cantidad">
            <?php if(isset($errors)): ?>
                <p class="text-xs text-red-500"><?php echo $errors->getFrom('cantidad') ?></p>
            <?php endif ?>
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>

            <p>Como desea ser Contactado:</p>

            <div class="forma-contacto">
                <label for="telefono">Teléfono</label>
                <input type="radio" name="tipo_contacto" value="telefono" id="telefono" class="radioBtn" checked>

                <label for="correo">E-mail</label>
                <input type="radio" name="tipo_contacto" value="correo" id="correo" class="radioBtn">
            </div>
            <?php if(isset($errors)): ?>
                <p class="text-xs text-red-500"><?php echo $errors->getFrom('tipo_contacto') ?></p>
            <?php endif ?>

            <div id="contacto_telefono">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" placeholder="Tu Teléfono" name="telefono">
                <?php if(isset($errors)): ?>
                    <p class="text-xs text-red-500"><?php echo $errors->getFrom('telefono') ?></p>
                <?php endif ?>
                <p>Elija la fecha y la hora para agendar una llamada</p>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha_contacto">

                <label for="hora">Hora:</label>
                <input type="time" id="hora" min="09:00" max="18:00" name="hora_contacto">
            </div>
            
            <div id="contacto_correo">
                <label for="email">E-mail: </label>
                <input type="email" id="email" placeholder="Tu Correo electrónico" name="email">
                <?php if(isset($errors)): ?>
                    <p class="text-xs text-red-500"><?php echo $errors->getFrom('email') ?></p>
                <?php endif ?>
            </div>

        </fieldset>

        <input type="submit" value="Enviar" class="boton boton-verde">

    </form>
</main>