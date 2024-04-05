<?php require 'temp/encabezado.php';
    $depto=$edit->obtener_todos("proov_y_uventas");
    $materiales_=$edit->obtener_todos("materiales");
    $params = $_GET;
    if (isset($params['indice'])) {
        unset($params['indice']);
    }
    $qry ="&";
    if (!empty($params)) $qry .= http_build_query($params);
?>

<div class="container">

<table width="100%" class="table table-hover table-stripped scrolleable tableDesk">
        <thead>
          <tr>
            <th class="col-2">Id agrup</th>
            <th class="col-2">Id depto</th>
            <th class="col-2">marcas_y_prod</th>
            <th class="col-2">Interna</th>
            <th class="col-2">Real</th>
            <th></th>
          </tr>
          <a href=""></a>
        </thead>
        <tbody>
        <tr><form action="#" >
          <?php echo "<td><select style='padding: 5px;' name='id_material' class='depto-mod' title='materiales' id='campo2'><option></option>";
               foreach ($materiales_ as $key3 => $value3) echo "<option value='".$value3['id_material']."'>".$value3['nombre_material']."</option>";
               echo "</select></td>";?>
          <?php echo "<td><select style='padding: 5px;' name='id_proov_y_uvent' class='depto-mod' title='proov_y_vent' id='campo3'><option></option>";
               foreach ($depto as $key3 => $value3) echo "<option value='".$value3['id_proov_y_uvent']."'>".$value3['nombre_proov_y_uvent']."</option>";
               echo "</select></td>";?>
          <td><input type="text" name="nombre_marca_prod" id="campo4" class="buscar_inp"></td>  
          <td><input type="text" name="interna_marcas_y_prod" id="campo5" class="buscar_inp"></td>
          <td><input type=number name="real_marcas_y_prod" id="campo6" class="buscar_inp"></td>
          <input type="hidden" name='crear' id="campo1" value='crear'>
          <td><button class="btn btn-large btn-info modal-perm" id="crear" >Crear</button></td>
        </form></tr>
  </tbody>
</body>

      <table width="100%" class="table table-hover table-stripped scrolleable tableDesk">
        <thead>
          <tr>
            <th class="col-2">Id marcas_y_prod</th>
            <th class="col-2">Id agrup</th>
            <th class="col-2">Id depto</th>
            <th class="col-2">marcas_y_prod</th>
            <th class="col-2">Interna</th>
            <th class="col-2">Real</th>
            <th class="col-2">Editar</th>
            <th class="col-2">Borar</th>
          </tr>
          <a href=""></a>
        </thead>
        <tbody>
          <tr><form action="#" method="get">
            <td><input type="text" name="id_marcas_prod" class="buscar_inp"></td>
            <td><input type="text" name="id_material" class="buscar_inp"></td>
            <td><input type="text" name="id_proov_y_uvent" class="buscar_inp"></td>
            <td><input type="text" name="nombre_marca_prod" class="buscar_inp"></td>
            <td><input type="text" name="interna_marcas_y_prod" class="buscar_inp"></td>
            <td><input type=number name="real_marcas_y_prod" min="0" min="1" class="buscar_inp"></td>
            <input type="hidden" name='consultar' value='consultar'>
            <td><button class="btn btn-large btn-info modal-perm" id="boton" >Buscar</button></td>
          </form></tr>

            <?php if(isset($todos)){
            foreach ($todos as $key => $value){
              echo"<tr>";
              foreach ($value as $key2 => $value2){
              echo"<td>".ucwords($value2)."</td>";

           }
           echo"<td><button class='btn btn-large btn-alert modal-perm elim' name='edit' value='".$value['id_marcas_prod']."' onclick='rellenarFormulario(this)'>editar</button></td>".
           "<td><button class='btn btn-large btn-danger modal-perm elim' name='elim' value='".$value['id_marcas_prod']."' onclick='eliminar(this)'>eliminar</button></td></tr>";
          } }?>
        </tbody>
      </table>

      <div id="paginator">
        <a href="?indice=0<?= $qry ?>">Inicio</a>
        <a id="pag_ant" href='?indice=<?php echo isset($_GET['indice'])?($_GET['indice']-1).$qry:"0".$qry;?>' ><i class="fas fa-chevron-left"></i> Ant.</a>
        <a id="pag_pos" href='?indice=<?php echo isset($_GET['indice'])?($_GET['indice']+1).$qry:"1".$qry;?>'>Sig. <i class="fas fa-chevron-right"></i></a>
        <!-- <a id="pag_ul" href="?<?php //echo isset($_POST['indice'])?$_POST['indice']-1:"";?>">Última página</a> -->
        <br><br>
      </div>
    </div>
    <script>

function eliminar(button) {
    var fila = button.value;
        if(confirm('desea borrar esta marcas_prod?')){
            $.ajax({
            type: "POST",
            url: 'marcas_prod',
            data:{id_marcas_prod: fila, accion: "eliminar"}  //,token:$("#token").val()
        }).then(alert('marcas_prod eliminada')).then(location.reload()).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        })
        };
  }
   
function rellenarFormulario(button) {
  var fila = button.parentNode.parentNode;

  var valor1 = fila.cells[0].textContent;
  var valor2 = fila.cells[1].textContent;
  var valor3 = fila.cells[2].textContent;
  var valor4 = fila.cells[3].textContent;
  var valor5 = fila.cells[4].textContent;
  var valor6 = fila.cells[5].textContent;
  document.getElementById("crear").innerHTML="Editar";
  document.getElementById("campo1").value = valor1;
  document.getElementById("campo2").value = valor2;
  document.getElementById("campo3").value = valor3;
  document.getElementById("campo4").value = valor4;
  document.getElementById("campo5").value = valor5;
  document.getElementById("campo6").value = valor6;
}

    </script>

  </body>
</html>