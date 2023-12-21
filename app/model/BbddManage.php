<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase para manejar los datos de la BBDD
*/  
require_once 'Furgoneta.php';
require_once 'Todoterreno.php';
require_once 'Turismo.php';
require_once __DIR__ .'/../utilities/httpCode/ClientErrorCod.php';
require_once __DIR__ .'/../utilities/httpCode/SuccessCod.php';
// clase para manejar los datos del archivo json
class BbddManage {
    
    private $rutaArchivoJSON;

    function __construct()
    {
        
            // Defino la ruta al archivo JSON en el constructor del controlador
            $this->rutaArchivoJSON = __DIR__.'/vehiculos.json';
        
    }
    //metodo para obtener la ruta del json donde están los datos
    public function getRutaArchivo() 
    {
        return $this->rutaArchivoJSON;
    }
    // metodo para estraer los datos del archivo json y parsearlos a formato manejable
    public function vehiculosConDatos()
    { 
        if (file_exists($this->rutaArchivoJSON)) {
            $datosArchivo=file_get_contents($this->rutaArchivoJSON);
            $datos = json_decode($datosArchivo);
            $vehiculos = [];
            foreach ($datos as $dato) {
                $prop=(array) $dato;
                if ($prop['clase']=='turismo') {
                    $vehiculos[]= new Turismo($prop);
                } elseif ($prop['clase']=='todoterreno') {
                    $vehiculos[] = new Todoterreno($prop);
                } elseif ($prop['clase']=='furgoneta') {
                   $vehiculos[] = new Furgoneta($prop);
                } 
            }  
            return $vehiculos; 
        } else {
            return ClientErrorCod::notFound(['error' => "no existe el archivo ". $this->rutaArchivoJSON]); 
        }
    }
    // metodo para obtener un vehiculo por su id
    public function getVehiculoId ($id) {
        $vehiculosArray = $this->vehiculosConDatos();
        for ($i = 0; $i <= count($vehiculosArray); $i++) {
            $num = $vehiculosArray[$i]->getPropiedad_id();
            if ($num == $id) {
                return $vehiculosArray[$i];
            } 
        }
    }
    // metodo para contar la cantidad de elementos
    public function getNumeroElementos () {
        return count($this->vehiculosConDatos());
    }

    public function eliminar_elemento ($id) {
        // accedo a todos los elementos
        $vehiculosArray = $this->vehiculosConDatos();
        // los itero hasta encontrar el que busco
        for ($i = 0; $i <= count($vehiculosArray); $i++) {
            $num = $vehiculosArray[$i]->getPropiedad_id();
            // si lo encuentro acabo
            if ($num == $id) {
                unset ($vehiculosArray[$i]);
                return $vehiculosArray;
            } 
        }
        //si no está envío un mensaje
        return SuccessCod::noContent();
    }

    public function convertirJson ($data) {
        // creo un array vacio que contenga todos los registros
        // para luego convertirlo en json
        $arrayParaJSON = [];
        // compruebo que es un array
        if (is_array($data)) {
            //convierto cada objeto en array
            foreach ($data as $objeto) {
                // compruebo que cada elemento del array es un objeto y no un array asociativo
                if (is_object($objeto)) {
                    $arrayParaJSON[] = $objeto->toArray();
                // si no es un objeto lo añado directamente al array geenral
                } else {
                    $arrayParaJSON[] = $objeto;   
                } 
            }
        // si el dato es un único objeto lo convierto a array para poder parsearlo
        } elseif(is_object($data)){
            $arrayParaJSON[] = $data->toArray();
        }
        //print_r($arrayParaJSON);
        $bbddJson=json_encode($arrayParaJSON,JSON_PRETTY_PRINT);
        return $bbddJson;
    }
    // método para enviar los datos parseados a json a la bbdd
    public function enviarJsonBbdd ($data) {
        $archivoJson=$this->rutaArchivoJSON;
        $jsonObtenido= $this->convertirJson($data);
        file_put_contents($archivoJson, $jsonObtenido);
    }
    
}