<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");


$servername = "localhost";
$username = "root";
$password = "";
$database = "malijamii";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo mysqli_connect_error();
    exit();
} else {
    $businessName = $_POST['businessName'] ?? '';
    $sellerName = $_POST['sellerName'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $location = $_POST['location'] ?? '';
    $productCategory = $_POST['productCategory'] ?? '';

   
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (businessName, sellerName, phoneNumber, email, password, location, productCategory)
    VALUES ('$businessName', '$sellerName', '$phoneNumber', '$email', '$hashedPassword', '$location', '$productCategory')";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Thank you for reaching us";
    } else {
        echo "Error!";
    }
    $conn->close();
}
?>
