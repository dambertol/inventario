<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LUM - Sistema de volumen</title>
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

			<form class="login100-form validate-form" method="post" action="inicio">
				<span class="login100-form-title">
				</span>
				<div>
				<?php if(!empty($message)): ?>
					<p class="alert-danger"> <?= $message ?></p>
					<?php endif; ?>
				</div>
				<div class="wrap-input100 validate-input">
					<span class="label-input100">Usuario</span>
					<input class="input100" type="text" name="username" placeholder="Ingrese su Usuario">
					<span class="focus-input100 input-name"></span>
				</div>
				<div class="wrap-input100 validate-input">
					<span class="label-input100">Contraseña</span>
					<input class="input100" type="password" name="password" placeholder="Ingrese su Contraseña">
					<span class="focus-input100 input-lock"></span>
				</div>

				<div class="container-login100-form-btn">
				<div class="wrap-login100-form-btn">
					<button class="login100-form-btn">
					Ingresar
					</button>
				</div>
			
				<!-- <div class="new_c_link"><a class="new_link" href="/resultados/registro">Registrarse</a></div> -->
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>