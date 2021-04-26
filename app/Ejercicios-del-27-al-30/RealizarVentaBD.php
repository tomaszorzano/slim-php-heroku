<?php
include_once "AccesoDatos.php";
include_once "Usuario.php";
include_once "Producto.php";
include_once "Venta.php";

$codigo=$_POST["codigo"];
$idUsuario=$_POST["id"];
$cantidad=$_POST["cantidad"];


if (isset($codigo) && isset($idUsuario) && isset($cantidad)) 
{
    if (Producto::hayStock($codigo,$cantidad) && Usuario::Comparar($idUsuario)) 
    {
        $venta= new Venta();
        $venta->id_producto=$codigo;
        $venta->id_usuario=$idUsuario;
        $venta->cantidad=$cantidad;
        $venta->fecha_de_venta=date("Y-m-d");

        $venta->InsertarVenta();
        Producto::QuitarStock($codigo,$cantidad);
        echo "Venta realizada";
    }else
    {
        echo "No existe producto o no hay stock";
    }
}








?>