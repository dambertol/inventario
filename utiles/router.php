<?php
namespace utiles;

use v2\classe\Usuarios;       
use v2\classe\Informacion;
use v2\classe\Informacion2;

class Router 
{
    private $_uri = array();
    private $_action = array();

    public function get($uri, $action = null) {
        if($_SERVER['REQUEST_METHOD']=="GET") $this->add($uri, $action);
    }

    public function post($uri, $action = null) {
        if($_SERVER['REQUEST_METHOD']=="POST") $this->add($uri, $action);
    }

    public function put($uri, $action = null) {
        if($_SERVER['REQUEST_METHOD']=="PUT") $this->add($uri, $action);
    }

    public function delete($uri, $action = null) {
        if($_SERVER['REQUEST_METHOD']=="DELETE") $this->add($uri, $action);
    }

    private function add($uri, $action = null) {
        /*validaciones porque pregmatch no siempre anda bien >:-| */
        $n=strpos($uri,"%");
        $uriGet = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $L=strpos($_SERVER['REQUEST_URI'],"?");
        if($n) if(substr($uri,0,$n)==substr($uriGet,0,$n))$uri=$uriGet;
        $L?$uri=$uri.substr($_SERVER['REQUEST_URI'],$L):"";

        $uri = trim($uri, '/');
        $this->_uri[$uri]= ($action != null)? $action:null;
    }

    public function run($def=null,$funcion=null){
        $uri=$_SERVER['REQUEST_URI'];
        $uri=trim($uri,'/');
        foreach ($this->_uri as $key => $value) {
            if(strpos($key,':')!==false) $key=preg_replace('#:[a-zA-Z]+#','([a-zA-Z]+)',$key);
            if(preg_match("#^$key$#",$uri, $parametros)||$key==$uri){
                !isset($parametros)?$parametros=null:"";
                $this->ejecutor($value,$parametros,$funcion);
                exit;
            }
        }
        $this->ejecutor($def);
    }

    private function ejecutor($value,$parametros=null,$funcion=null){
        $params=$parametros?array_slice($parametros,1):array();
        $respuesta=$value;
        if(is_callable($value)){        /*para funciuones anonimas      */
            $respuesta=$value(...$params);
        }elseif(is_array($value)){        /*para funciones de clases        */
          //  $control = new $value[0];   /*no funciona para mi version de php >:-|     */
            $control=$funcion($value[0]);
            $respuesta=$control->{$value[1]}(...$params);
        }elseif(is_object($respuesta)){
            echo json_encode($respuesta);
        }else{
            echo $respuesta;
        }
        return;
    }
}
?>