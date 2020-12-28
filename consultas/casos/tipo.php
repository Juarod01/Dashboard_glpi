<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$meses = $conexion->prepare('SELECT DATE_FORMAT(date, "%M %Y") AS mes FROM glpi_950.glpi_tickets
                                group by mes 
                                order by year(date), month(date)');
$meses->execute();
$result3 = array();
while ($fila = $meses->fetch(PDO::FETCH_ASSOC)){
    array_push($result3, array($fila["mes"]));
}

$incidencias = $conexion->prepare('SELECT DATE_FORMAT(date, "%Y-%m") AS mes, count(id) as incidencias 
                                    FROM glpi_950.glpi_tickets 
                                    WHERE type = 1 
                                    group by mes  
                                    order by year(date), month(date)');
$incidencias->execute();
$result = array();
while ($fila = $incidencias->fetch(PDO::FETCH_ASSOC)){
    array_push($result, array($fila["mes"], $fila["incidencias"]));
}

$requerimientos = $conexion->prepare('SELECT DATE_FORMAT(date, "%Y-%m") AS mes, count(id) as requerimientos 
                                    FROM glpi_950.glpi_tickets
                                    WHERE type = 2 
                                    group by mes
                                    order by year(date), month(date)');
$requerimientos->execute();
$result1 = array();
while ($fila = $requerimientos->fetch(PDO::FETCH_ASSOC)){
    array_push($result1, array($fila["mes"], $fila["requerimientos"]));
}

$problemas = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(glpi_tickets.id) as problemas 
                                    FROM glpi_950.glpi_tickets
                                    INNER JOIN glpi_problems_tickets
                                    ON glpi_tickets.id = glpi_problems_tickets.tickets_id 
                                    group by mes
                                    order by year(date), month(date)');
$problemas->execute();
$result2 = array();
while ($fila = $problemas->fetch(PDO::FETCH_ASSOC)){
    array_push($result2, array($fila["mes"], $fila["problemas"]));
}

$problema_p = array();
for ($i=0; $i < count($result); $i++) {
    $problema_p[$i][0] = $result[$i][0];
    for ($j=0; $j < count($result2); $j++) { 
        if($problema_p[$i][0] == $result2[$j][0]){
            $problema_p[$i][1] = $result2[$j][1];
            break;
        }else{
            $problema_p[$i][1] = 0;
        }
    }
}

$final = ["incidencias" => $result, "requerimientos" => $result1, "problemas" => $problema_p, "meses" => $result3];

print json_encode($final, JSON_NUMERIC_CHECK);
