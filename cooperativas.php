<?php
require_once 'config/conexion.php';

class Cooperativa
{
    private $id;
    private $nombre;
    private $direccion;
    private $departamento;
    private $telefono;
    private $email;
    private $created_at;

    const TABLA = 'cooperativas';

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getDepartamento()
    {
        return $this->departamento;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    // Setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    // Constructor opcional
    public function __construct($nombre = null, $direccion = null, $departamento = null, $telefono = null, $email = null)
    {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->departamento = $departamento;
        $this->telefono = $telefono;
        $this->email = $email;
    }

    // Guardar o actualizar cooperativa
    public function guardar()
    {
        $conexion = new Conexion();
        if ($this->id) {
            $consulta = $conexion->prepare('
                UPDATE ' . self::TABLA . ' 
                SET nombre = :nombre, direccion = :direccion, departamento = :departamento, telefono = :telefono, email = :email
                WHERE id = :id
            ');
            $consulta->bindParam(':id', $this->id);
        } else {
            $consulta = $conexion->prepare('
                INSERT INTO ' . self::TABLA . ' (nombre, direccion, departamento, telefono, email)
                VALUES (:nombre, :direccion, :departamento, :telefono, :email)
            ');
        }

        $consulta->bindParam(':nombre', $this->nombre);
        $consulta->bindParam(':direccion', $this->direccion);
        $consulta->bindParam(':departamento', $this->departamento);
        $consulta->bindParam(':telefono', $this->telefono);
        $consulta->bindParam(':email', $this->email);
        $consulta->execute();

        if (!$this->id) {
            $this->id = $conexion->lastInsertId();
        }

        $conexion = null;
    }

    // Buscar por ID
    public static function buscarPorId($id)
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE id = :id');
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $registro = $consulta->fetch();
        $conexion = null;

        if ($registro) {
            $cooperativa = new self();
            $cooperativa->id = $registro['id'];
            $cooperativa->nombre = $registro['nombre'];
            $cooperativa->direccion = $registro['direccion'];
            $cooperativa->departamento = $registro['departamento'];
            $cooperativa->telefono = $registro['telefono'];
            $cooperativa->email = $registro['email'];
            $cooperativa->created_at = $registro['created_at'];
            return $cooperativa;
        } else {
            return false;
        }
    }

    // Obtener todas las cooperativas
    public static function obtenerTodas()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY nombre ASC');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        $conexion = null;
        return $registros;
    }

    // Eliminar cooperativa
    public function eliminar()
    {
        if ($this->id) {
            $conexion = new Conexion();
            $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE id = :id');
            $consulta->bindParam(':id', $this->id);
            $consulta->execute();
            $conexion = null;
        }
    }
}
