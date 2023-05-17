<!DOCTYPE html>
<html>

<head>
	<title>Document Management System</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}

		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
		}

		h1 {
			text-align: center;
			margin-top: 0;
		}

		.form-section {
			background-color: #f2f2f2;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0px 0px 10px #ccc;
			margin-bottom: 20px;
		}

		.form-section h2 {
			margin-top: 0;
		}

		.form-section label {
			display: block;
			font-weight: bold;
			margin-bottom: 5px;
		}

		.form-section input[type=text],
		.form-section input[type=date] {
			width: 100%;
			padding: 5px;
			border-radius: 5px;
			border: none;
			box-shadow: 0px 0px 5px #ccc;
			margin-bottom: 10px;
		}

		.form-section select,
		.form-section input[type=file] {
			width: 100%;
			padding: 5px;
			border-radius: 5px;
			border: none;
			box-shadow: 0px 0px 5px #ccc;
			margin-bottom: 10px;
		}

		.form-section input[type=submit] {
			padding: 10px;
			border-radius: 5px;
			border: none;
			background-color: #4CAF50;
			color: white;
			font-weight: bold;
			cursor: pointer;
		}

		.documents-section {
			margin-top: 20px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		table th,
		table td {
			padding: 10px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		table th {
			background-color: #4CAF50;
			color: white;
		}

		.delete-button {
			background-color: #ff0000;
			color: #ffffff;
			border: none;
			padding: 5px 10px;
			cursor: pointer;
			border-radius: 5px;
			transition: background-color 0.3s ease;
		}

		.delete-button:hover {
			background-color: #ff3333;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>Document Management System</h1>

		<div class="form-section">
			<h2>Upload Document</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<label for="document-type">Document Type:</label>
				<select name="document-type" id="document-type">
					<option value="1">1.PDF</option>
					<option value="2">2.WORD</option>
					<option value="3">3.PPT</option>
				</select>

				<label for="document-title">Document Title:</label>
				<input type="text" name="document-title" id="document-title">

				<label for="document-author">Document Author:</label>
				<input type="text" name="document-author" id="document-author">
				<label for="document-date">Document Date:</label>
			<input type="date" name="document-date" id="document-date">

			<label for="document-file">Document File:</label>
			<input type="file" name="document-file" id="document-file">

			<input type="submit" name="submit" value="Upload Document">
		</form>
	</div>

	<div class="documents-section">
		<h2>Documents List</h2>
		<table>
			<thead>
				<tr>
					<th>Document Type</th>
					<th>Document Title</th>
					<th>Document Author</th>
					<th>Document Date</th>
					<th>Document File</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
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

				// Upload document file to server
				if (isset($_FILES["document-file"]) && $_FILES["document-file"]["error"] == UPLOAD_ERR_OK) {
					$document_type = $_POST["document-type"];
					$document_title = $_POST["document-title"];
					$document_author = $_POST["document-author"];
					$document_date = $_POST["document-date"];
					$document_file_path = "uploads/" . $_FILES["document-file"]["name"];

					// Check if file already exists
					if (file_exists($document_file_path)) {
						echo "<p>Sorry, the file already exists.</p>";
					} else {
						// Upload the file
						move_uploaded_file($_FILES["document-file"]["tmp_name"], $document_file_path);

						// Insert document data into database
						$sql = "INSERT INTO documents (document_type, document_title, document_author, document_date, document_file_path) VALUES ('$document_type', '$document_title', '$document_author', '$document_date', '$document_file_path')";

						if ($conn->query($sql) === TRUE) {
							echo "<p>The document has been uploaded successfully.</p>";
						} else {
							echo "Error: " . $sql . "<br>" .
								$conn->error;
						}
					}
				}
				// Retrieve documents from database
				$sql = "SELECT * FROM documents";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// Output data of each row
					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>" . $row["document_type"] . "</td>";
						echo "<td>" . $row["document_title"] . "</td>";
						echo "<td>" . $row["document_author"] . "</td>";
						echo "<td>" . $row["document_date"] . "</td>";
						echo "<td><a href='" . $row["document_file_path"] . "'>Download</a></td>";
						echo "<td><form method='post' action='delete.php?id=" . $row["id"] . "' onsubmit='return confirm(\"Are you sure you want to delete this document?\")'>";
						echo "<input type ='submit' name='delete' value='Delete' class='delete-button'>";
						echo "</form></td>";
						echo "</tr>";
						}
						} else {
						echo "";
						}
						$conn->close();
						?>
					</tbody>
				</table>
			</div>
		</div>
		</body>
</html>		