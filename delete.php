<?php
	// Database connection
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "db_document";

	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Get document id from URL
	$id = $_GET["id"];

	// Get document file path from database
	$sql = "SELECT document_file_path FROM documents WHERE id = $id";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$document_file_path = $row["document_file_path"];

	// Delete document from database
	$sql = "DELETE FROM documents WHERE id = $id";
	$conn->query($sql);

	// Delete document file from server
	unlink($document_file_path);

	// Redirect to index.php
	header("Location: index.php");
	exit();
?>
