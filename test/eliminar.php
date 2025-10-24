<?php

/* // Inicio test eliminar cooperativas
require_once '../cooperativas.php';

// Buscar la cooperativa con ID 3
$coop = Cooperativa::buscarPorId(4);

if ($coop) {
    // Eliminarla
    $coop->eliminar();
    echo "Cooperativa eliminada correctamente.";
} else {
    echo "No se encontró ninguna cooperativa con ese ID.";
}

*/ // Fin test eliminar cooperativas

/* // Inicio test eliminar aportes legales
require_once '../ingresos.php';

//ID del ingreso que quiero eliminar
$idEliminar = 4; // Manual

// Buscar el ingreso
$ingreso = Ingreso::obtenerPorId($idEliminar);

if ($ingreso) {
    $ingreso->eliminar();
    echo "Ingreso con ID {$idEliminar} eliminado correctamente.";
} else {
    echo "No se encontro un registro con ese ID";
}
*/ // Fin test eliminar aportes legales


require_once '../aportes_legales.php';

// Mostrar en pantalla
echo "<h2>=== PRUEBA: ELIMINAR APORTES LEGALES ===</h2>";

// ID del aporte legal a eliminar
$idAEliminar = 2; // Manual

// Obtener el aporte antes de eliminar
$aporte = AporteLegal::obtenerPorId($idAEliminar);

if ($aporte) {

    // Eliminar el registro
    $aporte->eliminar();

    echo "Aporte legal con ID $idAEliminar eliminado correctamente.<br>";
} else {
    echo "No se encontró ningún aporte legal con ID $idAEliminar.<br>";
}

echo "<hr><h3>Fin de la prueba de eliminación.</h3>";
?>

