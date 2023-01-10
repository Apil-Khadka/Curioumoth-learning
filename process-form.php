<?php

// Connect to the 'information' database
$hostname = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=information", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}

// Sanitize and validate form fields
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$body = filter_input(INPUT_POST, "body", FILTER_SANITIZE_STRING);
$priority = filter_input(INPUT_POST, "priority", FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
$terms = filter_input(INPUT_POST, "terms", FILTER_VALIDATE_BOOLEAN);

// Validate that the 'terms' field is true
if (!$terms) {
    die("Terms must be accepted");
}

// Insert record into 'message' table
$sql = "INSERT INTO message (name, body, priority, type) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $name, PDO::PARAM_STR);
$stmt->bindValue(2, $body, PDO::PARAM_STR);
$stmt->bindValue(3, $priority, PDO::PARAM_STR);
$stmt->bindValue(4, $type, PDO::PARAM_STR);

try {
    if ($stmt->execute()) {
        $resMessage = array(
            "status" => "alert-success",
            "message" => "Record saved successfully."
        );
        header("Location: thanks.html");
        exit;
    }  else {
      $resMessage = array(
          "status" => "alert-danger",
          "message" => "Error saving record: " . $stmt->$error
      );
  }
} catch (Exception $e) {
  $resMessage = array(
      "status" => "alert-danger",
      "message" => "Error saving record: " . $e->getMessage()
  );
}

echo json_encode($resMessage);




?>
