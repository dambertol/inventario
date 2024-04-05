<?php require 'temp/encabezado.php';?>
<div class="container">
      <h1> bienvenido <?php echo ucwords($user->nombre); ?></h1>

      <!--<p class="alert-success">Se ha registrado con exito</p>-->
      <br>
      <br><p>A continuación elija el proov_y_vent y local de la que será el único fiscal encargado o admin para más acceso, este caso esta sujeto a posterior aprobación</p>
      <br>
      <form action="<?php echo DIR; ?>/bienvenido" method='post'>
      <select name="dep" id="dep" placeholder="proov_y_vent" class="custom-select padding width20">
        <option></option>
        <?php foreach ($depto as $key2 => $value2) {

          ($_POST["dep"]==$value2[0])? $sel="selected" : $sel="";
          echo"<option ".$sel." style='padding:10px' value='".$value2[0]."'>".$value2[1]."</option>";
        }
        ?>        
        <option value='adm'>**Sin local**</option>
        </select><button class="padding" style="margin-left:10px" type='submit'>buscar</button></form>
        <br>
    <form action="<?php echo DIR; ?>/bienvenido" method="post">
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
              if($key2!=0) echo "<td>".$value2."</td>";
            }
            echo "<td><button data-esc='".$value[4]."' class='conf' type='submit' name='local' value=".$value[0]." >elegir</button></td>";
            echo"</tr>";
    } }?>
        </tbody>
      </table>

      <!--mobile-->


      <table class="table table-hover table-stripped scrolleable tableResponsive">
        <thead>
          <tr>
            <th class="col-2">local</th>
            
            <th class="col-2">Nombre</th>
            <th class="col-2">Localidad</th>
            <th class="col-1"></th>
          </tr>
        </thead>
        <tbody>
    <?php if(isset($circuito)){
            foreach ($circuito as $key => $value){
            echo"<tr>"; 
              echo "<td>".$value[1]."</td>";  
              echo "<td>".$value[4]."</td>";  
              echo "<td>".$value[6]."</td>";  
              echo "<td><button data-esc='".$value[4]."' class='conf' type='submit' name='local' value=".$value[0]." >elegir</button></td>";
            echo"</tr>";
    } }?>
        </tbody>
      </table>




      </form>
<script>
/*
var conf=document.querySelectorAll('.conf');
conf.forEach(element => {
 element.addEventListener("click", function(e){
    if(!confirm('confirma la seleccion de esta local?')){
      e.preventDefault();
    };
}); 
});*/

$(document).ready(function(){
  $(".conf").click(function(e){
     if(!confirm('confirma la selección de la local '+$(this).attr("data-esc")+' ?')){
         e.preventDefault();
     }
  })
})


</script>
</script>
  </body>
</html>