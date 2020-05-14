<?php 

include_once "../config/Conexion.php";

Class Ingreso{

//Implementamos nuestro constructor
public function __construct(){

}

//IMPLEMENTAMOS UN METODO PARA INSERTAR REGISTROS
public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta){

	$sql = "INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
	        VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
	//return ejecutarConsulta($sql);

	  $idingresonew =  ejecutarConsulta_retornarID($sql);
	  print_r($idingresonew);   
	  $num_elementos = 0;

	  $swl = true;

	  while ($num_elementos < count($idarticulo)) {
           $sql_detalle = "INSERT INTO detalle_ingreso (idingreso,idarticulo,cantidad,precio_compra,precio_venta) VALUES ('$idingresonew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]') ";

           ejecutarConsulta($sql_detalle) or $swl = false;
	       $num_elementos = $num_elementos+1;
	   }   

	     return $swl;
}

//Implementamos un metodo para editar registros
public function anular($idingreso){
$sql = "UPDATE ingreso SET estado = 'Anulado' WHERE idingreso = '$idingreso'";
return ejecutarConsulta($sql);
}


//Implementamos un metodo para mostrar los datos de un registro o modificar
public function mostrar($idingreso){
$sql = "SELECT i.idingreso, DATE(i.fecha_hora) as fecha, i.idproveedor, p.nombre as proveedor, u.idusuario,u.nombre as usuario, i.tipo_comprobante, i.serie_comprobante,i.num_comprobante, i.total_compra, i.impuesto,i.estado
FROM ingreso i 
INNER JOIN persona p 
ON i.idproveedor = p.idpersona 
INNER JOIN usuario u
ON i.idusuario = u.idusuario 
WHERE i.idingreso = '$idingreso'";
return ejecutarConsultaSimpleFila($sql);
}

public function listarDetalle($idingreso){
    $sql = "SELECT di.idingreso, di.idarticulo, a.nombre, di.cantidad, di.precio_compra, di.precio_venta FROM detalle_ingreso di INNER JOIN articulo a ON di.idarticulo=a.idarticulo WHERE di.idingreso = '$idingreso'";
    return ejecutarConsulta($sql);
}

//Implementamos un metodo para listar registros
public function listar(){
$sql = "SELECT i.idingreso, DATE(i.fecha_hora) as fecha, i.idproveedor, p.nombre as proveedor, u.idusuario,u.nombre as usuario, i.tipo_comprobante, i.serie_comprobante,i.num_comprobante, i.total_compra, i.impuesto,i.estado
FROM ingreso i 
INNER JOIN persona p 
ON i.idproveedor = p.idpersona 
INNER JOIN usuario u
ON i.idusuario = u.idusuario
ORDER BY i.idingreso desc";
return ejecutarConsulta($sql);
}

}


?>