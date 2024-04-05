<?php  require 'v2/vistas/temp/encabezado.php';?>

<div class="container" style="margin-top: 20px">
  <h2>Perfil <?=$user->nombre?></h2>
    <div> <b>Permiso:</b> <?=$user->permiso?> </div>  
    <div>      
      <b>local Asignada:</b> <?php if(is_array($userEsc)) echo $userEsc["id_local"] . " - " .$userEsc["nombre_local"];?>
    </div>
     <div>      
      <b>transacciones: </b>
        <?php if($transaccionesXusu){
            $transaccionesString="";
            foreach ($transaccionesXusu as $value)  $transaccionesString.= $value[0] . " - ";
            echo substr($transaccionesString,0,-2);
          }?>
    </div>

  <h2>Cambio de contraseña</h2>
  <form class="login100-form validate-form" method="post" action="<?php echo DIR; ?>/contrasena">
   
    <div>
          </div>
    <div class="wrap-input100 validate-input">
      <span class="label-input100">Contraseña</span>
      <input class="input100" name="token_usu" id="pass" type="password" placeholder="ingrese contraseña" >
      <span class="focus-input100 input-lock"></span>
    </div>
    <div style="height: 20px"></div>
    <div class="wrap-input100 validate-input">
    <span class="label-input100">Confirme Contraseña</span>
    <input class="input100" name="confirm_password" id="pass2" type="password" placeholder="Confirme contrasña">
    <span class="focus-input100 input-lock"></span>
    </div>

    <div class="container-login100-form-btn">
    <div class="wrap-login100-form-btn">

      <input class="login100-form-btn" type="button" value="Guardar" id="envio">

    </div>
    
     
    </div>


    </form>

</div>



<script>
/*
var pass=document.getElementById("pass");
var pass2=document.getElementById("pass2");
var subb=document.getElementById("envio");

pass.addEventListener("change",(e)=>{
  if(pass.value.length<6){
    alert('la contraseÃ±a debe ser mayor a 6 caracteres');
  }
});

pass2.addEventListener("change",(e)=>{
  if(pass.value==pass2.value && pass.value.length>5){
    subb.removeAttribute("disabled");
  }else{
        alert('no coinciden las contraseÃ±as');
    subb.setAttribute("disabled","");
  }
});
*/

$(document).ready(function(){
  $("#envio").click(function(){
  
   if(!$( "#pass" ).val()){
    alert('Ingrese una Contraseña');
    $("#pass").focus();
    return false;
   }
   if($( "#pass" ).val().length < 6){
    alert('La contraseña  debe ser mayor a 6 caracteres');
    $("#pass").focus();
    return false;
   }

   if(!$( "#pass2" ).val()){
    alert('Ingrese una Contraseña de confirmación');
    $("#pass2").focus();
    return false;
   }
   if($( "#pass2" ).val().length < 6){
    alert('La contraseña de confirmación debe ser mayor a 6 caracteres');
    $("#pass2").focus();
    return false;
   }

   if($( "#pass" ).val()!=$( "#pass2" ).val() ){
    alert('No coinciden las contraseñas');
    $("#pass2").focus();
    return false;
   }
   $(this).closest("form").submit();
  })
})
</script>
  </body>
</html>
