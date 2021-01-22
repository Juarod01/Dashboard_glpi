<?php

header('Content-type: application/json');
include_once "../../bd/conexion.php";

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = $conexion->prepare('SELECT glpi_tickets.id as ticket, glpi_tickets.name as titulo,
        DATE_FORMAT(glpi_tickets.date, "%Y-%m-%d %r") as abierto, 
        DATE_FORMAT(glpi_tickets.closedate, "%Y-%m-%d %r") as cerrado,
        glpi_ticketsatisfactions.satisfaction as satisfaccion
        FROM '.nombre_bd.'.glpi_tickets
        INNER JOIN '.nombre_bd.'.glpi_ticketsatisfactions
        ON glpi_tickets.id = glpi_ticketsatisfactions.tickets_id');
$consulta->execute();
$ticketsTitulo = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($ticketsTitulo, array($fila["ticket"], $fila["titulo"], '', '', $fila["abierto"], $fila["cerrado"], $fila["satisfaccion"]));
}

$consulta = $conexion->prepare('SELECT glpi_tickets_users.tickets_id as ticket, concat(glpi_users.firstname, " ", glpi_users.realname, " (", glpi_users.name, ")") AS nombre
        FROM '.nombre_bd.'.glpi_tickets_users
        INNER JOIN '.nombre_bd.'.glpi_users
        ON glpi_tickets_users.users_id = glpi_users.id
        WHERE glpi_tickets_users.type = 1 order by ticket');
$consulta->execute();
$solicitantes = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($solicitantes, array($fila["ticket"], $fila["nombre"]));
}

$consulta = $conexion->prepare('SELECT glpi_tickets_users.tickets_id as ticket, concat(glpi_users.firstname, " ", glpi_users.realname, " (", glpi_users.name, ")") AS nombre
        FROM '.nombre_bd.'.glpi_tickets_users
        INNER JOIN '.nombre_bd.'.glpi_users
        ON glpi_tickets_users.users_id = glpi_users.id
        WHERE glpi_tickets_users.type = 2 order by ticket');
$consulta->execute();
$tecnicos = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($tecnicos, array($fila["ticket"], $fila["nombre"]));
}

for ($i=0; $i < count($ticketsTitulo); $i++) { 
    for ($j=0; $j < count($solicitantes); $j++) { 
        if($ticketsTitulo[$i][0] == $solicitantes[$j][0]){
            $ticketsTitulo[$i][2] = $solicitantes[$j][1]; 
            break;
        }
    }
    for ($j=0; $j < count($tecnicos); $j++) { 
        if($ticketsTitulo[$i][0] == $tecnicos[$j][0]){
            $ticketsTitulo[$i][3] = $tecnicos[$j][1]; 
            break;
        }
    }
}

$final = ["satisfaccion" => $ticketsTitulo];

print json_encode($final, JSON_NUMERIC_CHECK);

?>