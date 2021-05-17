<?php
class usuario
{
	public $id;
    public $nombre;
    public $apellido;
    public $clave;
    public $mail;
    public $fecha_de_registro;
    public $localidad;



  	public function BorrarUsuario()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from usuario 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }

	
	public function ModificarUsuario()
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `usuario` SET clave =:clave WHERE mail= :mail ");
			return $consulta->execute();

	 }
	
  
	 public function InsertarUsuario()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)values(:nombre,:apellido,:clave,:mail,:fecha_de_registro,:localidad)");
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
				

	 }

	  public function ModificarUsuarioParametros()
	 {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta
		("UPDATE `usuario` SET clave =:clave WHERE mail= :mail " );
		
		$consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
		$consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);
		
		return $consulta->execute();
	 }

	 public function InsertarUsuarioParametros()
	 {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)values(:nombre,:apellido,:clave,:mail,:fecha_de_registro,:localidad)");


        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_de_registro', $this->fecha_de_registro, PDO::PARAM_STR);
        $consulta->bindValue(':localidad', $this->localidad, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

	 public function GuardarUsuario()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarUsuarioParametros();
	 		}else {
	 			$this->InsertarUsuarioParametros();
	 		}

	 }


  	public static function TraerTodosLosUsuarios()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,clave as clave,mail as mail, fecha_de_registro as fecha_de_registro, localidad as localidad  from usuario");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");	
	}

	public static function TraerUnUsuario($id) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,clave as calve,mail as mail, fecha_de_registro as fecha_de_registro, localidad as localidad  from usuario where id = $id");
        $consulta->execute();
        $usuarioBuscado = $consulta->fetchObject('Usuario');
        return $usuarioBuscado;				

			
	}

	
	public function mostrarDatos()
	{
		return "Id: " . $this->id . "  " .
		"Nombre: " . $this->nombre . "  " .
		"Apellido: " . $this->apellido . " " .
		"Clave: " . $this->clave . " " .
		"Mail: " . $this->mail . " " .
		"Fecha de registro:" . $this->fecha_de_registro . " " .
		"Localidad:" . $this->localidad;
	}

}