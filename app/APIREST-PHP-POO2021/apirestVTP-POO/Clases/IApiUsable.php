<?php 

interface IApiUsable
{ 
   	public function TraerUnUsuario($request, $response, $args); 
   	public function TraerTodosLosUsuarios($request, $response, $args); 
   	public function CargarUnUsuario($request, $response, $args);
   	public function BorrarUnUsuario($request, $response, $args);
   	public function ModificarUnUsuario($request, $response, $args);

    public function TraerUnProducto($request, $response, $args); 
   	public function TraerTodosLosProductos($request, $response, $args); 
   	public function CargarUnProducto($request, $response, $args);
   	public function BorrarUnProducto($request, $response, $args);
   	public function ModificarUnProducto($request, $response, $args);

	public function TraerUnaMesa($request, $response, $args); 
   	public function TraerTodasLasMesas($request, $response, $args); 
   	public function CargarUnaMesa($request, $response, $args);
   	public function BorrarUnaMesa($request, $response, $args);
   	public function ModificarUnaMesa($request, $response, $args);
	   
    public function TraerUnPedido($request, $response, $args); 
   	public function TraerTodosLosPedidos($request, $response, $args); 
   	public function CargarUnPedido($request, $response, $args);
   	public function BorrarUnPedido($request, $response, $args);
   	public function ModificarUnPedido($request, $response, $args);   

}