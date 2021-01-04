<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$meses = $conexion->prepare('SELECT DATE_FORMAT(date, "%Y-%m") AS mes1, DATE_FORMAT(date, "%M %Y") AS mes 
                                FROM '.nombre_bd.'.glpi_tickets
                                group by mes 
                                order by year(date), month(date)');
$meses->execute();
$rMeses = array();
$rMeses1 = array();
while ($fila = $meses->fetch(PDO::FETCH_ASSOC)){
    array_push($rMeses, array($fila["mes"]));
    array_push($rMeses1, array($fila["mes1"]));
}

$incidencias = $conexion->prepare('SELECT DATE_FORMAT(date, "%Y-%m") AS mes, count(id) as incidencias 
                                    FROM '.nombre_bd.'.glpi_tickets 
                                    WHERE type = 1 
                                    group by mes  
                                    order by year(date), month(date)');
$incidencias->execute();
$rIncidencias = array();
while ($fila = $incidencias->fetch(PDO::FETCH_ASSOC)){
    array_push($rIncidencias, array($fila["mes"], $fila["incidencias"]));
}

$requerimientos = $conexion->prepare('SELECT DATE_FORMAT(date, "%Y-%m") AS mes, count(id) as requerimientos 
                                    FROM '.nombre_bd.'.glpi_tickets
                                    WHERE type = 2 
                                    group by mes
                                    order by year(date), month(date)');
$requerimientos->execute();
$rRequerimientos = array();
while ($fila = $requerimientos->fetch(PDO::FETCH_ASSOC)){
    array_push($rRequerimientos, array($fila["mes"], $fila["requerimientos"]));
}

$problemas = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(glpi_tickets.id) as problemas 
                                    FROM '.nombre_bd.'.glpi_tickets
                                    INNER JOIN glpi_problems_tickets
                                    ON glpi_tickets.id = glpi_problems_tickets.tickets_id 
                                    group by mes
                                    order by year(date), month(date)');
$problemas->execute();
$rProblemas = array();
while ($fila = $problemas->fetch(PDO::FETCH_ASSOC)){
    array_push($rProblemas, array($fila["mes"], $fila["problemas"]));
}

$fIncidencias = array();
$fRequerimientos = array();
$fProblemas = array();

for ($i=0; $i < count($rMeses1); $i++) {

    $fIncidencias[$i][0] = $rMeses1[$i][0];
    $fRequerimientos[$i][0] = $rMeses1[$i][0];
    $fProblemas[$i][0] = $rMeses1[$i][0];

    for ($j=0; $j < count($rIncidencias); $j++) { 
        if($fIncidencias[$i][0] == $rIncidencias[$j][0]){
            $fIncidencias[$i][1] = $rIncidencias[$j][1];
            break;
        }else{
            $fIncidencias[$i][1] = 0;
        }
    }

    for ($j=0; $j < count($rRequerimientos); $j++) { 
        if($fRequerimientos[$i][0] == $rRequerimientos[$j][0]){
            $fRequerimientos[$i][1] = $rRequerimientos[$j][1];
            break;
        }else{
            $fRequerimientos[$i][1] = 0;
        }
    }

    for ($j=0; $j < count($rProblemas); $j++) { 
        if($fProblemas[$i][0] == $rProblemas[$j][0]){
            $fProblemas[$i][1] = $rProblemas[$j][1];
            break;
        }else{
            $fProblemas[$i][1] = 0;
        }
    }

}

$final = ["incidencias" => $fIncidencias, "requerimientos" => $fRequerimientos, "problemas" => $fProblemas, "meses" => $rMeses];

print json_encode($final, JSON_NUMERIC_CHECK);
