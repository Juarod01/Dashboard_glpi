SELECT * FROM glpi_953.glpi_tickets;
-- Cantidad de casos en estado nuevo, asignado y en espera, agrupados por mes
SELECT month(date), count(id) FROM glpi_953.glpi_tickets WHERE status = 1 OR status = 2 OR status = 4 GROUP BY month(date);
-- Cantidad de casos en estado solucionado y cerrado
SELECT count(id) FROM glpi_953.glpi_tickets WHERE status = 5 OR status = 6 AND is_deleted = 0;
-- Mes y cantidad de casos, filtrado por año y agrupado por mes
SELECT month(date) as meses, count(id) as casos FROM glpi_953.glpi_tickets WHERE year(date) = 2019 AND is_deleted = 0 group by month(date);
SELECT month(date) as meses, count(id) as casos FROM glpi_953.glpi_tickets WHERE year(date) = 2020 AND is_deleted = 0 group by month(date);
-- Mes y cantidad de casos abiertos, filtrado por año y agrupado por mes
SELECT month(date) as abiertos, count(id) as casos FROM glpi_953.glpi_tickets WHERE year(date) = 2020 group by abiertos;
-- Mes y cantidad de casos cerrados, filtrado por año y agrupado por mes
SELECT month(closedate) as cerrados, count(id) as casos FROM glpi_953.glpi_tickets WHERE year(closedate) = 2020 group by cerrados;
-- para tickets del mes
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
FROM glpi_953.glpi_tickets
where is_deleted = 0
group by mes;
-- para tickets del mes, estado en espera
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
FROM glpi_953.glpi_tickets
where status = 4 and is_deleted = 0
group by mes;
-- para tickets del mes, con estados nuevos y asignados
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
FROM glpi_953.glpi_tickets
where status = 2 OR status = 1 AND is_deleted = 0
group by mes;
-- para tickets del mes, estado resueltos
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
FROM glpi_953.glpi_tickets
where status = 5 and is_deleted = 0
group by mes;
-- para tickets del mes, estado cerrados
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, count(id) as casos 
FROM glpi_953.glpi_tickets
where status = 6 and is_deleted = 0
group by mes;
-- Mes - año y cantidad de casos abiertos, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as casos FROM glpi_953.glpi_tickets 
group by mes 
order by year(date), month(date);
-- Muestra todos los meses
SELECT DATE_FORMAT(date, "%M %Y") AS mes1, DATE_FORMAT(date, "%Y-%m") AS mes FROM glpi_953.glpi_tickets 
group by mes 
order by year(date), month(date);
-- Mes - año y cantidad de casos cerrados, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(closedate, "%M %Y") AS mes, count(id) as casos FROM glpi_953.glpi_tickets 
WHERE closedate is not null
group by mes 
order by year(closedate), month(closedate);
-- Mes - año y cantidad de casos tipo incidencias, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as incidencias FROM glpi_953.glpi_tickets 
WHERE type = 1 
group by mes 
order by year(date), month(date);
-- Mes - año y cantidad de casos tipo requerimientos, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as requerimientos FROM glpi_953.glpi_tickets 
WHERE type = 2
group by mes 
order by year(date), month(date);
-- Mes - año y cantidad de casos tipo problemas, agrupado por mes y ordenados por año y mes
SELECT DATE_FORMAT(glpi_tickets.date, "%M %Y") AS mes, count(glpi_tickets.id) as problemas 
FROM glpi_953.glpi_tickets
INNER JOIN glpi_problems_tickets
ON glpi_tickets.id = glpi_problems_tickets.tickets_id
group by mes
order by year(date), month(date);
-- Muestra la mas antigua y la fecha mas reciente de los casos creados
SELECT min(date) as masAntigua, max(date) as masReciente FROM glpi_953.glpi_tickets;
-- Muestra en formato (mes-año), la fecha mas antigua, la mas reciente y la fecha de hace 11 meses al mes actual, de los casos creados
SELECT DATE_FORMAT(min(date), "%Y-%m") as masAntigua, DATE_FORMAT(max(date), "%Y-%m") as masReciente, 
	DATE_FORMAT(date_add(now(), interval - 11 month), "%Y-%m") as haceAnno
FROM glpi_953.glpi_tickets;
-- Satisfaccion agrupada por meses
SELECT DATE_FORMAT(date_answered, "%Y-%m") AS mes, ROUND((100*AVG(satisfaction))/5,2) as promedio 
FROM glpi_953.glpi_ticketsatisfactions
WHERE satisfaction is not null
group by mes 
order by year(date_answered), month(date_answered);
-- satisfaccion total
SELECT ROUND((100*AVG(satisfaction))/5,2) as promedio 
FROM glpi_953.glpi_ticketsatisfactions
WHERE satisfaction is not null;
-- Cantidad de casos por localización, agrupado por mes
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_locations.name AS localizacion, count(glpi_tickets.id) as casos 
FROM glpi_953.glpi_tickets 
INNER JOIN glpi_953.glpi_locations
ON glpi_tickets.locations_id = glpi_locations.id
WHERE glpi_tickets.is_deleted = 0
group by mes, localizacion
order by casos DESC;
-- Cantidad de casos por localización-categoria, agrupado por mes
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_locations.name AS localizacion,
	glpi_itilcategories.completename AS categoria, count(glpi_tickets.id) as casos 
FROM glpi_953.glpi_tickets
INNER JOIN glpi_953.glpi_locations
ON glpi_tickets.locations_id = glpi_locations.id
INNER JOIN glpi_953.glpi_itilcategories
ON glpi_tickets.itilcategories_id = glpi_itilcategories.id
WHERE glpi_tickets.is_deleted = 0 
group by mes, localizacion, categoria
order by mes DESC;
-- Cantidad de casos por técnico, agrupado por mes
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, concat(glpi_users.firstname, " ", glpi_users.realname, " (", glpi_users.name, ")") AS nombre, count(glpi_tickets.id) as casos 
FROM glpi_953.glpi_tickets 
INNER JOIN glpi_953.glpi_tickets_users
ON glpi_tickets.id = glpi_tickets_users.tickets_id
INNER JOIN glpi_953.glpi_users
ON glpi_tickets_users.users_id = glpi_users.id
WHERE glpi_tickets_users.type = 2 AND glpi_tickets.is_deleted = 0
group by mes, nombre
order by mes ASC;
-- Muestra solo técnicos y admin
SELECT concat(glpi_users.firstname, " ", glpi_users.realname, " (", glpi_users.name, ")") AS nombre
FROM glpi_953.glpi_tickets 
INNER JOIN glpi_953.glpi_tickets_users
ON glpi_tickets.id = glpi_tickets_users.tickets_id
INNER JOIN glpi_953.glpi_users
ON glpi_tickets_users.users_id = glpi_users.id
WHERE glpi_tickets_users.type = 2 AND glpi_tickets.is_deleted = 0
group by nombre;
-- Muestra por cada caso la categoria a la que pertenece, el nombre del sla, y si lo cumple o no
SELECT DATE_FORMAT(glpi_tickets.date, "%Y-%m") AS mes, glpi_tickets.id as id, 
	glpi_itilcategories.completename AS categoria, 
    glpi_slas.name as name_sla,
    if(glpi_slas.number_time > timestampdiff(HOUR, glpi_tickets.date, glpi_tickets.solvedate), "cumple", "no cumple") as time_solved
FROM glpi_953.glpi_tickets
INNER JOIN glpi_953.glpi_itilcategories
ON glpi_tickets.itilcategories_id = glpi_itilcategories.id
INNER JOIN glpi_slas
ON glpi_tickets.slas_id_ttr = glpi_slas.id
WHERE glpi_tickets.is_deleted = 0 AND glpi_slas.name = "Análisis Requerimiento"
	AND year(glpi_tickets.date) = "2020" AND month(glpi_tickets.date) >= 1
    AND glpi_tickets.type = 1;