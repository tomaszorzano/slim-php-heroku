<?php
class Producto
{
    public $id;
    public $nombre;
    public $cantidad;
    public $tipo;
    
    public function InsertarProducto()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into productos 
               (nombre,cantidad,tipo)values('$this->nombre','$this->cantidad','$this->tipo')");
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
	public function InsertarProductoParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into productos 
                (nombre,cantidad,tipo)values(:nombre,:cantidad,:tipo)");
		$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
		$consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
    public function BorrarProducto()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE id=:id");
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();
	}
	public function ModificarProducto()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta(
            "UPDATE productos SET cantidad ='$this->cantidad' WHERE id='$this->id'");
		return $consulta->execute();
	}
    public function ModificarProductoParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta
		("UPDATE productos SET cantidad=:cantidad WHERE id=:id");
		
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
		
		return $consulta->execute();
	}
    public function GuardarProducto()
	{
		if ($this->id > 0) {
			$this->ModificarProductoParametros();
		} else {
			$this->InsertarProductoParametros();
		}
	}
	public static function TraerTodoLosProductos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta(
            "SELECT id,nombre as nombre, cantidad as cantidad,tipo as tipo FROM productos");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");
	}

	public static function TraerUnProducto($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id,nombre as nombre, cantidad as cantidad,tipo as tipo FROM productos WHERE id = $id");
		$consulta->execute();
		$empleadoBuscado = $consulta->fetchObject('Producto');
		return $empleadoBuscado;
	}

	public function mostrarDatos()
	{
		return "Metodo mostar:" . $this->nombre . "  " . $this->cantidad . "  " . $this->tipo;
	}



    
}
