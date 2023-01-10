<?php 
    // Database connection
    include("config/database.php");

    if(isset($_POST["submit"])) {
        // Set folder placement directory
        $target_dir = "files/";
        // Get folder path
        $target_folder = $target_dir . basename($_FILES["folderUpload"]["name"]);
        // Allowed file types
        $allowd_file_ext = array("zip", "txt", "c", "cpp", "html","css","php");
        // check if file input is not empty
        if($_FILES["fileUpload"]["name"] !== ""){
            $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
            // Get file extension
            $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $allowd_file_ext)) {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "Not-allowed file formats"
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
                try {
                    if (!move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
                        throw new Exception("Error uploading file.");
                    }
                    $submission_date = date("Y-m-d H:i:s");
                    $sql = "INSERT INTO datas (name_dir, submission_date) VALUES ('$target_file', '$submission_date')";
                    $stmt = $conn->prepare($sql);
                    if(!$stmt->execute()){
                        throw new Exception("File couldn't be uploaded.");
                    }
                    $resMessage = array(
                        "status" => "alert-success",
                        "message" => "File uploaded successfully."
                    );
                } catch (Exception $e) {
                    $resMessage = array(
                        "status" => "alert-danger",
                        "message" => $e->getMessage()
                    );
                }
            }
        }
        // Check if file is a directory
        if (!is_dir($_FILES["folderUpload"]["tmp_name"])) {
           $resMessage = array(
               "status" => "alert-danger",
               "message" => "Select folder to upload."
            );
            } else {
            // Check for file upload errors
            if ($_FILES["folderUpload"]["error"] > 0) {
            $resMessage = array(
            "status" => "alert-danger",
            "message" => "Error uploading file. Error code: " . $_FILES["folderUpload"]["error"]
            );
            } else {
            try {
            if (!move_uploaded_file($_FILES["folderUpload"]["tmp_name"], $target_folder)) {
            throw new Exception("Error moving uploaded folder.");
            }
            // Iterate through all files in the folder
            foreach (new DirectoryIterator($target_folder) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            $target_file = $fileInfo->getPathname();
            // Get file extension
            $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $allowd_file_ext)) {
            throw new Exception("Not-allowed file formats ");
            } else if ($fileInfo->getSize() > 5000000000) {
            throw new Exception("File is too large. File size should be less than 5 gigabytes.");
            } else if (file_exists($target_file)) {
            throw new Exception("File already exists.");
            } else {
            if (!move_uploaded_file($fileInfo->getPathname(), $target_file)) {
            throw new Exception("Error moving uploaded file.");
            }
            $submission_date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO datas (name_dir, submission_date) VALUES ('$target_file', '$submission_date')";
            $stmt = $conn->prepare($sql);
    if(!$stmt->execute()){
    throw new Exception("File couldn't be uploaded.");
    }
    }
    }
    $resMessage = array(
            "status" => "alert-success",
            "message" => "Folder and its contents uploaded successfully."
         );
    }   catch (Exception $e) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => $e->getMessage()
      );
     }
        }
        }
        }
    ?>
