<?php
use v2\classe\Usuario;
$b=new Usuario();
$user=$b->validar();
if($user->permiso!="admin" && $user->permiso!="visualizar" && $user->permiso!="visual_dto" && $user->permiso!="dios"){
    echo "<script> window.location.href = '".DIRECCION."/botonera';</script>";
    return;
  }
  
$titulo="";
require_once 'v2/includes/config_php.php';
use v2\classe\Informacion;
$db = new Informacion();

if(!($_SESSION["token"]=='IDtMBf0LVMHg9hTbgOQPpZ1tYZ0i6hOWtEO8Az4Bhu9G15AuSyLVsPmHByUk0qlS' || $_SESSION["token"]=="LuWq9yv205XfBphbLW9GtdL6AXZF0yUWBepCVHwCuqIiIo3sXGP2ediK8a1cKVic")){
    echo "<div style='margin: 0 auto; width: 10%; padding-top:50px'>Sin acceso a este informe</div>";
    return false;
}
    
    $extras='<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link rel="stylesheet" href="v2/src/css/dash.css" type="text/css">    ';

require 'v2/vistas/temp/encabezado.php';
$text="";
    isset($_GET["token"])?$text.="token=".$_GET["token"]:"";
    $id_proov_y_uvent=isset($_GET["id_proov_y_uvent"])?$_GET["id_proov_y_uvent"]:"";
    $id_tipo=isset($_GET['id_tipo'])?$_GET['id_tipo']:"";
    $user->dto!=0?$id_proov_y_uvent=$user->dto:"";
    $distrito=isset($_GET["distrito"])?$_GET["distrito"]:"";
    $marcas_y_prodproov_y_uventas = (json_decode($db->searchproov_y_uventas(),true));    
    if($user->dto!=0)$nombre_dep=$marcas_y_prodproov_y_uventas[$id_proov_y_uvent-1];
?>
<section>
<script
  src="https://code.jquery.com/jquery-3.7.0.js"
  integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="./v2/src/js/script.js?t=<?=date("His")?>"></script>

<h3 style="padding-top:10px;text-align:center;opacity:70%">RESULTADOS</h3>
<hr id="linea_hr" style="">

<div style="padding:5px">
<?php if($user->dto==0){ ?>
<button <?php if(empty($id_proov_y_uvent)) print "style='background-color: #302828; color:white'" ?> onclick="javascript:window.location.href='resultados?'" id="bottone5">GENERAL</button>
    <?php }else{ ?>
    <button class="btn_dep" onclick="ir('<?=$id_proov_y_uvent ?>','')" id="bottone5"><?php echo $nombre_dep["nombre_proov_y_uvent"]?></button>
    <?php } ?>
</div>
<script type="text/javascript">
 
    function ir(idd="",m_t=""){
       window.location.href='resultados?'+(m_t!=""?m_t+"&":"")+ (idd!=""?'id_proov_y_uvent='+idd:"");
       // window.top.location.href='resultados?id_proov_y_uvent=' + m_t;
       return false;
    }
  
</script>

<div style="padding:5px">

<?php
/////marcas_y_prod todos los proov_y_uventas
if($marcas_y_prodproov_y_uventas && $user->dto==0){
    foreach ($marcas_y_prodproov_y_uventas as $key => $value) {
?>
    <button class="btn_dep" <?php if($id_proov_y_uvent==$value["id_proov_y_uvent"]) print "style='background-color: #302828; color:white'" ?> onclick="ir('<?=$value['id_proov_y_uvent'] ?>','<?php echo $text ?>')" id="bottone5"><?=$value["nombre_proov_y_uvent"]?></button>
    <?php } ?>  
    <select id="selResponsiveDep" style="width: 100%; padding:10px; background-color: #fff; border: 1px solid #1380df;">
        <option <?php (empty($id_proov_y_uvent))? print "selected": print "" ?> disabled>marcas_y_prod de proov_y_uventas</option>
        <?php foreach ($marcas_y_prodproov_y_uventas as $key => $value) {?>
                <option onclick="ir('<?=$value['id_proov_y_uvent'] ?>','<?php echo $text?>')" <?php ($id_proov_y_uvent==$value["id_proov_y_uvent"])? print "selected": print "" ?> value="<?= $value['id_proov_y_uvent'] ?>"><?=$value["nombre_proov_y_uvent"]?></option>
            <?php } ?>
    </select>
    <script type="text/javascript">
    $('#selResponsiveDep').change(function(){       
        ir($(this).find(':selected').attr('data-idp'),$(this).find(':selected').attr('data-mtu'));
    });
    </script>
<?php } ?>
</div>

<?php
////busca localidades
$marcas_y_prodLocalidades =  (json_decode($db->searchLocales($id_proov_y_uvent),true));  
if(!empty($marcas_y_prodLocalidades) && is_array($marcas_y_prodLocalidades)){
echo '<div class="distritos_marcas_y_prod"><div>Locales:';
            foreach ($marcas_y_prodLocalidades as $key=>$value) {
                if($value && $value["local"]){    
                    if(isset($_GET['distrito']) && $_GET['distrito']== $value["local"]){
                        $active=" active";
                    }else{
                        $active="";   
                    }
                    echo '<a href="?'.(!empty($text)?$text."&":"").'id_proov_y_uvent='.$id_proov_y_uvent.'&distrito='.$value["local"].'" class="btn_local'.$active.'">'.$value["local"].'</a>';
                }
            } 
    echo"</div></div>";
 } ?>
</section>

<section> 
    <div class="container-cards">
<?php
/////////////////////////////////////////////////////////////////

$transaccionesHab=0;
    $eV = (int)(json_decode($db->electoresVotantes($id_proov_y_uvent,$distrito),true))['saldo_ant'];
    $transaccionesHab = (int)(json_decode($db->transaccionesHabilitadas($id_proov_y_uvent,$distrito),true))['habilitadas'];
    $eH = (int)(json_decode($db->electoresHabilitados($id_proov_y_uvent,$distrito),true))['saldo_ant'];

if(empty($eV))$eV=0;
if(empty($eH))$eH=0;

/////////////////////////////////////////////////////////////////
$transaccionesEscrutadas=json_decode($db->transaccionesEscrutadas($id_proov_y_uvent,$distrito),true);

$transaccionesEsc=isset($transaccionesEscrutadas["transacciones_escrutadas"])?$transaccionesEscrutadas["transacciones_escrutadas"]:0;

$transaccionesEscPorc= number_format((($transaccionesEsc * 100 / ($transaccionesHab==0?1:$transaccionesHab))),2);
$porcentajeVotaron= number_format((($eV*100)/$eH),3);
?>


<script type="text/javascript">
    $("#selResponsiveDep").on('change', function (e) {
     var optionSelected = $(this).find("option:selected");
     var valueSelected  = optionSelected.val();
        window.top.location.href='resultados?id_proov_y_uvent=' + valueSelected;
       return false;
    })
</script>

<div class="card">
    <div class="title"><p class="title-text"> transacciones Habilitadas</p></div>
    <div class="data"><p><?=$transaccionesHab?></p>      
        <div class="range"><div class=""></div></div>
    </div>
</div>

<div class="card">
        <div class="title"><p class="title-text"> transacciones Escrutadas </p></div>
        <div class="data"><p><?=$transaccionesEsc?></p>      
            <div class="range"><div class=""></div></div>
        </div>
</div>

<div class="card">
        <div class="title"><p class="title-text"> transacciones Escrutadas en % </p></div>
        <div class="data"><p> <?=$transaccionesEscPorc?>%</p>
            <div class="range"><div class=""></div></div>
        </div>
</div>

<div class="card">
    <div class="title"><p class="title-text"> Electores Habilitados </p></div>
    <div class="data"> <p><?=$eH?></p>      
        <div class="range"><div class=""></div></div>
    </div>
</div>

<div class="card">
    <div class="title"><p class="title-text"> Electores que Votaron</p></div>
    <div class="data"><p><?=$eV?></p>      
        <div class="range"><div class=""></div></div>
    </div>
</div>

<div class="card">
    <div class="title"><p class="title-text">Porcentaje Votantes</p></div>
    <div class="data"><p><?=number_format((($eV*1000/$eH))/10,3)?>% </p>      
        <div class="range"><div class=""></div></div>
    </div>
</div>
</div>
</div>
<div style="width:100%;display:flex;align-items:center">
    <div style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap; width:100%">
        <div id="grafico1" class="charts">
                <canvas id="myChart1"></canvas>
                <p style="text-align:center;font-weight:bold;opacity:80%"></p>
        </div>
        <div id="grafico2" class="charts">
                <canvas id="myChart2"></canvas>
                <p style="text-align:center;font-weight:bold;opacity:80%"></p>
        </div>
        <div id="grafico3" class="charts">
                <canvas id="myChart3"></canvas>
        <p style="text-align:center;font-weight:bold;opacity:80%"></p>
        </div>
        <div id="grafico4" class="charts">
                <canvas id="myChart4"></canvas>
        <p style="text-align:center;font-weight:bold;opacity:80%"></p>
        </div>
        <!-- otro -->
       
        <div id="grafico6" class="charts2">
                <canvas id="torta2"></canvas>    
        </div>
        <div id="grafico7" class="charts2">
                <canvas id="torta3"></canvas>    
        </div>

<?php ////////////////////////////////////////////////////////
    $marcas_y_prodPostulantes = json_decode($db->searchmarcas_prod2($id_proov_y_uvent,$id_tipo),true);

    if($marcas_y_prodPostulantes){
        foreach ($marcas_y_prodPostulantes as $key => $value) {
            $datamarcas_y_prod[$value["id_material"]][]=array("nombre"=>$value["nombre"],"nombre_marcas_y_prod"=>$value["nombre_material"],"id_marcas_prod"=>$value["id_marcas_prod"],"color"=>$value["color_rgb"]);
        }
    }
?>

<style>
.col-main {flex: 1; }  
.col-complementary {flex: 1; }
/*.submenu_ul{width: 50%}*/
#detalle{display: flex;align-content: center;justify-content: center;}
/* Responsive: */
@media only screen and (min-width: 640px) {.layout {display: flex;} }
@media only screen and (max-width: 600px) {.submenu_ul{width: 100%}}
.container_volumen_detalle {margin-right: auto;margin-left: auto;}
.col {padding: 1em;margin: 0 2px 2px 0;}
.submenu_ul {list-style-type: none;margin: 0;padding: 0;overflow: hidden;}
.submenu_ul li {float: left;background-color: #3e3d3d;min-width:100px}
.submenu_ul li a {display: block;color: white;text-align: center;padding: 16px;text-decoration: none;}
.submenu_ul li a:hover {background-color: #111111;}
</style>

<table width="100%" border="0"><tr><td style="border-bottom:none;">   
    <div id="detalle"><ul class="submenu_ul">
        <li style="<? ($id_tipo==1)? print "background-color:#63a9b0": print ""?>" ><a href="?id_proov_y_uvent=<?=($id_proov_y_uvent)?>&distrito=<?=$distrito?>&id_tipo=1<?= !empty($text)?"&".$text:""; ?>#detalle">Ingresos de mat.</a></li>
        <li style="<? ($id_tipo==2)? print "background-color:#63a9b0": print ""?>" ><a href="?id_proov_y_uvent=<?=($id_proov_y_uvent)?>&distrito=<?=$distrito?>&id_tipo=2<?= !empty($text)?"&".$text:""; ?>#detalle">Cant. Vendidas</a></li>
        <li style="<? ($id_tipo==3)? print "background-color:#63a9b0": print ""?>" ><a href="?id_proov_y_uvent=<?=($id_proov_y_uvent)?>&distrito=<?=$distrito?>&id_tipo=3<?= !empty($text)?"&".$text:""; ?>#detalle">Costos U.</a></li>
        <li style="<? ($id_tipo==4)? print "background-color:#63a9b0": print ""?>" ><a href="?id_proov_y_uvent=<?=($id_proov_y_uvent)?>&distrito=<?=$distrito?>&id_tipo=4<?= !empty($text)?"&".$text:""; ?>#detalle">Totales $</a></li>
    </ul></div>
</td></tr></table>
</section>
<?php
// if($id_tipo="" && empty($id_tipo)){
//     $id_tipo="";
//     $display=" style='display:none' ";
//     $display2=" style='display:none' ";
// }else{
//      $id_tipo=$id_tipo;
     $display=" style='display:block;' ";
     $display2=" style='display:block; width:95%' ";
//}
?>


    <?php
/////////busca general, ya sea gob, sen o dip ************
if(empty($id_proov_y_uvent) && $id_tipo!=""){
    
  // $id_tipo= $id_tipo;
   $marcas_y_prodPostulantesGenerales = json_decode($db->searchmarcas_prodGenerales($id_tipo),true); 
    if($marcas_y_prodPostulantesGenerales){
        foreach ($marcas_y_prodPostulantesGenerales as $key => $value) {
            $datamarcas_y_prod[$value["id_material"]][]=array("nombre"=>$value["nombre_marcas_y_prod"],"nombre_marcas_y_prod"=>$value["nombre"],"color"=>$value["color"],"id_material"=>$value["id_material"]);//"id_marcas_prod"=>$value["id_marcas_prod"]
        }
    }
}

////Se comienza hacer el bucle de datos

        if(!empty($id_tipo)){ ?>
    <section>
        <h3 style="text-align: center;">Resultados sobre el total de volumen positivos</h3>
        <div id="resultados_posit"></div>
    </section>        
    

    <section>
        <h3 style="text-align: center;">Total de volumen (incluye volumen no positivos)</h3>
        <div  class="detalle_volumen" <?=$display?> >  

            <table width="100%">
            <?php
            foreach ($datamarcas_y_prod as $key => $value) {     

            $volumenmarcas_y_prodCompleta = (json_decode($db->volumenmarcas_y_prodCompleta($id_proov_y_uvent,$id_tipo,$key,$distrito)));
         //   var_dump($volumenmarcas_y_prodCompleta);
            $vPos1marcas_y_prodCompleta=$volumenmarcas_y_prodCompleta->volumen_positivos;
            if(empty($vPos1marcas_y_prodCompleta)){
                $vPos1marcas_y_prodCompleta='0';
            }    
        //echo '<table width="100%">';
        echo "<tr>";
                if($value[0]["color"]){
                    $colorSpan="<span style='background-color:".$value[0]["color"]."; padding:3px; margin-right:5px'></span>";
                }else{
                    $colorSpan="<span style='background-color:gray; padding:3px;margin-right:5px'></span>";
                } ?>
                <td style="border-bottom: 2px solid #ddd;" width="55%"><h2><?=$colorSpan?> <?=$value[0]["nombre_marcas_y_prod"]?> / pr. <?=$value[0]["nombre"]?></h2></td> 

                <td style="font-size: 18px;border-bottom: 2px solid #ddd;text-align:center;width:25% !important;">volumen - <span class="posit" data-part="<?=$value[0]["nombre_marcas_y_prod"]?>" data-color="<?=$value[0]["color"]?>"><?=$vPos1marcas_y_prodCompleta?></span><br>
                <?php
                if($eV){
                        echo "<span class='poscen'>". number_format((($vPos1marcas_y_prodCompleta * 100) / $eV),2) ."% </span>"; 
                }else{
                    echo "<span>0.00%</span>";
                }?>
                </td> 
            </tr>
            <?php if(false): ?>
            <!-- /////////////////// este codigo trae las internas de cada partido - sólo para elecciones primarias /////////////////////////////-->
                            <tr> 
                                
                                <td colspan="2" style="border-bottom: 0px;">

                                    <div class="container_volumen_detalle">
                                    
                                        <div class="layout">
                                            <div class="col col-main">
                                                <table width="100%" border="0" style="float: left;">
                                                    <?php 
                                                    $vPos1marcas_y_prodCompleta=$vPos1marcas_y_prodCompleta==0?1:$vPos1marcas_y_prodCompleta;
                                                    foreach ($value as $key2 => $value2) { 
                                                            
                                                            if(isset($id_proov_y_uvent) && !empty($id_proov_y_uvent)){ ///solo para ver por proov_y_vent
                                                                        $volumenPositivos = (json_decode($db->volumenPositivosmarcas_y_prod($id_proov_y_uvent,$id_tipo,$value2["id_marcas_prod"],$distrito),true));
                                                            }else{  ///solo general
                                                                        $volumenPositivos = (json_decode($db->volumenPositivosmarcas_y_prodGeneral("",$id_tipo,$value2["id_material"],$value2["nombre"]),true));
                                                            }        
                                                            $vPos1=$volumenPositivos[0]["volumen_positivos"];
                                                            if(empty($vPos1)) $vPos1=0;
                                                        ?>
                                                    <tr>
                                                        <td width="60%" style="font-size: 16px;"><b>marcas_y_prod <?=$value2["nombre"]?></b></td><td style="font-size: 16px;"><? //=$vPos1?> volumen - 
                                                            <?php 
                                                            if($vPos1){
                                                                echo number_format(($vPos1 * 100 / $vPos1marcas_y_prodCompleta),2).' %</td>';
                                                            }else{
                                                                echo '0 %</td>';
                                                            }?>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                            <div class="col col-complementary" role="complementary">
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td></td>
                                                    </tr>                                   
                                                </table>
                                            </div>  
                                        </div>   
                                    </div>
                                </td>                
                            </tr>
            <?php endif; ?>        
         
    <?php }//} 

        $cantNulos=0;
            $resultadosvolumen = (json_decode($db->volumenResultados($id_proov_y_uvent,$id_tipo,$distrito),true)); 
        
        $NBIR[20]=null;$NBIR[21]=null;$NBIR[22]=null;$NBIR[23]=null;
        if($resultadosvolumen){
            foreach ($resultadosvolumen as $key => $value) $NBIR[$value["id_material"]]= $value["total_tr"];
        }
    ?>       
                </table>
            </div>
        </div>
        <div style="height: 50px;"></div>
    </div>
    </section>
<?php }; ?>

<script>
   <?php if(!empty($id_tipo)){ ?>
window.onload = function() {
    let suma = 0;

    const spans = document.querySelectorAll(".posit");
    let total = 0;

    // Captura los valores de los spans y suma
    spans.forEach((span) => {
        const valor = parseInt(span.textContent, 10);
        total += valor;
    });

    // Crea tarjetas con los resultados en porcentaje
    const resultadosDiv = document.getElementById("resultados_posit");


    spans.forEach((span) => {
        const part = span.getAttribute("data-part");
        const color = span.getAttribute("data-color");
        const valor = parseInt(span.textContent, 10);
        const porcentaje = ((valor / total) * 100).toFixed(2); // Calcula el porcentaje

        const tarjeta = document.createElement("div");
        tarjeta.classList.add("tarjeta");
        tarjeta.style.backgroundColor = color;

        const titulo = document.createElement("div");
        titulo.textContent = part;
        titulo.classList.add("titulo");

        const valorPorcentaje = document.createElement("div");
        valorPorcentaje.textContent = porcentaje + "%";
        valorPorcentaje.classList.add("valor-porcentaje");

        tarjeta.appendChild(titulo);
        tarjeta.appendChild(valorPorcentaje);
        resultadosDiv.appendChild(tarjeta);
    });
}

    <?php } ?>

function dibujador(arr,chart,titulo){
    const array = Object.entries(arr);
    let labels = Object.values(array[0][1]);
    let valores = Object.values(array[1][1]);

    let colores=[];
    colores['LA UNION MENDOCINA']='rgb(242, 60, 60)';
    colores['CAMBIA MENDOZA']='rgb(123, 60, 242';
    colores['FIT']='rgb(0, 0, 0)';
    colores['ELEGI MENDOZA']='rgb(60, 126, 242)';
    colores['PARTIDO VERDE']='rgb(60, 242, 66)';
    colores['PARTIDO HACIENDO LAS HERAS']='gray';
    colores['NUEVO TUPUNGATO']='gray';
    colores['RECONSTRUYENDO MALARGÜE']='gray';
    colores['SEMBRAR']='gray';

    let arrayColores=[];

    labels.forEach(function(element) { 
    arrayColores.push(colores[element]);
    });

    new Chart(document.getElementById(chart), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: titulo,
                data: valores,
                backgroundColor: arrayColores,
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: {beginAtZero: true} },
            indexAxis: 'y',
        }
    });  
}

    function showChart3(chart,titulo,id_tipo){
            $.ajax({
                url: 'grafico1?id_tipo='+id_tipo+'&id_proov_y_uvent=<?=$id_proov_y_uvent?>&distrito=<?=$distrito?>', // 
                type: 'GET',
            }).done(function(response) {
                var arr = JSON.parse(response);
                dibujador(arr,chart,titulo);                 
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Error en la solicitud HTTP:', textStatus, errorThrown);
            });
    }

/*
    const torta1 = document.getElementById('torta1');
    new Chart(torta1, {
        type: 'pie',
        data: {
         
          datasets: [{
            label: 'transacciones Escrutadas',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });*/

    const torta2 = document.getElementById('torta2');
    new Chart(torta2, {
        type: 'pie',
        data: {
          labels: ['Porcentaje Escrutadas','Faltan'],
          datasets: [{
            label: 'transacciones Escrutadas %',
            data: [<?=$transaccionesEscPorc?>,<?=100-$transaccionesEscPorc?>],
            borderWidth: 1
          }]
        },
        options: {  scales: { y: { beginAtZero: true } } }
      });

    const torta3 = document.getElementById('torta3');
    new Chart(torta3, {
        type: 'pie',
        data: {
          labels: ['Porcentaje Votaron', 'Falta Votar'],
          datasets: [{
            label: 'Votaron %',
            data: [<?=$porcentajeVotaron?>,<?=100-$porcentajeVotaron?> ],
            borderWidth: 1
          }]
        },
        options: { scales: { y: { beginAtZero: true } } }
      });

  ////////////////////////////////////////////////////////////////////////////  

$(document).ready(function() {
    showChart3("myChart1","Ingresos de mat.",1); ///1 es general
    showChart3("myChart2","Cant. Vendidas",2); ///1 es general
    showChart3("myChart3","Costos U.",3); ///1 es general
    showChart3("myChart4","Totales $",4); ///1 es general

});
///////////////////////////////////////////////////////
setInterval(function() {
    window.location.reload();
}, 300000); 

    </script>
</body>
</html>