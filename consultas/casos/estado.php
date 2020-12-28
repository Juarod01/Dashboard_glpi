<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$meses = $conexion->prepare('SELECT DATE_FORMAT(date, "%M %Y") AS mes FROM glpi_950.glpi_tickets
                                group by mes 
                                order by year(date), month(date)');
$meses->execute();
$result2 = array();
while ($fila = $meses->fetch(PDO::FETCH_ASSOC)){
    array_push($result2, array($fila["mes"]));
}

$abiertos = $conexion->prepare('SELECT DATE_FORMAT(date, "%Y-%m") AS abiertos, count(id) as casos 
                                    FROM glpi_950.glpi_tickets 
                                    group by abiertos  
                                    order by year(date), month(date)');
$abiertos->execute();
$result = array();
while ($fila = $abiertos->fetch(PDO::FETCH_ASSOC)){
    array_push($result, array($fila["abiertos"], $fila["casos"]));
}

$cerrados = $conexion->prepare('SELECT DATE_FORMAT(closedate, "%Y-%m") AS cerrados, count(id) as casos FROM glpi_950.glpi_tickets
                                    WHERE closedate is not null
                                    group by cerrados
                                    order by year(closedate), month(closedate)');
$cerrados->execute();
$result1 = array();
while ($fila = $cerrados->fetch(PDO::FETCH_ASSOC)){
    array_push($result1, array($fila["cerrados"], $fila["casos"]));
}

$final = ["abiertos" => $result, "cerrados" => $result1, "meses" => $result2];

print json_encode($final, JSON_NUMERIC_CHECK);