function scrollTo(elemento){
    $('html, body').animate({
                    scrollTop: $(elemento).offset().top
                }, 800);
}

function calcularSaldo() {
    console.log('dale');
    let in1=parseFloat($('#saldo_ant').val());
    let in2=parseFloat($('#importeT').val());
    let in3=parseFloat($('#pagos').val());
    suma=in1+in2-in3;
    console.log(suma);

    $('#diferencia').val(suma);
}

function calcularTot() {
    var suma = 0;
    $('.col4').each(function() {
      var valor = parseFloat($(this).val());
      if(valor){  suma += valor }       
    });
    $('#resultados_col4').text(suma);
    $('#importeT').val(suma);
    calcularSaldo();
}

function calcularSuma(n) {
    let fila=n.dataset.fila;
    let in1=parseFloat($('.col1.fila'+fila).val());
    let in2=parseFloat($('.col2.fila'+fila).val());
    let in3=parseFloat($('.col3.fila'+fila).val());
    suma=(in1-in2)*in3;
    $('.col4.fila'+fila).val(suma);
    calcularTot();
}

$(document).on('blur', '.input-carga', function(event) {
    var n = event.target;
    calcularSuma(n);    
});
$(document).on('blur', '#pagos', calcularSaldo);

/* para que seleccione todo*/
$(document).on('click', "input[type='number']", function() {
   $(this).select();
});


