<?php
require_once 'config/conexion.php';

class PagoSocios
{
    private $id;
    private $socio_id;
    private $monto;
    private $concepto;
    private $fecha;
    private $created_at;
    private $update_at;

    const TABLA = 'pagos_socios';

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getSocioId()
    {
        return $this->socio_id;
    }
    public function getMonto()
    {
        return $this->monto;
    }
    public function getConcepto()
    {
        return $this->concepto;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    // Setters
    public function setSocioId($socio_id)
    {
        $this->socio_id = $socio_id;
    }
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    // Guardar (insertar o actualizar)
    public function guardar()
    {
        $conexion = new Conexion();
        if ($this->id) {
            $consulta = $conexion->prepare('
                UPDATE ' . self::TABLA . ' 
                SET socio_id = :socio_id, monto = :monto, concepto = :concepto, fecha = :fecha 
                WHERE id = :id
            ');
            $consulta->bindParam(':id', $this->id);
        } else {
            $consulta = $conexion->prepare('
                INSERT INTO ' . self::TABLA . ' (socio_id, monto, concepto, fecha) 
                VALUES (:socio_id, :monto, :concepto, :fecha)
            ');
        }

        $consulta->bindParam(':socio_id', $this->socio_id);
        $consulta->bindParam(':monto', $this->monto);
        $consulta->bindParam(':concepto', $this->concepto);
        $consulta->bindParam(':fecha', $this->fecha);
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
            $pago = new self();
            $pago->id = $registro['id'];
            $pago->socio_id = $registro['socio_id'];
            $pago->monto = $registro['monto'];
            $pago->concepto = $registro['concepto'];
            $pago->fecha = $registro['fecha'];
            $pago->created_at = $registro['created_at'];
            $pago->update_at = $registro['update_at'];
            return $pago;
        } else {
            return false;
        }
    }

    // Obtener todos
    public static function obtenerTodos()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY fecha DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        $conexion = null;
        return $registros;
    }

    // Eliminar
    public function eliminar()
    {
        if (!$this->id) return false;
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE id = :id');
        $consulta->bindParam(':id', $this->id);
        $resultado = $consulta->execute();
        $conexion = null;
        return $resultado;
    }
}
