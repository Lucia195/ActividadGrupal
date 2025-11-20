<?php
class ParqueAtracciones{
    private int $id;
    private string $nombre;
    private string $descripcion;
    private string $imagen;

     public function __construct(int $id, string $nombre, string $descripcion,string $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->imagen=$imagen;
    }

    public function getId(): int {return $this->id;}

	public function getNombre(): string {return $this->nombre;}

	public function setId(int $id): void {$this->id = $id;}

	public function setNombre(string $nombre): void {$this->nombre = $nombre;}



	public function getDescripcion(): string {return $this->descripcion;}

	public function setDescripcion(string $descripcion): void {$this->descripcion = $descripcion;}

	public function getImagen(): string {return $this->imagen;}

	public function setImagen(string $imagen): void {$this->imagen = $imagen;}

	
	
}
?>