<?php
class Organizador{
    private int $id;
    private string $dni;
    private string $nombre;
    private string $contacto;
    public function __construct($id, string $dni, string $nombre, string $contacto){$this->$id;$this->dni = $dni;$this->nombre = $nombre;$this->contacto = $contacto;}
	public function getId(): int {return $this->id;}

	public function getDni(): string {return $this->dni;}

	public function getNombre(): string {return $this->nombre;}

	public function getContacto(): string {return $this->contacto;}

	public function setId(int $id): void {$this->id = $id;}

	public function setDni(string $dni): void {$this->dni = $dni;}

	public function setNombre(string $nombre): void {$this->nombre = $nombre;}

	public function setContacto(string $contacto): void {$this->contacto = $contacto;}

	
}
?>