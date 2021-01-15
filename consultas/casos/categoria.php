<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = $conexion->prepare('SELECT completename as nombre FROM '.nombre_bd.'.glpi_itilcategories');
$consulta->execute();
$nombreCategoria = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($nombreCategoria, array($fila["nombre"]));
}

$categoria = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.id as id, 
                                    glpi_itilcategories.completename AS categoria
                                    FROM '.nombre_bd.'.glpi_tickets
                                    INNER JOIN '.nombre_bd.'.glpi_itilcategories
                                    ON glpi_tickets.itilcategories_id = glpi_itilcategories.id
                                    INNER JOIN '.nombre_bd.'.glpi_slas
                                    ON glpi_tickets.slas_id_ttr = glpi_slas.id
                                    WHERE glpi_tickets.is_deleted = 0');
$categoria->execute();
$rCategoria = array();
while ($fila = $categoria->fetch(PDO::FETCH_ASSOC)){
    array_push($rCategoria, array($fila["mes"], $fila["id"], $fila["categoria"]));
}

$final = ["dataCategoria" => $rCategoria, "Categoria" => $nombreCategoria];

print json_encode($final, JSON_NUMERIC_CHECK);