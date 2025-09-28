<?php
include 'database.php';

if (isset($_GET['book_id'])) {
	$book_id = $_GET['book_id'];
	$stmt = $conn->prepare("DELETE FROM books WHERE book_id = ?");
	$stmt->bind_param("i", $book_id);
	if ($stmt->execute()) {
		echo "Book deleted successfully!";
	} else {
		echo "Error: " . $stmt->error;
	}
} else {
	echo "No book selected for deletion.";
}
?>
