<?php 

include_once "../config/Conexion.php";

Class Articulo{

//Implementamos nuestro constructor
public function __construct(){

}

//IMPLEMENTAMOS UN METODO PARA INSERTAR REGISTROS
public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen){
	$sql = "INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion)
	        VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen',1)";
	return ejecutarConsulta($sql);
}

//Implementamos un metodo para editar registros
public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen){
     $sql = "UPDATE articulo SET idcategoria = '$idcategoria', codigo = '$codigo', nombre = '$nombre', stock = '$stock', descripcion = '$descripcion', imagen = '$imagen'  WHERE idarticulo = '$idarticulo'";
     return ejecutarConsulta($sql);
}

//Implementamos un metodo para editar registros
public function desactivar($idarticulo){
$sql = "UPDATE articulo SET condicion = 0 WHERE idarticulo = '$idarticulo'";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para activar categoria
public function activar($idarticulo){
$sql = "UPDATE articulo SET condicion = 1 WHERE idarticulo = '$idarticulo'";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para mostrar los datos de un registro o modificar
public function mostrar($idarticulo){
$sql = "SELECT * FROM articulo WHERE idarticulo = '$idarticulo'";
return ejecutarConsultaSimpleFila($sql);
}

//Implementamos un metodo para listar registros
public function listar(){
$sql = "SELECT a.idarticulo,a.idcategoria,c.nombre as categoria, a.codigo, a.nombre, a.stock, a.descripcion, a.imagen, a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para listar registros activos
public function listarActivos(){
$sql = "SELECT a.idarticulo,a.idcategoria,c.nombre as categoria, a.codigo, a.nombre, a.stock, a.descripcion, a.imagen, a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria WHERE a.condicion = 1";
return ejecutarConsulta($sql);
}

public function listarActivosVenta(){
$sql = "SELECT a.idarticulo,a.idcategoria,c.nombre as categoria, a.codigo, a.nombre, a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta, a.descripcion, a.imagen, a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria WHERE a.condicion = 1";
return ejecutarConsulta($sql);
}

}


?>