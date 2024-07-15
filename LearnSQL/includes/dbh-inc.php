<?php

//Information about the database: provider, host name and database name.

$dsn = "mysql:host=localhost;dbname=learnsqldatabase";
$dbusername = "root";
$dbpassword = "";

try {
  //transforms x into object
  $pdo = new PDO($dsn, $dbusername, $dbpassword);
  //if you encounter an error, run an exception. This allows try/catch to work.
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection Failed: " . $e->getMessage();
}