<?php
require_once 'Empleado.php';
require_once 'Producto.php';
require_once 'Mesa.php';
require_once 'Pedido.php';
require_once 'IApiUsable.php';

class RestauranteApi extends Empleado implements IApiUsable
{
    public function TraerUnUsuario($request, $response, $args)
    {
        $id = $args['id'];
        $elEmpleado = Empleado::TraerUnEmpleado($id);
        $newResponse = $response->withJson($elEmpleado, 200);
        return $newResponse;
    }
    public function TraerTodosLosUsuarios($request, $response, $args)
    {
        $todosLosEmpleados = Empleado::TraerTodoLosEmpleados();
        $newResponse = $response->withJson($todosLosEmpleados, 200);
        return $newResponse;
    }

    public function CargarUnUsuario($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre = $ArrayDeParametros['nombre'];
        $apellido = $ArrayDeParametros['apellido'];
        $puesto = $ArrayDeParametros['puesto'];
        $mail = $ArrayDeParametros['mail'];
        $clave = password_hash($ArrayDeParametros['clave'], PASSWORD_BCRYPT);

        $miEmpleado = new Empleado();
        $miEmpleado->nombre = $nombre;
        $miEmpleado->apellido = $apellido;
        $miEmpleado->puesto = $puesto;
        $miEmpleado->mail = $mail;
        $miEmpleado->clave = $clave;

        $miEmpleado->InsertarEmpleadoParametros();

        $response->getBody()->write("Se guardo el empleado correctamente");

        return $response;
    }
    public function BorrarUnUsuario($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $id = $ArrayDeParametros['id'];
        $cd = new Empleado();
        $cd->id = $id;
        $cantidadDeBorrados = $cd->BorrarEmpleado();

        $objDelaRespuesta = new stdclass();
        $objDelaRespuesta->cantidad = $cantidadDeBorrados;
        if ($cantidadDeBorrados > 0) {
            $objDelaRespuesta->resultado = "Borro empleado!!!";
        } else {
            $objDelaRespuesta->resultado = "No pudo borrar empleado!!!";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);
        return $newResponse;
    }
    public function ModificarUnUsuario($request, $response, $args)
    {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);    	
        $clave = password_hash($ArrayDeParametros['clave'], PASSWORD_BCRYPT);

        $miEmpleado = new Empleado();
        $miEmpleado->id = $ArrayDeParametros['id'];
        $miEmpleado->puesto = $ArrayDeParametros['puesto'];
        $miEmpleado->clave = $clave;


        $resultado = $miEmpleado->ModificarEmpleadoParametros();
        $objDelaRespuesta = new stdclass();
        //var_dump($resultado);
        $objDelaRespuesta->resultado = $resultado;
        return $response->withJson($objDelaRespuesta, 200);
    }
    public function Login($request, $response, $args)
    {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);    	


        $mail = $ArrayDeParametros['mail'];
        $clave = $ArrayDeParametros['clave'];

        $resultado = Empleado::LoginEmpleado($mail, $clave);
        $objDelaRespuesta = new stdclass();
        //var_dump($resultado);
        $objDelaRespuesta->resultado = $resultado;
        return $response->withJson($objDelaRespuesta, 200);
    }
    public function TraerUnProducto($request, $response, $args)
    {
        $id = $args['id'];
        $elEmpleado = Empleado::TraerUnEmpleado($id);
        $newResponse = $response->withJson($elEmpleado, 200);
        return $newResponse;
    }
    public function TraerTodosLosProductos($request, $response, $args)
    {
        $todosLosProductos = Producto::TraerTodoLosProductos();
        $newResponse = $response->withJson($todosLosProductos, 200);
        return $newResponse;
    }
    public function CargarUnProducto($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre = $ArrayDeParametros['nombre'];
        $cantidad = $ArrayDeParametros['cantidad'];
        $tipo = $ArrayDeParametros['tipo'];



        $miProducto = new Producto();
        $miProducto->nombre = $nombre;
        $miProducto->cantidad = $cantidad;
        $miProducto->tipo = $tipo;


        $miProducto->InsertarProductoParametros();

        $response->getBody()->write("Se guardo el producto correctamente");

        return $response;
    }
    public function BorrarUnProducto($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $id = $ArrayDeParametros['id'];
        $producto = new Producto();
        $producto->id = $id;
        $cantidadDeBorrados = $producto->BorrarProducto();

        $objDelaRespuesta = new stdclass();
        $objDelaRespuesta->cantidad = $cantidadDeBorrados;
        if ($cantidadDeBorrados > 0) {
            $objDelaRespuesta->resultado = "Borro Producto!!!";
        } else {
            $objDelaRespuesta->resultado = "No pudo borrar producto!!!";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);
        return $newResponse;
    }
    public function ModificarUnProducto($request, $response, $args)
    {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);    	

        $miProducto = new Producto();
        $miProducto->id = $ArrayDeParametros['id'];
        $miProducto->cantidad = $ArrayDeParametros['cantidad'];

        $resultado = $miProducto->ModificarProductoParametros();
        $objDelaRespuesta = new stdclass();
        //var_dump($resultado);
        $objDelaRespuesta->resultado = $resultado;
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function TraerUnaMesa($request, $response, $args)
    {
        $id = $args['id'];
        $laMesa = Mesa::TraerUnaMesa($id);
        $newResponse = $response->withJson($laMesa, 200);
        return $newResponse;
    }
    public function TraerTodasLasMesas($request, $response, $args)
    {
        $todaslasMesas = Mesa::TraerTodoLasMesas();
        $newResponse = $response->withJson($todaslasMesas, 200);
        return $newResponse;
    }
    public function CargarUnaMesa($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $estado = $ArrayDeParametros['estado'];
        $importe = $ArrayDeParametros['importe'];
        $id_cliente = $ArrayDeParametros['cliente'];
        $comentario = $ArrayDeParametros['comentario'];



        $miMesa = new Mesa();
        $miMesa->estado = $estado;
        $miMesa->importe = $importe;
        $miMesa->id_cliente = $id_cliente;
        $miMesa->comentario = $comentario;


        $miMesa->InsertarMesaParametros();

        $response->getBody()->write("Se guardo la mesa correctamente");

        return $response;
    }
    public function BorrarUnaMesa($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $id = $ArrayDeParametros['id'];
        $mesa = new Mesa();
        $mesa->id = $id;
        $cantidadDeBorrados = $mesa->BorrarMesa();

        $objDelaRespuesta = new stdclass();
        $objDelaRespuesta->cantidad = $cantidadDeBorrados;
        if ($cantidadDeBorrados > 0) {
            $objDelaRespuesta->resultado = "Borro Mesa!!!";
        } else {
            $objDelaRespuesta->resultado = "No pudo borrar mesa!!!";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);
        return $newResponse;
    }
    public function ModificarUnaMesa($request, $response, $args)
    {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);    	

        $miMesa = new Mesa();
        $miMesa->id = $ArrayDeParametros['id'];
        $miMesa->estado = $ArrayDeParametros['estado'];

        $resultado = $miMesa->ModificarMesaParametros();
        $objDelaRespuesta = new stdclass();
        //var_dump($resultado);
        $objDelaRespuesta->resultado = $resultado;
        return $response->withJson($objDelaRespuesta, 200);
    }

    //**********************************************************************
    public function TraerUnPedido($request, $response, $args)
    {
        $id_pedido = $args['id'];
        $elPedido = Pedido::TraerUnPedido($id_pedido);
        $newResponse = $response->withJson($elPedido, 200);
        return $newResponse;
    }
    public function TraerTodosLosPedidos($request, $response, $args)
    {
        $todoslosPedidos = Pedido::TraerTodosLosPedidos();
        $newResponse = $response->withJson($todoslosPedidos, 200);
        return $newResponse;
    }
    public function CargarUnPedido($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $id_pedido = $ArrayDeParametros['id_pedido'];
        $id_producto = $ArrayDeParametros['id_producto'];
        $cantidad_producto = $ArrayDeParametros['cantidad_producto'];
        $id_mesa = $ArrayDeParametros['id_mesa'];
        $id_empleado = $ArrayDeParametros['id_empleado'];
        $estado = $ArrayDeParametros['estado'];
        $tiempo_estimado = $ArrayDeParametros['tiempo_estimado'];



        $miPedido = new Pedido();
        $miPedido->id_pedido = $id_pedido;
        $miPedido->id_producto = $id_producto;
        $miPedido->cantidad_producto = $cantidad_producto;
        $miPedido->id_mesa = $id_mesa;
        $miPedido->id_empleado = $id_empleado;
        $miPedido->estado = $estado;
        $miPedido->tiempo_estimado = $tiempo_estimado;

        $miPedido->InsertarPedidoParametros();

        $response->getBody()->write("Se guardo el pedido correctamente");

        return $response;
    }
    public function BorrarUnpedido($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $id = $ArrayDeParametros['id'];
        $pedido = new Pedido();
        $pedido->id_pedido = $id;
        $cantidadDeBorrados = $pedido->BorrarPedido();

        $objDelaRespuesta = new stdclass();
        $objDelaRespuesta->cantidad = $cantidadDeBorrados;
        if ($cantidadDeBorrados > 0) {
            $objDelaRespuesta->resultado = "Borro Pedido!!!";
        } else {
            $objDelaRespuesta->resultado = "No pudo borrar Pedido!!!";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);
        return $newResponse;
    }
    public function ModificarUnPedido($request, $response, $args)
    {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);    	

        $miPedido = new Pedido();
        $miPedido->id_pedido = $ArrayDeParametros['id'];
        $miPedido->estado = $ArrayDeParametros['estado'];

        $resultado = $miPedido->ModificarPedidoParametros();
        $objDelaRespuesta = new stdclass();
        //var_dump($resultado);
        $objDelaRespuesta->resultado = $resultado;
        return $response->withJson($objDelaRespuesta, 200);
    }
}
