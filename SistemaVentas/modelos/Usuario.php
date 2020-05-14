<?php 

include_once "../config/Conexion.php";

Class Usuario{

//Implementamos nuestro constructor
public function __construct(){

}

//IMPLEMENTAMOS UN METODO PARA INSERTAR REGISTROS
public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permiso){
	$sql = "INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion)
	        VALUES ('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen',1)";
	//return ejecutarConsulta($sql);
	  $idusuarionew =  ejecutarConsulta_retornarID($sql);   
	  $num_elementos = 0;

	  $swl = true;

	  while ($num_elementos < count($permiso)) {
           $sql_detalle = "INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES ('$idusuarionew','$permiso[$num_elementos]') ";

           ejecutarConsulta($sql_detalle) or $swl = false;
	       $num_elementos = $num_elementos+1;
	   }   

	     return $swl;
}

//Implementamos un metodo para editar registros
public function editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permiso){
     $sql = "UPDATE usuario SET nombre = '$nombre',tipo_documento = '$tipo_documento',num_documento = '$num_documento',direccion = '$direccion',telefono = '$telefono',email = '$email',cargo = '$cargo',login = '$login',clave = '$clave',imagen = '$imagen' WHERE idusuario = '$idusuario'";
    ejecutarConsulta($sql);

    //Eliminamos todos los permisos asignados para volverlos a registrar
    $sqldel = "DELETE FROM usuario_permiso WHERE idusuario = '$idusuario'";
    ejecutarConsulta($sqldel);

     $num_elementos = 0;

	  $swl = true;

	  while ($num_elementos < count($permiso)) {
           $sql_detalle = "INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES ('$idusuario','$permiso[$num_elementos]') ";

           ejecutarConsulta($sql_detalle) or $swl = false;
	       $num_elementos = $num_elementos+1;
	   }   

	     return $swl;


}

//Implementamos un metodo para editar registros
public function desactivar($idusuario){
$sql = "UPDATE usuario SET condicion = 0 WHERE idusuario = '$idusuario'";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para activar usuario
public function activar($idusuario){
$sql = "UPDATE usuario SET condicion = 1 WHERE idusuario = '$idusuario'";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para mostrar los datos de un registro o modificar
public function mostrar($idusuario){
$sql = "SELECT * FROM usuario WHERE idusuario = '$idusuario'";
return ejecutarConsultaSimpleFila($sql);
}

//Implementamos un metodo para listar registros
public function listar(){
$sql = "SELECT * FROM usuario";
return ejecutarConsulta($sql);
}

//Implementamos un metodo para listar registros
public function listarmarcados($idusuario){
$sql = "SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario' ";
return ejecutarConsulta($sql);
}


//Funcion para verificar el acceso al sistema
public function verificar($login,$clave){
$sql="select idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login from usuario where login='$login' and clave='$clave' and condicion=1";

           return ejecutarConsulta($sql);
}



}


?>