<?php
require_once 'config/conexion.php';

class Socio
{
    private $id;
    private $cooperativa_id;
    private $nombre;
    private $documento;
    private $telefono;
    private $email;
    private $fecha_ingreso;
    private $activo;
    private $socio;
    private $clave;
    private $created_at;
    private $update_at;

    const TABLA = 'socios';

    // ----- Getters -----
    public function getId()
    {
        return $this->id;
    }
    public function getCooperativaId()
    {
        return $this->cooperativa_id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDocumento()
    {
        return $this->documento;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getFechaIngreso()
    {
        return $this->fecha_ingreso;
    }
    public function getActivo()
    {
        return $this->activo;
    }
    public function getSocio()
    {
        return $this->socio;
    }
    public function getClave()
    {
        return $this->clave;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    // ----- Setters -----
    public function setCooperativaId($cooperativa_id)
    {
        $this->cooperativa_id = $cooperativa_id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setFechaIngreso($fecha_ingreso)
    {
        $this->fecha_ingreso = $fecha_ingreso;
    }
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }
    public function setSocio($socio)
    {
        $this->socio = $socio;
    }
    public function setClave($clave)
    {
        // Solo aplicar el hash si el valor no parece ya encriptado
        if (!password_get_info($clave)['algo']) {
            $this->clave = password_hash($clave, PASSWORD_DEFAULT);
        } else {
            // Si ya está encriptada (por ejemplo, cargada desde la base de datos), la dejamos igual
            $this->clave = $clave;
        }
    }

    // ----- Constructor -----
    public function __construct(
        $cooperativa_id,
        $nombre,
        $documento = null,
        $telefono = null,
        $email = null,
        $fecha_ingreso = null,
        $activo = true,
        $socio = true,
        $clave = null,
        $id = null
    ) {
        $this->cooperativa_id = $cooperativa_id;
        $this->nombre = $nombre;
        $this->documento = $documento;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->fecha_ingreso = $fecha_ingreso;
        $this->activo = $activo;
        $this->socio = $socio;
        $this->setClave($clave); // Debe llamar a la funcion setClave asi aplica el password_hash, sino queda en texto plano
        $this->id = $id;
    }

    // ----- Guardar (insertar o actualizar) -----
    public function guardar()
    {
        $Conexion = new Conexion();
        if ($this->id) {
            $sql = 'UPDATE ' . self::TABLA . ' SET 
            cooperativa_id = :cooperativa_id,
            nombre = :nombre,
            documento = :documento,
            telefono = :telefono,
            email = :email,
            fecha_ingreso = :fecha_ingreso,
            activo = :activo,
            socio = :socio,
            clave = :clave,
            update_at = CURRENT_TIMESTAMP
            WHERE id = :id';
            $consulta = $Conexion->prepare($sql);
            $consulta->bindParam(':id', $this->id);
        } else {
            $sql = 'INSERT INTO ' . self::TABLA . ' 
            (cooperativa_id, nombre, documento, telefono, email, fecha_ingreso, activo, socio, clave)
            VALUES (:cooperativa_id, :nombre, :documento, :telefono, :email, :fecha_ingreso, :activo, :socio, :clave)';
            $consulta = $Conexion->prepare($sql);
        }

        $consulta->bindParam(':cooperativa_id', $this->cooperativa_id);
        $consulta->bindParam(':nombre', $this->nombre);
        $consulta->bindParam(':documento', $this->documento);
        $consulta->bindParam(':telefono', $this->telefono);
        $consulta->bindParam(':email', $this->email);
        $consulta->bindParam(':fecha_ingreso', $this->fecha_ingreso);
        $consulta->bindParam(':activo', $this->activo, PDO::PARAM_BOOL);
        $consulta->bindParam(':socio', $this->socio, PDO::PARAM_BOOL);
        $consulta->bindParam(':clave', $this->clave);

        $consulta->execute();
        if (!$this->id) {
            $this->id = $Conexion->lastInsertId();
        }
        $Conexion = null;
    }

    // ----- Buscar por ID -----
    public static function buscarPorId($id)
    {
        $Conexion = new Conexion();
        $consulta = $Conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE id = :id');
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $registro = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($registro) {
            $socio = new self(
                $registro['cooperativa_id'],
                $registro['nombre'],
                $registro['documento'],
                $registro['telefono'],
                $registro['email'],
                $registro['fecha_ingreso'],
                $registro['activo'],
                $registro['socio'],
                $registro['clave'],
                $registro['id']
            );
            $socio->created_at = $registro['created_at'];
            $socio->update_at = $registro['update_at'];
            return $socio;
        } else {
            return false;
        }
    }

    // ----- Recuperar todos -----
    public static function recuperarTodos($pag = 0, $mostrar = 0)
    {
        $Conexion = new Conexion();
        $sql = 'SELECT * FROM ' . self::TABLA . ' ORDER BY nombre';
        if ($mostrar) {
            $sql .= ' LIMIT ' . $pag * $mostrar . ',' . $mostrar;
        }
        $consulta = $Conexion->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // ----- Borrar -----
    public static function borrar($id)
    {
        $Conexion = new Conexion();
        $sql = 'DELETE FROM ' . self::TABLA . ' WHERE id = ?';
        $consulta = $Conexion->prepare($sql);
        $consulta->bindParam(1, $id);
        $consulta->execute();
    }
}
