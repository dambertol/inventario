<?php 
var_dump("vista");
require 'v2/vistas/temp/encabezado.php';
var_dump("vista2");

?>

  <h1>iniciar sesion</h1>
  <span>o <a href="<?php echo DIR; ?>/registro">Registro</a></span>

  <form action="<?php echo DIR ?>/inicio" method="POST">
    <input name="dni_usu" type="number" placeholder="Enter your email">
    <input name="token_usu" type="password" placeholder="Enter your Password">
    <input type="submit" value="Ingresar">
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>