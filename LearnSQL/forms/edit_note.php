<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>
    <link rel="stylesheet" href="../css/forms.css"/>
</head>

<?php
  require_once "../includes/dbh-inc.php"; 

  //Not secure as currently you could edit anybodies id
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
      $noteId = $_GET['id'];

      try {
          $stmt = $pdo->prepare("SELECT note_title, note_description FROM notes WHERE id = :noteId");
          $stmt->bindParam(':noteId', $noteId, PDO::PARAM_INT);
          $stmt->execute();
          
          $note = $stmt->fetch(PDO::FETCH_ASSOC);
          
          if ($note) {
              $noteTitle = htmlspecialchars($note['note_title']);
              $noteDescription = htmlspecialchars($note['note_description']);
          } else {
              echo "No note found";
              exit; 
          }
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          exit; 
      }
  } else {
      echo "Error";
      exit;
  }
?>

<body class="forms-body-styles">
    <h1 class="forms-header">Edit Note</h1>
    <form action="<?php echo '../includes/editNoteHandler-inc.php?id=' . $noteId; ?>" method="post">
        <input type="hidden" name="note_id" value="<?php echo $noteId; ?>">
        <label for="note_title">Title:</label>
        <input type="text" id="note_title" name="note_title" value="<?php echo $noteTitle; ?>" required><br><br>

        <label for="note_description">Description:</label>
        <textarea id="note_description" name="note_description" required><?php echo $noteDescription; ?></textarea><br><br>

        <button type="submit">Update Note</button>
    </form>
</body>

</html>