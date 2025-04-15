<?php
class Usuario {
    public $id;
    public $nombres;
    public $apellidos;
    public $correo;
    public $contrasena;
    public $posicion;

    public function __construct($id, $nombres, $apellidos, $correo, $contrasena, $posicion) {
        $this->id = $id;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->posicion = $posicion;
    }
}
?>
