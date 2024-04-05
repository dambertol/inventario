<?php
isset($_SESSION)?"":session_start();

if (isset($_SESSION['user_id'])) {
    if(isset($_SESSION['token'])&& $_SESSION['token']=="carga"){
      // header("Location: /2023/escrutinio_v2/bienvenido");
      //  echo "<script> window.location.href = '".DIRECCION."/bienvenido';</script>";
      echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";

        return;
    }else{
        echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
        return;  
    }
}

//include_once 'v2/classe/Usuario.php';
use v2\classe\Usuario;
$b=new Usuario();
$message = '';
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $usuario=$_POST['username'];
    $usu =$b->obtener_condni($usuario);
    $encrip=$usu->dni;
    $hash=$b->encr($encrip);  //dni hasheado
    $contra=$_POST['password'];

    $fafa=$b->desenc($usu->contra);
    if ( $contra === $fafa ) {

        if ($usu->permiso=="admin" || $usu->permiso=="editor" || $usu->permiso=="admin_dto" || $user->permiso!="dios") {
            $_SESSION["token"] ="IDtMBf0LVMHg9hTbgOQPpZ1tYZ0i6hOWtEO8Az4Bhu9G15AuSyLVsPmHByUk0qlS";

        }elseif ($usu->permiso=="visualizar" ||$usu->permiso=="visual_dto") {
            $_SESSION["token"] ="LuWq9yv205XfBphbLW9GtdL6AXZF0yUWBepCVHwCuqIiIo3sXGP2ediK8a1cKVic";
            //$_SESSION["token"] =="oUsZmiumyCayBlka0xMIw4Jiq4S83C6iSDQsyGRD9iMYB4jd1Lxhigkg1tpwFcQI"){ $titulo="TESTIGO";}

        }elseif ($usu->permiso=="carga") {
            $_SESSION["token"] ="carga";
        }
        $_SESSION['user_current'] = ucwords($usu->nombre);
        $_SESSION['user_id'] = $hash;
        header("Location: ".DIR."/bienvenido");
       //echo "<script> window.location.href = '".DIRECCION."/bienvenido';</script>";
       return;
    } else {
        $message = 'Las credenciales no coinciden';
    }
}
$titulo="Inicio";
require 'v2/vistas/login.php';
?>

