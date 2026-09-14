<?php

/* Load .env file */
$env_file = __DIR__ . "/.env";

if (file_exists($env_file)) {

    $lines = file(
        $env_file,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

    foreach ($lines as $line) {

        $line = trim($line);

        if ($line === "" || str_starts_with($line, "#")) {
            continue;
        }

        $parts = explode("=", $line, 2);

        if (count($parts) === 2) {

            $key = trim($parts[0]);
            $value = trim($parts[1]);

            $_ENV[$key] = $value;
        }
    }
}


/* Database configuration */
$host = $_ENV["DB_HOST"] ?? "localhost";
$port = $_ENV["DB_PORT"] ?? "3306";
$username = $_ENV["DB_USER"] ?? "root";
$password = $_ENV["DB_PASS"] ?? "";
$database = $_ENV["DB_NAME"] ?? "adelaide_bakery";


/* Connect to MySQL */
$conn = new mysqli(
    $host,
    $username,
    $password,
    $database,
    $port
);


if ($conn->connect_error) {

    die("Database connection failed.");

}

$conn->set_charset("utf8mb4");

?>