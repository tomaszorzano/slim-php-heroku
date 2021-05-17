<?php
class Empleado
{
	public $id;
	public $nombre;
	public $apellido;
	public $puesto;
	public $mail;
	public $clave;

	public function InsertarEmpleado()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into empleados 
               (nombre,apellido,puesto,mail,clave)values('$this->nombre','$this->apellido','$this->puesto','$this->mail','$this->clave')");
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
	public function InsertarEmpleadoParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into empleados 
                (nombre,apellido,puesto,mail,clave)values(:nombre,:apellido,:puesto,:mail,:clave)");
		$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':puesto', $this->puesto, PDO::PARAM_STR);
		$consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

	public function BorrarEmpleado()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("
				delete 
				from empleados				
				WHERE id=:id");
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();
	}
	public function ModificarEmpleado()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("
				update empleados 
				set puesto ='$this->puesto',
				    clave='$this->clave',
				WHERE id='$this->id'");
		return $consulta->execute();
	}
	
	public function ModificarEmpleadoParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta
		("UPDATE empleados SET puesto=:puesto, clave=:clave WHERE id=:id");
		
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->bindValue(':puesto', $this->puesto, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
		return $consulta->execute();
	}
	public function GuardarEmpleado()
	{
		if ($this->id > 0) {
			$this->ModificarEmpleadoParametros();
		} else {
			$this->InsertarEmpleadoParametros();
		}
	}
	public static function TraerTodoLosEmpleados()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,puesto as puesto,mail as mail, clave as clave from empleados");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");
	}

	public static function TraerUnEmpleado($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, nombre as nombre, apellido as apellido,puesto as puesto,mail as mail, clave as clave from empleados where id = $id");
		$consulta->execute();
		$empleadoBuscado = $consulta->fetchObject('Empleado');
		return $empleadoBuscado;
	}

	public function mostrarDatos()
	{
		return "Metodo mostar:" . $this->nombre . "  " . $this->apellido . "  " . $this->puesto;
	}

	public static function LoginEmpleado($mail, $clave)
	{
		$ret = false;
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, mail, clave from empleados where mail = '$mail'");
		$consulta->execute();
		$empleadoBuscado = $consulta->fetch(PDO::FETCH_ASSOC);

		if (count($empleadoBuscado) > 0 && password_verify($clave, $empleadoBuscado['clave'])) 
		{
			
			$ret = true;
		} else

		return $ret;
	}
}
