<?php
namespace v2\classe;
use v2\classe\Usuario;
use v2\classe\Informacion;

class Carga extends Usuario{
private $user;

public function __construct() {
    parent::__construct();
    $this->user = $this->validar();
}

public function searchActas($n_transaccion){
    $SQL = "SELECT * FROM actas_guardadas WHERE id_transaccion='".$n_transaccion."' order by id_acta desc";
    $result = $this->consulta_r( $SQL);
    if ($result) {
        return  $result;
    } else {
        return "error";
    }
}

public function searchTransaccion($n_transaccion){
    $SQL = "SELECT * FROM transacciones WHERE id_transaccion='".$n_transaccion."' order by fecha desc";
    $result = $this->consulta_r( $SQL);
    if ($result) {
        return  $result;
    } else {
        return "error";
    }
}

public function savevolumen($transaccion,$id_marcas_prod,$id_tipo,$id_proov_y_uvent,$id_material,$volumen){

    $SQL = "SELECT * FROM cant_transac WHERE id_transaccion='".$transaccion."' AND id_marcas_prod='".$id_marcas_prod."' AND id_proov_y_uvent='".$id_proov_y_uvent."'  AND id_tipo='".$id_tipo."'  ";     
    $result = $this->consulta_r( $SQL);

     if ($result==null) {
        //  $SQL2="INSERT INTO cant_transac VALUES(null,'".$transaccion."','".$id_marcas_prod."','".$id_tipo."','".$id_proov_y_uvent."','".$id_material."','".$volumen."')";
        //  $this->consulta_r( $SQL2);
         $this->guardar_("cant_transac",array('id_cant_transac'=>null,'id_transaccion'=>$transaccion,'id_marcas_prod'=>$id_marcas_prod,'id_tipo'=>$id_tipo,'id_proov_y_uvent'=>$id_proov_y_uvent,'id_material'=>$id_material,'salida_u'=>$volumen['0'],'entrada_u'=>$volumen['1'],'valor_u'=>$volumen['2'],'total_tr'=>$volumen['3']) );
     }else{
       // var_dump($result);
        //  $SQL2="UPDATE cant_transac SET total_tr=".$volumen." WHERE id_cant_transac=".$result['id_cant_transac'].";";//."' AND id_marcas_prod='".$id_marcas_prod."' AND id_proov_y_uvent='".$id_proov_y_uvent."' AND id_tipo='".$id_tipo."'  "   
        //  $this->consulta_r( $SQL2);
         $this->modif_("cant_transac",array('salida_u'=>$volumen['0'],'entrada_u'=>$volumen['1'],'valor_u'=>$volumen['2'],'total_tr'=>$volumen['3']), array('id_cant_transac',$result[0]['id_cant_transac']));
     }
 }

//  public function saveResultados($transaccion,$id_postulante,$id_proov_y_uvent,$datos=array()){      
//      //////GENERADOS COMO marcas_prod
//      $arr=array(1=>21,2=>22,3=>23,4=>20);
//      foreach ($arr as $key => $value) {
//          $SQL = "SELECT * FROM cant_transac WHERE id_transaccion=".$transaccion." AND id_tipo=".$id_postulante." AND id_material=".$value.";";
//          $result = $this->consulta_r( $SQL); 
//          if (count($result) == 0) {
//              if($datos[$key]!=0){
//                  $SQL2="INSERT INTO cant_transac VALUES(null,".$transaccion.",0,".$id_postulante.",".$id_proov_y_uvent.",".$value.",".$datos[$key].")";
//                  $this->consulta_r( $SQL2);
//              }
//          }else{
//              $result=($result);
//              $SQL2="UPDATE cant_transac SET total_tr=".$datos[$key]." WHERE id_cant_transac=".$result['id_cant_transac'].";";                   
//              $this->consulta_r( $SQL2);           
//          }
//      }       
//  }
 /* otras*/
 private function descargar_($id_proov_y_uvent="",$id_local=""){
     $xtra="";$xtra2="";
     if(!empty($id_proov_y_uvent)) $xtra=" WHERE cant_transac.id_proov_y_uvent='$id_proov_y_uvent' "; 
     if(!empty($id_local)) $xtra2=!empty($id_proov_y_uvent)?" AND transacciones.id_local='$id_local' ":" WHERE transacciones.id_local='$id_local' ";

     $SQL="SELECT  proov_y_uventas.nombre_proov_y_uvent as proov_y_vent, locales.localidad_esc as distrito, locales.circuito_esc, materiales.nombre_material as materiales, concat(marcas_prod.nombre_marca_prod,marcas_prod.interna_marcas_y_prod) as marcas_y_prod, SUM(cant_transac.total_tr) as volumen FROM cant_transac left join transacciones on cant_transac.id_transaccion=transacciones.id_transaccion left join marcas_prod on cant_transac.id_marcas_prod=marcas_prod.id_marcas_prod left join materiales on cant_transac.id_material=materiales.id_material left JOIN locales ON transacciones.id_local=locales.id_local and transacciones.id_local=locales.id_local left join proov_y_uventas on cant_transac.id_proov_y_uvent=proov_y_uventas.id_proov_y_uvent $xtra $xtra2 group by locales.localidad_esc , marcas_prod.nombre_marca_prod, marcas_prod.interna_marcas_y_prod order by proov_y_uventas.nombre_proov_y_uvent, locales.localidad_esc, materiales.nombre_material"; 

     $result = $this->consulta_r( $SQL);          
     return $result;
 }

public function carga(){
    $user=$this->user;  
    if($user->permiso!="admin" && $user->permiso!="admin_dto"&& $user->permiso!="carga" && $user->permiso!="editor"&& $user->permiso!="visualizar" && $user->permiso!="visual_dto"  && $user->permiso!="dios"){
      echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
      return;
    }
  
  $locales=$user->consultar_localxusu($user->esc);
  if(is_object($locales))$locales=array('0'=>$locales);
  
  $proov_y_uv_Xlocal;
  if(is_array($locales) && count($locales)==1){
    $proov_y_uv_Xlocal=json_decode($user->proov_y_uy_xlocal($locales->id_local),true);
    if(is_object($proov_y_uv_Xlocal))$proov_y_uv_Xlocal=array('0'=>$proov_y_uv_Xlocal);
  }else{
    $b= new Informacion();
    $proov_y_uv_Xlocal=json_decode($b->searchproov_y_uventas(),true);
  }
  
    if($user->permiso=="carga" || ($user->permiso=="admin_dto")){
      if(empty($proov_y_uv_Xlocal))  header("Location: ".DIR."/bienvenido");
    }
    $transaccion=isset($_GET["transaccion"])?$_GET["transaccion"]:0; //si viene del buscador de transacciones
    if(isset($proov_y_uv_Xlocal)&& !empty($proov_y_uv_Xlocal)){ 
        $proovyuv;
        foreach ($proov_y_uv_Xlocal as $key => $value) {
          $proovyuv[$value['id_proov_y_uvent']]=$value['nombre_proov_y_uvent'];
        }
          $proovyuv2=json_encode($proovyuv);
      }
          $titulo="carga de actas";

require "v2/controladores/carga.php";
}

public function grilla(){ $this->arma();}

public function grilla_mob(){ $this->arma(true);}

protected function arma($mob=false){
    $user=$this->user;
    $db = new Informacion();
    if(isset($_POST['id_transaccion'])){
        $transaccion=$_POST['id_transaccion'];
        $id_proov_y_uvent="";
        $id_local="";
        $SQL = "SELECT * FROM transacciones m inner join locales e on m.id_local = e.id_local inner join proov_y_uventas d on m.id_proov_y_uvent = d.id_proov_y_uvent WHERE m.id_transaccion='".$transaccion."' ";
        $datos_trans = $this->consulta_r( $SQL);
        if($datos_trans=='0'||$datos_trans==null)return false;
        $proov_y_vent=$datos_trans[0]['id_proov_y_uvent'];
    }elseif($_POST['id_proov_y_uvent']){
        $id_proov_y_uvent=$_POST['id_proov_y_uvent'];
        $id_local=$_POST['id_local'];
        $transaccion=0;
        $SQL = "SELECT *, '0' as fecha FROM locales e inner join locales_prooyu m on m.id_local = e.id_local inner join proov_y_uventas d on m.id_proov_y_uvent = d.id_proov_y_uvent WHERE m.id_local='".$id_local."' and m.id_proov_y_uvent='".$id_proov_y_uvent."' ";
        $datos_trans =$this->consulta_r( $SQL);
        $proov_y_vent=$id_proov_y_uvent;
    }
    var_dump($datos_trans);
    $results = json_decode($db->searchmarcas_prod($proov_y_vent),true);
    $volumen_realizados = json_decode($db->searchvolumen((int)$proov_y_vent,(int)$transaccion),true);

    if($volumen_realizados){
        foreach ($volumen_realizados as $key => $value) {
            $datavolumen[$value["id_marcas_prod"]."-".$value["id_tipo"]]=array("cantidad"=>$value["total_tr"]);
        }
    }

    $dataPosproov_y_vent=[1,2,3,4];
    $actas=$this->searchActas($transaccion);
    if($datos_trans=='0'||$datos_trans==null)return false;
    if($mob){
        require "v2/controladores/grillaMobile.php";
    }else{
        require "v2/controladores/grilla.php";
    }
}

public function guardar_inf(){
    $user=$this->user;
    if($user->permiso!="admin" && $user->permiso!="admin_dto"&& $user->permiso!="carga" && $user->permiso!="editor" && $user->permiso!="dios"){
        echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
        return;
    }
    isset($message)?"":$message="";

    if($_POST['transaccion_sel']!=""){
        $transaccion=$this->searchTransaccion((int)$_POST['transaccion_sel']);
    }elseif($_POST['proov_y_vent_sel'] && $_POST['id_local']){
        $transaccion=array("id_transaccion"=>null,"id_proov_y_uvent"=>(int)$_POST['proov_y_vent_sel'],"id_local"=>(int) $_POST['id_local'],"saldo_ant"=>$_POST['saldo_ant'],"fecha"=>date(),"id_usuario"=>$this->user->dni,"pago_tr"=>$_POST['pago'],"saldo_pos"=>$_POST['diferencia'],"importe_tr"=>$_POST['importe']);
        $result = $this->guardar_("transacciones",$transaccion);
        if ($result) $transaccion['id_transaccion']=$result;
        $transaccion=[0=>$transaccion];
    }



    $transaccionesX;
    if ($user->permiso=="carga" ||$user->permiso=="admin_dto" ){
        if($user->permiso=="carga"){
            $transaccionesXusu=$this->transacciones_Xfiscal($usuario);
        }else{
            $transaccionesXusu=$this->transacciones_Xdto($user->dto);
        }
        foreach ($transaccionesXusu as $key => $value) $transaccionesX[]=(int)$value[0];
    }
    if ((($user->permiso=="carga" && $transaccion=="error" && in_array(((int)$_POST['transaccion_sel']),$transaccionesX))||($user->permiso=="admin_dto" && in_array(((int)$_POST['transaccion_sel']),$transaccionesX))||$user->permiso=="editor" ||$user->permiso=="admin"||$user->permiso=="admin_dto"||$user->permiso=="dios")) {



//        $diferencia=$_POST["saldo_ant"] - $_POST["pago"];
            $nombre_archivo="";
            if($_FILES["image"]["name"]){
                $allowedExtensions = ["jpg", "jpeg", "png", "gif", "pdf"];
                $fileExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                if (in_array($fileExtension, $allowedExtensions)) {
                    $directorio_destino = "v2/actas/";
                    $nombre_archivo = date("d-m-Y h:i:s")."_".(int)$_POST['transaccion_sel'].".".$fileExtension;
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $directorio_destino . $nombre_archivo)) {
                        $message.= "El archivo se ha cargado correctamente.";
                    } else {
                        $message.= "Hubo un error al guardar el archivo.";
                    }
                }else{
                        $message.="formato de archivo invalido";
                }
            }


       //     $totalCategorias= count($_POST["blancos"]);
                // for($i=1;$i<5;$i++){
                //     if(isset($_POST["tipo".$i])){
                //         foreach ($_POST["tipo".$i] as $key => $value) {
                //                 $partes=explode("-",$key);
                //                 $this->savevolumen($_POST['transaccion_sel'],$partes[0],$partes[1],$_POST['proov_y_vent_sel'],$partes[2],$value);////////////////
                //             //}
                //         }
                //     }
                // }

            //    for($i=1;$i<5;$i++){
            if(isset($_POST["tipo1"])){
                foreach ($_POST["tipo1"] as $key => $value) {
                    $partes=explode("-",$key);
                    $col1=$_POST["tipo1"][$partes[0]."-1-".$partes[2]];
                    $col2=$_POST["tipo2"][$partes[0]."-2-".$partes[2]];
                    $col3=$_POST["tipo3"][$partes[0]."-3-".$partes[2]];
                    $col4=$_POST["tipo4"][$partes[0]."-4-".$partes[2]];
                    if($col1!=0 ||$col2!=0 ||$col3!=0 ||$col4!=0){
                        $valores=array($col1,$col2,$col3,$col4);
                        $this->savevolumen($_POST['transaccion_sel'],$partes[0],$partes[1],$_POST['proov_y_vent_sel'],$partes[2],$valores);
                    }
                }
            }
            //    }





                // for($i=1;$i<=$totalCategorias;$i++){	
                //     if(isset($_POST['nulos'][$i]) || isset($_POST['recurridos'][$i]) || isset($_POST['impugnados'][$i]) || isset($_POST['blancos'][$i])  ){				
                //         $datos[1]=$_POST['nulos'][$i];
                //         $datos[2]=$_POST['recurridos'][$i];
                //         $datos[3]=$_POST['impugnados'][$i];
                //         $datos[4]=$_POST['blancos'][$i];		
                //         $db->saveResultados($_POST['transaccion_sel'],$i,$_POST['proov_y_vent_sel'],$datos);		
                //     }
                // }

             //   $this->saveVotantes($_POST['transaccion_sel'],$_POST["saldo_ant"],$_POST["boletas_unica"],$diferencia);
             var_dump($user);
                $data = array(
                    "id_transaccion" => $_POST['transaccion_sel'],		
                    "fecha_acta" => date("Y-m-d H:i:s"),
                    "id_usuario" =>$user->dni,
                    "imagen_acta"=>$nombre_archivo);
$guarda=$this->guardar_("actas_guardadas", $data);
var_dump($guarda);
if($guarda){
            //    if ($this->guardar_("actas_guardadas", $data)) {
                    $message.="Datos guardados correctamente.";
                } else {
                    $message.="Error al guardar los datos.";
                }



        $_SESSION['message']=$message;
        header("Location: ".DIR."/cargar_acta");	
        return;
    }
    $_SESSION['message']="sin permiso de edicion de transaccion - ".$message;
    header('location: '.DIR.'/cargar_acta');
    return;
}

public function insertData($table, $data){
    $columns = implode(', ', array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    $lastInsertId=$this->guardar( $sql);
    return $lastInsertId;
}
}