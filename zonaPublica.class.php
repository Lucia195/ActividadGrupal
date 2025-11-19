<?php

require_once 'parque.class.php';

class ZonaPublica {
    private int $id;
    private Parque $parque;      
    private string $nombre;
    private string $descripcion;

    public function __construct(int $id, Parque $parque, string $nombre, string $descripcion) {
    	$this->id = $id;
    	$this->parque = $parque;
    	$this->nombre = $nombre;
    	$this->descripcion = $descripcion;
    
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getParque(): Parque {
        return $this->parque;
    }

    public function setParque(Parque $parque): void {
        $this->parque = $parque;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    
}

?>
