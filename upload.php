<?php
  // Database credentials
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "proj";

  // Connect to database
  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // File upload path
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);

  // File information
  $title = $_POST["title"];
  $keywords = $_POST["keywords"];
  $size = $_FILES["file"]["size"];
  $format = pathinfo($target_file, PATHINFO_EXTENSION);

  // Move file to uploads directory
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    // Insert file details into database
    $sql = "INSERT INTO files (path, title, size, format, keywords) VALUES ('$target_file', '$title', '$size', '$format', '$keywords')";
    if (mysqli_query($conn, $sql)) {
      echo "File uploaded successfully.";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  } else {
    echo "Error uploading file.";
  }

  // Close database connection
  mysqli_close($conn);
?>