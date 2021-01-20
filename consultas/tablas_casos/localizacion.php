<?php

header('Content-type: application/json');
include_once "../../bd/conexion.php";

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.name as titulo, 
        glpi_tickets.id as id, glpi_locations.completename as name, glpi_tickets.status as estado
        FROM '.nombre_bd.'.glpi_tickets
        INNER JOIN '.nombre_bd.'.glpi_locations
        ON glpi_tickets.locations_id = glpi_locations.id');
$consulta->execute();
$localizacion = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($localizacion, array($fila["mes"], 
        $fila["titulo"], $fila["id"], $fila["name"], $fila["estado"]));
}

for ($i=0; $i < count($localizacion); $i++) { 
    if($localizacion[$i][4] == 1){
        $localizacion[$i][4] = "Nuevo";
    }
    else if($localizacion[$i][4] == 2){
        $localizacion[$i][4] = "Asignado";
    }
    else if($localizacion[$i][4] == 4){
        $localizacion[$i][4] = "En espera";
    }
    else if($localizacion[$i][4] == 5){
        $localizacion[$i][4] = "Solucionado";
    }
    else if($localizacion[$i][4] == 6){
        $localizacion[$i][4] = "Cerrado";
    }
}

$final = ["localizacion" => $localizacion];

print json_encode($final, JSON_NUMERIC_CHECK);

?>