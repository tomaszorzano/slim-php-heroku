<?php
include_once "Producto.php";
include_once "AccesoDatos.php";

$nombre = $_POST["nombre"];
$tipo = $_POST["tipo"];
$stock = $_POST["stock"];
$precio = $_POST["precio"];
$codigoDeBarras = $_POST["codigo"];
$id = $_POST["id"];

if ((isset($nombre) == true) &&
    (isset($tipo) == true) &&
    (isset($stock) == true) &&
    (isset($precio) == true) &&
    (isset($codigoDeBarras) == true) &&
    (isset($id) == true)
) 
{
    $fecha = date("Y-m-d");
    
    $producto = new Producto();
    $producto->nombre=$nombre;
    $producto->tipo= $tipo;
    $producto->stock= $stock;
    $producto->precio=$precio;   
    $producto->codigoDeBarras=$codigoDeBarras;
    $producto->fecha_de_creacion= $fecha;
    $producto->fecha_de_modificacion= $fecha;

    if (Producto::Comparar($codigoDeBarras)) 
    {
        $producto->ModificarProductoParametros($producto);
        echo "Producto Modificado";
    }else
    {
        echo "Producto Modificado";
    }
    
    

    
   
}







?>