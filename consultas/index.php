<?php

include_once "bd/conexion.php";

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$ano = date("Y");
$mes = date("m") - 4;

$consulta = $conexion->prepare('SELECT count(id) FROM '.nombre_bd.'.glpi_tickets 
                                    WHERE year(date) = :ano AND month(date) = :mes AND is_deleted = 0');
$consulta->bindValue(':ano', $ano);
$consulta->bindValue(':mes', $mes);
$consulta->execute();
$ticketMes=$consulta->fetchAll(PDO::FETCH_COLUMN, 0);

$consulta = $conexion->prepare('SELECT count(id) FROM '.nombre_bd.'.glpi_tickets 
                                    WHERE status = 4 AND is_deleted = 0');
$consulta->execute();
$ticketEspera=$consulta->fetchAll(PDO::FETCH_COLUMN, 0);

$consulta = $conexion->prepare('SELECT count(id) FROM '.nombre_bd.'.glpi_tickets 
                                    WHERE status = 2 OR status = 1 AND is_deleted = 0');
$consulta->execute();
$ticketNuevosAsignados=$consulta->fetchAll(PDO::FETCH_COLUMN, 0);

$consulta = $conexion->prepare('SELECT count(id) FROM '.nombre_bd.'.glpi_tickets 
                                    WHERE status = 5 AND is_deleted = 0');
$consulta->execute();
$ticketResueltos=$consulta->fetchAll(PDO::FETCH_COLUMN, 0);

$consulta = $conexion->prepare('SELECT count(id) FROM '.nombre_bd.'.glpi_tickets 
                                    WHERE year(date) = :ano AND month(date) = :mes AND status = 6 AND is_deleted = 0');
$consulta->bindValue(':ano', $ano);
$consulta->bindValue(':mes', $mes);
$consulta->execute();
$ticketCerrados=$consulta->fetchAll(PDO::FETCH_COLUMN, 0);


$consulta = $conexion->prepare('SELECT DATE_FORMAT(min(date), "%Y-%m") as masAntigua, DATE_FORMAT(max(date), "%Y-%m") as masReciente, 
                                    DATE_FORMAT(date_add(now(), interval - 12 month), "%Y-%m") as haceAnno 
                                    FROM '.nombre_bd.'.glpi_tickets');
$consulta->execute();
$fechas = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($fechas, array($fila["masAntigua"], $fila["masReciente"], $fila["haceAnno"]));
}

?>