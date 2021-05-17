<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/RestauranteApi.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

/*$app->group('/Login', function () {
    $this->post('/', \EmpleadoApi::class . ':Login');});*/
/* FUNCION MIDDELWARE*/
$VerificadorDeCredenciales = function ($request, $response, $next) {

    if($request->isGet())
    {
       $response->getBody()->write('<p>NO necesita credenciales para los get</p>');
       $response = $next($request, $response);
    }
    else
    {
      $response->getBody()->write('<p>verifico credenciales</p>');
      $ArrayDeParametros = $request->getParsedBody();
      $nombre=$ArrayDeParametros['nombre'];
      $puesto=$ArrayDeParametros['puesto'];
      if($puesto=="socio")
      {
        $response->getBody()->write("<h3>Bienvenido $nombre </h3>");
        $response = $next($request, $response);
      }
      else
      {
        $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
      }  
    }  
    $response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
    return $response;  
  };



$app->group('/Empleado', function () {

    $this->get('/', \RestauranteApi::class . ':traerTodosLosUsuarios');

    $this->get('/{id}', \RestauranteApi::class . ':traerUnUsuario');

    $this->post('/', \RestauranteApi::class . ':CargarUnUsuario');

    $this->delete('/', \RestauranteApi::class . ':BorrarUnUsuario');

    $this->put('/', \RestauranteApi::class . ':ModificarUnUsuario');
})->add($VerificadorDeCredenciales);
$app->group('/Producto', function () {

    $this->get('/', \RestauranteApi::class . ':traerTodosLosProductos');

    $this->get('/{id}', \RestauranteApi::class . ':traerUnProducto');

    $this->post('/', \RestauranteApi::class . ':CargarUnProducto');

    $this->delete('/', \RestauranteApi::class . ':BorrarUnProducto');

    $this->put('/', \RestauranteApi::class . ':ModificarUnProducto');
})->add($VerificadorDeCredenciales);
$app->group('/Mesa', function () {

    $this->get('/', \RestauranteApi::class . ':traerTodasLasMesas');

    $this->get('/{id}', \RestauranteApi::class . ':traerUnaMesa');

    $this->post('/', \RestauranteApi::class . ':CargarUnaMesa');

    $this->delete('/', \RestauranteApi::class . ':BorrarUnaMesa');

    $this->put('/', \RestauranteApi::class . ':ModificarUnaMesa');
})->add($VerificadorDeCredenciales);

$app->group('/Pedido', function () {

  $this->get('/', \RestauranteApi::class . ':traerTodosLosPedidos');

  $this->get('/{id}', \RestauranteApi::class . ':traerUnPedido');

  $this->post('/', \RestauranteApi::class . ':CargarUnPedido');

  $this->delete('/', \RestauranteApi::class . ':BorrarUnPedido');

  $this->put('/', \RestauranteApi::class . ':ModificarUnPedido');
});

$app->run();


