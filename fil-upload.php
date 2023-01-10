<?php

   include("config/database.php");


     if(isset($_POST["submit"])) {
    // Set File placement folder
    $target_dir = "files/";
    // Get file path
    $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
    // Get file extension
    $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Allowed file types
    $allowd_file_ext = array("zip", "txt", "c", "cpp", "html","css");

    if (!file_exists($_FILES["fileUpload"]["tmp_name"])) {
       $resMessage = array(
           "status" => "alert-danger",
           "message" => "Select file to upload."
       );
    } else if (!in_array($fileExt, $allowd_file_ext)) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "Allowed file formats zip , txt"
        );            
    } else if ($_FILES["fileUpload"]["size"] > 5000000000) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "File is too large. File size should be less than 5 gigabytes."
        );
    } else if (file_exists($target_file)) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "File already exists."
        );
    } else {
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
            // Get current date and time
            $submission_date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO datas (name_dir, submission_date) VALUES ('$target_file', '$submission_date')";
            $stmt = $conn->prepare($sql);
             if($stmt->execute()){
                $resMessage = array(
                    "status" => "alert-success",
                    "message" => "File uploaded successfully."
                );                 
             }
        } else {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "File coudn't be uploaded."
            );
        }
    }

}

?>