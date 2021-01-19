<?php
header('Content-type: application/json');
include_once "../../bd/conexion.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombreLocalizacion = $conexion->prepare('SELECT distinct(name) as nombre FROM '.nombre_bd.'.glpi_locations');
$nombreLocalizacion->execute();
$areas = array();
while ($fila = $nombreLocalizacion->fetch(PDO::FETCH_ASSOC)){
    array_push($areas, array('name'=>$fila["nombre"]));
}

$localizacion = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_locations.name AS localizacion, count(glpi_tickets.id) as casos
                                    FROM '.nombre_bd.'.glpi_tickets
                                    INNER JOIN '.nombre_bd.'.glpi_locations
                                    ON glpi_tickets.locations_id = glpi_locations.id
                                    WHERE glpi_tickets.is_deleted = 0
                                    group by mes, localizacion
                                    order by casos DESC');
$localizacion->execute();
$rLocalizacion = array();
while ($fila = $localizacion->fetch(PDO::FETCH_ASSOC)){
    array_push($rLocalizacion, array('fecha'=> $fila["mes"], 'localizacion'=>$fila["localizacion"], 'casos'=>$fila["casos"]));
}

$localizacion_categoria = $conexion->prepare('SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_locations.name AS localizacion,
                                    glpi_itilcategories.completename AS categoria, count(glpi_tickets.id) as casos
                                    FROM '.nombre_bd.'.glpi_tickets
                                    INNER JOIN '.nombre_bd.'.glpi_locations
                                    ON glpi_tickets.locations_id = glpi_locations.id
                                    INNER JOIN glpi_953.glpi_itilcategories
                                    ON glpi_tickets.itilcategories_id = glpi_itilcategories.id
                                    WHERE glpi_tickets.is_deleted = 0
                                    group by mes, localizacion, categoria
                                    order by mes DESC');
$localizacion_categoria->execute();
$rLocalizacionCategoria = array();
while ($fila = $localizacion_categoria->fetch(PDO::FETCH_ASSOC)){
    array_push($rLocalizacionCategoria, array('fecha'=> $fila["mes"], 'localizacion'=>$fila["localizacion"], 'categoria'=>$fila["categoria"], 'casos'=>$fila["casos"]));
}

$final = ["localizacion" => $rLocalizacion, "areas" => $areas, "localizacionCategoria" => $rLocalizacionCategoria];

print json_encode($final, JSON_NUMERIC_CHECK);