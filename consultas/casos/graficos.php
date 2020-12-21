<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = $conexion->prepare('SELECT year(date) as annos FROM glpi_950.glpi_tickets WHERE is_deleted = 0 group by year(date)');
$consulta->execute();
$annos=$consulta->fetchAll(PDO::FETCH_COLUMN, 0);

$data = array();
for($i=0; $i<count($annos); $i++){
    
    $result = array();
    $consulta = $conexion->prepare('SELECT month(date) as meses, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(date) = :anno AND is_deleted = 0 group by month(date);');
    $consulta->bindValue(':anno', $annos[$i]);
    $consulta->execute();
    
    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
        array_push($result, array($fila["meses"], $fila["casos"]));
    }
    array_push($data, $result);
}

$final = array();

array_push($final, array("annos" => $annos), array("data" => $data));

print json_encode($final, JSON_NUMERIC_CHECK);
$conexion=null;