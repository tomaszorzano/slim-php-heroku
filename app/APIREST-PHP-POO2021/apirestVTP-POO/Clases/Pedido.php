<?php

class Pedido
{
    public $id_registro;
    public $id_pedido;
    public $id_producto;
    public $cantidad_producto;
    public $id_mesa;
    public $id_empleado;
    public $estado;
    public $tiempo_estimado;

    public function InsertarPedido()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into pedidos 
               (id_pedido,id_producto,cantidad_producto,id_mesa,id_empleado,estado,tiempo_estimado)values('$this->id_pedido','$this->id_producto','$this->cantidad_producto','$this->id_mesa','$this->id_empleado','$this->estado','$this->tiempo_estimado')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public function InsertarPedidoParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into pedidos 
                (id_pedido,id_producto,cantidad_producto,id_mesa,id_empleado,estado,tiempo_estimado)values(:id_pedido,:id_producto,:cantidad_producto,:id_mesa,:id_empleado,:estado,:tiempo_estimado)");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':id_producto', $this->id_producto, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad_producto', $this->cantidad_producto, PDO::PARAM_INT);
        $consulta->bindValue(':id_mesa', $this->id_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':id_empleado', $this->id_empleado, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function BorrarPedido()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				delete 
				from pedidos				
				WHERE id_pedido = :id_pedido");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
    public function ModificarPedido()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				update pedidos 
				set estado ='$this->estado',
				WHERE id_pedido='$this->id_pedido'");
        return $consulta->execute();
    }

    public function ModificarPedidoParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedidos SET estado=:estado WHERE id_pedido=:id_pedido");

        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        return $consulta->execute();
    }
    public function GuardarEmpleado()
    {
        if ($this->id > 0) {
            $this->ModificarPedidoParametros();
        } else {
            $this->InsertarPedidoParametros();
        }
    }

    public static function TraerTodosLosPedidos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id_registro,id_pedido as id_pedido, id_producto as id_producto,cantidad_producto as cantidad_producto,id_mesa as id_mesa, id_empleado as id_empleado,estado as estado,tiempo_estimado as tiempo_estimado from pedidos");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");
    }

    public static function TraerUnPedido($id_pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id_registro,id_pedido as id_pedido, id_producto as id_producto,cantidad_producto as cantidad_producto,id_mesa as id_mesa, id_empleado as id_empleado,estado as estado,tiempo_estimado as tiempo_estimado from pedidos where id_pedido = $id_pedido");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");
    }
}
