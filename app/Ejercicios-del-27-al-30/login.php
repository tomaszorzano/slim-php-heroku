<?php
include_once "AccesoDatos.php";
include_once "Usuario.php";


$mail = $_POST['mail'];
$clave = $_POST['clave'];

if (isset($mail) && isset($clave)) {

    echo Usuario::Login($mail, $clave);
}
