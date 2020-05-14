var tabla;

//Funcion que se ejecuta al inicio
function init(){
mostrarForm(false);
listar();

$("#formulario").on("submit",function(e)
{
guardaryeditar(e);
})

$.post("../ajax/usuario.php?op=permisos&id=",function(r){
    $("#permiso").html(r);
});




$("#imagemuestra").hide();
}
//Funcion limpiar
function limpiar(){
	$("#nombre").val("");
	$("#numero").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#imagemuestra").attr("src","");
    $("#imagenactual").val("");
    $("#imagen").val("");
    $("#idusuario").val("");
    $('input[type=checkbox]').attr('checked', false);
    $("#tipo_documento").val("");
    $("#tipo_documento").selectpicker('refresh');
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
        	url: '../ajax/usuario.php?op=listar',
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
        url: "../ajax/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType : false,
        processData : false,

        success: function(datos){
            bootbox.alert(datos);
            //notie.alert({type:1, text : datos, time:2});
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

//Funcion mostrar
function mostrar(idusuario){
   $.post("../ajax/usuario.php?op=mostrar",
    {idusuario : idusuario},
    function(data,status)
    {
      data = JSON.parse(data);
      mostrarForm(true);
      $("#nombre").val(data.nombre);
      $("#tipo_documento").val(data.tipo_documento);
      $("#tipo_documento").selectpicker('refresh');
      $("#numero").val(data.num_documento);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#email").val(data.email);
      $("#cargo").val(data.cargo);
      $("#login").val(data.login);
      $("#clave").val(data.clave);
      $("#imagemuestra").show();
      $("#imagemuestra").attr("src","../files/usuarios/"+data.imagen);
      $("#imagenactual").val(data.imagen);
      $("#idusuario").val(data.idusuario);
    });

   $.post("../ajax/usuario.php?op=permisos&id=" + idusuario,function(r){
    $("#permiso").html(r);
});
}

//Funcion para desactivar registros
function desactivar(idusuario){
    bootbox.confirm("¿Está Seguro de desactivar el Usuario?",function(result){
        if (result) {
            $.post("../ajax/usuario.php?op=desactivar",{idusuario : idusuario},function(e){
            notie.alert({type:1, text : e, time:2});
            //bootbox.alert(e);
            tabla.ajax.reload();
            });
        }
    });
}

//Funcion para activar registros
function activar(idusuario){
    bootbox.confirm("¿Está´Seguro de activar el Usuario?",function(result){
        if (result) {
            $.post("../ajax/usuario.php?op=activar",{idusuario : idusuario},function(e){
            notie.alert({type:1, text : e, time:2});
            //bootbox.alert(e);
            tabla.ajax.reload();
            });
        }
    });
}

init();