<?php
error_reporting(0);
ob_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "malijamii";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $response = array("result" => "Error connecting to the database.");
    echo json_encode($response);
    exit();
}

$eData = file_get_contents("php://input");
$dData = json_decode($eData, true);

$username = $dData['username'];
$password = $dData['password'];
$result = "";

if ($username !== "" && $password !== "") {
    $sql = "SELECT * FROM customeruser WHERE username = '$username'";
    $res = $conn->query($sql);

    if ($res->num_rows != 0) {
        $row = $res->fetch_assoc();
        $hashedPasswordFromDB = $row['password'];

        if (password_verify($password, $hashedPasswordFromDB)) {
            $result = "Logged in successfully! Redirecting...";
        } else {
            $result = "Invalid password!";
        }
    } else {
        $result = "Invalid username!";
    }

    $response = array("result" => $result);
    echo json_encode($response);
} else {
    $result = "Fields required";
    $response = array("result" => $result);
    echo json_encode($response);
}

$conn->close();
ob_end_flush();
?>
