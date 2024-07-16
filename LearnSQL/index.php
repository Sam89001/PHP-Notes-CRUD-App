<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learn SQL</title>
  <link rel="stylesheet" href="css/main.css"/> 
</head>

<body class="body-styles">

  <!-- GET request into an object, the looped later -->
  <?php 

    class Note {
      public $id;
      public $note_title;
      public $note_description;
  
      // Constructor to initialize properties
      public function __construct($id, $note_title, $note_description) {
          $this->id = $id;
          $this->note_title = $note_title;
          $this->note_description = $note_description;
      }
    }

    try {
      require_once "includes/dbh-inc.php";

      $pdo = new PDO($dsn, $dbusername, $dbpassword);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      // Get from the database
      $stmt = $pdo->prepare("SELECT id, note_title, note_description FROM notes");
      $stmt->execute();
  
      // Fetch all rows
      $notesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      // Map data to object
      $notes = [];
      foreach ($notesData as $noteData) {
          $note = new Note(
              $noteData['id'],
              $noteData['note_title'],
              $noteData['note_description']
          );
          $notes[] = $note;
      }

      //Manually close the statement to free up resources
      $pdo = null;
      $stmt = null;
  
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } 

  ?>

  <h1>PHP Notes CRUD App</h1>

  <div class="button-container" >
    <a href="forms/create_note.php" class="button-styles">Create Note</a>
  </div>

  <div class="notes-container">
    <div class="notes-grid">

      <!-- For Each for the notes -->
      <?php
        foreach ($notes as $note) {
            echo '<div class="note-styles" id="note-' . $note->id . '">';
              echo '<div class="note-content">';
                echo '<div style="padding-bottom: 5px;">' . htmlspecialchars($note->note_title) . '</div>';
                echo '<div style="padding-bottom: 5px;">' . htmlspecialchars($note->note_description) . '</div>';
                echo '<div style="display: flex; flex-direction: row;">';
                  echo '<a style=" border-right: solid 1px black; padding-right: 5px;" href="forms/edit_note.php?id=' . $note->id . '">Update</a>';

                  echo '<form action="includes/deleteNoteHandler-inc.php" method="post">';
                    echo '<input type="hidden" name="note_id" value="' . $note->id . '">';
                    echo '<button 
                            type="submit" 
                            onclick="return confirm(\'Are you sure you want to delete?\')"
                            style="display: inline-block; border: none; background-color: transparent; text-decoration: underline; cursor: pointer;"
                          >Delete
                          </button>';
                  echo '</form>';

                echo '</div>'; 
              echo '</div>'; 
            echo '</div>'; 
        }
      ?>


    </div>
  </div>

  
  
</body>

</html>