<?php 
$extras="<style>/* Estilos para la ventana emergente */
.modal {  display: none;  position: fixed;  z-index: 1;  left: center;  width: 100%;  height: 100%;  overflow: auto;  background-color: rgb(0,0,0);  background-color: rgba(0,0,0,0.4);}
.modal-contenido {  background-color: #fff;  margin: 15% auto;  padding: 10px;  border: 1px solid #888;  width: 90%;  max-width: 550px;  position: relative;  border-radius: 5px;}
.cerrar-modal {  position: absolute;  top: 0;  right: 0;  padding: 10px;  cursor: pointer;}
/* Estilos adicionales según tus necesidades */
</style>";
require 'temp/encabezado.php';
$params = $_GET;
if (isset($params['indice'])) {
    unset($params['indice']);
}
$qry ="&";
if (!empty($params)) $qry .= http_build_query($params);
?>

<div class="container">

      <!--<p class="alert-success">Se ha registrado con exito</p>-->
      <br>
      <?php 
      if($user->permiso=="admin" || $user->permiso=="visualizar"|| $user->permiso=="editor"|| $user->permiso=="dios"){?>
      <form action="<?php echo DIR; ?>/escrutados">
        <select name="dep" id="dep" placeholder="proov_y_vent" class="custom-select padding width20">
          <option></option>
          <?php foreach ($depto as $key2 => $value2) {
            $sel="";
            if(isset($_GET["dep"]))($_GET["dep"]==$value2['id_proov_y_uvent'])? $sel="selected" : $sel="";         
            echo"<option ".$sel." style='padding:10px' value='".$value2['id_proov_y_uvent']."'>".$value2['nombre_proov_y_uvent']."</option>";
        }
        ?>        
          <option value='adm'>**Sin local**</option>
        </select>
        <button class="padding" style="margin-left:10px" type='submit'>buscar</button>
      </form>
        <br>

    <?php } ?>
        <div id="miModal" class="modal" style="" >
          <div class="modal-contenido">
              <span class="cerrar-modal" id="cerrarModal">&times;</span>
              <h2>transacciones</h2>
              <div id="datosDesdeServidor">
                <table id="tablaDatos" style="width:100%;">
                  <!-- Aquí se mostrarán los datos -->
              </table>
            </div>
          </div>
      </div>

    <form action="<?php echo DIR; ?>/escrutados" method="post">
      <table class="table table-hover table-stripped scrolleable tableDesk">
        <thead>
          <tr>
            <th class="col-2">local</th>
            <th class="col-2">proov_y_vent</th>
            <th class="col-1">Circuito</th>
            <th class="col-2">Nombre</th>
            <th class="col-2">Total</th>
            <th class="col-2">Escrutadas</th>
          </tr>
        </thead>
        <tbody>
        <?php if(!empty($dto)){
            foreach ($circuito as $key => $value){
              echo"<tr>";
              foreach ($value as $key2 => $value2) {
                if($key2!='id_local' && $key2!='escrut'){
                  echo "<td>".$value2."</td>";
                }elseif($key2=='escrut'){
                $color=$value2=='0'?0:(float)$value2/(float)$value['escrut'];
                $color=$color==0?'red':($color<1?'yellow':'green');
                echo "<td><button style='background-color:$color; width:40px;border:none; border-radius:3px;' class='mostrarModal' data-local='".$value['id_local']."'>".$value2."</button></td></tr>";
              } } } }?>
        </tbody>
      </table>

      <!--mobile-->
      <table class="table table-hover table-stripped scrolleable tableResponsive">
        <tr>
          <td>
        <?php if(!empty($dto)){
            foreach ($circuito as $key => $value){
              echo"<div>";
              echo "<b>local: </b>" . $value['local'] . "<br>"; 
              echo "<b>proov_y_vent: </b>" . $value['nombre_proov_y_uvent'] . "<br>"; 
              echo "<b>Circuito: </b>" . $value['circuito_esc'] . "<br>"; 
              echo "<b>Nombre: </b>" . $value['nombre_local'] . "<br>"; 
              echo "<b>Escrutadas: </b> " ; 

                if($value['total']==$value['escrut']){
                  $color="green";
                }else if($value['escrut'] > 1){
                  $color="yellow";
                }else{
                  $color="red";
                }
              echo "<button style='background-color:$color; width:40%;border:none; border-radius:3px; padding:10px' class='mostrarModal' data-local='".$value['id_local']."'>".$value['escrut']."</button>";
              echo "<hr>";
               
           echo"</div>";
          } }?>
        </td></tr>
      </table>

      </form>
      <div id="paginator">
        <a href="escrutados?indice=0<?php echo $qry;?>"> Inicio </a>
        <a id="pag_ant" href='escrutados?indice=<?php echo isset($_GET['indice'])?($_GET['indice']-1).$qry:"0".$qry;?>' > <i class="fas fa-chevron-left"></i> Ant.</a>
        <a id="pag_pos" href='escrutados?indice=<?php echo (isset($_GET['indice']) && $_GET['indice']+1<=$cant)?($_GET['indice']+1).$qry:((isset($_GET['indice']))?$_GET['indice']:"1".$qry);?>'>Sig. <i class="fas fa-chevron-right"></i></a>
        <a id="pag_pos" href='escrutados?indice=<?php echo isset($cant)?($cant).$qry:"1".$qry;?>'>Ult. <i class="fas fa-chevron-right"></i></a>
      </div>
      <br><br>

<script>

      // Obtén elementos del DOM
      const mostrarModalBtn = document.querySelectorAll('.mostrarModal'); // Agrega un punto antes de 'mostrarModal' para seleccionar elementos por clase
      const modal = document.getElementById('miModal');
      const cerrarModalSpan = document.getElementById('cerrarModal');
      const datosDesdeServidor = document.getElementById('datosDesdeServidor');
      var tableta;

      // Agrega un evento de clic a los botones para mostrar el modal
      mostrarModalBtn.forEach(element => {
          element.addEventListener('click', (e) => {
              e.preventDefault();
              modal.style.display = 'block';

              tablaDatos.innerHTML = "<div>Cargando</div>";
              // Realiza una solicitud a tu servidor utilizando fetch 
              fetch('detalle_local?local=' + element.getAttribute("data-local"))
                  .then(response => response.json())
                  .then(data => {
                    console.log(data);
                      // Construye la tabla con los datos
                      let tablaHTML = '<thead ><tr><th>local</th><th>transaccion</th><th>imagen</th><th>volumen</th></tr></thead><tbody>';
                      data.forEach(item => {
                        let imm=(item.imagen_acta!="" && item.imagen_acta!=null);
                        let color=(item.pago_tr!="0" && item.pago_tr!=undefined);
                          tablaHTML += `<tr><td style='padding:8px'>${item.local}</td><td><a href="cargar_acta?transaccion=${item.id_transaccion}">${item.id_transaccion}</a></td><td>${imm}</td><td style="background-color:${color?'green':'red'}; color:white; text-align:center;">${color}</td></tr>`;
                      });
                      tablaHTML += '</tbody>';
                      tablaDatos.innerHTML = tablaHTML;
                  })
                  .catch(error => console.error('Error:', error));
          });
      });
      // Agrega un evento de clic al botón de cerrar para ocultar el modal
      cerrarModalSpan.addEventListener('click', () => modal.style.display = 'none');

      // Cierra el modal si el usuario hace clic fuera de él
      window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
      });
    </script>
  </body>
</html>