<?php

require_once '../vendor/autoload.php';
require_once 'db_conn.php';

// All users with city name and skills names
$sql = "SELECT u.id,u.name,u.city_id,s.name AS city, GROUP_CONCAT(sk.name) AS skills
FROM users AS u
LEFT JOIN cities AS s ON u.city_id = s.id
LEFT JOIN users_skills AS us ON u.id = us.user_id
LEFT JOIN skills AS sk ON us.skill_id = sk.id
GROUP BY u.id";
$sth = $db_conn->prepare($sql);
$sth->execute();

$users = $sth->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);