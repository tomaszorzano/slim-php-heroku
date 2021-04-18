<?php

class Usuario
{
    public $_nombre;
    public $_clave;
    public $_mail;
    public $_id;
    public $_fecha;
    public $_rutaImagen;

    //--CONSTRUCTOR
    function __construct($_clave, $_mail, $_nombre = " ", $_rutaImagen = null)
    {

        $this->_clave = $_clave;
        $this->_mail = $_mail;
        $this->_nombre = $_nombre;
        $this->_id = rand(1, 10000);
        $this->_fecha = date("j/n/Y");
        $this->_rutaImagen = $_rutaImagen;
    }
    //--------------------------------------------------------------------------------//
    //--GETTERS Y SETTERS
    function GetClave()
    {
        return $this->_clave;
    }
    function GetMail()
    {
        return $this->_mail;
    }
    function GetImagen()
    {
        return $this->_rutaImagen;
    }
    function GetId()
    {
        return $this->_id;
    }
    function GetNombre()
    {
        return $this->_nombre;
    }
    function SetClave($clave)
    {
        $this->_clave = $clave;
    }
    function SetMail($mail)
    {
        $this->_mail = $mail;
    }
    function SetImagen($ruta)
    {
        $this->_rutaImagen = $ruta;
    }
    function SetId($id)
    {
        $this->_id = $id;
    }
    function SetNombre($nombre)
    {
        $this->_nombre = $nombre;
    }
    //--------------------------------------------------------------------------------//
    public function ToString()
    {
        return "Nombre: " . $this->_nombre . " " . "Clave: " . $this->_clave . " " . "Mail: " . $this->_mail . "Ruta img " . $this->_rutaImagen;
    }

    public function guardarCSV()
    {
        $archivoAux = fopen("usuarios.csv", 'a');
        fwrite($archivoAux, "$this->_nombre,$this->_mail,$this->_clave" . PHP_EOL);
        fclose($archivoAux);
    }

    public static function leerCSV($archivoCSV)
    {

        $arrayUsuarios = array();
        $archivo = fopen($archivoCSV, 'r');

        while (!(feof($archivo))) {
            $linea = fgets($archivo);
            if (!empty($linea)) {
                array_push($arrayUsuarios, explode(",", $linea));
            }
        }
        fclose($archivo);

        return $arrayUsuarios;
    }


    public static function listar($array)
    {
      

        if (isset($array) && is_array($array)) 
        {
            echo "<ul>";
            foreach ($array as $value) 
            {
                $cadena=
                "Nombre: ".$value['_nombre']." ".
                "Clave:".$value['_clave']." ".
                "Mail:".$value['_mail']." ".
                "Id:".$value['_id']." ".
                "Fecha:".$value['_fecha']." ".
                "RutaImg:".$value['_rutaImagen']." ";

                echo "<li>" . $cadena. "</li>";
            }
            echo "</ul>";
        }
    }

    public static function Login($usuarioaComp, $usuariosCSV)
    {
        $mail = $usuarioaComp->GetMail();
        $clave = $usuarioaComp->GetClave();

        $usuarioReg = Usuario::leerCSV($usuariosCSV);

        $ret = '';

        foreach ($usuarioReg as $usuario) {
            if (($usuario[0] == $mail) && ($usuario[1] == $clave)) {
                $ret = "Verificado";
            } else if (($usuario[0] == $mail) && ($usuario[1] != $clave)) {
                $ret = "Error en los datos";
            } else {
                $ret = "Usuario no registrado";
            }
        }

        return $ret;
    }
    public static function LeerJson($path, &$array)
    {
        $ret = false;
        if (file_exists($path) && filesize($path) > 0) 
        {
            $archivo = fopen($path, 'r');
            $array = fread($archivo, filesize($path));
            fclose($archivo);
            $array = json_decode($array, true);
            $ret = true;
        } else {
            $array = array();
        }
        return $ret;
    }

    public static function GuardarJson($dato, $path)
    {
        $ret = false;

        if (Usuario::LeerJson($path, $array)) 
        {
            array_push($array, $dato);
            $aux = json_encode($array, true);
        } else 
        {
            array_push($array, $dato);
            $aux = json_encode($array, true);
        }

        $archivo = fopen($path, 'w');
        if (fwrite($archivo, $aux)) 
        {
            $ret = true;
        }
        fclose($archivo);

        return $ret;
    }
}
