<?php
require_once "Conexion.class.php";
require_once "Organizador.class.php";

class Evento{
    private int $id;
    private string $nombre;
    private DateTime $fecha;
    private string $ubicacion;
    private int $asistentes;
    private Organizador $organizador;
    public function __construct(int $id, string $nombre, DateTime $fecha, string $ubicacion, int $asistentes, Organizador $organizador){$this->id = $id;$this->nombre = $nombre;$this->fecha = $fecha;$this->ubicacion = $ubicacion;$this->asistentes = $asistentes;$this->organizador = $organizador;}
	public function getId(): int {return $this->id;}

	public function getNombre(): string {return $this->nombre;}

	public function getFecha(): DateTime {return $this->fecha;}

	public function getUbicacion(): string {return $this->ubicacion;}

	public function getAsistentes(): int {return $this->asistentes;}

	public function getOrganizador(): Organizador {return $this->organizador;}

	public function setId(int $id): void {$this->id = $id;}

	public function setNombre(string $nombre): void {$this->nombre = $nombre;}

	public function setFecha(DateTime $fecha): void {$this->fecha = $fecha;}

	public function setUbicacion(string $ubicacion): void {$this->ubicacion = $ubicacion;}

	public function setAsistentes(int $asistentes): void {$this->asistentes = $asistentes;}

	public function setOrganizador(Organizador $organizador): void {$this->organizador = $organizador;}

	
}
?>