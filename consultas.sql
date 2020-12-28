SELECT * FROM glpi_950.glpi_tickets;
-- Cantidad de casos en estado nuevo, asignado y en espera, agrupados por mes
SELECT month(date), count(id) FROM glpi_950.glpi_tickets WHERE status = 1 OR status = 2 OR status = 4 GROUP BY month(date);
-- Cantidad de casos en estado solucionado y cerrado
SELECT count(id) FROM glpi_950.glpi_tickets WHERE status = 5 OR status = 6 AND is_deleted = 0;
-- Mes y cantidad de casos, filtrado por año y agrupado por mes
SELECT month(date) as meses, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(date) = 2019 AND is_deleted = 0 group by month(date);
SELECT month(date) as meses, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(date) = 2020 AND is_deleted = 0 group by month(date);
-- Mes y cantidad de casos abiertos, filtrado por año y agrupado por mes
SELECT month(date) as abiertos, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(date) = 2020 group by abiertos;
-- Mes y cantidad de casos cerrados, filtrado por año y agrupado por mes
SELECT month(closedate) as cerrados, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(closedate) = 2020 group by cerrados;
-- Mes - año y cantidad de casos abiertos, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as casos FROM glpi_950.glpi_tickets 
group by mes 
order by year(date), month(date);
-- Muestra todos los meses
SELECT DATE_FORMAT(date, "%Y-%m") AS mes FROM glpi_950.glpi_tickets 
group by mes 
order by year(date), month(date);
-- Mes - año y cantidad de casos cerrados, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(closedate, "%M %Y") AS mes, count(id) as casos FROM glpi_950.glpi_tickets 
WHERE closedate is not null
group by mes 
order by year(closedate), month(closedate);
-- Mes - año y cantidad de casos tipo incidencias, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as incidencias FROM glpi_950.glpi_tickets 
WHERE type = 1 
group by mes 
order by year(date), month(date);
-- Mes - año y cantidad de casos tipo requerimientos, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as requerimientos FROM glpi_950.glpi_tickets 
WHERE type = 2
group by mes 
order by year(date), month(date);
-- Mes - año y cantidad de casos tipo problemas, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(glpi_tickets.date, "%M %Y") AS mes, count(glpi_tickets.id) as problemas 
FROM glpi_950.glpi_tickets
INNER JOIN glpi_problems_tickets
ON glpi_tickets.id = glpi_problems_tickets.tickets_id
group by mes
order by year(date), month(date);
-- Localización y cantidad de casos en los últimos 11 meses, ordenados por los 10 primeros con mas casos
SELECT glpi_locations.name AS localizacion, count(glpi_tickets.id) as casos 
FROM glpi_950.glpi_tickets 
INNER JOIN glpi_950.glpi_locations
ON glpi_tickets.locations_id = glpi_locations.id
WHERE date >= date_add(CONCAT(year(now()), "-", month(now()), "-", "01"), interval - 11 month)
group by localizacion
order by casos DESC
LIMIT 10;
-- Muestra la mas antigua y la fecha mas reciente de los casos creados
SELECT min(date) as masAntigua, max(date) as masReciente FROM glpi_950.glpi_tickets;
-- Muestra en formato (mes-año), la fecha mas antigua, la mas reciente y la fecha de hace 11 meses al mes actual, de los casos creados
SELECT DATE_FORMAT(min(date), "%Y-%m") as masAntigua, DATE_FORMAT(max(date), "%Y-%m") as masReciente, 
	DATE_FORMAT(date_add(now(), interval - 11 month), "%Y-%m") as haceAnno
FROM glpi_950.glpi_tickets;
