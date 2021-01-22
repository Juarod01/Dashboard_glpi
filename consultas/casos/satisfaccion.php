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

$satisfaccion = $conexion->prepare('SELECT DATE_FORMAT(date_answered, "%Y-%m") AS mes, ROUND((100*AVG(satisfaction))/5,2) as promedio 
                                    FROM '.nombre_bd.'.glpi_ticketsatisfactions
                                    WHERE satisfaction is not null
                                    group by mes  
                                    order by year(date_answered), month(date_answered)');
$satisfaccion->execute();
$rSatisfaccion = array();
while ($fila = $satisfaccion->fetch(PDO::FETCH_ASSOC)){
    array_push($rSatisfaccion, array($fila["mes"], $fila["promedio"]));
}

$fSatisfaccion = array();

for ($i=0; $i < count($rMeses1); $i++) {

    $fSatisfaccion[$i][0] = $rMeses1[$i][0];

    for ($j=0; $j < count($rSatisfaccion); $j++) { 
        if($fSatisfaccion[$i][0] == $rSatisfaccion[$j][0]){
            $fSatisfaccion[$i][1] = $rSatisfaccion[$j][1];
            break;
        }else{
            $fSatisfaccion[$i][1] = 0;
        }
    }

}

$final = ["promedio" => $fSatisfaccion, "meses" => $rMeses];

print json_encode($final, JSON_NUMERIC_CHECK);