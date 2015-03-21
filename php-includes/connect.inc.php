<?php

$dbConnect = array(
    'server' => 'localhost',
    'user' => 'root',
    'pass' => 'w79Ha924iF',
    'name' => 'movies'
);

$db = new mysqli(
    $dbConnect['server'],
    $dbConnect['user'],
    $dbConnect['pass'],
    $dbConnect['name']
);

$pdo = new PDO( 'mysql:dbname='.$dbConnect["name"].';host=127.0.0.1', $dbConnect['user'], $dbConnect['pass'] );

if($pdo){
    
} else {
    echo "PDO diidnt work";
}


if ($db->connect_errno>0) {
    echo "Database connection error" . $db->connect_error;
    exit;
}

?>