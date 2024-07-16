<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["note_id"])) {
        $noteId = $_POST["note_id"];

        try {
            require_once "dbh-inc.php";

            // SQL to delete
            $query = "DELETE FROM notes WHERE id = :noteId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":noteId", $noteId, PDO::PARAM_INT);
            $stmt->execute();

            $pdo = null;
            $stmt = null;
            header("Location: ../index.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    } else {
        echo "Error";
        exit();
    }
} else {
    // Redirect
    header("Location: ../index.php");
    exit();
}
?>
