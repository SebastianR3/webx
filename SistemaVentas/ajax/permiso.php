<?php 
include_once '../modelos/Permiso.php';

$permiso = new Permiso();


switch($_GET["op"]){
	
	
    case 'listar':
	$rpta = $permiso->listar();
	//Vamos a declarar un array
	$data = Array();

	while ($reg=$rpta->fetch_object()) {
		$data[]=array(
            "0"=>$reg->nombre   
		);
	}

	$results = array(
    "sEcho" =>1, //Informacion para el datatables
    "iTotalRecords" => count($data), //enviamos el total registros al datatable
    "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
    "aaData" => $data);

    echo json_encode($results);
	

	break;
}




 ?>