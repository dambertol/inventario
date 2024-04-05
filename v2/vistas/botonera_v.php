<?php require 'temp/encabezado.php';

use v2\classe\Informacion;
$bse=new Informacion();
$transaccionesHab;$transaccionesEscrutadas;
switch ($user->permiso) {
    case 'carga':
        $transaccionesHab = count($b->transacciones_Xfiscal($usuario));
        $transaccionesEscrutadas = json_decode($bse->transaccionesEscrutadas("","",$user->esc),true);
        break;
    case 'visualizar':
    case 'editor':
    case 'dios':
    case 'admin':
        $transaccionesHab = (json_decode($bse->transaccionesHabilitadas(),true))[0]["habilitadas"];
        $transaccionesEscrutadas = json_decode($bse->transaccionesEscrutadas(),true);
        break;
    case 'admin_dto':
    case 'visual_dto':
        $transaccionesHab = (json_decode($bse->transaccionesHabilitadas($user->dto),true))[0]["habilitadas"];
        $transaccionesEscrutadas = json_decode($bse->transaccionesEscrutadas($user->dto),true);
        break;       
    default:
        break;
}
$porce=(int)round((float)$transaccionesEscrutadas['transacciones_escrutadas_porcentaje']);
$marcas_y_prodproov_y_uventas = (json_decode($bse->searchproov_y_uventas(),true));    
$nombre_dep=$user->dto!=0?$marcas_y_prodproov_y_uventas[$user->dto-1]['nombre_proov_y_uvent']:"";
?>
<style>
  .progress {
    height: 10px;
    width: 100%;
    border: 1px solid #c4c4c4;
    border-radius: 5px;
    background-color: #e6f3fa;
    margin-bottom: 15px;
}
 
.progress-bar {
    height: 100%;
    background: #428bca;
    display: flex;
    align-items: center;
    transition: width 0.25s;
    border-radius: 5px;
}
 
.progress-bar-text {
    margin-left: 10px;
    font-weight: bold;
    color: #cce7f5;
    text-align: center;
    justify-content: center;

}


.card2 {
  padding: 1rem;
  background-color: #fff;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  max-width: 320px;
  border-radius: 20px;
}

.title {
  display: flex;
  align-items: center;
}

.title span {
  position: relative;
  padding: 0.5rem;
  background-color: #10B981;
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 9999px;
}

.title span svg {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #ffffff;
  height: 1rem;
}

.title-text {
  margin-left: 0.5rem;
  color: #374151;
  font-size: 18px;
  font-weight:bold;
}

.data{display: flex;justify-content: center;}

.data p {
  margin-top: 1rem;
margin-bottom: 1rem;
color: #1F2937;
font-size: 2em;
line-height: 2.5rem;
font-weight: 600;
text-align: left;
}

.container-cards{display:flex;justify-content:center;align-items:center;padding-bottom:20px;background: #f2f2f2;
padding: 20px;}
.card2{margin-right: 20px;min-height: 125px;}


@media (max-width: 460px){
    .container-cards {
      display: inline-block;
      width: 100%;
    }
    .card2 {
      margin-bottom: 20px;
      width: 45%;
      float: left;
      margin-right: 15px;
      min-height: 175px;
    }
}

</style>

<div class="container-cards">
<?php  if(!empty($nombre_dep)) echo"<div class='title_dto'><h2>".$nombre_dep."</h2></div>";?>

    <div class="card2">
        <div class="title"><p class="title-text"> transacciones Habilitadas</p></div>
        <div class="data">
            <p><?=$transaccionesHab?></p>      
            <div class="range"><div class=""> </div></div>
        </div>
    </div>
    <div class="card2">
        <div class="title"><p class="title-text"> transacciones Escrutadas</p></div>
        <div class="data">
            <p><?=$transaccionesEscrutadas["transacciones_escrutadas"]?> </p>      
            <div class="range"><div class=""> </div></div>
        </div>
    </div>

    <div class="card2">
        <div class="title"><p class="title-text">transacciones Escrutadas en % </p></div>
        <div class="data">
            <p><?=$transaccionesEscrutadas["transacciones_escrutadas_porcentaje"]?>% </p>      
            <div class="range"><div class=""></div></div>
        </div>
        <div class="progress" title="<?=$transaccionesEscrutadas["transacciones_escrutadas_porcentaje"]?>%">
        <div class="progress-bar"  style="width:<?=$porce;?>%;">
            <span class="progress-bar-text"></span>
        </div>
    </div>
    </div>

</div>

<?php

echo   "</br><div class='row'>";
foreach ($botones as $key => $value) {
    echo   "<div class='column' style='align:center;'><div class='card'><a href=".DIR."/".$value[1]." type='botton'><button class='card_button' title='".$value[3]."' ><img src='".$value[2]."' width='15%' height='30%'><p>".$value[0]."</p></button></a></div></div>";
}
echo   "</div>";
  ?>
 
    