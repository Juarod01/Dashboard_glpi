<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombreTecnico = $conexion->prepare('SELECT concat(glpi_users.firstname, " ", glpi_users.realname, " (", glpi_users.name, ")") AS nombre
                                            FROM '.nombre_bd.'.glpi_tickets 
                                            INNER JOIN '.nombre_bd.'.glpi_tickets_users
                                            ON glpi_tickets.id = glpi_tickets_users.tickets_id
                                            INNER JOIN '.nombre_bd.'.glpi_users
                                            ON glpi_tickets_users.users_id = glpi_users.id
                                            WHERE glpi_tickets_users.type = 2 AND glpi_tickets.is_deleted = 0
                                            group by nombre');
$nombreTecnico->execute();
$tecnico = array();
while ($fila = $nombreTecnico->fetch(PDO::FETCH_ASSOC)){
    array_push($tecnico, array($fila["nombre"]));
}

$casosTecnicos = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, concat(glpi_users.firstname, " ", glpi_users.realname, " (", glpi_users.name, ")") AS nombre, count(glpi_tickets.id) as casos
                                    FROM '.nombre_bd.'.glpi_tickets 
                                    INNER JOIN '.nombre_bd.'.glpi_tickets_users
                                    ON glpi_tickets.id = glpi_tickets_users.tickets_id
                                    INNER JOIN '.nombre_bd.'.glpi_users
                                    ON glpi_tickets_users.users_id = glpi_users.id
                                    WHERE glpi_tickets_users.type = 2 AND glpi_tickets.is_deleted = 0
                                    group by mes, nombre
                                    order by mes ASC');
$casosTecnicos->execute();
$numCasosTecnicos = array();
while ($fila = $casosTecnicos->fetch(PDO::FETCH_ASSOC)){
    array_push($numCasosTecnicos, array($fila["mes"], $fila["nombre"], $fila["casos"]));
}

$final = ["casosTecnicos" => $numCasosTecnicos, "tecnico" => $tecnico];

print json_encode($final, JSON_NUMERIC_CHECK);