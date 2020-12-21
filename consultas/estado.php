<?php
header('Content-type: application/json');
include_once "../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$abiertos = $conexion->prepare('SELECT DATE_FORMAT(date, "%M %Y") AS abiertos, count(id) as casos 
                                    FROM glpi_950.glpi_tickets 
                                    WHERE date >= date_add(CONCAT(year(now()), "-", month(now()), "-", "01"), interval - 11 month) 
                                    group by abiertos  
                                    order by year(date), month(date)');
$abiertos->execute();
$result = array();
$meses = array();
while ($fila = $abiertos->fetch(PDO::FETCH_ASSOC)){
    array_push($result, array($fila["abiertos"], $fila["casos"]));
    array_push($meses, array($fila["abiertos"]));
}

$cerrados = $conexion->prepare('SELECT DATE_FORMAT(closedate, "%M %Y") AS cerrados, count(id) as casos FROM glpi_950.glpi_tickets
                                    WHERE closedate >= date_add(CONCAT(year(now()), "-", month(now()), "-", "01"), interval - 11 month) 
                                    group by cerrados
                                    order by year(closedate), month(closedate)');
$cerrados->execute();
$result1 = array();
while ($fila = $cerrados->fetch(PDO::FETCH_ASSOC)){
    array_push($result1, array($fila["cerrados"], $fila["casos"]));
}

$final = array();
array_push($final, array("abiertos" => $result), array("cerrados" => $result1), array("meses" => $meses));

print json_encode($final, JSON_NUMERIC_CHECK);
