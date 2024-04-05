<?php
use v2\classe\Usuario;
$b=new Usuario();
$user=$b->validar();

$mysqli = $b->connection;
$message;

    if($user->permiso=="carga" && $user->esc==0)
    {
      $sSQL="SELECT * FROM proov_y_uventas;";
      $result3 = mysqli_query($mysqli, $sSQL);
      $depto = mysqli_fetch_all($result3);
      unset($depto[18]);  //id de provincia
      $circuito;
      if(isset($_POST['local']))
      {
        $esc=(int) $_POST['local'];
        $esc_as =$b->consultar_localxusu($usuario,$esc);
        if ($esc_as) 
        {
          $message="esta local ya ha sido asignada, en caso de error comuniquese con el administrador";
        }else{
          $guarda =$b->modif_local($usuario,$esc);
          if ($guarda) 
          {
            $message.="actualizado con exito" ;
            header("Location: ".DIR."/botonera");  
          //  echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
            return;
          }else{
            $message.="falló la actualizacion" ;
          }
        }
      }else{
          if(isset($_POST['dep']))
          {
            $deptoo=(int)$_POST['dep'];
            $SQLl="SELECT e.id_local, e.local, v.nombre_proov_y_uvent, e.circuito_esc, e.nombre_local, e.domicilio_esc, e.localidad_esc FROM locales e left join proov_y_uventas v on e.id_proov_y_uvent=v.id_proov_y_uvent where e.id_proov_y_uvent=$deptoo order by id_local;";
            $resu = mysqli_query($mysqli, $SQLl);
            $circuito = mysqli_fetch_all($resu);     
          }
      }
    }else{
      header("Location: ".DIR."/botonera");
      //echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
      return;
    }
  
  $titulo="locales";
  require 'v2/vistas/bienvenido_v.php'; 

?>
