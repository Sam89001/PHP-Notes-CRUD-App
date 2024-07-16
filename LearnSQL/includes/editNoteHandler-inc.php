<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $noteId = $_GET['id'];
    $noteTitle = $_POST["note_title"];
    $noteDescription = $_POST["note_description"];

    try {
        require_once "dbh-inc.php";

        //Sanitise the data only on output for best practices.
        $query = "UPDATE notes SET note_title = :noteTitle, note_description = :noteDescription WHERE id = :noteId";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":noteTitle", $noteTitle);
        $stmt->bindParam(":noteDescription", $noteDescription);
        $stmt->bindParam(":noteId", $noteId, PDO::PARAM_INT);
        $stmt->execute(); 
        
        //Manually close the statement to free up resources
        $pdo = null;
        $stmt = null;

        //Redirect 
        header("Location: ../index.php");
        die();

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

} else {
    // Redirect 
    header("Location: ../index.php");
    die();
}
?>
