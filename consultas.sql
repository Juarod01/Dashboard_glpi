SELECT * FROM glpi_950.glpi_tickets where id = 2772;
SELECT count(id) FROM glpi_950.glpi_tickets where status = 2 OR status = 1 AND is_deleted = 0;
SELECT * FROM glpi_950.glpi_tickets where status = 2 OR status = 1;
SELECT count(id) FROM glpi_950.glpi_tickets WHERE year(date) = 2020 AND month(date) = 8 AND status = 6 AND is_deleted = 0;

SELECT month(date) as meses, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(date) = 2019 AND is_deleted = 0 group by month(date);
SELECT month(date) as meses, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(date) = 2020 AND is_deleted = 0 group by month(date);
SELECT year(date) as annos FROM glpi_950.glpi_tickets WHERE is_deleted = 0 group by year(date);

SELECT month(date), count(id) FROM glpi_950.glpi_tickets WHERE status = 1 OR status = 2 OR status = 4 GROUP BY month(date);

SELECT month(date) as abiertos, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(date) = 2020 group by abiertos;
SELECT month(closedate) as cerrados, count(id) as casos FROM glpi_950.glpi_tickets WHERE year(closedate) = 2020 group by cerrados;

SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as casos FROM glpi_950.glpi_tickets 
WHERE date >= date_add(CONCAT(year(now()), "-", month(now()), "-", "01"), interval - 11 month) group by mes 
order by year(date), month(date);

SELECT DATE_FORMAT(closedate, "%M %Y") AS mes, count(id) as casos FROM glpi_950.glpi_tickets 
WHERE closedate >= date_add(CONCAT(year(now()), "-", month(now()), "-", "01"), interval - 11 month) group by mes 
order by year(closedate), month(closedate);

SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as casos FROM glpi_950.glpi_tickets 
WHERE date >= date_add(CONCAT(year(now()), "-", month(now()), "-", "01"), interval - 11 month) AND type = 1 
group by mes 
order by year(date), month(date);

SELECT DATE_FORMAT(date, "%M %Y") AS mes, count(id) as casos FROM glpi_950.glpi_tickets 
WHERE date >= date_add(CONCAT(year(now()), "-", month(now()), "-", "01"), interval - 11 month) AND type = 2
group by mes 
order by year(date), month(date);

SELECT DATE_FORMAT(glpi_tickets.date, "%M %Y") AS mes, count(glpi_tickets.id) as casos FROM glpi_950.glpi_tickets
INNER JOIN glpi_problems_tickets
ON glpi_tickets.id = glpi_problems_tickets.tickets_id
group by mes
order by year(date), month(date);

