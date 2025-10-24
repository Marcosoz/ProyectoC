<?php
require_once 'config/conexion.php';

class AporteLegal
{
    private $id;
    private $cooperativa_id;
    private $concepto;
    private $monto;
    private $fecha;
    private $created_at;
    private $update_at;

    const TABLA = 'aportes_legales';

    // ======= Getters =======
    public function getId()
    {
        return $this->id;
    }
    public function getCooperativaId()
    {
        return $this->cooperativa_id;
    }
    public function getConcepto()
    {
        return $this->concepto;
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
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    // ======= Setters =======
    public function setCooperativaId($cooperativa_id)
    {
        $this->cooperativa_id = $cooperativa_id;
    }
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;
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
            // Actualizar
            $sql = $conexion->prepare('UPDATE ' . self::TABLA . ' 
                SET cooperativa_id = :cooperativa_id, concepto = :concepto, 
                    monto = :monto, fecha = :fecha, update_at = NOW() 
                WHERE id = :id');
            $sql->bindParam(':id', $this->id);
        } else {
            // Insertar
            $sql = $conexion->prepare('INSERT INTO ' . self::TABLA . ' 
                (cooperativa_id, concepto, monto, fecha) 
                VALUES (:cooperativa_id, :concepto, :monto, :fecha)');
        }

        $sql->bindParam(':cooperativa_id', $this->cooperativa_id);
        $sql->bindParam(':concepto', $this->concepto);
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
            $aporte = new self();
            $aporte->id = $registro['id'];
            $aporte->cooperativa_id = $registro['cooperativa_id'];
            $aporte->concepto = $registro['concepto'];
            $aporte->monto = $registro['monto'];
            $aporte->fecha = $registro['fecha'];
            $aporte->created_at = $registro['created_at'];
            $aporte->update_at = $registro['update_at'];
            return $aporte;
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
