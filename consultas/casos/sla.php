<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.id as id, glpi_slas.name as sla
                                            FROM '.nombre_bd.'.glpi_tickets 
                                            INNER JOIN '.nombre_bd.'.glpi_slas
                                            ON glpi_tickets.slas_id_ttr = glpi_slas.id
                                            WHERE glpi_tickets.is_deleted = 0 AND glpi_tickets.type = 1');
$consulta->execute();
$sla = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($sla, array('mes' => $fila["mes"], 'ticket' => $fila["id"], 'sla' => $fila["sla"]));
}

$final = ["sla" => $sla];

print json_encode($final, JSON_NUMERIC_CHECK);