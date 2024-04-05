<?php  require 'v2/vistas/temp/encabezado.php';?>

<div class="container">
<h3>Cambiar local asignada al usuario <?php echo ucwords($user->nombre); ?> (<?php echo $usuario; ?>)</h3>
 <form action="<?php echo DIR; ?>/locales_mod?dni=<?php echo $usuario; ?>" method='post'>
      <select name="dep" id="dep" placeholder="proov_y_vent" class="custom-select padding width20">
        <option></option>
        <?php foreach ($depto as $key2 => $value2) {
          //echo"<option value='".$value2['id_proov_y_uvent']."'>".$value2['nombre_proov_y_uvent']."</option>";
           ($_POST["dep"]==$value2['id_proov_y_uvent'] || $usuarioEsc["id_proov_y_uvent"] ==$value2['id_proov_y_uvent'])? $sel="selected" : $sel="";
          echo"<option ".$sel." style='padding:10px' value='".$value2['id_proov_y_uvent']."'>".$value2['nombre_proov_y_uvent']."</option>";
        }
        ?>        
        <option value='adm'>admin</option>
        </select><button class="padding" style="margin-left:10px" type='submit'>buscar</button></form>
        <br>
    <form action="<?php echo DIR; ?>/locales_mod?dni=<?php echo $usuario; ?>" method="post">
      

      <table class="table table-hover table-stripped scrolleable tableDesk">
        <thead>
          <tr>
            <th class="col-2">local</th>
            <th class="col-2">proov_y_vent</th>
            <th class="col-1">Circuito</th>
            <th class="col-2">Nombre</th>
            <th class="col-2">Domicilio</th>
            <th class="col-2">Localidad</th>
            <th class="col-1"></th>
          </tr>
        </thead>
        <tbody>
    <?php if(isset($circuito)){
            foreach ($circuito as $key => $value){
              echo"<tr>";
            foreach ($value as $key2 => $value2) {
              ($user->esc==$value['id_local']) ? $styleCurr= "style='background-color: #fffde3;'" : $styleCurr="";
              if($key2!='id_local') echo "<td ".$styleCurr." >".$value2."</td>";
            }

            if($user->esc!=$value['id_local']){
                 echo "<td><button data-esc='".$value['circuito_esc']."' class='conf' type='submit' name='local' value=".$value['id_local']." >elegir"."</button></td>";
            }else{
                echo "<td style='background-color: #fffde3;' ><b>Actual</b></td>";
            }

            echo"</tr>";
    } }?>
        </tbody>
      </table>

      <!--version mobile-->

        <table class="tableResponsive" >

        <?php if(isset($circuito)){
                    foreach ($circuito as $key => $value){
                      echo"<tr><td style='width:400px;padding-bottom: 20px !important;'>";
                    foreach ($value as $key2 => $value2) {
                      ($user->esc==$value['id_local']) ? $styleCurr= "style='background-color: #fffde3;'" : $styleCurr="";
                      if($key2!=0) echo "<div ".$styleCurr." >".$value2."</div>";
                    }

                    if($user->esc!=$value['id_local']){
                         echo "<div><button data-esc='".$value['circuito_esc']."' class='conf' type='submit' name='local' value=".$value['id_local']." >elegir"."</button><br><hr></div>";
                    }else{
                        echo "<div style='background-color: #fffde3;' ><b>Actual</b></div>";
                    }

                    echo"</td></tr>";
            } }?>

        </table>



      </form>
<script>
  $(document).ready(function(){
  $(".conf").click(function(e){
     if(!confirm('confirma la selección de la local '+$(this).attr("data-esc")+' ?')){
         e.preventDefault();
     }
  })
})
</script>
</div>