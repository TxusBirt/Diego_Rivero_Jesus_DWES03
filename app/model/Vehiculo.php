<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase Vehiculo padre de las demás
*/  
abstract class Vehiculo {
    protected $marca;
    protected $modelo;
    protected $kilometros;
    protected $year;
    protected $clase;
    protected $disponible;
    protected $prestado;
    protected $fecha_inicio;
    protected $fecha_fin;
    protected $usuario_id;
    protected $revision;
    protected $id;
    // las propiedades se establecen a partir de un array asociativo
    public function __construct($datos)
    {
        $this->marca = $datos['marca'];
        $this->modelo = $datos['modelo'];
        $this->kilometros = $datos['kilometros'];
        $this->year = $datos['year'];
        $this->clase = $datos['clase'];
        $this->disponible = $datos['disponible'];
        $this->prestado = $datos['prestado'];
        $this->fecha_inicio = $datos['fecha_inicio'];
        $this->fecha_fin = $datos['fecha_fin'];
        $this->usuario_id = $datos['usuario_id'];
        $this->revision = $datos['revision'];
        $this->id = $datos['id'];
    }
    // metodos que deben tener todas las clases hijas
    // metodo para convertir objetos en arrays
    abstract public function toArray(): array;
    // metodo para establecer valores en las propiedades susceptibles de variación
    abstract public function setPropiedades($datos);
    // metodo para modificar o establecer el id
    abstract public function setPropiedad_id($num);
    // metodo para saber el id
    abstract public function getPropiedad_id();
}

?>
