<?php

include_once "AccesoDatos.php";
include_once "Usuario.php";
include_once "Producto.php";
include_once "Venta.php";

$listado = $_GET['listado'];
$arrayLista = array();

if (isset($listado)) {
    switch ($listado) {
        case 'usuarios':
            $arrayLista = Usuario::TraerTodoLosUsuariosOrdenados(2);
            echo "<ul>";
            foreach ($arrayLista as $usuario) {

                echo "<li>" . $usuario->mostrarDatos() . "</li>";
            }
            echo "<ul>";

            $usuariosFiltrados = Usuario::UsuariosFiltradosXLetra("o");
            echo "<ul>";
            foreach ($usuariosFiltrados as $usuario)
            {
                echo "<li>" . $usuario->mostrarDatos(). "</li>" ;
            }
            echo "<ul>";
            break;
        case 'productos':
            $arrayLista = Producto::TraerTodoLosProductosOrdenados(2);
            echo "<ul>";
            foreach ($arrayLista as $producto) {

                echo "<li>" . $producto->mostrarDatos() . "</li>";
            }
            echo "<ul>";
            break;
        case 'ventas':
            $arrayLista = Venta::TraerTodasLasVentasEntre2Cant(4, 10);
            echo "<ul>";
            foreach ($arrayLista as $venta) {

                echo "<li>" . $venta->mostrarDatos() . "</li>";
            }
            echo "<ul>";
            echo "\n";
            $resultado = Venta::TraerTodasLasCantEntre2Fechas("2021-01-14", "2021-03-20");
            echo "La cantidad total entre esas dos fechas es: " . $resultado;
            echo "\n";
            $arraylist2=Venta::TraerlosPrimerosProductos(3);
            echo "<ul>";
            foreach ($arraylist2 as $venta) 
            {
                echo "<li>" ."Id producto: ". $venta->id_Producto . "</li>";
            }
            echo "<ul>";
            echo "\n";
            $arrayList3= Venta::TraerUsuarioyProducto();
            echo "<ul>";
            foreach ($arrayList3 as $venta) 
            {
                echo "<li>" ."Producto: ". $venta['nombreP'] ." "."Usuario: ". $venta['nombreU']. "</li>";
            }
            echo "<ul>";
            echo "\n";
            $monto=Venta::IndicarMonto();
            echo "El monto de las ventas es: ". $monto;
            echo "\n";
            $totalProd = Venta::CantidadTotaldeUnProdxUsu(1003,104);
            echo "La cantidad total de un producto que compro un usuario es: ". $totalProd;
            echo "\n";

            $productos = Venta::ProductosVendidos("avellaneda");
            echo "<ul>";
            foreach ($productos as $producto)
            {
                echo "<li>" ."Producto: ". $producto['producto']. "</li>" ;
            }
            echo "<ul>";
            echo "\n";
            $ventasEntre2Años = Venta::Ventasentre2Años(2021,2022);
            echo "<ul>";
            foreach ($ventasEntre2Años as $venta)
            {
                echo "<li>" .$venta->mostrarDatos(). "</li>" ;
            }
            echo "<ul>";
            echo "\n";
            
            
            break;
        default:

            break;
    }
} else {
    echo "listado no valido";
}
