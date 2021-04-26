<?php
include_once "AccesoDatos.php";

class Producto
{
    public $nombre;
    public $tipo;
    public $stock;
    public $precio;
    public $codigoDeBarras;
    public $fecha_de_creacion;
    public $fecha_de_modificacion;
    public $id;

    public static function TraerTodoLosProductos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,codigo_de_barra as codigo_de_barra, nombre as nombre, tipo as tipo, stock as stock, precio as precio, fecha_de_creacion as fecha_de_creacion, fecha_de_modificacion as fecha_de_modificacion from producto");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");
    }
    public static function TraerUnProducto($codigo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,codigo_de_barra as codigo_de_barra, nombre as nombre, tipo as tipo, stock as stock, precio as precio, fecha_de_creacion as fecha_de_creacion, fecha_de_modificacion as fecha_de_modificacion from producto where codigo_de_barra = $codigo");
        $consulta->execute();
        $usuarioBuscado = $consulta->fetchObject('Producto');
        return $usuarioBuscado;
    }
    public static  function Comparar($codigoProd)
    {
        $ret = false;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select * from producto WHERE codigo_de_barra='$codigoProd'");
        $consulta->execute();

        if ($consulta->fetchObject('Producto')) {
            $ret = true;
        }

        return $ret;
    }

    public function mostrarDatos()
    {
        return "Id: " . $this->id . "  " .
            "Nombre: " . $this->nombre . "  " .
            "Tipo: " . $this->tipo . " " .
            "Stock: " . $this->stock . " " .
            "Precio: " . $this->precio . " " .
            "Codigo: " . $this->codigo_de_barra . " " .
            "Fecha de creacion:" . $this->fecha_de_creacion . " " .
            "Fecha de modificacion:" . $this->fecha_de_modificacion . " " ;
            
    }

    public function ModificarUsuariosParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `producto` SET stock =:stock WHERE codigo_de_barra= :codigo_de_barra ");

        $consulta->bindValue(':codigo_de_barra', $this->codigo_de_barra, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_STR);

        return $consulta->execute();
    }

    public  function AgregarStock($codigo, $cantidad)
    {
        if ($producto = Producto::traerUnProducto($codigo)) {

            $stock = $producto->stock + $cantidad;

            $producto->stock = $stock;
            $producto->ModificarUsuariosParametros();

            return true;
        }
        return false;
    }
    public static function QuitarStock($codigo, $cantidad)
    {
        if ($producto = Producto::traerUnProducto($codigo)) {

            $stock = $producto->stock - $cantidad;

            $producto->stock = $stock;
            $producto->ModificarUsuariosParametros();

            return true;
        }
        return false;
    }


    public function InsertarProducto()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into producto (codigo_de_barra,nombre,tipo,stock,precio,fecha_de_creacion,fecha_de_modificacion)values(:codigo_de_barra,:nombre,:tipo,:stock,:precio,:fecha_de_creacion,:fecha_de_modificacion)");


        $consulta->bindValue(':codigo_de_barra', $this->codigoDeBarras, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_de_creacion', $this->fecha_de_creacion, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_de_modificacion', $this->fecha_de_modificacion, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function altaProducto($producto)
    {
        $fecha = date("Y-m-d");
        $ret = " ";
        if (Producto::Comparar($producto->codigoDeBarras)) {
            $producto->AgregarStock($producto->codigoDeBarras, $producto->stock);
            $ret = "Actualizado";
            $producto->fecha_de_modificacion = $fecha;
        } else {
            $producto->insertarProducto();
            $ret = "Nuevo";
        }
        return $ret;
    }

    public static function hayStock($codigoBarra, $stock)
    {
        $ret = false;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select * from producto WHERE codigo_de_barra='$codigoBarra'");
        $consulta->execute();
        $usuario = $consulta->fetchObject('Producto');

        if ($usuario->stock >= $stock) {
            $ret = true;
        }

        return $ret;
    }

    public function ModificarProductoParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta(
            "UPDATE `producto` SET nombre =:nombre,
                                   tipo =:tipo,
                                   stock =:stock,
                                   precio=:precion
                                   fecha_de_modificacion =:fecha_de_modificacion
                                                 WHERE codigo_de_barra= :codigo_de_barra "
        );

        $consulta->bindValue(':codigo_de_barra', $this->codigoDeBarras, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_de_modificacion', $this->fecha_de_modificacion, PDO::PARAM_STR);


        return $consulta->execute();
    }
    public static function TraerTodoLosProductosOrdenados($orden)
    {
        switch ($orden) {
            case 1:
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta = $objetoAccesoDato->RetornarConsulta("select id,codigo_de_barra as codigo_de_barra, nombre as nombre, tipo as tipo, stock as stock, precio as precio, fecha_de_creacion as fecha_de_creacion, fecha_de_modificacion as fecha_de_modificacion from producto ORDER BY nombre ASC");
                $consulta->execute();
                return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");
                break;
            case 2:
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta = $objetoAccesoDato->RetornarConsulta("select id,codigo_de_barra as codigo_de_barra, nombre as nombre, tipo as tipo, stock as stock, precio as precio, fecha_de_creacion as fecha_de_creacion, fecha_de_modificacion as fecha_de_modificacion from producto ORDER BY nombre DESC");
                $consulta->execute();
                return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");
                break;

            default:
                # code...
                break;
        }
    }
}
