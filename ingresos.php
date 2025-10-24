<?php
require_once 'config/conexion.php';

class Ingreso
{
    private $id;
    private $socio_id;
    private $tipo_ingreso;
    private $descripcion;
    private $monto;
    private $fecha;
    private $created_at;

    const TABLA = 'ingresos';

    // ======= Getters =======
    public function getId()
    {
        return $this->id;
    }
    public function getSocioId()
    {
        return $this->socio_id;
    }
    public function getTipoIngreso()
    {
        return $this->tipo_ingreso;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getMonto()
    {
        return $this->monto;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    // ======= Setters =======
    public function setSocioId($socio_id)
    {
        $this->socio_id = $socio_id;
    }
    public function setTipoIngreso($tipo_ingreso)
    {
        $this->tipo_ingreso = $tipo_ingreso;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    // ======= Guardar (insertar o actualizar) =======
    public function guardar()
    {
        $conexion = new Conexion();
        if ($this->id) {
            $sql = $conexion->prepare('UPDATE ' . self::TABLA . ' 
                                       SET socio_id = :socio_id, tipo_ingreso = :tipo_ingreso, 
                                           descripcion = :descripcion, monto = :monto, fecha = :fecha 
                                       WHERE id = :id');
            $sql->bindParam(':id', $this->id);
        } else {
            $sql = $conexion->prepare('INSERT INTO ' . self::TABLA . ' 
                                       (socio_id, tipo_ingreso, descripcion, monto, fecha) 
                                       VALUES (:socio_id, :tipo_ingreso, :descripcion, :monto, :fecha)');
        }

        $sql->bindParam(':socio_id', $this->socio_id);
        $sql->bindParam(':tipo_ingreso', $this->tipo_ingreso);
        $sql->bindParam(':descripcion', $this->descripcion);
        $sql->bindParam(':monto', $this->monto);
        $sql->bindParam(':fecha', $this->fecha);
        $sql->execute();

        if (!$this->id) {
            $this->id = $conexion->lastInsertId();
        }

        $conexion = null;
    }

    // ======= Obtener por ID =======
    public static function obtenerPorId($id)
    {
        $conexion = new Conexion();
        $sql = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE id = :id');
        $sql->bindParam(':id', $id);
        $sql->execute();
        $registro = $sql->fetch(PDO::FETCH_ASSOC);
        $conexion = null;

        if ($registro) {
            $ingreso = new self();
            $ingreso->id = $registro['id'];
            $ingreso->socio_id = $registro['socio_id'];
            $ingreso->tipo_ingreso = $registro['tipo_ingreso'];
            $ingreso->descripcion = $registro['descripcion'];
            $ingreso->monto = $registro['monto'];
            $ingreso->fecha = $registro['fecha'];
            $ingreso->created_at = $registro['created_at'];
            return $ingreso;
        } else {
            return false;
        }
    }

    // ======= Listar todos =======
    public static function listar()
    {
        $conexion = new Conexion();
        $sql = $conexion->query('SELECT * FROM ' . self::TABLA . ' ORDER BY fecha DESC');
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        return $resultado;
    }

    // ======= Eliminar =======
    public function eliminar()
    {
        if ($this->id) {
            $conexion = new Conexion();
            $sql = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE id = :id');
            $sql->bindParam(':id', $this->id);
            $sql->execute();
            $conexion = null;
        }
    }
}
