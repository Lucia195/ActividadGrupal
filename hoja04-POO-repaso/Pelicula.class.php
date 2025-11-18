<?php
require_once "Actor.class.php";
class Pelicula{
    private string $titulo;
    private string $imagen;
    private array $actores;

    public function __construct(string $titulo, string $imagen, array $actores){
        $this->titulo = $titulo;
        $this->imagen = $imagen;
        $this->actores = $actores;
    }
	public function getTitulo(): string {return $this->titulo;}

	public function getImagen(): string {return $this->imagen;}

	public function getActores(): array {return $this->actores;}

	
}
?>