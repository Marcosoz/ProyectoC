<?php
require_once 'config/conexion.php';

class Compra
{
    private $id;
    private $proveedor_id;
    private $fecha;
    private $descripcion;
    private $monto;
    private $saldo_pendiente;
    private $created_at;

    const TABLA = 'compras';

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getProveedorId()
    {
        return $this->proveedor_id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function getSaldoPendiente()
    {
        return $this->saldo_pendiente;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    // Setters
    public function setProveedorId($proveedor_id)
    {
        $this->proveedor_id = $proveedor_id;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setMonto($monto)
    {
        $this->monto = $monto;
    }

    public function setSaldoPendiente($saldo_pendiente)
    {
        $this->saldo_pendiente = $saldo_pendiente;
    }

    // Guardar o actualizar registro
    public function guardar()
    {
        $conexion = new Conexion();
        if ($this->id) {
            $consulta = $conexion->prepare('UPDATE ' . self::TABLA . ' 
                SET proveedor_id = :proveedor_id, fecha = :fecha, descripcion = :descripcion, 
                    monto = :monto, saldo_pendiente = :saldo_pendiente 
                WHERE id = :id');
            $consulta->bindParam(':id', $this->id);
        } else {
            $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA . ' 
                (proveedor_id, fecha, descripcion, monto, saldo_pendiente) 
                VALUES (:proveedor_id, :fecha, :descripcion, :monto, :saldo_pendiente)');
        }

        $consulta->bindParam(':proveedor_id', $this->proveedor_id);
        $consulta->bindParam(':fecha', $this->fecha);
        $consulta->bindParam(':descripcion', $this->descripcion);
        $consulta->bindParam(':monto', $this->monto);
        $consulta->bindParam(':saldo_pendiente', $this->saldo_pendiente);
        $consulta->execute();

        if (!$this->id) {
            $this->id = $conexion->lastInsertId();
        }

        $conexion = null;
    }

    // Buscar compra por ID
    public static function buscarPorId($id)
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE id = :id');
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $registro = $consulta->fetch();
        $conexion = null;

        if ($registro) {
            $compra = new self();
            $compra->id = $registro['id'];
            $compra->proveedor_id = $registro['proveedor_id'];
            $compra->fecha = $registro['fecha'];
            $compra->descripcion = $registro['descripcion'];
            $compra->monto = $registro['monto'];
            $compra->saldo_pendiente = $registro['saldo_pendiente'];
            $compra->created_at = $registro['created_at'];
            return $compra;
        } else {
            return false;
        }
    }

    // Obtener todas las compras
    public static function obtenerTodos()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY id DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        $conexion = null;
        return $registros;
    }

    // Eliminar compra
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
