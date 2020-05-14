var tabla;

//Funcion que se ejecuta al inicio
function init(){
mostrarForm(false);
listar();

$("#formulario").on("submit",function(e)
{
guardaryeditar(e);
})

//Cargamos los items al select categoria

$.post("../ajax/articulo.php?op=selectCategoria",function(r){
     $("#idcategoria").html(r);
     $("#idcategoria").selectpicker('refresh');
});

$("#imagemuestra").hide();
}
//Funcion limpiar
function limpiar(){
    $("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
    $("#stock").val("");
    $("#imagemuestra").attr("src","");
    $("#imagenactual").val("");
    $("#print").hide();
    $("#idarticulo").val("");
}

//Funcion mostrar formulario
function mostrarForm(flag){
    limpiar();
    if (flag) {
    	$("#listadoRegistros").hide();
    	$("#formularioRegistros").show();
    	$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        
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
        	url: '../ajax/articulo.php?op=listar',
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
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType : false,
        processData : false,

        success: function(datos){
            bootbox.alert(datos);
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

//Funcion mostrar
function mostrar(idarticulo){
   $.post("../ajax/articulo.php?op=mostrar",
    {idarticulo : idarticulo},
    function(data,status)
    {
      data = JSON.parse(data);
      mostrarForm(true);
      $("#idcategoria").val(data.idcategoria);
      $('#idcategoria').selectpicker('refresh');
      $("#codigo").val(data.codigo);
      $("#nombre").val(data.nombre);
      $("#stock").val(data.stock);
      $("#descripcion").val(data.descripcion);
      $("#imagemuestra").show();
      $("#imagemuestra").attr("src","../files/articulos/"+data.imagen);
      $("#imagenactual").val(data.imagen);
      $("#idarticulo").val(data.idarticulo);
      generarbarcode();
    })
}

//Funcion para desactivar registros
function desactivar(idarticulo){
    bootbox.confirm("¿Está´Seguro de desactivar el Articulo?",function(result){
        if (result) {
            $.post("../ajax/articulo.php?op=desactivar",{idarticulo : idarticulo},function(e){
            bootbox.alert(e);
            tabla.ajax.reload();
            });
        }
    });
}

//Funcion para activar registros
function activar(idarticulo){
    bootbox.confirm("¿Está´Seguro de activar el Articulo?",function(result){
        if (result) {
            $.post("../ajax/articulo.php?op=activar",{idarticulo : idarticulo},function(e){
            bootbox.alert(e);
            tabla.ajax.reload();
            });
        }
    });
}

function generarbarcode(){
    codigo = $("#codigo").val();
    JsBarcode("#barcode",codigo);
    $("#print").show();

}

function imprimir(){
    $("#print").printArea();
}

init();