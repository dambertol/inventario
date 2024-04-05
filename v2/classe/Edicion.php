<?php
namespace v2\classe;
use v2\classe\Usuario;

class Edicion extends Usuario{
  private $user;

  public function __construct(Type $var = null) {
      parent::__construct();
      $this->user = $this->validar();
  }

  public function index(){//$tabla=null,$indice=null,$text=null){
    if($_GET || $_POST){
      $this->derivador();
    }else{
    $this->vista();
  }}

  private function derivador(){
    $this->corrobora();
    if(isset($_GET['accion'])){
      $tabla=$_GET['tabla']?$_GET['tabla']:"";
      $get=$_GET;
      unset($get['accion']);
      unset($get['tabla']);
      unset($get['indice']);
      $this->{$_GET['accion']}($tabla,$get);
    }elseif(!empty($_POST)){
      $this->eliminar();
    }else{
      $this->vista();
    }
  }
  
  private function vista($text=null){
    $tabla=$_GET['tabla']?$_GET['tabla']:"";
    $tablasT=array("cos","cos_estacionamientos","cos_permitidos","cos_retiros_especiales","cos_sub_usos","cos_usos","cos_zonas");
    !in_array($tabla,$tablasT)?$tabla="cos":"";
    $indice=isset($_GET['indice'])?$_GET['indice']:0;
    $tabla?$todos=$this->obtener_todos($tabla,$indice,$text):"";
    $ult=$this->obtener_ul($tabla);
    $titulo="edicion";
    require 'programa/vistas/editor_v.php'; 
  }
  

  private function crear($tabla,$get){
    if($_GET){
      $id=$this->idcorr($get);
      unset($get[$id[0]]);
      $this->guardar_($tabla,$get);
    }
    $this->vista();
  }

  private function editar($tabla,$get){
    if($_GET){
      $id=$this->idcorr($get);
      unset($get[$id[0]]);
      $this->modif_($tabla,$get,$id);  
    }
//   echo $get;  
//   echo $tabla;
// return;
    $this->vista();
  }

  private function consultar($tabla,$get){
    $text="";
    if(!empty($_GET)){
      foreach ($get as $key => $value) {
        $text.=$value!=""?" $key like '%".$value."%' ":"";
      }
        $indice=isset($_GET['indice'])?$_GET['indice']:0;
    };
    $this->vista($text);
  }

  private function eliminar($tabla,$get){ ///////////////////////
    if($_GET){
      $id=$this->idcorr($get);
      $this->eliminar_($tabla,$id);
        return true;    
    }
  }

  private function corrobora(){
    $get=array();
    if($_GET) foreach (array_values($_GET) as $key => $value) if($value) $get[$key]=addslashes($value);
    return $get;
  }

  private function idcorr($get){
    $id=array();
    if($_GET){
        foreach (array_keys($_GET) as $key => $value){ 
            if($value && stripos('id_',$value)){
                $id=[$value,$get[$value]];
                break;
            }
        }
    }
    return $id;
  }

public function crear_u(){
    $user=$this->user;
    
      if ($user->permiso!="admin" && $user->permiso!="admin_dto"  && $user->permiso!="dios")  {
        echo "<script> window.location.href = '".DIRECCION."/botonera';</script>"; //header("Location: ".DIR."/salir")
        return;
      }
    
    if (!empty($_POST['dni_usu']) && strlen($_POST['dni_usu'])>6 && !empty($_POST['token_usu']) && strlen($_POST['token_usu'])>=6 && !empty($_POST['nombre_usu'])) {
        $usuario=$_POST['dni_usu'];
        $nombre=$_POST['nombre_usu'];
        $ya_regis=$this->obtener_condni($usuario);
        
        if(!$ya_regis->dni) {
            $password=$this->encr($_POST['token_usu']);
            $results=$user->guardar_usuario($usuario, $nombre, $password, 'carga',0);
            if ($results) {
                $message = 'Usuario creado con exito';
                $_SESSION['message']=$message;
    //            header("Location: ".DIR."/");
              echo "<script> window.location.href = '".DIRECCION."/administrar_usuarios';</script>";
              return;
            } else {
              $message = 'verifique los datos';
              $_SESSION['message']=$message;
            }
        }else{
          $message = 'usuario duplicado';
          $_SESSION['message']=$message;
        }
    }else{
      if($_POST) $message = 'los datos solicitados no estan completos';
    }
    $titulo="Crear usuario";
    require 'v2/vistas/crear_v.php';
}

public function editables(){
  $user=$this->user;

    if ($user->permiso!="dios")  {
        echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
        return;
    }
    
        $botones[]=array("marcas_prod","marcas_prod","v2/src/admin_user.png","Administración de Usuarios");
        $botones[]=array("materiales_","materiales","v2/src/admin_user.png","Administración de Usuarios");
        $botones[]=array("transacciones","editartransacciones","v2/src/admin_user.png","Administración de Usuarios");
        $botones[]=array("locales","locales_edit","v2/src/admin_user.png","Administración de Usuarios");
    
    $titulo="configuracion";
    require 'v2/vistas/botonera_v.php';
}

public function localesedito()
{
  $user=$this->user;
    if($user->permiso!="dios"){
        echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
        return;
      }
      
      $indice=isset($_GET['indice'])?$_GET['indice']:0;
      $text=null;
      
      $tabla="locales";
      if($_GET){
        foreach (array_values($_GET) as $key => $value) {
          if($value){
            if (!preg_match('/^[a-zA-Z0-9\.\:\_\-\)\(\,\s]+$/', $value)) return false;
          }}
      
        if($_GET['crear']!=""){
          if((isset($_GET['id_proov_y_uvent']) && $_GET['id_proov_y_uvent']!="")&&(isset($_GET['local']) && $_GET['local']!="")&&(isset($_GET['circuito_esc']) && $_GET['circuito_esc']!="") &&(isset($_GET['nombre_local']) && $_GET['nombre_local']!="") &&(isset($_GET['domicilio_esc']) && $_GET['domicilio_esc']!="") &&(isset($_GET['localidad_esc']) && $_GET['localidad_esc']!="")){
              $columna=$_GET;
            if($_GET['crear']=='crear'){
              unset($columna['crear']);
              $this->guardar_($tabla,$columna);
            }else{ //editar
              $id=$_GET['crear'];
              unset($columna['crear']);
              $this->modif_($tabla,$columna,array("id_local",$id));
            }
          }
        }elseif($_GET['consultar']){
          if((isset($_GET['id_local']) && $_GET['id_local']!="")||(isset($_GET['id_proov_y_uvent']) && $_GET['id_proov_y_uvent']!="")||(isset($_GET['local']) && $_GET['local']!="")||(isset($_GET['circuito_esc']) && $_GET['circuito_esc']!="") ||(isset($_GET['nombre_local']) && $_GET['nombre_local']!="") ||(isset($_GET['domicilio_esc']) && $_GET['domicilio_esc']!="") ||(isset($_GET['localidad_esc']) && $_GET['localidad_esc']!="")){
            $text=$_GET['id_local']!=""?" id_local like '%".$_GET['id_local']."%' ":"";
            $text.=$_GET['id_proov_y_uvent']!=""?(($text!=null?"and":"")." id_proov_y_uvent like '%".$_GET['id_proov_y_uvent']."%' "):"";
            $text.=$_GET['local']!=""?(($text!=null?"and":"")." local like '%".$_GET['local']."%' "):"";
            $text.=$_GET['circuito_esc']!=""?(($text!=null?"and":"")." circuito_esc like '%".$_GET['circuito_esc']."%' "):"";
            $text.=$_GET['nombre_local']!=""?(($text!=null?"and":"")." nombre_local like '%".$_GET['nombre_local']."%' "):"";
            $text.=$_GET['domicilio_esc']!=""?(($text!=null?"and":"")." domicilio_esc like '%".$_GET['domicilio_esc']."%' "):"";
            $text.=$_GET['localidad_esc']!=""?(($text!=null?"and":"")." localidad_esc like '%".$_GET['localidad_esc']."%' "):"";
            $indice=isset($_GET['indice'])?$_GET['indice']:0;
        }}
      }elseif($_POST){
          foreach (array_values($_POST) as $key => $value) {
          if($value){
            if (!preg_match('/^[a-zA-Z0-9\.\:\_\-\)\(\,\s]+$/', $value)) return false;
          }}
      if(isset($_POST['accion'])){
          $id=$_POST['id_local'];
          $this->eliminar_($tabla,array('id_local',$id));
          return true;    
          exit;
      }}
      $todos=$this->obtener_todos($tabla,$indice,$text);
      foreach ($todos as $key => $value) {
          unset($todos[$key]['latitud_esc']);
          unset($todos[$key]['longitud_esc']);
      }
      
       $titulo="locales";
       require 'v2/vistas/locales_edit_v.php'; 
      
}

  public function administrar_usuarios(){
    $user=$this->user;
    if($user->permiso!="admin" && $user->permiso!="admin_dto" && $user->permiso!="dios")header("Location: ".DIR."/botonera");//{
      // echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
      // return;
    //}
    $indice=isset($_GET['indice'])?$_GET['indice']:0;
    $todos="";$text=null;
        
    if((isset($_GET['dni_usu']) && $_GET['dni_usu']!="")||(isset($_GET['nombre_usu']) && $_GET['nombre_usu']!="")||(isset($_GET['permiso_usu']) && $_GET['permiso_usu']!="")||(isset($_GET['nombre_local']) && $_GET['nombre_local']!="")){
      foreach (array_values($_GET) as $key => $value) {
        if($value &&(!preg_match('/^[a-zA-Z0-9\.\:\_\-]+$/', $value))) return false;
      }
      $text=$_GET['dni_usu']!=""?" u.dni_usu like '%".$_GET['dni_usu']."%' ":"";
      $text.=$_GET['nombre_usu']!=""?(($text!=null?"and":"")." u.nombre_usu like '%".$_GET['nombre_usu']."%' "):"";
      $text.=$_GET['permiso_usu']!=""?(($text!=null?"and":"")." u.permiso_usu like '%".$_GET['permiso_usu']."%' "):"";
      $text.=$_GET['nombre_local']!=""?(($text!=null?"and":"")." e.nombre_local like '%".$_GET['nombre_local']."%' "):"";
      $indice=isset($_GET['indice'])?$_GET['indice']:0;
    }else{
      if(isset($_POST['contrasegna'])){
        $dni=$_POST['contrasegna'];
        $enn=$this->encr("elecciones123");
        $this->modif_("usuarios",array("token_usu"=>$enn),array("dni_usu",$dni));
        return true;
        exit;
      }elseif(isset($_POST['permiso'])&&isset($_POST['dni'])){
        $dni=$_POST['dni'];
        $perm= $_POST['permiso'];
        $guarda =$this->modif_("usuarios",array("permiso_usu"=>$perm,$dni,"id_local"=>'0'),array("dni_usu",$dni));
        return true;
      }}
      
    if($user->permiso=="admin_dto"){
      $text!=null?$text.=" and u.id_proov_y_uvent='$user->dto' ":$text=" u.id_proov_y_uvent='$user->dto' ";
    }
    $todos=$this->obtener_todos_u($indice,$text);
    $titulo="usuarios";
    require 'v2/vistas/administrar_usuario_v.php';     
  }

  public function contra_mod(){
    $user=$this->user;
    $message="";
    $userEsc =$this->consultar_localxusu($user->esc); 
    $transaccionesXusu=$this->transacciones_Xfiscal($user->dni);

    if($_POST){
      $contrasegna=$_POST['token_usu'];
      if (strlen($contrasegna)>5) {
        $dni=$user->dni;
        $enn=$this->encr($contrasegna);
        $this->modif_("usuarios",array("token_usu"=>$enn),array("dni_usu",$dni));
        $_SESSION['message']="Contraseña Modificada";      
        header("Location: ".DIR."/botonera");
      }else{
        //$_SESSION['message']="la contraseña es muy corta";
          $message.="la contraseña es muy corta";

      }
    }
    $titulo="contraseña";
    require 'v2/vistas/contra_mod_v.php';
  }

  public function locales_mod(){
    $user=$this->user;
    if($user->permiso!="admin" && $user->permiso!="admin_dto") header("Location: ".DIR."/Botonera");

    $id_proov_y_uvent=$this->dto;
    $message="";$user;
    $usuario=($_GET['dni']);
    $user =$this->obtener_condni($usuario);
    $sSQL=$id_proov_y_uvent==0?"SELECT * FROM proov_y_uventas;":"SELECT * FROM proov_y_uventas where id_proov_y_uvent=$id_proov_y_uvent;";
    $depto = $this->consulta_r($sSQL);
    $circuito;
    $usuarioEsc = $this->consultar_localxusu($user->esc);   
  
    if(isset($_POST['local']))
    {
      $esc=(int) $_POST['local'];
      $guarda = $this->modif_("usuarios",array("id_local"=>$esc),array("dni_usu",$usuario));

      if (!$guarda) 
      {
        $message.="actualizado con exito" ;
        header("Location: ".DIR."/administrar_usuarios");
      }else{
        $message.="falló la actualizacion" ;
      }
    }else{
        if(isset($_POST['dep']) || !empty($usuarioEsc) && isset($usuarioEsc["id_proov_y_uvent"]))
        {    
          if(isset($usuarioEsc["id_proov_y_uvent"])) $_POST['dep']= $usuarioEsc["id_proov_y_uvent"];
          $deptoo=(int)$_POST['dep'];
          $SQLl="SELECT e.id_local, e.local, v.nombre_proov_y_uvent, e.circuito_esc, e.nombre_local, e.domicilio_esc, e.localidad_esc FROM locales e left join proov_y_uventas v on e.id_proov_y_uvent=v.id_proov_y_uvent where e.id_proov_y_uvent=$deptoo order by id_local;";
          $circuito = $this->consulta_r( $SQLl);
        }
    }
    $titulo="locales";
    require 'v2/vistas/locales_mod_v.php';
  }
}