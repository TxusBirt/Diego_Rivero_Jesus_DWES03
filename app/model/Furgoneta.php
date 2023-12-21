<?php
require_once 'Vehiculo.php';
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase Furgoneta que hereda de Vehiculo
*/  
class Furgoneta extends Vehiculo {
    // propiedad unica de esta clase
    protected $capacidad;

    public function __construct($datos)
    {
        parent::__construct($datos);
        $this->capacidad = $datos['capacidad'];
    }
    public function toArray(): array {
        return [
            'marca' => $this->marca,
            'modelo'=>$this->modelo,
            'kilometros'=>$this->kilometros,
            'year'=>$this->year,
            'clase'=>$this->clase,
            'disponible'=>$this->disponible,
            'prestado'=>$this->prestado,
            'fecha_inicio'=>$this->fecha_inicio,
            'fecha_fin'=>$this->fecha_fin,
            'usuario_id'=>$this->usuario_id,
            'revision'=>$this->revision,
            'id'=>$this->id,
            'capacidad'=>$this->capacidad
        ];
    }
    public function setPropiedades($datos)
    {
        if (isset($datos['kilometros'])) {
            $this->kilometros = $datos['kilometros'];
        }
        if (isset($datos['disponible']) && $datos['disponible']=='si') {
            $this->disponible = $datos['disponible'];
        //si no está disponible no tienen valor los atributos relacionados
        } elseif (isset($datos['disponible']) && $datos['disponible']=='no') {
            $this->prestado = 'no';
            $this->fecha_inicio = '';
            $this->fecha_fin = '';
            $this->usuario_id = '';
            $this->disponible = $datos['disponible'];
        }
        if (isset($datos['prestado']) && $datos['prestado']=='si') {
            $this->prestado = $datos['prestado'];
        //si no está prestado no tienen valor los atributos relacionados
        } elseif (isset($datos['prestado']) && $datos['prestado']=='no') {
            $this->fecha_inicio = '';
            $this->fecha_fin = '';
            $this->usuario_id = '';
            $this->prestado = $datos['prestado'];
        }
        if (isset($datos['fecha_inicio'])) {
            $this->fecha_inicio = $datos['fecha_inicio'];
        }
        if (isset($datos['fecha_fin'])) {
            $this->fecha_fin = $datos['fecha_fin'];
        }
        if (isset($datos['usuario_id'])) {
            $this->usuario_id = $datos['usuario_id'];
        }
        if (isset($datos['revision']) && $datos['revision']=='si') {
            $this->revision = $datos['revision'];
        //si no está revisado no se puede prestar ni está disponible
        } elseif (isset($datos['revision']) && $datos['revision']=='no') {
            $this->revision = $datos['revision'];
            $this->disponible = 'no';
            $this->prestado = 'no';
            $this->fecha_inicio = '';
            $this->fecha_fin = '';
            $this->usuario_id = '';
        }
    }
    // establece un id nuevo
    public function setPropiedad_id($num) {
        $id = $num + 1;
        $this->id = $id;
        return $this->id;
    }

    public function getPropiedad_id() {
        return $this->id;
    }
}
?>

