<?php
require_once 'config/conexion.php';

class HorasTrabajadas
{
    private $id;
    private $socio_id;
    private $fecha;
    private $horas;
    private $tarea;
    private $created_at;

    const TABLA = 'horas_trabajadas';

    // ==== Getters ====
    public function getId()
    {
        return $this->id;
    }
    public function getSocioId()
    {
        return $this->socio_id;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getHoras()
    {
        return $this->horas;
    }
    public function getTarea()
    {
        return $this->tarea;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    // ==== Setters ====
    public function setSocioId($socio_id)
    {
        $this->socio_id = $socio_id;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function setHoras($horas)
    {
        $this->horas = $horas;
    }
    public function setTarea($tarea)
    {
        $this->tarea = $tarea;
    }

    // ==== Guardar (Insertar o Actualizar) ====
    public function guardar()
    {
        $conexion = new Conexion();
        if ($this->id) {
            // Actualizar registro existente
            $consulta = $conexion->prepare('UPDATE ' . self::TABLA . ' SET socio_id = :socio_id, fecha = :fecha, horas = :horas, tarea = :tarea WHERE id = :id');
            $consulta->bindParam(':id', $this->id);
        } else {
            // Insertar nuevo registro
            $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA . ' (socio_id, fecha, horas, tarea) VALUES (:socio_id, :fecha, :horas, :tarea)');
        }

        $consulta->bindParam(':socio_id', $this->socio_id);
        $consulta->bindParam(':fecha', $this->fecha);
        $consulta->bindParam(':horas', $this->horas);
        $consulta->bindParam(':tarea', $this->tarea);
        $consulta->execute();

        if (!$this->id) {
            $this->id = $conexion->lastInsertId();
        }

        $conexion = null;
    }

    // ==== Eliminar ====
    public function eliminar()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE id = :id');
        $consulta->bindParam(':id', $this->id);
        $consulta->execute();
        $conexion = null;
    }

    // ==== Buscar por ID ====
    public static function buscarPorId($id)
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE id = :id');
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $registro = $consulta->fetch();

        $conexion = null;

        if ($registro) {
            $instancia = new self();
            $instancia->id = $registro['id'];
            $instancia->socio_id = $registro['socio_id'];
            $instancia->fecha = $registro['fecha'];
            $instancia->horas = $registro['horas'];
            $instancia->tarea = $registro['tarea'];
            $instancia->created_at = $registro['created_at'];
            return $instancia;
        } else {
            return false;
        }
    }

    // ==== Obtener todos ====
    public static function obtenerTodos()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY fecha DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        $conexion = null;
        return $registros;
    }
}
