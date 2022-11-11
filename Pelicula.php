<?php

class Pelicula 
{

    private $nombre;
    private $id;
    private $año;
    private $nota;

    public function __construct($id,$nombre,$puntuacion,$año)
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->puntuacion=$puntuacion;
        $this->año=$año;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setID($id)
    {
        $this->id=$id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre=$nombre;
    }

    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    public function setPuntuacion($puntuacion)
    {
        $this->puntuacion=$puntuacion;
    }

    public function getAño()
    {
        return $this->año;
    }

    public function setAño($año)
    {
        $this->año=$año;
    }

}
?>