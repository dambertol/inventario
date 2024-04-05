<?php

  require 'v2/vistas/temp/encabezado.php';
  include_once "v2/includes/detect_mobile.php";
?>
  <script>
      var estiloAdicional = document.createElement('link');
      estiloAdicional.rel = 'stylesheet';
  if(isMobile){
    estiloAdicional.href = 'v2/src/css/estilos_mobile.css';
  }else{
    estiloAdicional.href = 'v2/src/css/estilos_desc.css';
  }
      document.head.appendChild(estiloAdicional);
  </script>

<form class="form-transaccion">
    <div class="insert-transaccion">
        <?php echo "<label>Seleccionar transaccion:</label>";
              echo "<input id='transaccion' name='transaccion' class='input_transaccion' value='$transaccion'>"; ?>
        <p><button id="accion-buscar" class="accion-buscar" type="submit">Buscar</button></p> 
    </div>
</form>

<form class="form-transaccion">
    <div class="insert-transaccion">
        <?php
          echo "<label>Seleccionar proovedor o punto:</label>";
          echo "<select id='proov' name='proov' class='input_transaccion'>";
          foreach ($proovyuv as $key => $value) echo"<option value=".(int)$key." >".$value."</option>";
          echo "</select>";
          echo "<label>Seleccionar local:</label>";
          echo "<select id='id_local' name='id_local' class='input_transaccion'>";
          foreach ($locales as $key => $value) echo"<option value=".(int)$value['id_local']." >".$value['nombre_local']."</option>";
          echo "</select>";
        ?>
        <p><button id="accion-nuevo" class="accion-buscar" type="submit">Nuevo</button></p> 
    </div>
</form>
<br>

<div id="grilla"></div>

<div class="toast" style="display:none">  
  <div class="toast-content">
    <div class="message">    
      <span class="text text-1">Acta Guardada!</span>
    </div>
  </div> 
  <div class="progress active"></div>
</div>

<script
  src="https://code.jquery.com/jquery-3.7.0.js"
  integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
  crossorigin="anonymous"></script>
  <script>
  const dato={transaccion : $(".input-transaccion").val()};
</script>
<script src="./v2/src/js/script.js?t=<?=date("His")?>"></script>

<script>
<?php if(!empty($_GET['save'])=="ok"){  ?>
    $(document).ready(function(){ 
     $( ".toast" ).show();    
    let timer1, timer2;  
       $( ".toast" ).addClass( "active" );
       $( ".progress" ).addClass( "active" );
        timer1 = setTimeout(() => {
            $( ".toast" ).removeClass("active");
            $( ".toast" ).hide();
          }, 5000);

          timer2 = setTimeout(() => {
           
            $( ".progress" ).removeClass("active");
          }, 5300);
    });
<?php } ?>

function iniciarBusqueda(datos){  
    $('#grilla').html('');
    $('.load-bar').show();
    $('#linea_hr').hide();
    $('.datos-transaccion').hide();      
    $.ajax({
        type: "POST",
        url: mobilee,
        data: datos
    }).done(function (response) {
        $('.datos-transaccion').show();
        $('#grilla').append().html($.parseHTML(response));
        $("#transaccion_sel").val($("#transaccion").val());
        $('.load-bar').hide();
        $('#linea_hr').show();
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown)
    })
    }
    
  $("#accion-buscar").on("click", function (e) { 
    e.preventDefault();
    var datos={id_transaccion:$("#transaccion").val()};
    setTimeout(iniciarBusqueda(datos), 100);  
  })


  $("#accion-nuevo").on("click", function (e) { 
    e.preventDefault();
    var datos={id_local: $("#id_local").val(),id_proov_y_uvent: $("#proov").val()}
    setTimeout(iniciarBusqueda(datos), 100);  
  })
</script>

<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <img alt="" width="70%" id="imgBlob" >
  </div>

</div>
<script type="text/javascript">
  $(document.body).on('click', "#myBtn", function(){  
    $("#imgBlob").attr("src","v2/actas/"+ $(this).attr("data-img"));
    $("#myModal").show();
  });
  $(".close").click(function(){
    $("#myModal").hide();
  })
  $(document).click(function(e){                  
    if (e.target.id == "myModal") {
      $("#myModal").hide();
    }
  });
</script>

</body>
</html>
