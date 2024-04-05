<?php
use v2\classe\Usuario;
$b=new Usuario();
$user=$b->validar();
$botones=array();
switch ($user->permiso) {
    case 'dios':
    case 'admin':
        $botones[]=array("Edicion","edicion","v2/src/admin_user.png","Edicion de tablas");
        $botones[]=array("usuarios","administrar_usuarios","v2/src/admin_user.png","Administración de Usuarios");
    case 'visualizar':case 'visual_dto':
        $botones[]=array("Resultados - proov_y_uventas","resultados?","v2/src/pie-chart.png","Visualizar Gráfico por proov_y_uventas","");
        $botones[]=array("locales escrutadas",'escrutados?indice=0',"v2/src/pie-chart.png" ,"Ver transacciones escrutadas");     
        $botones[]=array("Ver Actas","cargar_acta","v2/src/contact-form-edit.png","");   
        $botones[]=array("Mi Perfil","contrasena","v2/src/user.png","");
        $botones[]=array("Descargar","descargar","v2/src/contact-form-edit.png","Descargar resultados");
        break;
    case 'editor':    
        $botones[]=array("locales escrutadas",'escrutados?indice=0',"v2/src/pie-chart.png" ,"Ver transacciones escrutadas");    
    case 'carga':
        $botones[]=array("Carga Actas","cargar_acta","v2/src/contact-form-edit.png","");   
        $botones[]=array("Mi Perfil","contrasena","v2/src/user.png","");
        break;
    case 'admin_dto':
        $botones[]=array("usuarios","administrar_usuarios","v2/src/admin_user.png","Administración de Usuarios"); 
        $botones[]=array("locales escrutadas",'escrutados?indice=0',"v2/src/pie-chart.png" ,"Ver transacciones escrutadas");       
        $botones[]=array("Carga Actas","cargar_acta","v2/src/contact-form-edit.png","");   
        $botones[]=array("Mi Perfil","contrasena","v2/src/user.png","");
        $botones[]=array("Descargar","descargar","v2/src/contact-form-edit.png","Descargar resultados");
        break;    
    default:
        $botones[]=array();
        break;
}
$titulo="Acciones";
require 'v2/vistas/botonera_v.php';
