<?php
require_once '../socios.php';

/*
// Crear un nuevo socio
$socio = new Socio(
    1, // ID de cooperativa (ajusta según tus datos)
    "Manuel Mendez",
    "12223334",
    "099123445",
    "jose@example.com",
    "2025-10-20"
);
$socio->guardar();

echo "Socio creado con ID: " . $socio->getId() . "<br>";

// Buscar un socio existente (otro ID)
$idBuscado = 3;
$encontrado = Socio::buscarPorId($idBuscado);

if ($encontrado) {
    echo "Socio existente encontrado: " . $encontrado->getNombre() . "<br>";
} else {
    echo "No se encontró un socio con ID $idBuscado.<br>";
}

/*
// Buscar socio por ID Opcion 1 --crear una variable socio vacia para que la busque--
$encontrado = Socio::buscarPorId($socio->getId());
if ($encontrado) {
    echo "Socio encontrado: " . $encontrado->getNombre() . "<br>";
}


// Actualizar datos
$encontrado->setTelefono("12223334");
$encontrado->guardar();
echo "Socio actualizado.<br>";

// Mostrar todos los socios
$todos = Socio::recuperarTodos();
echo "<pre>";
print_r($todos);
echo "</pre>";

// Borrar el socio de prueba
// Socio::borrar($socio->getId());
// echo "Socio eliminado.<br>";

*/ //FIN TEST SOCIOS

/*
require_once '../cooperativas.php';

// Crear nueva cooperativa
$coop = new Cooperativa('Nueva Cooperativa', 'Av. Siempre Viva 742', 'Canelones', '091234567', 'nueva@coop.com');
$coop->guardar();
echo "Cooperativa guardada con ID: " . $coop->getId() . "<br>";

// Buscar por ID
$buscada = Cooperativa::buscarPorId($coop->getId());
if ($buscada) {
    echo "Encontrada: " . $buscada->getNombre() . "<br>";
}

// Listar todas
$todas = Cooperativa::obtenerTodas();
foreach ($todas as $fila) {
    echo $fila['id'] . " - " . $fila['nombre'] . "<br>";
}

*/ //fin test cooperativas

/* //inicio test proveedores 

require_once '../proveedores.php';

// Crear un proveedor de prueba
$prov = new Proveedor('Proveedor Temporal', 12345678, '099888777', 'temporal@prov.com', 'Calle Falsa 456', 'Montevideo');
$prov->guardar();

echo "<strong>Proveedor creado con ID:</strong> " . $prov->getId() . "<br>";

// Buscar por ID
$buscado = Proveedor::buscarPorId($prov->getId());
if ($buscado) {
    echo "<strong>Proveedor encontrado:</strong> " . $buscado->getNombre() . "<br>";
}

// Listar todos los proveedores
echo "<strong>Todos los proveedores:</strong><br>";
$todos = Proveedor::obtenerTodos();
foreach ($todos as $fila) {
    echo $fila['id'] . " - " . $fila['nombre'] . "<br>";
}

/*
// Eliminar el proveedor de prueba
$prov->eliminar();
echo "<strong>Proveedor eliminado con ID:</strong> " . $prov->getId() . "<br>";

// Verificar eliminación
$verificar = Proveedor::buscarPorId($prov->getId());
if (!$verificar) {
    echo "<span style='color:green; font-weight:bold;'>✔ Eliminación confirmada: proveedor no encontrado.</span>";
} else {
    echo "<span style='color:red; font-weight:bold;'>✖ Error: el proveedor aún existe.</span>";
}
    */


/* // -- Inicio test ingresos --

require_once '../ingresos.php';

echo "<h2>=== PRUEBA DE CLASE INGRESOS ===</h2>";

// Crear un nuevo ingreso de prueba
echo "<h3>Insertando un nuevo ingreso...</h3>";

$ingreso = new Ingreso();
$ingreso->setSocioId(3); // Tiene que existir un socio. De lo contrario tira error
$ingreso->setTipoIngreso("Aporte mensual");
$ingreso->setDescripcion("Aporte correspondiente al mes de octubre");
$ingreso->setMonto(1800.50);
$ingreso->setFecha(date('Y-m-d'));
$ingreso->guardar();

echo "Ingreso guardado con ID: " . $ingreso->getId() . "<br><br>";

// Obtener ingreso por ID
echo "<h3>Obteniendo ingreso por ID...</h3>";
$ingresoObtenido = Ingreso::obtenerPorId($ingreso->getId());

if ($ingresoObtenido) {
    echo "ID: " . $ingresoObtenido->getId() . "<br>";
    echo "Socio ID: " . $ingresoObtenido->getSocioId() . "<br>";
    echo "Tipo: " . $ingresoObtenido->getTipoIngreso() . "<br>";
    echo "Descripción: " . $ingresoObtenido->getDescripcion() . "<br>";
    echo "Monto: " . $ingresoObtenido->getMonto() . "<br>";
    echo "Fecha: " . $ingresoObtenido->getFecha() . "<br>";
    echo "Creado: " . $ingresoObtenido->getCreatedAt() . "<br><br>";
} else {
    echo "No se encontró el ingreso.<br><br>";
}

// Listar todos los ingresos
echo "<h3>Listado de todos los ingresos:</h3>";
$ingresos = Ingreso::listar();

if ($ingresos) {
    foreach ($ingresos as $i) {
        echo "ID: " . $i['id'] . " | Socio ID: " . $i['socio_id'] . 
             " | Tipo: " . $i['tipo_ingreso'] . 
             " | Monto: " . $i['monto'] . 
             " | Fecha: " . $i['fecha'] . 
             " | Descripción: " . $i['descripcion'] . "<br>";
    }
} else {
    echo "No hay ingresos registrados.<br>";
}
*/ //Fin test ingresos

/* // Inicio test aportes legales
    
    require_once '../aportes_legales.php';

echo "<h2>=== PRUEBA DE CLASE APORTES LEGALES ===</h2>";

// Crear un nuevo aporte legal
echo "<h3>Insertando un nuevo aporte legal...</h3>";

$aporte = new AporteLegal();
$aporte->setCooperativaId(1); // Cooperativa manual. ver una opcion valida
$aporte->setConcepto("Pago BPS");
$aporte->setMonto(2500.75);
$aporte->setFecha(date('Y-m-d'));
$aporte->guardar();

echo "✔ Aporte legal guardado con ID: " . $aporte->getId() . "<br><br>";

// Obtener aporte legal por ID
echo "<h3>Obteniendo aporte legal por ID...</h3>";

$aporteObtenido = AporteLegal::obtenerPorId($aporte->getId());
if ($aporteObtenido) {
    echo "ID: " . $aporteObtenido->getId() . "<br>";
    echo "Cooperativa ID: " . $aporteObtenido->getCooperativaId() . "<br>";
    echo "Concepto: " . $aporteObtenido->getConcepto() . "<br>";
    echo "Monto: " . $aporteObtenido->getMonto() . "<br>";
    echo "Fecha: " . $aporteObtenido->getFecha() . "<br>";
    echo "Creado: " . $aporteObtenido->getCreatedAt() . "<br>";
    echo "Actualizado: " . $aporteObtenido->getUpdateAt() . "<br><br>";
} else {
    echo "✖ No se encontró el aporte legal.<br><br>";
}

// Listar todos los aportes legales
echo "<h3>Listado de todos los aportes legales:</h3>";
$aportes = AporteLegal::listar();

if ($aportes) {
    foreach ($aportes as $a) {
        echo "ID: " . $a['id'] .
            " | Coop ID: " . $a['cooperativa_id'] .
            " | Concepto: " . $a['concepto'] .
            " | Monto: " . $a['monto'] .
            " | Fecha: " . $a['fecha'] .
            " | Creado: " . $a['created_at'] .
            " | Actualizado: " . $a['update_at'] . "<br>";
    }
} else {
    echo "No hay aportes legales registrados.<br>";
}

*/


/* // Inicio test compras

require_once '../compras.php';

// Crear una nueva compra
$compra = new Compra();
$compra->setProveedorId(2); // Para el test tiene que haber un proveedor
$compra->setFecha('2025-10-23');
$compra->setDescripcion('Compra de materiales de construcción');
$compra->setMonto(15000.50);
$compra->setSaldoPendiente(5000.00);

// Guardar en la base de datos
$compra->guardar();

echo "Compra creada correctamente con ID: " . $compra->getId();

// Buscar una compra por id
require_once '../compras.php';

// Buscar una compra por ID
$id = 3;
$compra = Compra::buscarPorId($id);

if ($compra) {
    echo "<h3>Compra encontrada:</h3>";
    echo "ID: " . $compra->getId() . "<br>";
    echo "Proveedor ID: " . $compra->getProveedorId() . "<br>";
    echo "Fecha: " . $compra->getFecha() . "<br>";
    echo "Descripción: " . $compra->getDescripcion() . "<br>";
    echo "Monto: " . $compra->getMonto() . "<br>";
    echo "Saldo Pendiente: " . $compra->getSaldoPendiente() . "<br>";
    echo "Creada: " . $compra->getCreatedAt();
} else {
    echo "No se encontró ninguna compra con ese ID.";
}

// listar compras
require_once '../compras.php';

$compras = Compra::obtenerTodos();

if ($compras) {
    echo "<h3>Listado de compras:</h3>";
    foreach ($compras as $compra) {
        echo "ID: " . $compra['id'] . " | ";
        echo "Proveedor ID: " . $compra['proveedor_id'] . " | ";
        echo "Monto: " . $compra['monto'] . " | ";
        echo "Fecha: " . $compra['fecha'] . "<br>";
    }
} else {
    echo "No hay compras registradas.";
}

require_once '../compras.php';

// Buscar la compra que querés modificar
$compra = Compra::buscarPorId(3); // id manual

if ($compra) {
    $compra->setDescripcion('Compra actualizada: materiales eléctricos');
    $compra->setMonto(18000.00);
    $compra->setSaldoPendiente(3000.00);
    $compra->guardar();

    echo "Compra actualizada correctamente.";
} else {
    echo "No se encontró la compra para actualizar.";
}

require_once '../compras.php';

echo "<h2>=== PRUEBA: ELIMINAR COMPRA ===</h2>";

// ID de la compra a eliminar (cambialo según tu base de datos)
$idEliminar = 4;

// Buscar la compra antes de eliminar
$compra = Compra::buscarPorId($idEliminar);

if ($compra) {
    echo "Compra encontrada:<br>";
    echo "ID: " . $compra->getId() . "<br>";
    echo "Descripción: " . $compra->getDescripcion() . "<br>";
    echo "Monto: " . $compra->getMonto() . "<br><br>";

    // Eliminar la compra
    $compra->eliminar();

    echo "Compra con ID $idEliminar eliminada correctamente.<br>";
} else {
    echo "No se encontró ninguna compra con ID $idEliminar.<br>";
}

echo "<hr><h3>Fin de la prueba de eliminación.</h3>";
// Fin test compras

// Inicio test horas_trabajadas

require_once '../horas_trabajadas.php';

// Crear un nuevo registro de horas
$horas = new HorasTrabajadas();
$horas->setSocioId(3); // Socio manual, debe existir uno
$horas->setFecha('2025-10-23');
$horas->setHoras(8.5);
$horas->setTarea('Limpieza y organización del depósito');

// Guardar en la base de datos
$horas->guardar();

echo "Registro de horas creado correctamente con ID: " . $horas->getId();


require_once '../horas_trabajadas.php';

// Buscar un registro de horas por ID
$id = 1; // id manual
$horas = HorasTrabajadas::buscarPorId($id);

if ($horas) {
    echo "<h3>Registro encontrado:</h3>";
    echo "ID: " . $horas->getId() . "<br>";
    echo "Socio ID: " . $horas->getSocioId() . "<br>";
    echo "Fecha: " . $horas->getFecha() . "<br>";
    echo "Horas: " . $horas->getHoras() . "<br>";
    echo "Tarea: " . $horas->getTarea() . "<br>";
    echo "Creado: " . $horas->getCreatedAt() . "<br>";
} else {
    echo "No se encontró ningún registro con ese ID.";
}

require_once '../horas_trabajadas.php';

// Obtener todos los registros
$registros = HorasTrabajadas::obtenerTodos();

if ($registros) {
    echo "<h3>Listado de horas trabajadas:</h3>";
    foreach ($registros as $r) {
        echo "ID: " . $r['id'] . " | ";
        echo "Socio ID: " . $r['socio_id'] . " | ";
        echo "Fecha: " . $r['fecha'] . " | ";
        echo "Horas: " . $r['horas'] . " | ";
        echo "Tarea: " . $r['tarea'] . "<br>";
    }
} else {
    echo "No hay registros de horas trabajadas.";
}

require_once '../horas_trabajadas.php';

// Buscar el registro a actualizar
$id = 1; // id manual
$horas = HorasTrabajadas::buscarPorId($id);

if ($horas) {
    $horas->setHoras(10.0);
    $horas->setTarea('Trabajo en estructura de techo');
    $horas->guardar();

    echo "Registro de horas actualizado correctamente.";
} else {
    echo "No se encontró el registro para actualizar.";
}

require_once '../horas_trabajadas.php';

echo "<h2>=== PRUEBA: ELIMINAR HORAS TRABAJADAS ===</h2>";

$idEliminar = 1; // id manual
$horas = HorasTrabajadas::buscarPorId($idEliminar);

if ($horas) {
    echo "Registro encontrado:<br>";
    echo "ID: " . $horas->getId() . "<br>";
    echo "Tarea: " . $horas->getTarea() . "<br><br>";

    $horas->eliminar();

    echo "Registro con ID $idEliminar eliminado correctamente.<br>";
} else {
    echo "No se encontró ningún registro con ID $idEliminar.<br>";
}

echo "<hr><h3>Fin de la prueba de eliminación.</h3>";
*/
/* 
// Inicio test pagoSocios
require_once '../pago_socios.php';

// --- 1. Crear un nuevo pago ---
echo "<h3>1. Crear un nuevo pago</h3>";

$pago = new PagoSocios();
$pago->setSocioId(3); // ID de un socio existente
$pago->setMonto(1500.75);
$pago->setConcepto("Pago mensual cuota cooperativa");
$pago->setFecha(date('Y-m-d'));
$pago->guardar();

echo "Pago creado con ID: " . $pago->getId() . "<br><br>";


// --- 2. Buscar un pago por ID ---
echo "<h3>2. Buscar pago por ID</h3>";

$pagoBuscado = PagoSocios::buscarPorId($pago->getId());
if ($pagoBuscado) {
    echo "ID: " . $pagoBuscado->getId() . "<br>";
    echo "Socio ID: " . $pagoBuscado->getSocioId() . "<br>";
    echo "Monto: $" . $pagoBuscado->getMonto() . "<br>";
    echo "Concepto: " . $pagoBuscado->getConcepto() . "<br>";
    echo "Fecha: " . $pagoBuscado->getFecha() . "<br>";
    echo "Creado: " . $pagoBuscado->getCreatedAt() . "<br>";
    echo "Actualizado: " . $pagoBuscado->getUpdateAt() . "<br><br>";
} else {
    echo "No se encontró el pago con ID " . $pago->getId() . "<br><br>";
}

// --- 3. Listar todos los pagos ---
echo "<h3>3. Listar todos los pagos registrados</h3>";

$pagos = PagoSocios::obtenerTodos();
if (count($pagos) > 0) {
    foreach ($pagos as $p) {
        echo "ID: " . $p['id'] . " | Socio ID: " . $p['socio_id'] .
            " | Monto: $" . $p['monto'] .
            " | Concepto: " . $p['concepto'] .
            " | Fecha: " . $p['fecha'] . "<br>";
    }
} else {
    echo "No hay pagos registrados todavía.<br>";
}
*/

/*
// --- Eliminar un pago existente ---

$idEliminar = 2; // Valor manual para id del pago

$pago = PagoSocios::buscarPorId($idEliminar);

if ($pago) {
    if ($pago->eliminar()) {
        echo "El pago con ID $idEliminar fue eliminado correctamente.<br>";
    } else {
        echo "Ocurrió un error al intentar eliminar el pago con ID $idEliminar.<br>";
    }
} else {
    echo "No se encontró ningún pago con ID $idEliminar.<br>";
}
    */
