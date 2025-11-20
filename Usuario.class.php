<?php
class Usuario{
    private int $id_usuario;
    private string $nombre;
    private string $apellidos;
    private int $edad;
    private string $correo;
    private string $contraseña;
    public function __construct(int $id_usuario, string $nombre, string $apellidos, int $edad, string $correo){$this->id_usuario = $id_usuario;$this->nombre = $nombre;$this->apellidos = $apellidos;$this->edad = $edad;$this->correo = $correo;}
	public function getIdUsuario(): int {return $this->id_usuario;}

	public function getNombre(): string {return $this->nombre;}

	public function getApellidos(): string {return $this->apellidos;}

	public function getEdad(): int {return $this->edad;}

	public function getCorreo(): string {return $this->correo;}

	public function setIdUsuario(int $id_usuario): void {$this->id_usuario = $id_usuario;}

	public function setNombre(string $nombre): void {$this->nombre = $nombre;}

	public function setApellidos(string $apellidos): void {$this->apellidos = $apellidos;}

	public function setEdad(int $edad): void {$this->edad = $edad;}

	public function setCorreo(string $correo): void {$this->correo = $correo;}
	
	
}
?>