<?php
isset($_SESSION)?"":session_start();

include_once 'v2/classe/Usuario.php';
use v2\classe\Usuario;

$message = '';
  $a=new Usuario();
if($_POST){
if (!empty($_POST['dni_usu']) &&  !empty($_POST['token_usu']) && strlen($_POST['token_usu'])>=6 && !empty($_POST['nombre_usu'])) 
{
    $usuario=$_POST['dni_usu'];
    $nombre=$_POST['nombre_usu'];
    $ya_regis=$a->obtener_condni($usuario);
    if(!$ya_regis->dni)
    {
        $password=$a->encr($_POST['token_usu']);
        $results=$a->guardar_usuario($usuario, $nombre, $password, 'sin',0,0);
        if ($results) 
        {
            $message = '<p class="alert-success">Usuario creado con exito</p>';
            $usuar=$a->encr($usuario);
            $_SESSION['user_id']=$usuar;
            $_SESSION['token']="sin";
            $_SESSION['user_current'] = ucwords($usuar->nombre);

//            header("Location: ".DIR."/bienvenido");          
              echo "<script> window.location.href = '".DIRECCION."/bienvenido';</script>";  
              return;
        } else {
          $message = '<p class="alert-danger">Verifique los datos</p>';
        }
    }else{
      $message = '<p class="alert-danger">Ya existe este usuario</p>';
    }
}else{
  $message = '<p class="alert-danger">Los datos solicitados no estan completos</p>';
}
}
$titulo="Registro";
require 'v2/vistas/registro_v.php';

?>
