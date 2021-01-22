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

$consulta = $conexion->prepare('SELECT glpi_tickets.date AS mes, glpi_tickets.id as id,
        glpi_itilcategories.completename AS categoria, 
        glpi_slas.name as name_sla,
        glpi_slas.number_time as time_sla,
        timestampdiff(HOUR, glpi_tickets.date, glpi_tickets.solvedate) as time_solved,
        if(glpi_slas.number_time > timestampdiff(HOUR, glpi_tickets.date, glpi_tickets.solvedate), "cumple", "no cumple") as criterio,
        glpi_tickets.status as status
        FROM '.nombre_bd.'.glpi_tickets
        INNER JOIN '.nombre_bd.'.glpi_itilcategories
        ON glpi_tickets.itilcategories_id = glpi_itilcategories.id
        INNER JOIN '.nombre_bd.'.glpi_slas
        ON glpi_tickets.slas_id_ttr = glpi_slas.id
        WHERE glpi_tickets.is_deleted = 0 AND glpi_tickets.type = 1');
$consulta->execute();
$categoriaSla = array();
while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    array_push($categoriaSla, array($fila["mes"], 
        $fila["id"], $fila["categoria"], $fila["name_sla"], $fila["time_sla"], 
        $fila["time_solved"], $fila["criterio"], $fila["status"]));
}

for ($i=0; $i < count($categoriaSla); $i++) { 
    if($categoriaSla[$i][7] == 1){
        $categoriaSla[$i][7] = "Nuevo";
    }
    else if($categoriaSla[$i][7] == 2){
        $categoriaSla[$i][7] = "Asignado";
    }
    else if($categoriaSla[$i][7] == 4){
        $categoriaSla[$i][7] = "En espera";
    }
    else if($categoriaSla[$i][7] == 5){
        $categoriaSla[$i][7] = "Solucionado";
    }
    else if($categoriaSla[$i][7] == 6){
        $categoriaSla[$i][7] = "Cerrado";
    }
}

$final = ["dataCategoria" => $categoriaSla,  "Categoria" => $nombreCategoria];

print json_encode($final, JSON_NUMERIC_CHECK);

?>