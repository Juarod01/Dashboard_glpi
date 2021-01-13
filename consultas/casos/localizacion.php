<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombreLocalizacion = $conexion->prepare('SELECT distinct(name) as nombre FROM '.nombre_bd.'.glpi_locations');
$nombreLocalizacion->execute();
$areas = array();
while ($fila = $nombreLocalizacion->fetch(PDO::FETCH_ASSOC)){
    array_push($areas, array($fila["nombre"]));
}

$localizacion = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_locations.name AS localizacion, count(glpi_tickets.id) as casos
                                    FROM '.nombre_bd.'.glpi_tickets
                                    INNER JOIN '.nombre_bd.'.glpi_locations
                                    ON glpi_tickets.locations_id = glpi_locations.id
                                    WHERE glpi_tickets.is_deleted = 0
                                    group by mes, localizacion
                                    order by casos DESC');
$localizacion->execute();
$rLocalizacion = array();
while ($fila = $localizacion->fetch(PDO::FETCH_ASSOC)){
    array_push($rLocalizacion, array($fila["mes"], $fila["localizacion"], $fila["casos"]));
}

$final = ["localizacion" => $rLocalizacion, "areas" => $areas];

print json_encode($final, JSON_NUMERIC_CHECK);