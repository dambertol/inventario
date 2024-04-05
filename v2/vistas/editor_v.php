<?php //require 'temp/encabezado.php';
   // $depto=$edit->obtener_todos("departamentos");
    $columna = $_GET;
    if (isset($columna['indice'])) {
        unset($columna['indice']);
    }
    $qry ="&";
    if (!empty($columna)) $qry .= http_build_query($columna);
    //	''	'audi_accion'
    foreach ($todos as $key => $value) {
      unset($todos[$key]['audi_usuario']);
      unset($todos[$key]['audi_fecha']);
      unset($todos[$key]['audi_accion']);
    }

    $zonas_nombres = $this->consulta_zona();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="https://sistemamlc.lujandecuyo.gob.ar/v2/favicon.ico">
  
	<title>TAD - Descargar Informe -</title>
		<!-- Bootstrap-Select -->
	<link href="https://sistemamlc.lujandecuyo.gob.ar/v2/vendor/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
		<!-- Bootstrap Core CSS -->
	<link href="https://sistemamlc.lujandecuyo.gob.ar/v2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom CSS -->
	<!-- <link href="https://sistemamlc.lujandecuyo.gob.ar/v2/vendor/gentelella/css/custom.min.css" rel="stylesheet"> -->
		<!-- Custom Fonts -->
	<!-- <link href="https://sistemamlc.lujandecuyo.gob.ar/v2/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
		<!-- DataTables -->
	<link href="https://sistemamlc.lujandecuyo.gob.ar/v2/vendor/datatables/css/datatables.min.css" rel="stylesheet">
		<!-- DateTimePicker -->
	<link href="https://sistemamlc.lujandecuyo.gob.ar/v2/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/w3.css?<?=date("YmdHis")?>">  
  <style>
    #tabla-fija {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
    }
    #tabla-fija3 {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
    }
    #tabla-fija2 tbody td:nth-child(4) {
        position: sticky;
        left: 0;
        z-index: 1;
        background-color: #f2f2f2;
        min-width: 25px;

    }
    
  </style>
  <title><?=$titulo?></title>
</head>
<body>
  
<div class="container" style="margin: auto !important; width: 100%;">
  <section id="tabla-fija3">
    <h2><?=$tabla?></h2>
      <form action="#">
        <select name="tabla" id="selectortabla">elija la tabla
          <?php foreach ($tablasT as $value) echo "<option value='$value'>$value</option>"?>
        </select>
        <button type="submit">elegir tabla</button>
      </form>

      <button id="myBtn" class="btn btn-large btn-info modal-perm crearbot">CREAR</button>



<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>


        <form action="#" id="campo1">
                <table width="100%"  style="background-color: #f2f2f2;" class="table table-hover table-stripped scrolleable tableDesk">       

                    <tbody>
                      <tr>                        
                          <?php 
                          foreach (array_keys($todos[0]) as $nombre){
                            if ($nombre=='id_sub_uso'||$nombre=='id_estac'||$nombre=='id'||$nombre=='id_uso') {
                              $idd=$nombre;
                              break;
                            }              
                          }
                          foreach (array_keys($todos[0]) as $nombre){
                            if ($nombre==$idd) {
                              echo "<table width='100%'><tr><td style='padding: 6px;'><div style='width:50%'>".$nombre."</div><textarea style='resize: vertical;width:100%' rows='1' name='$nombre' id='$nombre' readonly></textarea></td></tr></table>";
                            }else{

                              ($nombre=="zona_id")? $zi="<b><select id='zona_id_sel'><option value='1'>xxxxx</option></select></b>" : $zi="" ;

                              echo "<table width='100%'><tr><td style='padding: 6px;'><div>".$nombre."</div><textarea style='resize: vertical;width:100%' rows='1' name='$nombre' id='$nombre' class='buscar_inp'></textarea>".$zi."</td></tr></table>";


                          }}?>
                        <input type="hidden" name='accion' value='crear' id="crearinp">
                        <input type="hidden" name='tabla' value='<?=$tabla?>'>
                        <td><div style="text-align:center;">
                          <button type="submit" class="btn btn-large btn-info modal-perm crearbot" >Guardar</button>
                        </div>
                        </td>
                      </tr>
                    </tbody>
                </table></form>

    </p>
  </div>

</div>


    </section>

    <table id="tabla-fija2" width="100%" class="table table-hover table-stripped scrolleable tableDesk">
        <thead>
          <tr id="tabla-fija" style="background-color: #ddf7ff;"><th></th><th></th>
            <?php 
            foreach (array_keys($todos[0]) as $nombre) {
              //if($nombre!="id"){
                echo "<th class='col-2'>".ucwords($nombre)."</th>";
              //}
            }
            ?>
            <th class="col-2">Editar</th>
            <th class="col-2">Borrar</th>
          </tr>
          <!-- <a href=""></a> -->
        </thead>
        <tbody>
          <form action="#" method="get"><tr><td colspan='2'>Buscador</td>
            <?php 
            foreach (array_keys($todos[0]) as $nombre) {
              //if($nombre!="id"){
                echo "<td><input type=text name='$nombre' class='buscar_inp'></td>";
             // }
            }
            ?>

            <input type="hidden" name='accion' value='consultar'>
            <input type="hidden" name='tabla' value='<?=$tabla?>'>
            <td><button class="btn btn-large btn-info modal-perm" id="boton" >Buscar</button></td>
          </tr></form>
            <?php if(isset($todos)){
              foreach ($todos as $key => $value){

                  echo"<tr><td><button  class='btn btn-large btn-alert modal-perm elim' name='edit' value='".$value[$idd]."' onclick='rellenarFormulario(this)'>editar</button></td>".
                  "<td><button class='btn btn-large btn-danger modal-perm elim' name='elim' value='".$value[$idd]."' onclick='eliminar(this)'>eliminar</button></td>";      

                  foreach ($value as $key2 => $value2){
                   // if($key2!="id"){

                      $org=$value2;
                      
                      //if($key2=="zona_id") $value2=   $zonas_nombres[$value2["id"]]["zona_urb"];    



                      echo"<td data-rel='".$org."' style='max-width : 80px; word-break: break-all;'><div style='max-height: 100px; overflow: auto;'>".$value2 ."</div></td>";   
                   // }  
                  } 
                  echo"<td><button  class='btn btn-large btn-alert modal-perm elim' name='edit' value='".$value[$idd]."' onclick='rellenarFormulario(this)'>editar</button></td>".
                  "<td><button class='btn btn-large btn-danger modal-perm elim' name='elim' value='".$value[$idd]."' onclick='eliminar(this)'>eliminar</button></td></tr>";
               
            } }?>


        </tbody>
    </table>

      <div id="paginator">
        <a href="?indice=0<?= $qry ?>">Inicio</a>
        <a id="pag_ant" href='?indice=<?php echo isset($_GET['indice'])?($_GET['indice']-1).$qry:"0".$qry;?>' ><i class="fas fa-chevron-left"></i> Ant.</a>
        <a id="pag_pos" href='?indice=<?php echo isset($_GET['indice'])?($_GET['indice']+1).$qry:"1".$qry;?>'>Sig. <i class="fas fa-chevron-right"></i></a>
        <a href="?indice=<?php echo floor($ult[0]['total']/20);?><?= $qry ?>">Última</a>

        <!-- <a id="pag_ul" href="listas?<?php //echo isset($_POST['indice'])?$_POST['indice']-1:"";?>">�ltima p�gina</a> -->
        <br><br>
      </div>

    </div>
    <script>

function eliminar(button) {
    var fila = button.value;
    if (confirm('¿Desea borrar este postulante?')) {
        // Obtener la URL base sin los parámetros GET
        var baseUrl = window.location.href.split('?')[0];
        
        fetch(baseUrl + '?<?=$idd?>=' + fila + '&accion=eliminar&tabla=<?=$tabla?>', {
            method: 'GET'
        })
        .then(response => {
            if (response.ok)  return response.json();
            throw new Error('Error en la solicitud.');
        })
        .then(data => {
            alert('Postulante eliminado');
            location.reload(); // Recargar la página después de eliminar
        })
        .catch(error => {
            console.error(error);
        });
    }
}



   //version
function rellenarFormulario(button) {
  var fila = button.parentNode.parentNode;
  <?php  for ($i=2; $i < (count($todos[0])+2) ; $i++) { 
    $j=$i+1;
    echo "var valor".$j." = fila.cells[".$i."].textContent; \n";
    echo "var valor_org".$j." = fila.cells[".$i."].getAttribute('data-rel'); \n";/////////////////////////// tratar de tomar el td
  }?>


 //alert(valor_org4);

  document.querySelector(".crearbot").innerHTML="Editar";
  document.getElementById("crearinp").value="editar";

  <?php  $i=2; 
  foreach (array_keys($todos[0]) as $key => $value) {
    $j=$i+1;
    echo "document.getElementById('$value').value = valor_org".$j."; \n";
    if($value=="zona_id"){

        echo "document.getElementById('$value').setAttribute('readonly', 'true');";

        echo "document.getElementById('$value').style.backgroundColor = '#ccc';";

        echo "document.getElementById('$value').style.border = '1px solid #ccc';";
 
    }
    echo "document.getElementById('$value').setAttribute('data-value', '".$j."');";
    $i++;
  }
  ?>
 document.getElementById('myBtn').click();
}

/////////////////////////////////////////////////////////////////////////
</script>

<script>


var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
var box = document.getElementById('tabla-fija');
var celdas = document.querySelectorAll('#tabla-fija2 tbody td:nth-child(3)');

btn.onclick = function() {
  modal.style.display = "block";
  box.style.position = 'unset';
  celdas.forEach(function(celda) {
    celda.style.position = 'unset'; 
  });
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  box.style.position = 'sticky';  
  celdas.forEach(function(celda) {
    celda.style.position = 'sticky'; 
  });
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    box.style.position = 'sticky';
    celdas.forEach(function(celda) {
      celda.style.position = 'sticky'; 
    });
  }
}
</script>

  </body>
</html>