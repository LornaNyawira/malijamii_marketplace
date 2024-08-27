<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$database = "malijamii";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  echo json_encode([]);
  exit();
} else {
  if (isset($_GET['businessName'])) {
    $businessName = $_GET['businessName'];

    $sql = "SELECT * FROM products WHERE businessName='$businessName'";
    $result = $conn->query($sql);

    $products = array();

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
    }

    echo json_encode($products);
  } else {
    echo json_encode([]);
  }

  $conn->close();
}
?>
