<?php require 'temp/encabezado.php';
    $params = $_GET;
    if (isset($params['indice']))  unset($params['indice']);
    $qry ="&";
    if (!empty($params)) $qry .= http_build_query($params);
?>

<div class="container">

<div style="margin-bottom: 30px;margin-top: 30px;text-align: center;">
    <a id="crear_usuario" class="btn btn-large btn-info modal-perm" href="crear_usuario">Crear usuario</a>
</div>


      <table width="100%" class="table table-hover table-stripped scrolleable tableDesk">
        <thead>
          <tr>
            <th class="col-2">Usuario</th>
            <th class="col-2">Nombre</th>
            <th class="col-2">local</th>
            <th class="col-2">Permiso</th>
            <th class="col-2">Editar local</th>
            <th class="col-1">Editar Contraseña</th>
          </tr>
          <a href=""></a>
        </thead>
        <tbody>
        <tr><form action="#"><td><input type="text" name="dni_usu" class="buscar_inp"></td>   <td><input type="text" name="nombre_usu" class="buscar_inp"></td>  <td><input type="text" name="nombre_local" class="buscar_inp"></td>  <td><input type="text" name="permiso_usu" class="buscar_inp"></td><td>  </td><td><button class="btn btn-large btn-info modal-perm" id="boton" >Buscar</button></td></form></tr>
            <form action="<?php echo DIR; ?>/administrar_usuarios" method="post">

            <?php if(isset($todos) && $todos!=null){
            foreach ($todos as $key => $value){
              echo"<tr><td>".ucwords($value['dni_usu'])."</td><td>".ucwords($value['nombre_usu'])."</td>";
              ($value['nombre_local'])? print "<td>".ucwords($value['nombre_local'])."</td>" : print "<td><span class='sinlocal'>Sin local Asignada</span></td>" ;   

            echo "<td><select style='padding: 5px;' name='permiso' data-dni=".$value['dni_usu']." class='permiso-mod' title='".$value['permiso_usu']."'>".
            "<option></option>".
            "<option value='sin' ". ($value['permiso_usu']=='sin'?"selected":"") .">sin</option>".
            "<option value='carga' ". ($value['permiso_usu']=='carga'?"selected":"") .">carga</option>";
            //if($id_proov_y_uvent==0){
            echo "<option value='visualizar'". ($value['permiso_usu']=='visualizar'?"selected":"") .">visualizar</option>".
            "<option value='editor' ". ($value['permiso_usu']=='editor'?"selected":"") .">editor</option>".
            "<option value='visual_dto' ". ($value['permiso_usu']=='visual_dto'?"selected":"") .">visual_dto</option>".
            "<option value='admin_dto' ". ($value['permiso_usu']=='admin_dto'?"selected":"") .">admin_dto</option>".
            "<option value='admin' ". ($value['permiso_usu']=='admin'?"selected":"") .">admin</option>";
            //}
            echo "</select></td>";
         /*   if($id_proov_y_uvent==0){
              echo "<td><select style='padding: 5px;' name='id_depto' data-dni=".$value['dni_usu']." class='depto-mod' title='".$value['id_proov_y_uvent']."'><option> </option>";
              foreach ($depto as $key3 => $value3) echo "<option value='".$value3[0]."'". ($value['id_proov_y_uvent']==$value3[0]?"selected":"").">".$value3[1]."</option>";
              echo "</select></td>";
            }else{
              echo "<td>$id_proov_y_uvent</td>";
            } */
            echo '<td><a  title="Asignar local" style="width: 80px;" href="locales_mod?dni='.$value['dni_usu'].'" role="button" class="btn btn-large btn-primary modal-perm" 
            data-toggle="modal" onClick="window.open(this.href, this.target, width=50%); return false;">'.$value['id_local'].'</a></td>';//pop-up con opciones de permiso
            echo "<td><button data-nombre=".ucwords($value['nombre_usu'])." title='Editar Contraseña' style='padding: 7px;' class='conf' type='button' name='contrasegna' value=".$value['dni_usu']." >Cambiar</button></td>";
            echo"</tr>";
            } }?>
          </form>
        </tbody>
      </table>


<!-- versin mobile -->
      <table class="table table-hover table-stripped scrolleable tableResponsive">
   
      <form action="<?php echo DIR; ?>/administrar_usuarios" method="post">
        <?php if(isset($todos) && $todos!=null){
            foreach ($todos as $key => $value){
              echo"<tr> <td> <div class='divSpace'><b>DNI:</b> ".ucwords($value['dni_usu'])."</div>";
              echo "<div class='divSpace'><b>Nombre:</b> ".ucwords($value[1])."</div>";
              ($value['id_local'])? print "<div class='divSpace'><b>local:</b> <i>".ucwords($value['id_local'])."</i></div>" : print "<div class='divSpace'><span class='sinlocal'>Sin local Asignada</span></div>" ;   
              echo "<div class='divSpace'><b>Permiso:</b> <select style='padding: 5px; width:100%' name='permiso' data-dni=".$value['dni_usu']." class='permiso-mod' title='".$value['permiso_usu']."'>".
              "<option></option>".
              "<option value='sin' ". ($value['permiso_usu']=='sin'?"selected":"") .">sin</option>".
              "<option value='carga' ". ($value['permiso_usu']=='carga'?"selected":"") .">carga</option>";
              //if($id_proov_y_uvent){
              echo "<option value='visualizar' ". ($value['permiso_usu']=='visualizar'?"selected":"") .">visualizar</option>".
              "<option value='editor' ". ($value['permiso_usu']=='editor'?"selected":"") .">editor</option>".
              "<option value='visual_dto' ". ($value['permiso_usu']=='visual_dto'?"selected":"") .">visual_dto</option>".
              "<option value='admin_dto' ". ($value['permiso_usu']=='admin_dto'?"selected":"") .">admin_dto</option>".
              "<option value='admin' ". ($value['permiso_usu']=='admin'?"selected":"") .">admin</option>";

              //}
              echo "</select></div>";
          /*    if($id_proov_y_uvent==0){
                echo "<div class='divSpace'><select style='padding: 5px; width:100%' name='id_depto' data-dni=".$value['dni_usu']." class='depto-mod' title='".$value['id_proov_y_uvent']."'><option> </option>";
                foreach ($depto as $key3 => $value3) echo "<option value='".$value3[0]."'". ($value['id_proov_y_uvent']==$value3[0]?"selected":"").">".$value3[1]."</option>";
                echo "</select></div>";
              }else{
                echo "<div class='divSpace'>$id_proov_y_uvent</div>";
              } */
              echo '<div class="divSpace"><b>Editar local:</b> <a  title="Asignar local" style="width: 80px;" href="locales_mod?dni='.$value['dni_usu'].'" role="button" class="btn btn-large btn-primary modal-perm" 
              data-toggle="modal" onClick="window.open(this.href, this.target, width=50%); return false;">'.$value['id_local'].'</a></div>';//pop-up con opciones de permiso
              echo "<div class='divSpace'><button data-nombre=".ucwords($value['dni_usu'])." title='Editar Contraseña' style='padding: 7px;' class='conf' type='button' name='contrasegna' value=".$value['dni_usu']." >Cambiar Contraseña</button></div><br>";
              echo"</td></tr>";
            } }?>
      </table>
      </form>

      <div id="paginator">
        <a href="administrar_usuarios?indice=0<?= $qry ?>">Inicio</a>
        <a id="pag_ant" href='administrar_usuarios?indice=<?php echo isset($_GET['indice'])?($_GET['indice']-1).$qry:"0".$qry;?>' ><i class="fas fa-chevron-left"></i> Ant.</a>
        <a id="pag_pos" href='administrar_usuarios?indice=<?php echo isset($_GET['indice'])?($_GET['indice']+1).$qry:"1".$qry;?>'>Sig. <i class="fas fa-chevron-right"></i></a>
        <!-- <a id="pag_ul" href="administrar_usuarios?<?php //echo isset($_POST['indice'])?$_POST['indice']-1:"";?>">Última página</a> -->
        <br><br>
      </div>
    </div>
    <script>
    var conf=document.querySelectorAll('.permiso-mod');
    var moddep=document.querySelectorAll('.depto-mod');
    var confff=document.querySelectorAll('.conf');

    conf.forEach(element => {
    element.addEventListener("change", function(e){
        if(confirm('confirma cambio de accesos?')){
            $.ajax({
            type: "POST",
            url: 'administrar_usuarios',
            data:{dni: element.dataset.dni, permiso:element.value}  //,token:$("#token").val()
        }).then(alert('acceso para el usuario '+element.dataset.dni+' modificada')).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        })
        };
    }); 
    });

    moddep.forEach(element => {
    element.addEventListener("change", function(e){
      element.value==20?newdep=0:newdep=element.value;
        if(confirm('confirma cambio de proov_y_vent? se reseteara la local si fue asignada')){
            $.ajax({
            type: "POST",
            url: 'administrar_usuarios',
            data:{dni: element.dataset.dni, dto:newdep}  //,token:$("#token").val()
        }).then(alert('proov_y_vent del usuario '+element.dataset.dni+' modificada')).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        })
        };
    }); 
    });

    confff.forEach(element => {
    element.addEventListener("click", function(e){
        if(confirm('confirma cambio de contraseña? La contraseña nueva será: elecciones123')){
          e.preventDefault;
            $.ajax({
            type: "POST",
            url: 'administrar_usuarios',
            data:{contrasegna: element.value}})  //,token:$("#token").val()
        .done(function(response) {
    console.log((response));})
          .then(alert('Contraseña modificada para '+element.dataset.nombre+''))
          .then(console.log())
          .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        })
        };
    }); 
    });

    </script>

  </body>
</html>