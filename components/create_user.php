<?php

require_once '../vendor/autoload.php';
require_once 'db_conn.php';


$faker = Faker\Factory::create('ru_RU');

if (!function_exists("create_or_get_city")) {
    /**
     * @param $faker
     * @param PDO $db_conn
     * @return int city_id
     */
    function create_or_get_city($faker, PDO $db_conn)
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

if (!function_exists("add_skills_for_created_user")) {

    /**
     * @param PDO $db_conn
     * @param $user_id
     */
    function add_skills_for_created_user(PDO $db_conn, $user_id)
    {
        // Get skills count
        $sth = $db_conn->prepare("SELECT * FROM skills");
        $sth->execute();
        $skillsCount = $sth->rowCount();

        // Get random limit for skills
        $limit = rand(0, $skillsCount);

        // Get skills randomly
        $sth = $db_conn->prepare("SELECT * FROM skills WHERE id IN 
    (SELECT id FROM (SELECT id FROM skills ORDER BY RAND() LIMIT ?) AS t)");
        $sth->execute([$limit]);


        $skills = $sth->fetchAll();

        // Add slills for new user
        foreach ($skills as $skill) {
            $sth = $db_conn->prepare("INSERT INTO users_skills (user_id, skill_id) VALUES (:user_id,:skill_id)");
            $sth->execute([
                'user_id' => $user_id,
                'skill_id' => $skill['id']
            ]);
        }
    }
}

if (!function_exists('create_user')) {
    /**
     * @param  $faker
     * @param PDO $db_conn
     */
    function create_user($faker, PDO $db_conn)
    {
        // Create user
        $city_id = create_or_get_city($faker, $db_conn);
        $sth = $db_conn->prepare("INSERT INTO users (name, city_id) VALUES (:name,:city_id)");
        $sth->execute([
            'name' => $faker->name('male'),
            'city_id' => $city_id
        ]);

        // add skills for new user
        add_skills_for_created_user($db_conn, (int)$db_conn->lastInsertId() /*created user ID*/);
    }
}


try {

    create_user($faker, $db_conn);

} catch (\Exception $e) {

    echo $e->getMessage();
}