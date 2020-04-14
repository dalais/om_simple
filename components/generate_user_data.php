<?php

require_once '../vendor/autoload.php';
require_once 'db_conn.php';

$faker = Faker\Factory::create('ru_RU');

if (!function_exists("get_or_create_city")) {
    /**
     * @param $faker
     * @param PDO $db_conn
     * @return int city_id
     */
    function get_or_create_city($faker, PDO $db_conn)
    {
        $city = $faker->city;
        // Get random city ID
        $sth = $db_conn->prepare("SELECT id FROM cities WHERE name=:city");
        $sth->execute(['city' => $city]);
        $citiCheck = $sth->fetch(PDO::FETCH_ASSOC);

        if ($citiCheck) {
            $city_id = $citiCheck['id'];
        } else {
            $sth = $db_conn->prepare("INSERT INTO cities (name) VALUES (:name)");
            $sth->execute(['name' => $city]);
            $city_id = $db_conn->lastInsertId();
        }

        return (int)$city_id;
    }


}


if (!function_exists("generate_user")) {
    /**
     * @param $faker
     * @param PDO $db_conn
     */
    function generate_user($faker, $db_conn)
    {
        $sth = $db_conn->prepare("SELECT id,name FROM cities WHERE id=:city_id");
        $sth->execute(['city_id' => get_or_create_city($faker, $db_conn)]);
        $city = $sth->fetch(PDO::FETCH_ASSOC);
        echo json_encode([
            'name' => $faker->name('male'),
            'city' => $city
        ]);
    }

}

try {

    generate_user($faker, $db_conn);

} catch (\Exception $e) {

    echo $e->getMessage();
}