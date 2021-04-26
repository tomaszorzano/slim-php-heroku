<?php
include_once "AccesoDatos.php";

class Venta
{
    public $id_Usuario;
    public $id_Producto;
    public $cantidad;
    public $fecha_de_venta;
    public $id;


    public function InsertarVenta()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into venta (id_usuario,id_producto,cantidad,feca_de_venta)values(:id_usuario,:id_producto,:cantidad,:feca_de_venta)");

        $consulta->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':id_producto', $this->id_producto, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':feca_de_venta', $this->fecha_de_venta, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public function mostrarDatos()
    {
        return "Id usuario: " . $this->id_Usuario . "  " .
            "Id producto: " . $this->id_Producto . "  " .
            "Cantidad: " . $this->cantidad . " " .
            "Fecha de venta: " . $this->fecha_de_venta . " " .
            "Id: " . $this->id . " ";
    }

    public static function TraerTodoLasVentas()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,id_usuario as id_usuario, id_Producto as id_Producto, cantidad as cantidad, fecha_de_venta as fecha_de_venta from venta");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");
    }
    public static function TraerTodasLasVentasEntre2Cant($cant1, $cant2)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,id_usuario as id_usuario, id_Producto as id_Producto, cantidad as cantidad, feca_de_venta as fecha_de_venta from venta  WHERE cantidad>='$cant1' && cantidad<='$cant2' ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");
    }
    public static function TraerTodasLasCantEntre2Fechas($fecha1, $fecha2)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select SUM(cantidad) as total from venta  WHERE feca_de_venta>='$fecha1' && feca_de_venta<='$fecha2' ");
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        $consulta->execute();
        $resultado = $consulta->fetch();

        return $resultado["total"];
    }
    public static function TraerlosPrimerosProductos($n)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,id_usuario as id_usuario, id_Producto as id_Producto, cantidad as cantidad, feca_de_venta as fecha_de_venta from venta limit $n ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");
    }
    public static function TraerUsuarioyProducto()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select `producto`.`nombre` as nombreP ,`usuario`.`nombre` as nombreU from `venta` inner join producto on venta.id_producto = producto.id inner join usuario on venta.id_usuario = usuario.id ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function IndicarMonto()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta(
        "select sum((`venta`.`cantidad`)*(`producto`.`precio`)) as monto
         from `venta`
         inner join producto on venta.id_producto=producto.id ");
         $consulta->setFetchMode(PDO::FETCH_ASSOC);
         $consulta->execute();
         $resultado = $consulta->fetch();
 
         return $resultado["monto"];
    }

    public static function CantidadTotaldeUnProdxUsu($idProducto,$idUsuario)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta(
        "select sum(cantidad) as total from `venta` WHERE id_producto=$idProducto && id_usuario=$idUsuario");
         $consulta->setFetchMode(PDO::FETCH_ASSOC);
         $consulta->execute();
         $resultado = $consulta->fetch();
 
         return $resultado["total"];
    }
    public static function ProductosVendidos($localidad)
    {
         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
         $consulta = $objetoAccesoDato->RetornarConsulta("
         select  `id_producto` as producto
         from `venta` 
         inner join usuario on venta.id_usuario=usuario.id WHERE localidad='$localidad' ");
         $consulta->execute();
         return $consulta->fetchAll(PDO::FETCH_ASSOC);

    }
    public static function Ventasentre2Años($a1,$a2)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
        select * from `usuario` where usuario.fecha_de_registro between $a1 AND $a2");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");
    }
    
}
