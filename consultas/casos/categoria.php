<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$categoria = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.id as id, 
                                    glpi_itilcategories.completename AS categoria
                                    FROM '.nombre_bd.'.glpi_tickets
                                    INNER JOIN '.nombre_bd.'.glpi_itilcategories
                                    ON glpi_tickets.itilcategories_id = glpi_itilcategories.id
                                    WHERE glpi_tickets.is_deleted = 0');
$categoria->execute();
$rCategoria = array();
while ($fila = $categoria->fetch(PDO::FETCH_ASSOC)){
    array_push($rCategoria, array($fila["mes"], $fila["id"], $fila["categoria"]));
}

$final = ["dataCategoria" => $rCategoria];

print json_encode($final, JSON_NUMERIC_CHECK);