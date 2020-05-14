<?php 

include_once "../config/Conexion.php";

Class Permiso{

//Implementamos nuestro constructor
public function __construct(){
}

//Implementamos un metodo para listar registros
public function listar(){
$sql = "SELECT * FROM permiso";
return ejecutarConsulta($sql);
}

}
?>