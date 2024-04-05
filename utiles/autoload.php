<?php
function carga($clase) {
    $archivo = DIRECCION . '/'  . str_replace('\\', '/', $clase) . '.php';
    if (file_exists($archivo))  include $archivo;
}

spl_autoload_register('carga');