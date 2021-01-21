<?php

header('Content-type: application/json');
include_once "../../bd/conexion.php";

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.id as id, 
        concat(glpi_users.firstname, " ", glpi_users.realname, " (", glpi_users.name, ")") AS name, 
        if(glpi_tickets.status = 1 OR glpi_tickets.status = 2, "1", "0") as Abiertos,
        if(glpi_tickets.status = 4, "1", "0") as EnEspera,
        if(glpi_tickets.status = 5, "1", "0") as Solucionado,
        if(glpi_tickets.status = 6, "1", "0") as Cerrado
        FROM '.nombre_bd.'.glpi_tickets
        INNER JOIN '.nombre_bd.'.glpi_tickets_users
        ON glpi_tickets.id = glpi_tickets_users.tickets_id
        INNER JOIN '.nombre_bd.'.glpi_users
        ON glpi_tickets_users.users_id = glpi_users.id
        WHERE glpi_tickets_users.type = 2 AND glpi_tickets.is_deleted = 0');
$consulta->execute();
$tecnico = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($tecnico, array($fila["mes"], $fila["id"], $fila["name"], $fila["Abiertos"],
                                $fila["EnEspera"], $fila["Solucionado"], $fila["Cerrado"]));
}

$final = ["tecnico" => $tecnico];

print json_encode($final, JSON_NUMERIC_CHECK);

?>