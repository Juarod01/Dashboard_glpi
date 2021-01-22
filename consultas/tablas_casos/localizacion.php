<?php

header('Content-type: application/json');
include_once "../../bd/conexion.php";

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes,  
        glpi_tickets.id as id, glpi_locations.completename as name, 
        if(glpi_tickets.status = 1 OR glpi_tickets.status = 2 OR glpi_tickets.status = 4, "1", "0") as Abiertos,
        if(glpi_tickets.status = 5, "1", "0") as Solucionado,
        if(glpi_tickets.status = 6, "1", "0") as Cerrado
        FROM '.nombre_bd.'.glpi_tickets
        INNER JOIN '.nombre_bd.'.glpi_locations
        ON glpi_tickets.locations_id = glpi_locations.id
        WHERE is_deleted = 0');
$consulta->execute();
$localizacion = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($localizacion, array($fila["mes"], $fila["id"], $fila["name"], $fila["Abiertos"],
                                    $fila["Solucionado"], $fila["Cerrado"]));
}

$final = ["localizacion" => $localizacion];

print json_encode($final, JSON_NUMERIC_CHECK);

?>