var tabla;

//Funcion que se ejecuta al inicio
function init(){
mostrarForm(false);
listar();

$("#formulario").on("submit",function(e)
{
guardaryeditar(e);
});
}
//Funcion limpiar
function limpiar(){
	$("#idpersona").val("");
	$("#nombre").val("");
	$("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#num_documento").val("");
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
        	url: '../ajax/persona.php?op=listarC',
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
        url: "../ajax/persona.php?op=guardaryeditar",
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
function mostrar(idpersona){
   $.post("../ajax/persona.php?op=mostrar",
    {idpersona : idpersona},
    function(data,status)
    {
      data = JSON.parse(data);
      mostrarForm(true);
      $("#nombre").val(data.nombre);
      $("#tipo_documento").val(data.tipo_documento);
      $("#tipo_documento").selectpicker('refresh');
      $("#num_documento").val(data.num_documento);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#email").val(data.email);
      $("#idpersona").val(data.idpersona);
    })
}

//Funcion para desactivar registros
function eliminar(idpersona){
    bootbox.confirm("¿Está´Seguro de eliminar el cliente?",function(result){
        if (result) {
            $.post("../ajax/persona.php?op=eliminar",{idpersona : idpersona},function(e){
            bootbox.alert(e);
            tabla.ajax.reload();
            });
        }
    });
}



init();