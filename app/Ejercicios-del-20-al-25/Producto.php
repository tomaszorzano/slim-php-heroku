<?php
include_once "archivos.php";


class Producto
{
    public $_nombre;
    public $_tipo;
    public $_stock;
    public $_id;
    public $_precio;
    public $_codigoDeBarras;

    public function __construct($_nombre, $_tipo, $_stock, $_precio, $_codigoDeBarras)
    {
        $this->_nombre = $_nombre;
        $this->_tipo = $_tipo;
        $this->_stock = $_stock;
        $this->_id = rand(1, 10000);
        $this->_precio = $_precio;
        $this->_codigoDeBarras = $_codigoDeBarras;
    }

    function GetNombre()
    {
        return $this->_nombre;
    }
    function GetTipo()
    {
        return $this->_tipo;
    }
    function GetPrecio()
    {
        return $this->_precio;
    }
    function GetStock()
    {
        return $this->_stock;
    }
    function GetCodigo()
    {
        return $this->_codigoDeBarras;
    }
    function GetId()
    {
        return $this->_id;
    }
    function SetNombre($_nombre)
    {
        $this->_nombre = $_nombre;
    }
    function SetTipo($_tipo)
    {
        $this->_tipo = $_tipo;
    }
    function SetPrecio($_precio)
    {
        $this->_precio = $_precio;
    }
    function SetStock($_stock)
    {
        $this->_stock = $_stock;
    }
    function SetCodigo($_codigoDeBarras)
    {
        $this->_codigoDeBarras = $_codigoDeBarras;
    }
    function SetId($_id)
    {
        $this->_id = $_id;
    }


    public function altaProducto($producto, $path)
    {
       $ret = "";
        
            if (Leer_Json($path, $listaProd)) 
            {
                
                foreach ($listaProd as $auxProd) 
                {
                    
                    if ($producto->_id == $auxProd['_id']) 
                    {
                        
                        Producto::AgregarStock($auxProd['_id'], $producto->_stock);
                        
                        $ret = "Actualizado";
                    } else 
                    {
                        
                        Guardar_Json($producto, "productos.json");
                        
                        $ret = "Ingresado";

                    }
                    
                }
            } 
            else 
            {
                echo "aca llega";
                Guardar_Json($producto, "./productos.json");
                $ret = "Primer producto";
            }
        
       
        return $ret;

        
    }

  
   

   public static function AgregarStock($id, $cantidad)
    {


        if (Leer_Json("productos.json", $productos)) {


            for ($i = 0; $i < sizeof($productos); $i++) {

                if ($id == $productos[$i]['_id']) {

                    $stock = $productos[$i]['_stock'] + $cantidad;

                    $productos[$i]['_stock'] = $stock;

                    Reescribir_Json($productos, 'productos.json');
                    return true;
                }
            }
        }
        return false;
    }
}
