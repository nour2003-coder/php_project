<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM Livres WHERE id = $id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();

    if (!$book) {
        die("Book not found");
    }
}

if (isset($_POST['update'])) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $annee_publication = $_POST['annee_publication'];
    $statut = isset($_POST['statut']) ? 1 : 0;
    $note = $_POST['note'];

    $sql = "UPDATE Livres SET titre = '$titre', auteur = '$auteur', annee_publication = $annee_publication, 
            statut = $statut, note = $note WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating book: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="icon" href="img/stack-of-books.png" type="image/x-icon" />
</head>
<body>
    <h2>Edit Book</h2>
    <form method="POST" action="">
        <label>Title:</label><br>
        <input type="text" name="titre" value="<?php echo $book['titre']; ?>" required><br>

        <label>Author:</label><br>
        <input type="text" name="auteur" value="<?php echo $book['auteur']; ?>" required><br>

        <label>Year of Publication:</label><br>
        <input type="number" name="annee_publication" value="<?php echo $book['annee_publication']; ?>" required><br>

        <label>Status (Read/Unread):</label><br>
        <input type="checkbox" name="statut" <?php echo $book['statut'] ? 'checked' : ''; ?>><br>

        <label>Rating (1-5):</label><br>
        <input type="number" name="note" value="<?php echo $book['note']; ?>" min="1" max="5" required><br><br>

        <button type="submit" name="update">Update Book</button>
    </form>
</body>
</html>
