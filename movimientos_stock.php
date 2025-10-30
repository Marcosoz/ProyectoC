<?php
require_once 'config/conexion.php';

class MovimientoStock {
    private $id;
    private $stock_id;
    private $tipo_movimiento; // entrada, salida o devolucion
    private $cantidad;
    private $responsable;
    private $motivo;
    private $fecha;

    const TABLA = 'movimientos_stock';

    // Getters
    public function getId() { return $this->id; }
    public function getStockId() { return $this->stock_id; }
    public function getTipoMovimiento() { return $this->tipo_movimiento; }
    public function getCantidad() { return $this->cantidad; }
    public function getResponsable() { return $this->responsable; }
    public function getMotivo() { return $this->motivo; }
    public function getFecha() { return $this->fecha; }

    // Setters
    public function setStockId($stock_id) { $this->stock_id = $stock_id; }
    public function setTipoMovimiento($tipo_movimiento) { $this->tipo_movimiento = $tipo_movimiento; }
    public function setCantidad($cantidad) { $this->cantidad = $cantidad; }
    public function setResponsable($responsable) { $this->responsable = $responsable; }
    public function setMotivo($motivo) { $this->motivo = $motivo; }
    public function setFecha($fecha) { $this->fecha = $fecha; }

    // Constructor (hacer parámetros opcionales si preferís)
    public function __construct($stock_id = null, $tipo_movimiento = null, $cantidad = null, $responsable = null, $motivo = null, $fecha = null, $id = null) {
        $this->stock_id = $stock_id;
        $this->tipo_movimiento = $tipo_movimiento;
        $this->cantidad = $cantidad;
        $this->responsable = $responsable;
        $this->motivo = $motivo;
        $this->fecha = $fecha;
        $this->id = $id;
    }

    // Guardar movimiento y actualizar stock automáticamente
    public function guardar() {
        $conexion = new Conexion(); // $conexion actúa como PDO
        $db = $conexion;

        if ($this->id) {
            // Actualizar registro existente (si se necesitara)
            $consulta = $db->prepare('
                UPDATE ' . self::TABLA . ' 
                SET stock_id = :stock_id, tipo_movimiento = :tipo_movimiento, cantidad = :cantidad,
                    responsable = :responsable, motivo = :motivo, fecha = :fecha
                WHERE id = :id
            ');
            $consulta->bindParam(':id', $this->id);
        } else {
            // Insertar nuevo movimiento
            $consulta = $db->prepare('
                INSERT INTO ' . self::TABLA . ' (stock_id, tipo_movimiento, cantidad, responsable, motivo, fecha)
                VALUES (:stock_id, :tipo_movimiento, :cantidad, :responsable, :motivo, :fecha)
            ');
        }

        $consulta->bindParam(':stock_id', $this->stock_id);
        $consulta->bindParam(':tipo_movimiento', $this->tipo_movimiento);
        $consulta->bindParam(':cantidad', $this->cantidad);
        $consulta->bindParam(':responsable', $this->responsable);
        $consulta->bindParam(':motivo', $this->motivo);
        $consulta->bindParam(':fecha', $this->fecha);
        $consulta->execute();

        // Si es nuevo, obtenemos el ID
        if (!$this->id) {
            $this->id = $db->lastInsertId();
        }

        // Actualizar stock automáticamente
        $this->actualizarStock();
    }

    private function actualizarStock() {
        $conexion = new Conexion();
        $db = $conexion;

        if ($this->tipo_movimiento == 'entrada' || $this->tipo_movimiento == 'devolucion') {
            $sql = 'UPDATE stock SET cantidad = cantidad + :cantidad WHERE id = :stock_id';
        } elseif ($this->tipo_movimiento == 'salida') {
            $sql = 'UPDATE stock SET cantidad = cantidad - :cantidad WHERE id = :stock_id';
        } else {
            return; // Tipo no válido
        }

        $consulta = $db->prepare($sql);
        $consulta->bindParam(':cantidad', $this->cantidad);
        $consulta->bindParam(':stock_id', $this->stock_id);
        $consulta->execute();
    }

    // Listar todos los movimientos
    public static function listar() {
        $conexion = new Conexion();
        $db = $conexion;

        $consulta = $db->prepare('
            SELECT m.*, s.nombre AS item_nombre 
            FROM ' . self::TABLA . ' m
            INNER JOIN stock s ON s.id = m.stock_id
            ORDER BY m.fecha DESC
        ');
        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    // Buscar movimiento por ID
    public static function buscarPorId($id) {
        $conexion = new Conexion();
        $db = $conexion;

        $consulta = $db->prepare('SELECT * FROM ' . self::TABLA . ' WHERE id = :id');
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return $resultado ? $resultado : false;
    }

    // Eliminar movimiento (opcional)
    public static function eliminar($id) {
        $conexion = new Conexion();
        $db = $conexion;

        $consulta = $db->prepare('DELETE FROM ' . self::TABLA . ' WHERE id = :id');
        $consulta->bindParam(':id', $id);
        return $consulta->execute();
    }
}
?>
