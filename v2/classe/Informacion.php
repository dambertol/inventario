<?php
namespace v2\classe;
use v2\classe\Conexion;

class Informacion extends Conexion{
///////////////////////////////BUSCAR ACTAS
    public function searchmarcas_prod($id_proov_y_uvent, $id_tipo="")
    {
        $SQL = "SELECT *, CONCAT(l.nombre_marca_prod,' ',l.interna_marcas_y_prod) as nombre FROM marcas_prod l inner join materiales a on l.id_material=a.id_material WHERE  l.id_proov_y_uvent='".$id_proov_y_uvent."' AND l.real_marcas_y_prod='1' ORDER BY a.id_material ASC , l.id_marcas_prod ASC";        
        $result = $this->consulta_r( $SQL);         
        return json_encode($result);
    }

    public function searchmarcas_prod2($id_proov_y_uvent){
        $SQL = "SELECT CONCAT(l.nombre_marca_prod,' ',l.interna_marcas_y_prod) as nombre, a.id_material, a.nombre_material, a.color_rgb, l.id_marcas_prod FROM marcas_prod l left join materiales a on a.id_material=a.id_material WHERE  l.id_proov_y_uvent='$id_proov_y_uvent' AND l.real_marcas_y_prod='1' GROUP BY l.nombre_marca_prod ORDER BY l.nombre_marca_prod DESC";   
        $result = $this->consulta_r( $SQL);          
        return json_encode($result);
    }

    public function searchmarcas_prodGenerales(){
        $SQL = "SELECT l.nombre_marca_prod as nombre_marcas_y_prod, a.nombre_material as nombre, a.id_material, a.color_rgb as color FROM marcas_prod l left join materiales a on l.id_material=a.id_material WHERE l.real_marcas_y_prod='1' GROUP BY l.nombre_marca_prod ORDER BY l.nombre_marca_prod DESC";
        $result = $this->consulta_r( $SQL);
        return json_encode($result);
    }

    public function searchmarcas_prodNombre($nombre,$id_proov_y_uvent){
        $SQL = "SELECT id_marcas_prod FROM marcas_prod l WHERE l.nombre_marca_prod='".$nombre."' AND l.id_proov_y_uvent='".$id_proov_y_uvent."' ";
        $result = $this->consulta_r( $SQL);
        return  $result;
    }

    public function searchvolumen($id_proov_y_uvent,$transaccion) {
        $SQL = "SELECT * FROM cant_transac WHERE  id_proov_y_uvent='".$id_proov_y_uvent."' AND id_transaccion='".$transaccion."'   ";
        $result = $this->consulta_r( $SQL);          
        return json_encode($result);
    }

    public function searchproov_y_uventas(){
        $SQL = "SELECT * FROM proov_y_uventas where id_proov_y_uvent ORDER BY id_proov_y_uvent";  
        $result = $this->consulta_r( $SQL);        
        return json_encode($result);
    }

    public function searchLocales($id_local=null){
        $xtra=(isset($id_local) && !empty($id_local))?"WHERE id_local='$id_local'":"";

        $SQL = "SELECT local_ as local FROM locales $xtra GROUP BY local_ ORDER BY local_";
        $result = $this->consulta_r( $SQL);
        if(isset($result['local']))$result=array(['local'=>$result['local']]);
        return json_encode($result);
    }
    /* charts -------------------------------------------------------------------------*/
    
    public function transaccionesHabilitadas($id_proov_y_uvent="",$distrito="",$esc=null){ //mejora de distrito
        $xtra="";$xtra2="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" WHERE transacciones.id_proov_y_uvent='$id_proov_y_uvent' ";

        if(isset($distrito) && !empty($distrito)) $xtra2=" inner JOIN locales ON transacciones.id_local=locales.id_local AND locales.localidad_esc='".$distrito."' ";
        if(isset($esc) && !empty($esc)) $xtra2=" inner JOIN locales ON transacciones.id_local=locales.id_local AND transacciones.id_local=$esc ";

        $SQL="SELECT COUNT(id_transaccion) as habilitadas FROM transacciones ".$xtra2." ".$xtra."  ";
        $result = $this->consulta_r( $SQL);
        return json_encode($result);
    }

    // public function traer_todo2(){
    //     $SQL="SELECT cant_transac.id_proov_y_uvent as id_dto, materiales.nombre_material as nombre,SUM(cant_transac.total_tr) as cantidad, cant_transac.id_tipo,materiales.color_rgb as color from cant_transac LEFT JOIN materiales on cant_transac.id_material=materiales.id_material where cant_transac.id_tipo in (4,5) and cant_transac.id_material not in (20,21,22,23) GROUP BY cant_transac.id_proov_y_uvent, cant_transac.id_tipo, materiales.id_material;";
    //     $result = $this->consulta_r( $SQL);      
    //     return json_encode($result);
    // }
    
    // public function escrutadosXdepto(){
    //     $SQL="SELECT transacciones.id_proov_y_uvent, COUNT(DISTINCT transacciones.id_transaccion) as total, COUNT(DISTINCT actas.id_transaccion) as cuenta FROM transacciones left join actas_guardadas actas on transacciones.id_transaccion=actas.id_transaccion group by transacciones.id_proov_y_uvent; ";
    //     $result = $this->consulta_r( $SQL);           
    //     return $result;
    // }

    // public function traer_todo(){
    //     $tabla = json_decode($this->traer_todo2());
    //     $escrut = $this->escrutadosXdepto();
    //     $limpio=array();
        
    //     foreach ($escrut as $key => $value) $limpio[$value['id_proov_y_uvent']]=$value['cuenta']==0?0:round(($value['cuenta']/$value['total'])*100, 2);
    //     foreach ($tabla as $key=>$value) {
    //         $tabla[$key]->escrutados=$limpio[$value->id_dto];
    //     }
    //     return json_encode($tabla);
    // }

    public function transaccionesEscrutadas($id_proov_y_uvent="",$distrito="",$esc=null){   
        $xtra="";$xtra2="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" where transacciones.id_proov_y_uvent='$id_proov_y_uvent' ;";
        if(isset($distrito) && !empty($distrito)) $xtra2=" inner JOIN locales ON transacciones.id_proov_y_uvent=locales.id_proov_y_uvent AND locales.localidad_esc='".$distrito."' and transacciones.id_local=locales.id_local ";
        if(isset($esc) && !empty($esc)){ 
            $xtra2=" inner JOIN locales ON transacciones.id_local=locales.id_local" ;
            $xtra=" where locales.id_local='".$esc."' ;";
        }
        $SQL="SELECT COUNT(DISTINCT ag.id_transaccion) as cuenta FROM actas_guardadas ag inner join transacciones on ag.id_transaccion=transacciones.id_transaccion ".$xtra2.$xtra;
        $result = $this->consulta_r( $SQL);

        if (count($result) > 0) {
            $data = array();
            $escrutadas= $result[0]["cuenta"]; 
            $data["transacciones_escrutadas"] = $escrutadas; 
            ///saca el porcentaje
            $dataHabilitada =  $this->transaccionesHabilitadas($id_proov_y_uvent,$distrito,$esc);
            $transaccionesHabilitadas = (array) json_decode( $dataHabilitada,true );            
            $porcentaje = ($escrutadas * 100) / $transaccionesHabilitadas[0]["habilitadas"];
            $porcentaje = number_format((float)$porcentaje, 2, '.', '');
            $data["transacciones_escrutadas_porcentaje"] = $porcentaje; 

            return json_encode($data);
        } else {
            return json_encode(array());
        }
    }

    public function electoresHabilitados($id_proov_y_uvent="",$distrito=""){
        $xtra="";$xtra2="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" WHERE transacciones.id_proov_y_uvent='$id_proov_y_uvent' ";
        if(isset($distrito) && !empty($distrito)) $xtra2=" inner JOIN locales ON transacciones.id_proov_y_uvent=locales.id_proov_y_uvent AND locales.localidad_esc='".$distrito."' and transacciones.id_local=locales.id_local ";

        $SQL="SELECT SUM(saldo_ant) as saldo_ant FROM transacciones ".$xtra2." ".$xtra." ";    
        $result = $this->consulta_r( $SQL);
        return json_encode($result);
    }

    public function electoresVotantes($id_proov_y_uvent="",$distrito=""){
        $xtra="";$xtra2="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" WHERE transacciones.id_proov_y_uvent='$id_proov_y_uvent' ";
        if(isset($distrito) && !empty($distrito)) $xtra2=" INNER JOIN locales ON transacciones.id_proov_y_uvent=locales.id_proov_y_uvent AND locales.localidad_esc='".$distrito."' and transacciones.id_local=locales.id_local ";        

        // $SQL="SELECT SUM(votantes.pago_tr) as saldo_ant FROM votantes inner join transacciones on votantes.id_transaccion=transacciones.id_transaccion ".$xtra2.$xtra.";";
        // $result = $this->consulta_r( $SQL);
        $result['saldo_ant']=0;          
        return json_encode($result);
    }

    public function volumenmarcas_y_prodCompleta($id_proov_y_uvent="",$id_tipo="",$id_material="",$distrito=""){
        $xtra=""; $xtra2="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" AND cant_transac.id_proov_y_uvent='$id_proov_y_uvent' "; 
        if(isset($id_tipo) && !empty($id_tipo)) $xtra.=" AND cant_transac.id_tipo='$id_tipo' ";    
        if(isset($distrito) && !empty($distrito)) $xtra2="inner join transacciones on cant_transac.id_transaccion=transacciones.id_transaccion inner JOIN locales ON transacciones.id_proov_y_uvent=locales.id_proov_y_uvent AND locales.localidad_esc='".$distrito."' and transacciones.id_local=locales.id_local ";       

        $SQL="SELECT SUM(cant_transac.total_tr) as volumen_positivos FROM cant_transac  $xtra2 WHERE cant_transac.id_material='".$id_material."' ".$xtra."  "; 

        $result = $this->consulta_r( $SQL);       
        if($id_tipo) $result["id_tipo"] = $id_tipo;
        return json_encode($result);
    }

    public function volumenPositivos($id_proov_y_uvent="",$id_tipo=""){
        $xtra="";$xtra2="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" AND cant_transac.id_proov_y_uvent='$id_proov_y_uvent' "; 
        if(isset($id_tipo) && !empty($id_tipo)) $xtra2=" AND cant_transac.id_tipo='$id_tipo' ";        

        $SQL="SELECT SUM(cant_transac.total_tr) as volumen_positivos from cant_transac,marcas_prod WHERE cant_transac.id_marcas_prod=marcas_prod.id_marcas_prod AND marcas_prod.id_material='1' ".$xtra." ".$xtra2."  "; 
        $result = $this->consulta_r( $SQL);         
        if($id_tipo) $result["id_tipo"] = $id_tipo;
        return json_encode($result);
    }

    // public function volumenPositivosTodos($id_proov_y_uvent="",$id_tipo=""){
    //     $xtra="";$xtra2="";
    //     if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" AND cant_transac.id_proov_y_uvent='$id_proov_y_uvent' "; 
    //     if(isset($id_tipo) && !empty($id_tipo)) $xtra2=" AND cant_transac.id_tipo='$id_tipo' ";        

    //     $SQL="SELECT SUM(cant_transac.total_tr) as volumen_positivos from cant_transac,marcas_prod WHERE cant_transac.id_marcas_prod=marcas_prod.id_marcas_prod  ".$xtra." ".$xtra2."  "; 
    //     $result = $this->consulta_r( $SQL);        
    //     if($id_tipo)$result["id_tipo"] = $id_tipo; 
    //     return json_encode($result);
    // }

    public function volumenPositivosmarcas_y_prod($id_proov_y_uvent="",$id_tipo="",$id_marcas_prod="",$distrito=""){
        $xtra=""; $xtra2="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" AND cant_transac.id_proov_y_uvent='$id_proov_y_uvent' "; 
        if(isset($id_tipo) && !empty($id_tipo)) $xtra.=" AND cant_transac.id_tipo='$id_tipo' ";    
        if(isset($distrito) && !empty($distrito)) $xtra2="inner JOIN  transacciones on cant_transac.id_transaccion=transacciones.id_transaccion inner JOIN locales ON transacciones.id_proov_y_uvent=locales.id_proov_y_uvent AND locales.localidad_esc='".$distrito."' and transacciones.id_local=locales.id_local ";       

        $SQL="SELECT SUM(cant_transac.total_tr) as volumen_positivos FROM cant_transac $xtra2 WHERE cant_transac.id_marcas_prod='".$id_marcas_prod."' ".$xtra."  "; 
        $result = $this->consulta_r( $SQL);         
        if($id_tipo) $result["id_tipo"] = $id_tipo;
            return json_encode($result);
    }

    public function volumenPositivosmarcas_y_prodGeneral($id_proov_y_uvent="",$id_tipo="",$id_material="",$nom_marcas_y_prod=""){
        $xtra="";$xtra2="";$xtra3="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) {
            $xtra=" AND cant_transac.id_proov_y_uvent='$id_proov_y_uvent' "; 
            $xtra3=" WHERE id_proov_y_uvent='$id_proov_y_uvent' ";
        }    

        if(isset($id_tipo) && !empty($id_tipo)) $xtra2=" AND cant_transac.id_tipo='$id_tipo' ";        
        $SQL="SELECT SUM(cant_transac.total_tr) as volumen_positivos from cant_transac,marcas_prod WHERE cant_transac.id_marcas_prod=marcas_prod.id_marcas_prod AND marcas_prod.id_material='".$id_material."' AND marcas_prod.nombre_marca_prod LIKE '".$nom_marcas_y_prod."%' ".$xtra." ".$xtra2." ;"; 
        $result = $this->consulta_r( $SQL);         
        if($id_tipo) $data["id_tipo"] = $id_tipo;
        return json_encode($data);
    }

    // public function volumenPositivosPorPartido($id_proov_y_uvent=""){
    //     $xtra="";
    //     if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" AND cant_transac.id_proov_y_uvent='$id_proov_y_uvent' "; 

    //     $SQL="SELECT SUM(cant_transac.total_tr) as cantidad_positivos, cant_transac.id_material,materiales.nombre_material from cant_transac,marcas_prod,materiales WHERE cant_transac.id_marcas_prod=marcas_prod.id_marcas_prod AND  marcas_prod.id_material=materiales.id_material   ". $xtra." GROUP BY cant_transac.id_material order by cant_transac.id_material";
    //     $result = $this->consulta_r( $SQL);

    //     $SQL2="SELECT SUM(cant_transac.total_tr) as volumen_positivos from cant_transac,marcas_prod WHERE cant_transac.id_marcas_prod=marcas_prod.id_marcas_prod  ".$xtra."  "; 
    //     $result2 = $this->consulta_r( $SQL2);
      
    //     if ($row2 = ($result2)) $cantidadvolumenPositivo = $row2["volumen_positivos"];
    //     if (count($result) > 0) {
    //         $data = $result;
    //         foreach ($result as $row)  $data[$row["id_material"]]["data"] = $row;
    //         return json_encode($data);
    //     } else {
    //         return json_encode(array());
    //     }
    // }

    public function volumenResultados($id_proov_y_uvent="",$id_tipo="",$distrito=""){
        $xtra="";$xtra2="";
        if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)) $xtra=" AND cant_transac.id_proov_y_uvent='$id_proov_y_uvent' "; 
        if(isset($id_tipo) && !empty($id_tipo)) $xtra.=" AND cant_transac.id_tipo='$id_tipo' ";    
        if(isset($distrito) && !empty($distrito)) $xtra2="inner join transacciones on cant_transac.id_transaccion=transacciones.id_transaccion inner JOIN locales ON cant_transac.id_proov_y_uvent=locales.id_proov_y_uvent AND locales.localidad_esc='".$distrito."' and transacciones.id_local=locales.id_local ";       
        $SQL = "SELECT cant_transac.id_material, sum(cant_transac.total_tr) as total_tr FROM cant_transac  ".$xtra2." WHERE cant_transac.id_marcas_prod='0' ".$xtra." group by cant_transac.id_material;";
        $result = $this->consulta_r( $SQL);

        return json_encode($result);
    }

    // public function volumenCargoPartido($id_proov_y_uvent=""){
    //     $xtra=isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)?" AND cant_transac.id_proov_y_uvent='$id_proov_y_uvent' ":"";

    //     $SQL="SELECT marcas_prod.id_material,cant_transac.id_tipo,marcas_prod.nombre_marcas_y_prod,SUM(cantidad) as cantidad_volumen_cargo from cant_transac,marcas_prod WHERE cant_transac.id_marcas_prod = marcas_prod.id ".$xtra." GROUP BY id_marcas_prod,id_tipo ORDER BY id_tipo,id_material,nombre_marcas_y_prod  ";
    //     $result = $this->consulta_r( $SQL);

    //     if (count($result) > 0) {
    //         $data = array();
    //         foreach ($result as $row) {
    //         $data[] = $row;
    //             $data[$row["id_material"]]["data"] = $row;
    //         }
    //         return json_encode($data);
    //     } else {
    //         return json_encode(array());
    //     }
    // }

}
?>