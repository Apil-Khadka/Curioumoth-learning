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
                // Move uploaded folder to target directory
                if (move_uploaded_file($_FILES["folderUpload"]["tmp_name"], $target_folder)) {
                    // Iterate through all files in the folder
                    foreach (new DirectoryIterator($target_folder) as $fileInfo) {
                        if($fileInfo->isDot()) continue;
                        // Get file path
                        $target_file = $fileInfo->getPathname();
                        // Get file extension
                        $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        if (!in_array($fileExt, $allowd_file_ext)) {
                            $resMessage = array(
                                "status" => "alert-danger",
                                "message" => "Not-allowed file formats "
                            );            
                        } else if ($fileInfo->getSize() > 5000000000) {
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
                            // Move uploaded file to target directory
                            if (move_uploaded_file($fileInfo->getPathname(), $target_file)) {
                                // Get current date and time
                                $submission_date = date("Y-m-d H:i:s");
                                // Insert file into database
                                $sql = "INSERT INTO datas (name_dir, submission_date) VALUES ('$target_file', '$submission_date')";
                                $stmt = $conn->prepare($sql);
                                if($stmt->execute()){
                                    $resMessage = array(
                                        "status" => "alert-success",
                                        "message" => "File uploaded successfully."
                                    );
                                } else {
                                    $resMessage = array(
                                        "status" => "alert-danger",
                                        "message" => "File couldn't be uploaded."
                                    );
                                }
                            }
                        }
                    }
                } else {
                    $resMessage = array(
                        "status" => "alert-danger",
                        "message" => "Error moving uploaded folder."
                    );
                }
            }
        }
    }
  
?>


                           
