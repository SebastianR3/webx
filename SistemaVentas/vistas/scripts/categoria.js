var tabla;

//Funcion que se ejecuta al inicio
function init(){
mostrarForm(false);
listar();

$("#formulario").on("submit",function(e)
{
guardaryeditar(e);
})
}
//Funcion limpiar
function limpiar(){
	$("#idcategoria").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
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
        	url: '../ajax/categoria.php?op=listar',
        	type: "get",
        	dataType: "json",
        	error: function(e){
        		console.log(e.responseText);
        	}
        },
        "bDestroy": true,
        "iDisplayLength": 10,//Paginacion
        "order": [[0,"desc"]]//Ordenar (columna,orden) ,


		}).DataTable();
}

//Funcion para guardar o editar
function guardaryeditar(e){
    e.preventDefault();
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/categoria.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType : false,
        processData : false,

        success: function(datos){
            notie.alert({type:1, text : datos, time:2});
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

//Funcion mostrar
function mostrar(idcategoria){
   $.post("../ajax/categoria.php?op=mostrar",
    {idcategoria : idcategoria},
    function(data,status)
    {
      data = JSON.parse(data);
      mostrarForm(true);
      $("#nombre").val(data.nombre);
      $("#descripcion").val(data.descripcion);
      $("#idcategoria").val(data.idcategoria);
    })
}

//Funcion para desactivar registros
function desactivar(idcategoria){
    bootbox.confirm("¿Está´Seguro de desactivar la Categoria?",function(result){
        if (result) {
            $.post("../ajax/categoria.php?op=desactivar",{idcategoria : idcategoria},function(e){
            notie.alert({type:1, text : e, time:2});
            //bootbox.alert(e);
            tabla.ajax.reload();
            });
        }
    });
}

//Funcion para activar registros
function activar(idcategoria){
    bootbox.confirm("¿Está´Seguro de activar la Categoria?",function(result){
        if (result) {
            $.post("../ajax/categoria.php?op=activar",{idcategoria : idcategoria},function(e){
            notie.alert({type:1, text : e, time:2});
            //bootbox.alert(e);
            tabla.ajax.reload();
            });
        }
    });
}

init();