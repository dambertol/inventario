<?php require 'temp/encabezado.php';?>

<div class="container">

  <h2>Crear Usuario "carga"</h2>

    <form class=""  action="<?php echo DIR; ?>/crear_usuario" method="POST">

      <div class="wrap-input100 validate-input">
        <span class="label-input100">Usuario</span>
        <input class="input100" name="dni_usu" id="dni_usu" type="text" placeholder="nombre de usuario"  >
        <span class="focus-input100 input-dni"></span>
      </div>

      <div class="wrap-input100 validate-input">
        <span class="label-input100">Nombre</span>
        <input class="input100" name="nombre_usu" id="nombre_usu" type="text" placeholder="nombre" >
        <span class="focus-input100 input-user"></span>
      </div>   

      <div class="wrap-input100 validate-input">
        <span class="label-input100">Contraseña</span>
        <input class="input100" name="token_usu" id="pass" type="password" placeholder="ingrese contraseña" >
        <span class="focus-input100 input-lock"></span>
      </div>    

      <div style="height: 20px"></div>
      <div class="wrap-input100 validate-input">
      <span class="label-input100">Confirme Contraseña</span>
      <input class="input100" name="confirm_password" id="pass2" type="password" placeholder="Confirme contraseña">
      <span class="focus-input100 input-lock"></span>
      </div>


      <div class="container-login100-form-btn">
        <div class="wrap-login100-form-btn">
          <input class="login100-form-btn" type="submit" value="Guardar" id="envio" disabled>
        </div>        
    </div>
     
    </form>

</div>

<script>
var pass=document.getElementById("pass");
var pass2=document.getElementById("pass2");
var subb=document.getElementById("envio");

pass.addEventListener("change",(e)=>{
  if(pass.value.length<6){
    alert('la contraseña debe ser mayor a 6 caracteres');
  }
});

pass2.addEventListener("change",(e)=>{
  if(pass.value==pass2.value && pass.value.length>5){
    subb.removeAttribute("disabled");
  }else{
        alert('no coinciden las contraseñas');
    subb.setAttribute("disabled","");
  }
});

</script>
  </body>
</html>