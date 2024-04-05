<?php
namespace v2\classe;

class Conexion
{
	/**
	 * Controlador Certificado
	 * Autor: yoel grosso
	 * Creado: 20/10/2023
	 */
    public $connection;

    public function __construct()
    {
        include 'v2/includes/datos_base.php';
        $connection = mysqli_connect($HOST,$USERNAME,$PASSWORD,$Informacion);
        if (!$connection)  die("Conexion fallada: " . mysqli_connect_error());
        $this->connection=$connection;        
    }

    public function consulta_r($SQL){
        if (strpos($SQL, 'select') == 0) {
            return $this->admin($SQL);
        }else{
            return ("error");
        }
    }

    private function admin($SQL){
        $connection=$this->connection;
        $results = mysqli_query($connection, $SQL);
        $a=null;
        if($results){
            if(isset($results->num_rows) && $results->num_rows>0) $a=$results->fetch_all(MYSQLI_ASSOC);
        }elseif($results->error!=null){
            $a=$results->error;
        }
        return $a;
    }

    //actualizar registro
    public function modif_($tabla, array $arr, array $id){
        $str="";
        foreach ($arr as $key => $value)  $str.= $key."='".$value."' ,";
        $str = substr($str, 0, -1);
        $SQL="UPDATE $tabla SET $str WHERE $id[0]=$id[1];";
        $res=$this->admin($SQL);
        return $res;
    }

    //crear registro
    public function guardar_(string $tabla,array $array){
        $tabla=addslashes($tabla);
        $keys=array_keys($array);
        $valores=array_values($array);
        foreach ($valores as $key => $value)  $value=addslashes($value);
        $SQL="INSERT INTO $tabla (".implode(",",$keys).") VALUES('".implode("','",$valores)."');";
        $res=$this->admin($SQL);
        return $res;
    }

    //metodos de listas
    public function obtener_todos($tabla, $offset=0, $where=null){
        $extra=empty($where)?"":' where '.$where;
        $offset<0?$offset=0:"";
        $SQL="SELECT * FROM $tabla $extra LIMIT ".((int)$offset*20).", 20;";
        $res=$this->admin($SQL);
        return $res;
    }

    public function obtener_ul($tabla){
        $SQL = "SELECT COUNT(*) as total FROM $tabla";
        $res=$this->consulta_r($SQL);
        return $res;
    }

    public function enumerar($tabla, $columna){
        $SQL="SELECT $columna FROM $tabla group by $columna;";
        $res=$this->consulta_r($SQL);
        return $res;
    }

    public function eliminar_($tabla, array $arr){
        $SQL="DELETE FROM $tabla WHERE $arr[0]=$arr[1];";
        $res=$this->consulta_r($SQL);
        return $res;
    }
}