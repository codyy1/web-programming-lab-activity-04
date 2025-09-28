<?php
include 'database.php';

if (isset($_GET['book_id'])) {
	$book_id = $_GET['book_id'];
	$stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
	$stmt->bind_param("i", $book_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$book = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$book_id = $_POST['book_id'];
	$title = $_POST['title'];
	$author = $_POST['author'];
	$genre = $_POST['genre'];
	$year = $_POST['publication_year'];

	$stmt = $conn->prepare("UPDATE books SET title=?, author=?, genre=?, publication_year=? WHERE book_id=?");
	$stmt->bind_param("sssii", $title, $author, $genre, $year, $book_id);
	if ($stmt->execute()) {
		echo "Book updated successfully!";
	} else {
		echo "Error: " . $stmt->error;
	}
	// Refresh book data
	$stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
	$stmt->bind_param("i", $book_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$book = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Book</title>
</head>
<body>
	<h2>Edit Book</h2>
	<?php if (!empty($book)) { ?>
	<form method="POST" action="">
		<input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">

		<label>Title:</label><br>
		<input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required><br><br>

		<label>Author:</label><br>
		<input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required><br><br>

		<label>Genre:</label><br>
		<select name="genre" required>
			<option value="">--Select Genre--</option>
			<option value="History" <?php if ($book['genre'] == 'History') echo 'selected'; ?>>History</option>
			<option value="Science" <?php if ($book['genre'] == 'Science') echo 'selected'; ?>>Science</option>
			<option value="Fiction" <?php if ($book['genre'] == 'Fiction') echo 'selected'; ?>>Fiction</option>
		</select><br><br>

		<label>Publication Year:</label><br>
		<input type="number" name="publication_year" value="<?php echo $book['publication_year']; ?>" required><br><br>

		<input type="submit" value="Update Book">
	</form>
	<?php } else { ?>
		<p>No book found to edit.</p>
	<?php } ?>
</body>
</html>
