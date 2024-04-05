
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div>
<div class="datos-transaccion" >
        <div class="div-data">local:<?php echo $datos_trans[0]['local_'] .' - '. $datos_trans[0]['nombre_local'];?><b class="local"></b></div>
        <div class="div-data">datos:<?php echo $datos_trans[0]['tipo'] .' - '. $datos_trans[0]['fecha'];?> <b class="circuito"></b></div>
        <div class="div-data">proov_y_vent:<?php echo $datos_trans[0]['nombre_proov_y_uvent'];?> <b class="proov_y_vent"></b></div>
</div>
<hr id="linea_hr" style="display:none">
<div style="display: none" class="load-bar">
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
</div>
<form action="guardar_inf" method="post" id="form-grilla"  enctype="multipart/form-data">
<div class="container-votacion">
<table class="tabla-votacion">
    <tr>
        <td style="background-color:#f2f2f2;padding:10px">SALDO INICIAL</td>
        <td style="padding: 2px 20px 2px 28px;background-color:#f2f2f2"><input class="input-carga" type="number" readonly id="saldo_ant" name="saldo_ant" value="<?php (isset($datos_trans[0]["saldo_ant"]))? print $datos_trans[0]["saldo_ant"]: print "0"?>"></td>
    </tr>
    <tr>
        <td style="background-color:#f2f2f2;padding:10px">IMPORTE</td>
        <td style="padding: 2px 20px 2px 28px;background-color:#f2f2f2"><input class="input-carga" type="number" id="importeT" readonly name="importeT" value="<?php (isset($datos_trans[0]["importe_tr"]))? print $datos_trans[0]["importe_tr"]: print "0"?>"></td>
    </tr>
    <tr>
    <td style="background-color:#f2f2f2;padding:10px">PAGO</td>
        <td style="padding: 2px 20px 2px 28px;background-color:#f2f2f2"><input class="input-carga pago"type="number" id="pagos" name="pago" value="<?php (isset($datos_trans[0]["pago_tr"]))? print $datos_trans[0]["pago_tr"]: print "0"?>"></td>
    </tr>
     <tr>
        <td style="background-color:#f2f2f2;padding:10px">SALDO FINAL</td>
        <td style="padding: 2px 20px;background-color:#f2f2f2"><input readonly id="diferencia" class="input-carga"type="text" name="diferencia" value="<?php (isset($datos_trans[0]["saldo_pos"]))? print $datos_trans[0]["saldo_pos"]: print "0"?>"></td>
    </tr>
</table>
</div>

<div class="container-postulantes">
<table>
        <thead>
            <tr>
                <th class="elementos">MATERIAL</th>
                <th class="elementos">PRODUCTO/MARCA</th>
                <th class="elementos">CANT. ENT.</th>
                <th class="elementos">CANT. SAL.</th>
                <th class="elementos">COSTO UN.</th>
                <th class="elementos">TOTAL</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $array = [];
            $vecesRepetidas = [];

            foreach ($results as $key => $value) {
               array_push($vecesRepetidas,$value['nombre']);
            };
            $array2 = array_count_values($vecesRepetidas);
            $codigoRepetidos=[];
            $SUM4=0;

            /////////////////////////////
            foreach ($results as $key => $value) {
                $count = $array2[$value['nombre']];
                if(empty($value['color_rgb'])) $value['color_rgb']='rgb(233, 233, 233)'; ///color grey
               if(!isset($array[$value['nombre_material']])){
                  $partido=$value['nombre_material'];
                  $lineaSuperior=" style='border: 0px !important;border-top: #e9e9e9 0.5px solid !important;border-left: ".$value['color_rgb']." 1.5px solid !important;' ";
                  $lineaSuperiormarcas_y_prod=" style='border: 0px !important;border-top: #e9e9e9 0.5px solid !important;border-left: #e9e9e9 0.5px solid !important;' ";
                }else{
                  $partido="";
                  $lineaSuperior=" style='border: 0px !important;border-left: ".$value['color_rgb']." 1.5px solid !important;' ";
                }

                    echo '<tr>';
                    echo '<td class="elementos" '.$lineaSuperior.' >'.$partido .'</td>';
                    echo '<td class="elementos" '.$lineaSuperiormarcas_y_prod.' >'.$value['nombre'].'</td>';

                    $cantidad1=0;
                    if(isset($datavolumen[$value["id_marcas_prod"]."-1"]["cantidad"])){
                        $cantidad1=$datavolumen[$value["id_marcas_prod"]."-1"]["cantidad"]; 
                    }
                    $marcas_y_prod1=$value["id_marcas_prod"];  
                    $input1='<input name="tipo1['.$marcas_y_prod1.'-1-'.$value["id_material"].']" class="input-carga col1 fila'.$marcas_y_prod1.'-'.$value["id_material"].'" data-fila="'.$marcas_y_prod1.'-'.$value["id_material"].'" "type="number" step="any" value="'.$cantidad1.'">';
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $marcas_y_prod2=$value["id_marcas_prod"];
                    $cantidad2=0;
                    if(isset($datavolumen[$value["id_marcas_prod"]."-2"]["cantidad"])){
                        $cantidad2=$datavolumen[$value["id_marcas_prod"]."-2"]["cantidad"];
                    }
                    $input2='<input name="tipo2['.$marcas_y_prod2.'-2-'.$value["id_material"].']" class="input-carga col2 fila'.$marcas_y_prod1.'-'.$value["id_material"].'" data-fila="'.$marcas_y_prod1.'-'.$value["id_material"].'" type="number" step="any" value="'.$cantidad2.'">';
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $marcas_y_prod3=$value["id_marcas_prod"];
                    $cantidad3=0;
                    if(isset($datavolumen[$value["id_marcas_prod"]."-3"]["cantidad"])){ 
                        $cantidad3=$datavolumen[$value["id_marcas_prod"]."-3"]["cantidad"];
                    }
                    $input3='<input name="tipo3['.$marcas_y_prod3.'-3-'.$value["id_material"].']" class="input-carga col3 fila'.$marcas_y_prod1.'-'.$value["id_material"].'" data-fila="'.$marcas_y_prod1.'-'.$value["id_material"].'" type="number" step="any" min="0" value="'.$cantidad3.'">';
                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    $marcas_y_prod4=$value["id_marcas_prod"];
                    $cantidad4=0;
                    if(isset($datavolumen[$value["id_marcas_prod"]."-4"]["cantidad"])){
                        $cantidad4=$datavolumen[$value["id_marcas_prod"]."-4"]["cantidad"];
                    }
                    $SUM4=$SUM4 + $cantidad4; 
                    $input4='<input name="tipo4['.$marcas_y_prod4.'-4-'.$value["id_material"].']" class="input-carga col4 fila'.$marcas_y_prod1.'-'.$value["id_material"].'" data-fila="'.$marcas_y_prod1.'-'.$value["id_material"].'" type="number" step="any" readonly value="'.$cantidad4.'">';
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    echo '<td class="elementos"  >'. $input1  .'</td>';
                    echo '<td class="elementos" >'. $input2 .'</td>';
                    echo '<td class="elementos" >'. $input3.'</td>';
                    echo '<td class="elementos" >'. $input4 .'</td>';  
                    echo '</tr>';              
                    $array[$value['nombre_material']]=$value['nombre_material'];
            }; ?>
        <tr>
            <td class="totales" colspan="2"><b class="titulo-total" style="letter-spacing: 3px; text-transform:uppercase;">total</b></td>
            <td class="totales" align="center"><div id="resultados_col1"></div></td>
            <td class="totales" align="center"><div id="resultados_col2"></div></td>
            <td class="totales" align="center"><div id="resultados_col3"></div></td>
            <td class="totales" align="center"><div id="resultados_col4"><?=$SUM4?></div></td>
        </tr>        
        
    </tbody>
</table> 
</div>
<input type="hidden" name="transaccion_sel" id="transaccion_sel" value="">
<input type="hidden" name="proov_y_vent_sel" id="proov_y_vent_sel" value="<?=$id_proov_y_uvent?>">
<input type="hidden" name="id_local" id="id_local" value="<?=$id_local?>">

<?php
    if($actas!="error"){   
        foreach ($actas as $key => $value) {
            $img=$value['imagen_acta'];  
            if(!empty($img))echo '<div width="70%" align="center"><div class="panel-body"><img id="myBtn" data-img="'.$img.'" src="v2/src/ver_imagen2.jpg" alt="" ></div></div>';
            $horaGuardada = $value!="error"?$value["fecha_acta"]:"";
            $horaActual = new DateTime($horaGuardada);
            $horasASumar = 4; // Número de horas a sumar
            $horaActual->modify("+$horasASumar hours");
            $nuevaHora = $horaActual->format('d-m-H H:i:s');
        
            ?>
            <div style="display: flex; align-items: center; justify-content: center; margin: 30px;">
                <div style="width: 98%; background-color:#cce5ff; text-align:center; padding:20px; color:#135090">
                    <img src="v2/src/exclamation.jpg"><?= !isset($actas["id_acta"])? 'sin permiso de edicion':'Ya se encuentra guardada esta acta'?> (<?=$nuevaHora?>)</div>
            </div><br>
        <?php
        }
    }     

    if($actas=="error" &&  $user->permiso=="carga"||$user->permiso=="admin"||$user->permiso=="admin_dto"||$user->permiso=="editor"){
?>
    <div align="center">
    <h4 >Seleccione imagen a cargar</h4>
            <div class="form-group">
            <div class="col-sm-8">
                <input type="hidden" name="MAX_FILE_SIZE" value="7145728">
                <input accept="image/png, application/pdf, image/jpeg, image/jpg" type="file" class="form-control" id="image" name="image" style="max-width: 48%;">
            </div>
            </div>
    </div>

    <div class="accion-enviar" align="center">
        <input >
        <button type="submit" class="guardar-form" id="guardar_acta">Guardar Acta</button>
        <input type="hidden" name="regreso" value="_mobile">
    </div>

<?php  } ?>
</form>
</div>