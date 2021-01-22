<?php

header('Content-type: application/json');
include_once "../../bd/conexion.php";

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$incidencias = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.name as titulo, 
                                glpi_tickets.id as id, "Incidencia", glpi_tickets.status as estado
                                FROM '.nombre_bd.'.glpi_tickets
                                WHERE type = 1 AND is_deleted = 0');
$incidencias->execute();
$casosPorTipo = array();
while ($fila = $incidencias->fetch(PDO::FETCH_ASSOC)){
    array_push($casosPorTipo, array($fila["mes"], $fila["titulo"], $fila["id"], $fila["Incidencia"], $fila["estado"]));
}

$requerimientos = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.name as titulo, 
                                glpi_tickets.id as id, "Requerimiento", glpi_tickets.status as estado
                                FROM '.nombre_bd.'.glpi_tickets
                                WHERE type = 2 AND is_deleted = 0');
$requerimientos->execute();
while ($fila = $requerimientos->fetch(PDO::FETCH_ASSOC)){
    array_push($casosPorTipo, array($fila["mes"], $fila["titulo"], $fila["id"], $fila["Requerimiento"], $fila["estado"]));
}

$problemas = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.name as titulo, 
                                glpi_tickets.id as id, "Problema", glpi_tickets.status as estado
                                FROM '.nombre_bd.'.glpi_tickets
                                INNER JOIN glpi_problems_tickets
                                ON glpi_tickets.id = glpi_problems_tickets.tickets_id
                                WHERE is_deleted = 0');
$problemas->execute();
while ($fila = $problemas->fetch(PDO::FETCH_ASSOC)){
    array_push($casosPorTipo, array($fila["mes"], $fila["titulo"], $fila["id"], $fila["Problema"], $fila["estado"]));
}

for ($i=0; $i < count($casosPorTipo); $i++) { 
    if($casosPorTipo[$i][4] == 1){
        $casosPorTipo[$i][4] = "Nuevo";
    }
    else if($casosPorTipo[$i][4] == 2){
        $casosPorTipo[$i][4] = "Asignado";
    }
    else if($casosPorTipo[$i][4] == 4){
        $casosPorTipo[$i][4] = "En espera";
    }
    else if($casosPorTipo[$i][4] == 5){
        $casosPorTipo[$i][4] = "Solucionado";
    }
    else if($casosPorTipo[$i][4] == 6){
        $casosPorTipo[$i][4] = "Cerrado";
    }
}

$final = ["datosPorTipo" => $casosPorTipo];

print json_encode($final, JSON_NUMERIC_CHECK);

?>