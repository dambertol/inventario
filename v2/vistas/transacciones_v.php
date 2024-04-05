<?php require 'temp/encabezado.php';
    $depto=$edit->obtener_todos("proov_y_uventas");
    $params = $_GET;
    unset($params['crear']);
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
            <th class="col-2">Id depto</th>
            <th class="col-2">Id local</th>
            <th class="col-2">Cant electores</th>
            <th class="col-2">Testigo</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <tr><form action="#" >
          <?php echo "<td><select style='padding: 5px;' name='id_proov_y_uvent' class='depto-mod' title='proov_y_vent' id='campo2'><option></option>";
               foreach ($depto as $key3 => $value3) echo "<option value='".$value3['id_proov_y_uvent']."'>".$value3['nombre_proov_y_uvent']."</option>";
               echo "</select></td>";?>
          <td><input type="text" name="id_local" id="campo3" class="buscar_inp"></td>  
          <td><input type="text" name="saldo_ant" id="campo4" class="buscar_inp"></td>
          <td><input type="text" name="transaccion_testigo" id="campo5" class="buscar_inp"></td>
          <input type="hidden" name='crear' id="campo1" value='crear'>
          <td><button class="btn btn-large btn-info modal-perm" id="crear" >Crear</button></td>
        </form></tr>
  </tbody>
</body>

      <table width="100%" class="table table-hover table-stripped scrolleable tableDesk">
        <thead>
          <tr>
            <th class="col-2">Id transaccion</th>
            <th class="col-2">Id depto</th>
            <th class="col-2">id_local</th>
            <th class="col-2">Cant. Electores</th>
            <th class="col-2">Testigo</th>
            <th class="col-2">Editar</th>
            <th class="col-2">Borar</th>
          </tr>
          <a href=""></a>
        </thead>
        <tbody>
          <tr><form action="#" method="get">
            <td><input type="text" name="id_transaccion" class="buscar_inp"></td>
            <td><input type="text" name="id_proov_y_uvent" class="buscar_inp"></td>
            <td><input type="text" name="id_local" class="buscar_inp"></td>
            <td><input type="text" name="saldo_ant" class="buscar_inp"></td>
            <td><input type="text" name="testigo" class="buscar_inp"></td>
            <input type="hidden" name='consultar' value='consultar'>
            <td><button class="btn btn-large btn-info modal-perm" id="boton" >Buscar</button></td>
          </form></tr>

            <?php if(isset($todos)){
            foreach ($todos as $key => $value){
              echo"<tr>";
              foreach ($value as $key2 => $value2){
              echo"<td>".ucwords($value2)."</td>";
           }
            echo"<td><button class='btn btn-large btn-alert modal-perm elim' name='edit' value='".$value['id_transaccion']."' onclick='rellenarFormulario(this)'>editar</button></td>".
           "<td><button class='btn btn-large btn-danger modal-perm elim' name='elim' value='".$value['id_transaccion']."' onclick='eliminar(this)'>eliminar</button></td></tr>";
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
        if(confirm('desea borrar esta transaccion?')){
            $.ajax({
            type: "POST",
            url: 'editartransacciones',
            data:{id_transaccion: fila, accion: "eliminar"}  //,token:$("#token").val()
        }).then(alert('transaccion eliminada')).then(location.reload()).fail(function (jqXHR, textStatus, errorThrown) {
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
  document.getElementById("crear").innerHTML="Editar";
  document.getElementById("campo1").value = valor1;
  document.getElementById("campo2").value = valor2;
  document.getElementById("campo3").value = valor3;
  document.getElementById("campo4").value = valor4;
  document.getElementById("campo5").value = valor5;
}

    </script>

  </body>
</html>