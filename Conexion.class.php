<?php
class Conexion
{
    private static $instancia = null;
    private $conexion;
    private $host = 'database-1.czui8geaq717.us-east-1.rds.amazonaws.com';
    private $usuario = 'admin';
    private $password = 'naranco123';
    private $basedatos = 'parque_atracciones';
    private $port =3310;
    //Constructor privado
    private function __construct()
    {
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $this->conexion = new PDO(
            "mysql:host={$this->host};port={$this->port}; dbname={$this->basedatos}",
            $this->usuario,
            $this->password,
            $opciones
        );
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public static function getInstancia()
    {
        if (!self::$instancia) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }
    public function getConexion()
    {
        return $this->conexion;
    }
}