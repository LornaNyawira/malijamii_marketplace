<?php
error_reporting(0);
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

$sql = "SELECT * FROM products";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $products = array();
  while ($row = $result->fetch_assoc()) {
    $product = array(
      "productId" => $row["productId"],
      "businessName" => $row["businessName"],
      "productName" => $row["productName"],
      "productDescription" => $row["productDescription"],
      "productPrice" => $row["productPrice"],
      "productImage" => $row["productImage"]
    );
    array_push($products, $product);
  }

  $response = array("success" => true, "products" => $products);
} else {
  $response = array("success" => false, "message" => "No products found.");
}

echo json_encode($response);

$conn->close();
?>
