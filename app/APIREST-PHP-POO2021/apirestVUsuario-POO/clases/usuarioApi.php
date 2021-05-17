<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';

class usuarioApi extends usuario implements IApiUsable
{
	public function TraerUno($request, $response, $args)
	{
		$id = $args['id'];
		$elUsuario = usuario::TraerUnUsuario($id);
		$newResponse = $response->withJson($elUsuario, 200);
		return $newResponse;
	}
	public function TraerTodos($request, $response, $args)
	{
		$todosLosUsuarios = usuario::TraerTodosLosUsuarios();
		$newResponse = $response->withJson($todosLosUsuarios, 200);
		return $newResponse;
	}
	public function CargarUno($request, $response, $args)
	{
		$ArrayDeParametros = $request->getParsedBody();
		//var_dump($ArrayDeParametros);

		$nombre=$ArrayDeParametros['nombre'];
		$apellido=$ArrayDeParametros['apellido'];
		$clave=$ArrayDeParametros['clave'];
		$mail=$ArrayDeParametros['mail'];
		$fecha_de_registro=$ArrayDeParametros['fecha'];
		$localidad=$ArrayDeParametros['localidad'];

		$miusuario = new usuario();
		$miusuario->nombre=$nombre;
		$miusuario->apellido=$apellido;
		$miusuario->clave=$clave;
		$miusuario->mail=$mail;
		$miusuario->fecha_de_registro=$fecha_de_registro;
		$miusuario->localidad=$localidad;
		$miusuario->InsertarUsuarioParametros();

		/*$archivos = $request->getUploadedFiles();
		$destino = "./fotos/";
		//var_dump($archivos);
		//var_dump($archivos['foto']);

		$nombreAnterior = $archivos['foto']->getClientFilename();
		$extension = explode(".", $nombreAnterior);
		//var_dump($nombreAnterior);
		$extension = array_reverse($extension);

		$archivos['foto']->moveTo($destino . $nombre . "." . $extension[0]);*/
		$response->getBody()->write("se guardo el usuario");

		return $response;
	}
	public function BorrarUno($request, $response, $args)
	{
		$ArrayDeParametros = $request->getParsedBody();
		$id = $ArrayDeParametros['id'];
		$usuario = new usuario();
		$usuario->id = $id;
		$cantidadDeBorrados = $usuario->BorrarUsuario();

		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->cantidad = $cantidadDeBorrados;
		if ($cantidadDeBorrados > 0) {
			$objDelaRespuesta->resultado = "algo borro!!!";
		} else {
			$objDelaRespuesta->resultado = "no Borro nada!!!";
		}
		$newResponse = $response->withJson($objDelaRespuesta, 200);
		return $newResponse;
	}

	public function ModificarUno($request, $response, $args)
	{
		//$response->getBody()->write("<h1>Modificar  uno</h1>");
		$ArrayDeParametros = $request->getParsedBody();
		//var_dump($ArrayDeParametros);    	
		$miusuario = new usuario();
		
		$miusuario->clave=$ArrayDeParametros['clave'];
		$miusuario->mail=$ArrayDeParametros['mail'];

		$resultado = $miusuario->ModificarUsuarioParametros();
		$objDelaRespuesta = new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado = $resultado;
		return $response->withJson($objDelaRespuesta, 200);
	}
}
