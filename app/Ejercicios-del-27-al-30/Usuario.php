<?php
class Usuario
{
    public $id;
    public $nombre;
    public $apellido;
    public $clave;
    public $mail;
    public $fecha_de_registro;
    public $localidad;

    

    public function InsertarUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)values(:nombre,:apellido,:clave,:mail,:fecha_de_registro,:localidad)");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public function InsertarElUsuarioParametros()
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

    public static function TraerTodoLosUsuarios()
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
    public static function Login($mail, $clave)
    {
        $ret = array();
        $ret = " ";
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select * from usuario WHERE mail='$mail'");
        $consulta->execute();



        if ($consulta->fetchObject('Usuario')) 
        {
            $consulta = $objetoAccesoDato->RetornarConsulta("select * from usuario WHERE clave='$clave'");
            $consulta->execute();

            if ($consulta->fetchObject('Usuario')) {
                $ret = "Usuario Verificado";
            } else {
                $ret = "Estan mal los datos";
            }
        } else {
            $ret = "Usuario no registrado";
        }



        return $ret;
    }

    public function ModificarUsuario()
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta
            ("UPDATE `usuario` SET clave =:clave WHERE mail= :mail " );
			return $consulta->execute();

	 }
	 public function ModificarUsuariosParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta
            ("UPDATE `usuario` SET clave =:clave WHERE mail= :mail " );
            
			$consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
			$consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);
			
			return $consulta->execute();
	 }
     public static  function Comparar($id)
     {
         $ret=false;
 
         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
         $consulta = $objetoAccesoDato->RetornarConsulta("select * from usuario WHERE id='$id'");
         $consulta->execute();
 
         if ($consulta->fetchObject('Usuario')) 
         {
             $ret=true;
         }
 
         return $ret;
     }


     public static function TraerTodoLosUsuariosOrdenados($orden)
    {
        switch ($orden) 
        {
            case 1:
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta = $objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,clave as clave,mail as mail, fecha_de_registro as fecha_de_registro, localidad as localidad  from usuario ORDER BY apellido ASC");
                $consulta->execute();
                return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
                break;
            case 2:
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta = $objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,clave as clave,mail as mail, fecha_de_registro as fecha_de_registro, localidad as localidad  from usuario ORDER BY apellido, nombre DESC");
                $consulta->execute();
                return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
                break;
            default:
                
                break;
        }
       
    }
    public static function UsuariosFiltradosXLetra($letra)
    {
         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
         $consulta = $objetoAccesoDato->RetornarConsulta("
         select * from `usuario` WHERE nombre LIKE '%$letra%' or apellido like '%$letra%' ");
         $consulta->execute();
         return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");

    }
}
