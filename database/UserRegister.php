<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$hostname = "localhost";
$username = "root";
$password = "";
$database = "malijamii";


$connection = mysqli_connect($hostname, $username, $password, $database);


if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  $data = json_decode(file_get_contents("php://input"), true);


  $username = mysqli_real_escape_string($connection, $data["username"]);
  $email = mysqli_real_escape_string($connection, $data["email"]);
  $password = mysqli_real_escape_string($connection, $data["password"]);

  
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

 
  $query = "INSERT INTO customeruser (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

  if (mysqli_query($connection, $query)) {
   
    $response = array(
      "success" => true,
      "message" => "User registered successfully!",
    );
  } else {
   
    $response = array(
      "success" => false,
      "message" => "An error occurred. Please try again later.",
    );
  }

 
  header("Content-Type: application/json");
  echo json_encode($response);
}


mysqli_close($connection);
?>
