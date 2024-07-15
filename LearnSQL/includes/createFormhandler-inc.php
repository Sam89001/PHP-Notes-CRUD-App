<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $noteTitle = $_POST["note_title"];
  $noteDescription = $_POST["note_description"];

  try {
    require_once "dbh-inc.php";

    //Sanitise the data only on output for best practices.
    $query = "INSERT INTO notes (note_title, note_description) VALUES (:noteTitle, :noteDescription);";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":noteTitle" , $noteTitle);
    $stmt->bindParam(":noteDescription" , $noteDescription);
    $stmt->execute(); 
    
    //Manually close the statement to free up resources
    $pdo = null;
    $stmt = null;

    //Die>Exit because we have a connection string and using a header.
    header("Location: ../index.php");
    die();

  } catch (PDOException $e) {
    die("Error: " . $e->getMessage());
  }

} else {
  //redirect
  header("Location: ../index.php");
}