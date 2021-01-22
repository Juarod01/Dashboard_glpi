<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$meses = $conexion->prepare('SELECT DATE_FORMAT(date, "%Y-%m") AS mes1, DATE_FORMAT(date, "%M %Y") AS mes 
                                FROM '.nombre_bd.'.glpi_tickets
                                WHERE is_deleted = 0
                                group by mes 
                                order by year(date), month(date)');
$meses->execute();
$rMeses = array();
$rMeses1 = array();
while ($fila = $meses->fetch(PDO::FETCH_ASSOC)){
    array_push($rMeses, array($fila["mes"]));
    array_push($rMeses1, array($fila["mes1"]));
}

$abiertos = $conexion->prepare('SELECT DATE_FORMAT(date, "%Y-%m") AS abiertos, count(id) as casos 
                                    FROM '.nombre_bd.'.glpi_tickets 
                                    WHERE is_deleted = 0
                                    group by abiertos  
                                    order by year(date), month(date)');
$abiertos->execute();
$rAbiertos = array();
while ($fila = $abiertos->fetch(PDO::FETCH_ASSOC)){
    array_push($rAbiertos, array($fila["abiertos"], $fila["casos"]));
}

$cerrados = $conexion->prepare('SELECT DATE_FORMAT(closedate, "%Y-%m") AS cerrados, count(id) as casos FROM '.nombre_bd.'.glpi_tickets
                                    WHERE closedate is not null AND is_deleted = 0
                                    group by cerrados
                                    order by year(closedate), month(closedate)');
$cerrados->execute();
$rCerrados = array();
while ($fila = $cerrados->fetch(PDO::FETCH_ASSOC)){
    array_push($rCerrados, array($fila["cerrados"], $fila["casos"]));
}

$fAbiertos = array();
$fCerrados = array();

for ($i=0; $i < count($rMeses1); $i++) {

    $fAbiertos[$i][0] = $rMeses1[$i][0];
    $fCerrados[$i][0] = $rMeses1[$i][0];

    for ($j=0; $j < count($rAbiertos); $j++) { 
        if($fAbiertos[$i][0] == $rAbiertos[$j][0]){
            $fAbiertos[$i][1] = $rAbiertos[$j][1];
            break;
        }else{
            $fAbiertos[$i][1] = 0;
        }
    }

    for ($j=0; $j < count($rCerrados); $j++) { 
        if($fCerrados[$i][0] == $rCerrados[$j][0]){
            $fCerrados[$i][1] = $rCerrados[$j][1];
            break;
        }else{
            $fCerrados[$i][1] = 0;
        }
    }

}

$final = ["abiertos" => $fAbiertos, "cerrados" => $fCerrados, "meses" => $rMeses];

print json_encode($final, JSON_NUMERIC_CHECK);