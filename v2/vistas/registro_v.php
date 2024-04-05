<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LUM - Registro</title>
  <link rel="stylesheet" href="v2/src/css/styles.css?t=<?=date("mHis")?>">
  <link rel="stylesheet" href="v2/src/css/box.css?t=<?=date("mHis")?>">
  <link rel="stylesheet" href="v2/src/css/login.css?t=<?=date("mHis")?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <style>
  .new_c_link{margin-top: 20px;}  
  .new_link{
    color: #337ab7;
    text-decoration: none;    
  }
  </style>
</head>
<body>

<div class="limiter">
<div class="container-login100">
  <div class="wrap-login100">


    <form class="login100-form validate-form"  action="<?php echo DIR; ?>/registro" method="POST">

    <div style="text-align:center">  
      <img src="<?php echo DIR; ?>/v2/src/logo-lum.jpg" alt="">
    </div>  
    <div>
        <h1>Registro</h1>        
    </div>


    <div>
      <?php if(!empty($message)): ?>
        <?=$message?>
      <?php endif; ?>
    </div>

     <div class="wrap-input100 validate-input">
        <span class="label-input100">DNI</span>
        <input class="input100" id="dni_usu" name="dni_usu" type="number" placeholder="Ingrese su DNI" min=1000000>
        <span class="focus-input100 input-dni"></span>
    </div>

     <div class="wrap-input100 validate-input">
        <span class="label-input100">Nombre</span>
        <input class="input100" id="nombre_usu" name="nombre_usu" type="text" placeholder="Ingrese su Nombre">
        <span class="focus-input100 input-user"></span>
    </div>

    <div class="wrap-input100 validate-input">
        <span class="label-input100">Contraseña</span>
        <input class="input100" name="token_usu" id="pass" type="password" placeholder="Ingrese su contraseña" >
        <span class="focus-input100 input-lock"></span>
    </div>

    <div class="wrap-input100 validate-input">
        <span class="label-input100">Confirmar Contraseña</span>
        <input class="input100" name="token_usu" id="pass2" type="password" placeholder="Confirmar contraseña" >
        <span class="focus-input100 input-lock"></span>
    </div>

    <div class="container-login100-form-btn">
        <div class="wrap-login100-form-btn">          
           <input class="login100-form-btn" type="button" value="Crear Cuenta" id="envio">
        </div>       
    </div>   

    <div style="margin-top:20px">
      <span>Ya tengo cuenta - <a class="new_link" href="<?php echo DIR; ?>/inicio">Ingreso</a></span>
    </div>  
    </form>
  </div>
</div>
</div>

<script>
$(document).ready(function(){
  $("#envio").click(function(){

   if(!$("#dni_usu" ).val() || $("#dni_usu" ).val()<0){
    alert('Ingrese su DNI' + $( "#dni_usu" ).val());
    $("#dni_usu").focus();
    return false;
   }

   if($( "#dni_usu" ).val().length < 6){
    alert('El dni debe ser mayor a 6 caracteres');
    $("#pass").focus();
    return false;
   }
var regex = /^[a-zA-Z\s]+$/;
   if(!$("#nombre_usu" ).val()){
    alert('Ingrese su Nombre');
    $("#nombre_usu").focus();
    return false;
   } else if (!regex.test($("#nombre_usu" ).val())) {
    alert('Nombre invalido');
    return false; // El texto contiene caracteres especiales
  }
   if(!$( "#pass" ).val()){
    alert('Ingrese una Contraseña');
    $("#pass").focus();
    return false;
   }
   if($( "#pass" ).val().length < 6){
    alert('La contraseña debe ser mayor a 6 caracteres');
    $("#pass").focus();
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

