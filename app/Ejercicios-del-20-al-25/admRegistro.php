<?php
include "Usuario.php";

class admRegistro
{
   public static function subirArchivo()
    {
        $destino = "xampp\htdocs\UtnEjercicios\Ejercicios-del-20-al-25\Usuarios\Fotos" . $_FILES["archivo"]["name"];
        $uploadOk = TRUE;
        $tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);


        if (file_exists($destino)) {
            $uploadOk = FALSE;
            echo "El archivo ya existe. Verifique!!!";
        }
        //VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
        if ($_FILES["archivo"]["size"] > 500000) {
            $uploadOk = FALSE;
            echo "El archivo es demasiado grande. Verifique!!!";
        }
        //OBTIENE EL TAMAÑO DE UNA IMAGEN, SI EL ARCHIVO NO ES UNA
        //IMAGEN, RETORNA FALSE
        $esImagen = getimagesize($_FILES["archivo"]["tmp_name"]);

        if ($esImagen === FALSE) { //NO ES UNA IMAGEN
            $uploadOk = FALSE;
            echo "S&oacute;lo son permitidas IMAGENES.";
        } else { // ES UNA IMAGEN

            //SOLO PERMITO CIERTAS EXTENSIONES
            if ($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif" && $tipoArchivo != "png") {
                $uploadOk = FALSE;
                echo "S&oacute;lo son permitidas imagenes con extensi&oacute;n JPG, JPEG, PNG o GIF.";
            }
        }
        //VERIFICO SI HUBO ALGUN ERROR, CHEQUEANDO $uploadOk
        if ($uploadOk === FALSE) 
        {

            echo "<br/><br/>NO SE PUDO SUBIR EL ARCHIVO.";
        } else 
        {
            //MUEVO EL ARCHIVO DEL TEMPORAL AL DESTINO FINAL
            if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) 
            {

                $p = new Usuario($_POST["clave"], $_POST["mail"],$_POST["nombre"], basename($_FILES["archivo"]["name"]));

                if (!Usuario::GuardarJson($p,"usuarios.json")) 
                {
                    echo "Lamentablemente ocurrio un error y no se pudo escribir en el archivo.";
                    
                } else 
                {
                    echo "El archivo fue escrito correctamente. PRODUCTO agregado CORRECTAMENTE!!!";
                    
                }
            } else 
            {
                echo "Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
                
            }
        }
    }
}
