var tabla;

//Funcion que se ejecuta al inicio
function init(){
mostrarForm(false);
listar();

$("#formulario").on("submit",function(e)
{
guardaryeditar(e);
});


$.post("../ajax/venta.php?op=selectcliente",function(r){
    $("#idcliente").html(r);
    $("#idcliente").selectpicker('refresh');
});

}
//Funcion limpiar
function limpiar(){
    $("#idcliente").val("");
    $("#cliente").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#fecha_hora").val("");
    $("#impuesto").val("0");

    $("#total_venta").val("");
    $(".filas").remove();
    $("#total").html("0");

    //Obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day);
    $('#fecha_hora').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
    $("#tipo_comprobante").selectpicker('refresh');
}

//Funcion mostrar formulario
function mostrarForm(flag){
    limpiar();
    if (flag) {
    	$("#listadoRegistros").hide();
    	$("#formularioRegistros").show();
    	//$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarArticulos();

        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles=0;
        $("#btnAgregarArt").show();

        
    }
    else{
    	$("#listadoRegistros").show();
    	$("#formularioRegistros").hide();
      $("#btnagregar").show();
    }
}

//Funcion cancelarform
function cancelarForm(){
	limpiar();
	mostrarForm(false);
}

//Funcion listar
function listar(){
	tabla=$("#tbllistado").dataTable({
        "aProccessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginacion y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdf'],

        "ajax":{
        	url: '../ajax/venta.php?op=listar',
        	type: "get",
        	dataType: "json",
        	error: function(e){
        		console.log(e.responseText);
        	}
        },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginacion
        "order": [[0,"desc"]]//Ordenar (columna,orden) ,


		}).DataTable();
}

function listarArticulos(){
    tabla=$("#tblarticulos").dataTable({
        "aProccessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginacion y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [
        ],
    
        "ajax":{
            url: '../ajax/venta.php?op=listarArticulos',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginacion
        "order": [[0,"desc"]]//Ordenar (columna,orden) ,


        }).DataTable();
}

//Funcion para guardar o editar
function guardaryeditar(e){
    e.preventDefault();
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/venta.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType : false,
        processData : false,

        success: function(datos){
            bootbox.alert(datos);
            mostrarForm(false);
            listar();
        }
    });
    limpiar();
}

//Funcion mostrar
function mostrar(idventa){
    
   $.post("../ajax/venta.php?op=mostrar",
    {idventa : idventa},
    function(data,status)
    {
      data = JSON.parse(data);
      mostrarForm(true);

      $("#idcliente").val(data.idcliente);
      $("#idcliente").selectpicker('refresh');
      $("#tipo_comprobante").val(data.tipo_comprobante);
      $("#tipo_comprobante").selectpicker('refresh');
      $("#serie_comprobante").val(data.serie_comprobante);
      $("#num_comprobante").val(data.num_comprobante);
      $("#fecha_hora").val(data.fecha);
      $("#impuesto").val(data.impuesto);
      $("#idventa").val(data.idventa);
      
      //Ocultar y mostrar los botones
      $("#btnGuardar").hide();
      $("#btnCancelar").show();
      $("#btnAgregarArt").hide();

    });

   $.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){

        $("#detalles").html(r);
        

   });
}

//Funcion para desactivar registros
function anular(idventa){
    bootbox.confirm("¿Está´Seguro de anular la venta?",function(result){
        if (result) {
            $.post("../ajax/venta.php?op=anular",{idventa : idventa},function(e){
            bootbox.alert(e);
            tabla.ajax.reload();
            });
        }
    });
}

//Declaracion de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto = 18;
var cont = 0;
var detalles=0;
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto(){
    var tipo_comprobante = $("#tipo_comprobante option:selected").text();
    if (tipo_comprobante=='Factura') {
        $("#impuesto").val(impuesto);
    }
    else{
        $("impuesto").val(0);
    }
    
}

function agregarDetalle(idarticulo,articulo,precio_venta){
 var cantidad=1;
 var descuento=0;
 //var precio_venta=1;

 if (idarticulo!="") {
    var subtotal = (cantidad*precio_venta)- descuento;
     var fila = '<tr class="filas" id="fila'+cont+'">'+
     '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
     '<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
     '<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
     '<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>'+
     '<td><input type="number" name="descuento[]" id="descuento[]" value="'+descuento+'"></td>'+
     '<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'<span></td>'+
     '<td><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
     '</tr>';
     cont++;
     detalles++;
     $('#detalles').append(fila);
     modificarSubtotales();
 }
 else{
    alert("Error al ingresar el detalle");
 }

}


function modificarSubtotales(){
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");

    for(var i=0;i<cant.length;i++){
        var inpC=cant[i];
        var inpP=prec[i];
        var inpD=desc[i];
        var inpS=sub[i];
 
        inpS.value = inpC.value * inpP.value - inpD.value;
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();
}

function calcularTotales(){
    var sub = document.getElementsByName("subtotal");
    var total =0.0;

    for (var i = 0; i < sub.length; i++) {
        total += document.getElementsByName("subtotal")[i].value;
    }

    $("#total").html("S/. "+total);
    $("#total_venta").val(total);
    evaluar();
}

function evaluar(){
    if (detalles>0) {
       $("#btnGuardar").show();
    }
    else{
       $("#btnGuardar").hide();
       cont=0;
    }
}

function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
}

init();