<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Livres WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Book deleted successfully!";
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting book: " . $conn->error;
    }
} else {
    echo "No book ID provided.";
}
?>
