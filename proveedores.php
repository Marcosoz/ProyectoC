<?php
require_once 'config/conexion.php';

class Proveedor
{
    private $id;
    private $nombre;
    private $rut;
    private $telefono;
    private $email;
    private $direccion;
    private $departamento;

    const TABLA = 'proveedores';

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getRut()
    {
        return $this->rut;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getDepartamento()
    {
        return $this->departamento;
    }

    // Setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setRut($rut)
    {
        $this->rut = $rut;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    // Constructor opcional
    public function __construct($nombre = null, $rut = null, $telefono = null, $email = null, $direccion = null, $departamento = null)
    {
        $this->nombre = $nombre;
        $this->rut = $rut;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->departamento = $departamento;
    }

    // Guardar o actualizar proveedor
    public function guardar()
    {
        $conexion = new Conexion();
        if ($this->id) {
            $consulta = $conexion->prepare('
                UPDATE ' . self::TABLA . ' 
                SET nombre = :nombre, rut = :rut, telefono = :telefono, email = :email, direccion = :direccion, departamento = :departamento
                WHERE id = :id
            ');
            $consulta->bindParam(':id', $this->id);
        } else {
            $consulta = $conexion->prepare('
                INSERT INTO ' . self::TABLA . ' (nombre, rut, telefono, email, direccion, departamento)
                VALUES (:nombre, :rut, :telefono, :email, :direccion, :departamento)
            ');
        }

        $consulta->bindParam(':nombre', $this->nombre);
        $consulta->bindParam(':rut', $this->rut);
        $consulta->bindParam(':telefono', $this->telefono);
        $consulta->bindParam(':email', $this->email);
        $consulta->bindParam(':direccion', $this->direccion);
        $consulta->bindParam(':departamento', $this->departamento);
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
            $prov = new self();
            $prov->id = $registro['id'];
            $prov->nombre = $registro['nombre'];
            $prov->rut = $registro['rut'];
            $prov->telefono = $registro['telefono'];
            $prov->email = $registro['email'];
            $prov->direccion = $registro['direccion'];
            $prov->departamento = $registro['departamento'];
            return $prov;
        } else {
            return false;
        }
    }

    // Obtener todos los proveedores
    public static function obtenerTodos()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY nombre ASC');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        $conexion = null;
        return $registros;
    }

    // Eliminar proveedor
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
