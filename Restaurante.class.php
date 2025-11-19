<?php
require_once "ParqueAtracciones.class.php";
class Restaurante {
    
    private int $id;
    private ParqueAtracciones $parque;         
    private string $nombre;
    private string $tipoCocina;
    private string $descripcion;

    public function __construct(int $id, ParqueAtracciones $parque, string $nombre, string $tipoCocina, string $descripcion) {
    	$this->id = $id;
    	$this->parque = $parque;
    	$this->nombre = $nombre;
    	$this->tipoCocina = $tipoCocina;
    	$this->descripcion = $descripcion;
    
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getParque(): ParqueAtracciones {
        return $this->parque;
    }

    public function setParque(ParqueAtracciones $parque): void {
        $this->parque = $parque;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getTipoCocina(): string {
        return $this->tipoCocina;
    }

    public function setTipoCocina(string $tipoCocina): void {
        $this->tipoCocina = $tipoCocina;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

   
}

?>
?>