<?php

class Mesa
{

    public $id;
    public $estado;
    public $importe;
    public $id_cliente;
    public $comentario;

    public function InsertarMesa()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into mesa 
               (estado,importe,id_cliente,comentario)values('$this->estado','$this->importe','$this->id_cliente','$this->comentario')");
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
	public function InsertarMesaParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta(
                "INSERT into mesa (estado,importe,id_cliente,comentario)
                 values(:estado,:importe,:id_cliente,:comentario)");
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
		$consulta->bindValue(':importe', $this->importe, PDO::PARAM_STR);
		$consulta->bindValue(':id_cliente', $this->id_cliente, PDO::PARAM_INT);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
    public function BorrarMesa()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM mesa WHERE id=:id");
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();
	}
	public function ModificarMesa()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta(
            "UPDATE mesa SET estado ='$this->estado' WHERE id='$this->id'");
		return $consulta->execute();
	}
    public function ModificarMesaParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta
		("UPDATE mesa SET estado=:estado WHERE id=:id");
		
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
		
		return $consulta->execute();
	}
    public function GuardarMesa()
	{
		if ($this->id > 0) {
			$this->ModificarMesaParametros();
		} else {
			$this->InsertarMesaParametros();
		}
	}
	public static function TraerTodoLasMesas()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta(
            "SELECT id,estado as estado, importe as importe, id_cliente as id_cliente, comentario as comentario FROM mesa");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");
	}

	public static function TraerUnaMesa($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id,estado as estado, importe as importe, id_cliente as id_cliente, comentario as comentario FROM mesa WHERE id = $id");
		$consulta->execute();
		$empleadoBuscado = $consulta->fetchObject('Mesa');
		return $empleadoBuscado;
	}

	public function mostrarDatos()
	{
		return "Metodo mostar:" . $this->id . "  " . $this->estado . "  ";
	}








}
?>
