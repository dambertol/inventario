<?php
namespace v2\classe;
use v2\classe\Conexion;

class Usuario extends Conexion{
public $contra;
public $nombre;
public $dni;
public $permiso;
public $esc;
public $dto;
//public $connection;

public function __construct($dni=null,$nombre=null,$contra=null,$permiso=null,$esc=null) {
    parent::__construct();
    $this->contra=$contra;
    $this->nombre=$nombre;
    $this->dni=$dni;
    $this->permiso=$permiso;
    $this->esc=$esc;
}

public function obtener_todos_u($offset=0, $where=null){
    $extra=empty($where)?"":' where '.$where;
    $offset<0?$offset=0:"";
    $SQL="SELECT u.dni_usu, u.nombre_usu, u.permiso_usu , u.id_local, e.nombre_local FROM usuarios u left join locales e on u.id_local=e.id_local ".$extra." order by u.dni_usu LIMIT ".((int)$offset*20).", 20;";
    $res=$this->consulta_r($SQL);
    return $res;
}

public function obtener_condni($dni){
    if(!preg_match('/^[a-zA-Z0-9\.\:\_\-]+$/', $dni))return false;
    $SQL="SELECT usuarios.*, locales.id_proov_y_uvent FROM usuarios left join locales on locales.id_local=usuarios.id_local WHERE dni_usu = '$dni';";
    $row=$this->consulta_r($SQL)[0];
    $usu=new Usuario($row['dni_usu'], $row['nombre_usu'], $row['token_usu'],$row['permiso_usu'],$row['id_local'],$row['id_proov_y_uvent']);
    return $usu;
}

public function consultar_localxusu($esc=0){
    $xtra=$esc=='0'?"":"inner join usuarios on usuarios.id_local = locales.id_local WHERE usuarios.id_local = $esc";
    $SQL="SELECT locales.* FROM locales  $xtra;";
    $res=$this->consulta_r($SQL);
    return $res;
}

public function transacciones_Xfiscal($dni){
    if(!preg_match('/^[a-zA-Z0-9\.\:\_\-]+$/', $dni))return false;
    $SQL="SELECT m.id_transaccion FROM transacciones m inner join usuarios u on m.id_local=u.id_local WHERE u.dni_usu = '$dni';";
    $res=$this->consulta_r($SQL);
    return $res;
}

public function proov_y_uy_xlocal($id_local="", $tipo=null){ //devuelve proov y unidades de venta por local
    if(!preg_match('/^[a-zA-Z0-9\.\:\_\-]+$/', $dni))return false;
    $xtra=$id_local==""?"":"WHERE l.id_local = $id_local";
    $xtra2=$tipo!=null?($id_local==""?"where m.tipo = $tipo":"and m.tipo = $tipo"):"";

    $SQL="SELECT m.*  FROM proov_y_uvent m inner join locales_prooyu l on m.id_proov_y_uvent=l.id_proov_y_uvent $xtra $xtra2 group by m.id_proov_y_uvent, m.nombre_proov_y_uvent, m.tipo ;";
    $res=$this->consulta_r($SQL);
    return $res;
}

public function guardar_usuario($dni,$nombre,$contra,$permiso=''){
    if(!preg_match('/^[a-zA-Z0-9\.\:\_\-]+$/', $dni))return false;
    if(!preg_match('/^[a-zA-Z0-9\.\:\_\-\s]+$/', $nombre))return false;
    $SQL="INSERT INTO usuarios VALUES('$dni','$nombre','$contra','$permiso',0);";
    $res=$this->guardar($SQL);
    return $res;
}

public function encr($usuario){
    if(!preg_match('/^[a-zA-Z0-9\.\:\_\-]+$/', $usuario))return false;
    $usuar = base64_encode($usuario);//,MET,COD,FALSE,METHOD);
    return $usuar;
}

public function desenc($usuario){
    $usuar = base64_decode($usuario);//,MET,COD,FALSE,METHOD);
    return $usuar;
}

public function validar(){
    $b=new Usuario();
    $user;$usuario;
  
    if (isset($_SESSION['user_id'])){
        $usuario=$b->desenc($_SESSION['user_id']);
        $user =$b->obtener_condni($usuario);
        if(!$user) {
            header("Location: ".DIR."/salir");
            return;
        }
    }else{
        header("Location: ".DIR."/salir");
        return;
    }
    return $user;
}
}?>