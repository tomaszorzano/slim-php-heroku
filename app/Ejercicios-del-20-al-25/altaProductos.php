<?php
include_once "Producto.php";
include_once "archivos.php";

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
) {
    $producto = new Producto($nombre, $tipo, $stock, $precio, $codigoDeBarras);
    /*$x=$producto->altaProducto($producto);
    echo $x;*/
    $producto->SetId($id);
    echo $producto->altaProducto($producto, "productos.json");
}
