var tabla;

//Funcion que se ejecuta al inicio
function init(){
mostrarForm(false);
listar();

}
//Funcion limpiar


//Funcion mostrar formulario
function mostrarForm(flag){
    //limpiar();
    if (flag) {
    	$("#listadoRegistros").hide();
    	$("#formularioRegistros").show();
    	$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
    }
    else{
    	$("#listadoRegistros").show();
    	$("#formularioRegistros").hide();
        $("#btnagregar").hide();
    }
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
        	url: '../ajax/permiso.php?op=listar',
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

init();