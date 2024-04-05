<?php
  require 'v2/vistas/temp/encabezado.php';
?>

    <h1>Resultados</h1>
    <br>
    <div style="width:90%; max-width:800px; margin:5% auto;margin-top:20px;">
      <button type="submit" onclick="exportTableToExcel('ResultadosMendoza2023')">Descargar Excel</button>
      <table style="margin-top:20px;">
        <thead id="tabla2">
        <tr><th>proov_y_vent</th><th>distrito</th><th>circuito</th><th>materiales </th><th>marcas_y_prod</th><th>volumen</th></tr>
        </thead>
        <tbody id="tabla3">
          <?php
          foreach ($elementos as $elemento) {
            echo "<tr>";
            foreach ($elemento as $key => $value) echo "<td>".strtr((string)$value, $acentos)."</td>";
            echo "</tr>";
          } ?>
        </tbody>
      </table>
    </div>
    <script>
        function exportTableToExcel(filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel;charset=utf-8';
        var tableSelect=document.createElement('TABLE');
        var table2 = document.getElementById("tabla2");
        var tabla2=table2.cloneNode(true);
        var table3 = document.getElementById("tabla3");
        var tabla3=table3.cloneNode(true);

        var espacio=document.createElement('TR');

        tableSelect.appendChild(espacio);
        tableSelect.appendChild(tabla2);
        tableSelect.appendChild(tabla3);

        var tableHTML =encodeURIComponent(tableSelect.outerHTML);
        
        filename = filename?filename+'.xls':'excel_data.xls';
        downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            downloadLink.download = filename;
            downloadLink.click();
        }
    }
    </script>

  </body>
</html>
