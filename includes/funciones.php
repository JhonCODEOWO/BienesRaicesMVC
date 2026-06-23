<?php

define('FUNCIONES_URL', __DIR__ . "/funciones/funciones.php");
define('TEMPLATES_URL', __DIR__ . "/templates");
define('CARPETA_IMAGENES', __DIR__."/../imagenes/");

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/$nombre.php";
}

function estaAutenticado() {
    session_start();
    
    if(!$_SESSION['login']) {
        header('Location: /');
    }
}

function debug(mixed $content){
    echo "<pre>";
    var_dump($content);
    echo "</pre>";
    exit;
}

function safe(string $html){
    $s = htmlspecialchars($html);
    return $s;
}


/**
 *  Checks if a string is valid to use to perform operations based on available actions.
 *
 * @param  string $type the type action to evaluate
 * @return bool True if the $type is available to use false otherwise.
 */
function validateActionTypes(string $type): bool {
    $availableTypeActions = ['vendedor', 'propiedades'];

    return in_array($type, $availableTypeActions);
}

/**
 * Redirects to a specific path in the server and append every query param specified in the array.
 *
 * @param  string $direction the url of the server to redirect
 * @param array $queryParams The associative array with query params and its values to append in the redirection
 * @return void
 */
function redirectTo(string $direction, array $queryParams = []): void
{
    $url = $direction;

    if (!empty($queryParams)) {
        $url .= '?' . http_build_query($queryParams);
    }

    header("Location: $url");
    exit;
}


/**
 * Get the error message from the const ERROR_MESSAGES
 *
 * @param  int $code a valid int value with the code to show.
 * @return string The message defined for the code.
 */
function getErrorMessage(int $code): string{
    if(!filter_var($code, FILTER_VALIDATE_INT)) return 'The code provided is not an int value.';
    return ERROR_MESSAGES[$code];
}