<?php
include 'db.php';

// Initialize $message_erreur
$message_erreur = "";

if (isset($_POST['add'])) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $annee_publication = $_POST['annee_publication'];
    $statut = isset($_POST['statut']) ? 1 : 0;

    // Automatically set the rating to 1 if the book is unread
    $note = $statut ? $_POST['note'] : 1;

    // Validate year of publication
    if ($annee_publication > date('Y')) {
        $message_erreur = "Publication year cannot be greater than the current year.";
    } else {
        $sql = "INSERT INTO Livres (titre, auteur, annee_publication, statut, note) 
                VALUES ('$titre', '$auteur', $annee_publication, $statut, $note)";

        if ($conn->query($sql) === TRUE) {
            // Redirect after successful insertion
            echo "New book added successfully!";
            header("Location: index.php");
            exit(); // Make sure to stop script execution after redirect
        } else {
            $message_erreur = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css" />
    <title>Library Management</title>
    <link rel="icon" href="img/stack-of-books.png" type="image/x-icon" />
</head>
<body>
    <div class="titre">
        <img width=50 src="img/stack-of-books.png" alt="bookimg">
        <h2>Library Collection</h2>

    </div>
    
    <div class="add">
    <h3 class="titreadd">Add a New Book</h3>
    
    <form method="POST" action="">
    
        <label>Title:</label><br>
        <input type="text" name="titre" required><br>

        <label>Author:</label><br>
        <input type="text" name="auteur" required><br>

        <label>Year of Publication:</label><br>
        <input type="number" name="annee_publication" required><br>

        <label>Status (Read/Unread):</label><br>
        <input type="checkbox" id="statut" name="statut"><br>

        <label>Rating (1-5):</label><br>
        <input type="number" id='rating' name="note" min="1" max="5" required><br><br>

        <button class="submit" type="submit" name="add">Add Book</button>
    </form>

    </div>
    
    
    <div class="erreur">
        <?php echo $message_erreur; ?>
    </div>

    <table cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Year of Publication</th>
                <th>Status</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Fetch and display books from the database
            $sql = "SELECT * FROM Livres";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['titre']}</td>
                        <td>{$row['auteur']}</td>
                        <td>{$row['annee_publication']}</td>
                        <td>" . ($row['statut'] ? 'Read' : 'Unread') . "</td>
                        <td>{$row['note']}</td>
                        <td>
                        <button class='button edit'><a href='edit.php?id={$row['id']}'>Edit</a></button>
                             |
                           <button class='button delete'> <a  href='delete.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\");'>Delete</a></button>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No books found</td></tr>";
            }
        ?>
        </tbody>
    </table>
</body>
</html>
