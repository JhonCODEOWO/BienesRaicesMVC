<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/build/main.css">
</head>
<body class="bg-neutral-900 text-white">
    <header class="flex justify-between p-3 w-full bg-black text-white">
        <h2 class="uppercase"><span class="font-extralight">Bienes</span>Raices</h2>
        <div>
            <div class="barra">
                <div class="block md:hidden mobile-menu">
                    <a href="#navegacion">
                        <img src="/assets/barras.svg" alt="Icono Menu" height="25" width="25">
                    </a>
                </div>

                <nav id="navegacion" class="hidden md:block navegacion">
                    <a href="/about">Acerca De</a>
                    <a href="/propiedades">Propiedades</a>
                    <a href="/blog">Blog</a>
                    <a href="/contactUs">Contacto</a>
                    <?php if(isset($_SESSION['__auth'])): ?>
                        <form action="/logout" method="post">
                            <button type="submit" class="cursor-pointer text-red-600">Cerrar sesión</button>
                        </form>
                    <?php else: ?>
                        <a href="/login">Iniciar sesión</a>
                    <?php endif ?>
                </nav>
        </div>
    </header>
    
    <div class="min-h-dvh">
        <?php echo $content; ?>
    </div>

    <footer class="bg-black p-5 text-white">
        <div>
            <nav>
                <a href="nosotros.php">Nosotros</a>
                <a href="anuncios.php">Anuncios</a>
                <a href="blog.php">Blog</a>
                <a href="contacto.php">Contacto</a>
            </nav>
            <p class="copyright">Todos los Derechos Reservados <?php echo date('Y'); ?> &copy; </p>
        </div>
    </footer>
    <script src="/build/main.js"></script>
</body>
</html>