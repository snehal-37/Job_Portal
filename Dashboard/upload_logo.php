<?php
session_start();
include '../config.php';

if (isset($_POST['submit'])) {
     // Create uploads folder if not exists
     $uploadDir = "../uploads/";
     if (!is_dir($uploadDir)) {
         mkdir($uploadDir, 0777, true);
     }
 
     // Handle the uploaded file
     $fileName = basename($_FILES["image"]["name"]);
     $targetFilePath = $uploadDir . $fileName;
     
     if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
         // Save path to database
         $sql = "INSERT INTO employer (logo) VALUES ('$targetFilePath')";
         if ($conn->query($sql) === TRUE) {
             echo "File uploaded successfully!";
         } else {
             echo "Database error: " . $conn->error;
         }
     } else {
         echo "File upload failed!";
     }
 
     $conn->close();
 }
    
    
    
    ?>
