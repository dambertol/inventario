<?php
namespace v2\classe;
use v2\classe\Usuario;
use v2\classe\Informacion;

class Informacion2 extends Usuario{
private $user;

    public function __construct(Type $var = null) {
        parent::__construct();
        $this->user = $this->validar();
    }
    
    /////////////////////////////////GUARDAR DATOS ACTAS

    public function detalle_transaccion(){ //arreglar
        if($this->user->permiso!="admin" && $user->permiso!="visualizar" && $user->permiso!="visual_dto" && $user->permiso!="admin_dto" && $user->permiso!="editor")  return false;
            $circuito = $_GET['local'];
        $SQL = "SELECT e.local, m.id_transaccion, ag.imagen_acta, v_m.id_cant_transac as pago_tr FROM transacciones m inner join locales e on m.id_local=e.id_local left join actas_guardadas ag on m.id_transaccion=ag.id_transaccion left join cant_transac v_m on m.id_transaccion=v_m.id_transaccion WHERE e.id_local=$circuito group by m.id_transaccion order by m.id_transaccion desc;";
        $result = $this->consulta_r( $SQL);       
        echo json_encode($result);
    }


    public function descargar(){
        $user=$this->user;
        if($user->permiso!="admin" && $user->permiso!="visualizar" && $user->permiso!="visual_dto" && $user->permiso!="admin_dto" && $user->permiso!="editor" && $user->permiso!="dios") header("Location: ".DIR."/botonera");

          if($user->esc==0){
            $elementos = $this->descargar_();
          }else{
            $elementos = $this->descargar_(null,$user->esc);
          }
          $acentos = array(
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
            'Ä' => 'A', 'Ë' => 'E', 'Ï' => 'I', 'Ö' => 'O', 'Ü' => 'U',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
            'À' => 'A', 'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U',
            'â' => 'a', 'ê' => 'e', 'î' => 'i', 'ô' => 'o', 'û' => 'u',
            'Â' => 'A', 'Ê' => 'E', 'Î' => 'I', 'Ô' => 'O', 'Û' => 'U',
            'ñ' => 'n', 'Ñ' => 'N',
            'ç' => 'c', 'Ç' => 'C'
        );
          $titulo="contraseña";
          require 'v2/vistas/descargar_v.php';
        }

    public function reset(){
        $b=new Usuario();
        $user=$this->validar();
        if($user->permiso!="admin"){
            echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
            return;
        }
        if(isset($_GET["reset"])=="ok"){
            echo "vacio las tablas correctamente";
        }else{
            echo "pasar parametro reset";
        }
        $this->consulta_r("TRUNCATE TABLE cant_transac ");
        $this->consulta_r("TRUNCATE TABLE votantes ");
        $this->consulta_r("TRUNCATE TABLE actas_guardadas ");
    }    

    public function grafico1(){
        $user=$this->user;

        $id_proov_y_uvent=isset($_GET["id_proov_y_uvent"])?$_GET["id_proov_y_uvent"]:"";
        $distrito=isset($_GET["distrito"])?$_GET["distrito"]:"";
        $id_tipo=$_GET["id_tipo"];

        $xtra=""; $xtra2="";$xtra3="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" WHERE cant_transac.id_proov_y_uvent='$id_proov_y_uvent' ";
        if(isset($id_tipo) && !empty($id_tipo)) !empty($id_proov_y_uvent)?$xtra3=" AND cant_transac.id_tipo='$id_tipo' ":$xtra3=" WHERE cant_transac.id_tipo='$id_tipo' "; 
        if(isset($distrito) && !empty($distrito)) $xtra2=" inner JOIN locales ON cant_transac.id_proov_y_uvent = locales.id_proov_y_uvent AND locales.localidad_esc='".$distrito."'and transacciones.id_local=locales.id_local ";       

        $SQL="SELECT materiales.nombre_material as nombre,SUM(cant_transac.total_tr) as cantidad  from cant_transac inner JOIN marcas_prod on cant_transac.id_marcas_prod=marcas_prod.id_marcas_prod LEFT JOIN materiales on marcas_prod.id_material=materiales.id_material inner JOIN transacciones  on cant_transac.id_transaccion=transacciones.id_transaccion".$xtra2.$xtra.$xtra3." GROUP BY materiales.id_material;";
        $data = $this->consulta_r( $SQL);        
       
        $arr=array();$arr2=array();
        if($data){
            foreach ($data as $key => $value) {		
                $arr[]=$data[$key]["nombre"];
                $arr2[]=$data[$key]["cantidad"];
            }
        }
        $data2["labels"]=$arr;
        $data2["valores"]=$arr2;
        echo json_encode($data2);
    }

    public function escrutados(){
        $user=$this->user;
        if($user->permiso!="admin" && $user->permiso!="visualizar" && $user->permiso!="visual_dto" && $user->permiso!="admin_dto" && $user->permiso!="editor" && $user->permiso!="dios"){
            header("Location: ".DIR."/botonera");
        }
        $indice=isset($_GET['indice'])?$_GET['indice']:0;
        $message;
        $dto=($user->dto)!=0?$user->dto:"";
        $depto=$dto;
        if($dto=="") $depto = $this->consulta_r("SELECT * FROM proov_y_uventas;");

        $circuito;$cant=0;
        if($dto||isset($_GET['dep'])){
            if($dto=="" && $_GET['dep'])$dto=$_GET['dep'];
            if(!empty($dto)){
                $indice<0?$indice=0:"";
                $SQLl="SELECT v.id_local, e.local, d.nombre_proov_y_uvent, e.circuito_esc, e.nombre_local, count(distinct(v.id_transaccion)) as total, count(distinct(ag.id_transaccion)) as escrut FROM transacciones v left join locales e on v.id_local=e.id_local left join actas_guardadas ag on v.id_transaccion=ag.id_transaccion left join proov_y_uventas d on v.id_proov_y_uvent=d.id_proov_y_uvent where v.id_proov_y_uvent= $dto group by v.id_local order by v.id_local LIMIT ".($indice*20).", 20;";
                $circuito = $this->consulta_r($SQLl);

                $SQ="SELECT CEILING(count(distinct(v.id_local))/20) as cant FROM transacciones v left join locales e on v.id_local=e.id_local where v.id_proov_y_uvent= $dto;";
                $cant = ((int)$this->consulta_r($SQ)['cant'])-1;
            }
        }
        $titulo="locales escrutadas";
        require 'v2/vistas/escrutados_v.php'; 
    }
}
?>