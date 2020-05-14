<?php 

include_once "../config/Conexion.php";

Class Categoria{

//Implementamos nuestro constructor
public function __construct(){

}

//IMPLEMENTAMOS UN METODO PARA INSERTAR REGISTROS
public function insertar($nombre,$descripcion){
	$insertar = 1 ;
	$sql = "INSERT INTO categoria (nombre,descripcion,condicion)
	        VALUES ('$nombre','$descripcion',$insertar)";
	return ejecutarConsulta($sql);
}

//Implementamos un metodo para editar registros
public function editar($idcategoria,$nombre,$descripcion){
     $sql = "UPDATE categoria SET nombre = '$nombre', descripcion = '$descripcion' WHERE idcategoria = '$idcategoria'";
     return ejecutarConsulta($sql);
}

//Implementamos un metodo para editar registros
public function desactivar($idcategoria){
$sql = "UPDATE categoria SET condicion = 0 WHERE idcategoria = '$idcategoria'";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para activar categoria
public function activar($idcategoria){
$sql = "UPDATE categoria SET condicion = 1 WHERE idcategoria = '$idcategoria'";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para mostrar los datos de un registro o modificar
public function mostrar($idcategoria){
$sql = "SELECT * FROM categoria WHERE idcategoria = '$idcategoria'";
return ejecutarConsultaSimpleFila($sql);
}

//Implementamos un metodo para listar registros
public function listar(){
$sql = "SELECT * FROM categoria";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para listar registros y mostrar en el select
public function select(){
$sql = "SELECT * FROM categoria WHERE condicion = 1";
return ejecutarConsulta($sql);
}



}


?>