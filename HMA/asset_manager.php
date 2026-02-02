<?php
echo"<!DOCTYPE html>";
session_start(); // start session

require_once "assets/dbconn.php"; // connects to another file
require_once "assets/common.php"; // connects to another file

if($_SERVER['REQUEST_METHOD'] === "POST") {// if method = post
    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    // Check if file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $stmt = dbconnect_insert()->prepare("INSERT INTO values (images) VALUES (?)");
            $stmt->bindparam("s", $targetFilePath);
            $stmt->execute();
            echo "<p style='color:green;'>Image uploaded successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error uploading file.</p>";
        }
    } else {
        echo "<p style='color:red;'>File is not an image.</p>";
    }

}

echo"<html>";
echo"<head>";
echo"    <title>Upload & Display Images</title>";
echo"</head>";
echo"<body>";
    echo"<h2>Upload Image</h2>";
echo"<form action='' method='post'' enctype='multipart/form-data'>";
    echo"<label>Select image to upload:</label><br>";
    echo"<input type='file' name='image' required>";
    echo"<button type='submit' name='upload'>Upload</button>";
echo"</form>";

    echo"<h2>Uploaded Images</h2>";
    $conn=dbconnect_select();
    $result = asset_getter(dbconnect_select());
    while ($row = $result->fetch_assoc()) {
        echo "<div style='margin:10px; display:inline-block;'>";
        echo "<img src='" . htmlspecialchars($row['file_path']) . "' width='150' height='150' style='object-fit:cover;'><br>";
        echo "</div>";
    }
echo"</body>";
echo"</html>";
