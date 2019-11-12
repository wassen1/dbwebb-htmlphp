<?php
$dbUsers = connectToDatabase($dsnUsers);
    
$sql = <<<EOD
DROP TABLE IF EXISTS "users";
EOD;

$stmt = $dbUsers->prepare($sql);

executeDB($stmt);

    
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS "users" (
    "id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    "username"	TEXT UNIQUE,
    "name"      TEXT,
    "password"	TEXT
);
EOD;

$stmt = $dbUsers->prepare($sql);

executeDB($stmt);

$sql = <<<EOD
INSERT INTO "users" (username, name, password) VALUES(?, ?, ?);
EOD;

$stmt = $dbUsers->prepare($sql);
$paramCollection = [
    ['fredrik','Fredrik Wassermeyer', password_hash("fredrik", PASSWORD_DEFAULT)],
    ['admin','All Mighty Administrator', password_hash("admin", PASSWORD_DEFAULT)],
    ['doe','Doe Doe', password_hash("doe", PASSWORD_DEFAULT)]
];

foreach ($paramCollection as $params) {
    executeDB($stmt, $params);
}


$_SESSION["message"] = "Användar db har återskapats!";
header("Location: ?page=status");
