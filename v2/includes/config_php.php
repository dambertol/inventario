<?php
// Desactivar toda notificaci�n de error
error_reporting(0);

// Notificar solamente errores de ejecuci�n
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Notificar E_NOTICE tambi�n puede ser bueno (para informar de variables
// no inicializadas o capturar errores en nombres de variables ...)
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// Notificar todos los errores excepto E_NOTICE
// Este es el valor predeterminado establecido en php.ini
error_reporting(E_ALL ^ E_NOTICE);

// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);

// Notificar todos los errores de PHP
error_reporting(-1);

// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

///////////////////////////////////////////////
isset($titulo)?"":$titulo="";
if(empty(isset($_SESSION["token"]))){
   $titulo.= "FISCAL"; 
}

if(isset($_SESSION["token"]) && $_SESSION["token"] =="IDtMBf0LVMHg9hTbgOQPpZ1tYZ0i6hOWtEO8Az4Bhu9G15AuSyLVsPmHByUk0qlS"){ 
   $titulo.="REVISORES";
}elseif(
isset($_SESSION["token"]) && $_SESSION["token"] =="oUsZmiumyCayBlka0xMIw4Jiq4S83C6iSDQsyGRD9iMYB4jd1Lxhigkg1tpwFcQI"){ 
   $titulo.="TESTIGO";
}else{
   $titulo.="Elecciones";
}?>