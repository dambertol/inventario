<?php
session_start();
define('DIR','/inventario');
define('DIRECCION',__DIR__);
require_once "utiles/autoload.php";
use utiles\Router;
// use v2\classe\Usuarios;       
 use v2\classe\Informacion;
 use v2\classe\Informacion2;
 use v2\classe\Edicion;
 use v2\classe\Carga;

$dir=DIR;
$router = new Router();

$router->get("$dir/", function(){
    require 'v2/prog/logueo.php';
});

$router->get("$dir/inicio", function(){
    require 'v2/prog/logueo.php';
});

$router->post("$dir/inicio", function(){
    require 'v2/prog/logueo.php';
});

$router->get("$dir/adminer", function(){ 
    require 'v2/adminer.php';
});

$router->get("$dir/bienvenido", function(){
    require 'v2/prog/bienvenido.php';
});

$router->get("$dir/salir", function(){
    require 'v2/prog/salir.php';
});

$router->get("$dir/botonera", function(){
    require 'v2/prog/botonera.php';
});

$router->get("$dir/registro", function(){
    require 'v2/prog/registro.php';
});

$router->get("$dir/circuitos", function(){
    require 'v2/controladores/dashboard_zonas.php';
});

$router->get("$dir/resultados", function(){
    require 'v2/controladores/dashboard.php';
});

// $router->get("$dir/cargar_acta", function(){
//     require 'v2/controladores/carga.php';
// });
$router->get("$dir/cargar_acta",['Carga','carga']);

$router->post("$dir/gr_Mobile", ['Carga','grilla_m']);

$router->post("$dir/grilla", ['Carga','grilla']);

// $router->post("$dir/gr_Mobile", function(){ //
//     require 'v2/controladores/grillaMobile.php';
// });

// $router->post("$dir/grilla", function(){ ///////////////
//     require 'v2/controladores/grilla.php';
// });

$router->get("$dir/escrutados", ['Informacion2','escrutados']);

$router->get("$dir/editables", ['Edicion','editables']);

$router->get("$dir/detalle_local", ['Informacion2','detalle_transaccion']);

$router->get("$dir/edicion", ['Edicion','index']);
$router->post("$dir/edicion", ['Edicion','index']);

$router->get("$dir/descargar", ['Informacion2','descargar']);
/////////////////////////////////////////////////////////////////


$router->post("$dir/guardar_inf", ['Carga','guardar_inf']);

$router->get("$dir/administrar_usuarios",['Edicion','administrar_usuarios']);
$router->post("$dir/administrar_usuarios",['Edicion','administrar_usuarios']);

$router->get("$dir/contrasena", ['Edicion','contra_mod']);
$router->post("$dir/contrasena", ['Edicion','contra_mod']);

$router->get("$dir/crear_usuario", ['Edicion','crear_u']);

/////////metodos d clases

$router->get("$dir/reseteadodamian", ['Informacion2','reset']);
//////////////////////////////////////////////////////////////////////////////////////////////////////////// archivos intermedios

$router->get("$dir/locales_mod", ['Edicion','locales_mod']);
$router->post("$dir/locales_mod", ['Edicion','locales_mod']);

$router->get("$dir/grafico1",['Informacion2','grafico1']);

$router->get("$dir/traer_todo", ['Informacion2','traertodo']);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$router->run( function(){
    require 'v2/prog/404.php';
},'objetos');

/*funcion callback para instanciar sòlo la clase que necesito
y que sea configurable desde este archivo sin tocar Router*/
function objetos($obj){
    switch ($obj) {      
        case 'Edicion':
            $anda=new Edicion;
            break;
        case 'Informacion':
            $anda=new Informacion;
            break;
        case 'Informacion2':
            $anda=new Informacion2;
            break;  
        case 'Carga':
            $anda=new Carga;
            break;      
        default:
            //$anda=new $obj;
            $anda= "no anda";
            break;
    }
    return $anda;
}

?>