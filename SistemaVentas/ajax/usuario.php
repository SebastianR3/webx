<?php 
session_start();
include_once '../modelos/Usuario.php';

$usuario = new Usuario();

$idusuario = isset($_POST["idusuario"])?limpiarCadena($_POST["idusuario"]):"";
$nombre = isset($_POST["nombre"])?limpiarCadena($_POST["nombre"]):"";
$tipo_documento = isset($_POST["tipo_documento"])?limpiarCadena($_POST["tipo_documento"]):"";
$num_documento = isset($_POST["numero"])?limpiarCadena($_POST["numero"]):"";
$direccion = isset($_POST["direccion"])?limpiarCadena($_POST["direccion"]):"";	
$telefono = isset($_POST["telefono"])?limpiarCadena($_POST["telefono"]):"";	
$email = isset($_POST["email"])?limpiarCadena($_POST["email"]):"";
$cargo = isset($_POST["cargo"])?limpiarCadena($_POST["cargo"]):"";
$login = isset($_POST["login"])?limpiarCadena($_POST["login"]):"";
$clave = isset($_POST["clave"])?limpiarCadena($_POST["clave"]):"";	
$imagen = isset($_POST["imagen"])?limpiarCadena($_POST["imagen"]):"";	

switch($_GET["op"]){
	case 'guardaryeditar':

     if (!file_exists($_FILES['imagen']['tmp_name'])  || !is_uploaded_file($_FILES['imagen']['tmp_name'])) 
    {
    	$imagen = $_POST['imagenactual'];
    }
    else{
    	$ext = explode(".",$_FILES["imagen"]["name"]);
    	if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
    		$imagen = round(microtime(true)) . '.' . end($ext);
    		move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/".$imagen);
    	}
    }

    //Hash SHA2556 en la contraseña
    $clavehash = hash("SHA256",$clave);



	 if (empty($idusuario)) {

        
        if (isset($_POST['permiso'])) {
        $rpta = $usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
        echo $rpta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        }
        else{
        $permiso = array();
        $rpta = $usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$permiso);
        echo $rpta ? "Usuario registrado. Sin ningun permiso" : "No se pudieron registrar todos los datos del usuario";
        }

	 }
	 else{

        if (isset($_POST['permiso'])) {
        $rpta = $usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
        echo $rpta ? "Usuario Actualizado" : "Usuario no se pudo actulizar";
        }
        else{
        $permiso = array();
        $rpta = $usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$permiso);
        echo $rpta ? "Usuario Actualizado. Se han quitado todos los permisos del usuario" : "No se pudieron actualizar todos los datos del usuario";
        }
	 }
	break;

	case 'desactivar':
	$rpta = $usuario->desactivar($idusuario);
	echo $rpta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
	break;

	case 'activar':
	$rpta = $usuario->activar($idusuario);
	echo $rpta ? "Usuario activado" : "Usuario no se pudo activar";
	break;

	case 'mostrar':
	$rpta = $usuario->mostrar($idusuario);
	//Codificar el resultado utilizando json
	echo json_encode($rpta);
	break;

	case 'listar':
	$rpta = $usuario->listar();
	//Vamos a declarar un array
	$data = Array();

	while ($reg=$rpta->fetch_object()) {
		$data[]=array(
            "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" ><i class="fa fa-pencil"></i></button>'.
            ' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')" ><i class="fa fa-close"></i></button>':
            '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" ><i class="fa fa-pencil"></i></button>'.
            ' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')" ><i class="fa fa-check"></i></button>'
            ,
            "1"=>$reg->nombre,
            "2"=>$reg->tipo_documento,
            "3"=>$reg->num_documento,
            "4"=>$reg->telefono,
            "5"=>$reg->email,
            "6"=>$reg->login,
            "7"=>'<img src="../files/usuarios/'.$reg->imagen.'" height="50" width="50" >',
            "8"=>($reg->condicion)?'<span class="label bg-green" >Activado</span>':
            '<span class="label bg-red" >Desactivado</span>'
		);
	}

	$results = array(
    "sEcho" =>1, //Informacion para el datatables
    "iTotalRecords" => count($data), //enviamos el total registros al datatable
    "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
    "aaData" => $data);

    echo json_encode($results);
	

	break;

	case 'permisos':
	//Obtenemos todos los permisos de la tabla permisos
	require_once "../modelos/Permiso.php";
	$permiso = new Permiso();
	$rpta = $permiso->listar();

	//Obtenemos los peermisos asignados al usuario
    $id = $_GET['id'];
    $marcados = $usuario->listarmarcados($id);

    //Declaramos el array para almacenar todos los permisos marcados
    $valores  = array();
    
    //Almacenar los permisos asignados al usuario en el array
    while($per = $marcados->fetch_object()){
           array_push($valores,$per->idpermiso);
    }


    //Mostramos la lista de permisos en la vista y si estan o no marcados
    while ($reg = $rpta->fetch_object()) {
    	$sw =in_array($reg->idpermiso, $valores)?'checked':'';
    	echo '<li> <input class="form-check-input" type="checkbox" '.$sw.' name="permiso[]" value="'. $reg->idpermiso .'" > '. $reg->nombre .' </li>';
    }

	break;

    case 'verificar':
$logina=$_POST['logina'];
            $clavea=$_POST['clavea'];

            $clavehash=hash("SHA256",$clavea);

            $resp=$usuario->verificar($logina,$clavehash);

            $fetch=$resp->fetch_object();

      if (isset($fetch)) {
         //DECLARAMOS VARIABLES DE SESION
        $_SESSION['idusuario']=$fetch->idusuario;
        $_SESSION['nombre']=$fetch->nombre;
        $_SESSION['imagen']=$fetch->imagen;
        $_SESSION['login']=$fetch->login;

        //Obtenemos los permisos del usuario
        $marcados = $usuario->listarmarcados($fetch->idusuario);

        //Declaramos el array para almacenar todos los permisos marcados
        $valores = array();

        while ($per = $marcados->fetch_object()) {
            array_push($valores,$per->idpermiso);
        }

        //Determinamos los accesos del usuario
        in_array(1, $valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
        in_array(2, $valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
        in_array(3, $valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
        in_array(4, $valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
        in_array(5, $valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;
        in_array(6, $valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;
        in_array(7, $valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;

      }

      echo json_encode($fetch);
       
       

    break;

    case 'salir':
    //Limpiamos las variables de sesion
    session_unset();
    //Destruimos las sesion
    session_destroy();
    //Redireccionamos al login
    header("Location:../index.php");
    break;
}
 ?>