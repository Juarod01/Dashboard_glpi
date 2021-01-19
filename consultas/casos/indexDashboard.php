<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
                                FROM '.nombre_bd.'.glpi_tickets
                                where is_deleted = 0
                                group by mes');
$consulta->execute();
$ticketsMes = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($ticketsMes, array('mes'=>$fila["mes"], 'casos'=>$fila["casos"]));
}

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
                                FROM '.nombre_bd.'.glpi_tickets
                                where status = 4 and is_deleted = 0
                                group by mes');
$consulta->execute();
$ticketsEnEspera = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($ticketsEnEspera, array('mes'=>$fila["mes"], 'casos'=>$fila["casos"]));
}

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
                                FROM '.nombre_bd.'.glpi_tickets
                                where status = 2 OR status = 1 AND is_deleted = 0
                                group by mes');
$consulta->execute();
$ticketsNuevosAsignados = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($ticketsNuevosAsignados, array('mes'=>$fila["mes"], 'casos'=>$fila["casos"]));
}

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
                                FROM '.nombre_bd.'.glpi_tickets
                                where status = 5 AND is_deleted = 0
                                group by mes');
$consulta->execute();
$ticketsSolucionados = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($ticketsSolucionados, array('mes'=>$fila["mes"], 'casos'=>$fila["casos"]));
}

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
                                FROM '.nombre_bd.'.glpi_tickets
                                where status = 6 AND is_deleted = 0
                                group by mes');
$consulta->execute();
$ticketsCerrados = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($ticketsCerrados, array('mes'=>$fila["mes"], 'casos'=>$fila["casos"]));
}

$consulta = $conexion->prepare('SELECT DATE_FORMAT(date_answered, "%Y-%m") AS mes, ROUND((100*AVG(satisfaction))/5,2) as promedio 
                                FROM '.nombre_bd.'.glpi_ticketsatisfactions
                                WHERE satisfaction is not null
                                group by mes 
                                order by year(date_answered), month(date_answered)');
$consulta->execute();
$satisfaccion = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($satisfaccion, array('mes'=>$fila["mes"], 'promedio'=>$fila["promedio"]));
}

$final = ["ticketsMes" => $ticketsMes, "ticketsEnEspera" => $ticketsEnEspera, "ticketsNuevosAsignados" => $ticketsNuevosAsignados,
            "ticketsSolucionados" => $ticketsSolucionados, "ticketsCerrados" => $ticketsCerrados, "satisfaccion" => $satisfaccion];

print json_encode($final, JSON_NUMERIC_CHECK);