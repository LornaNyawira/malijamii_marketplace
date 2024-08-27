<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root";
$password = "";
$database = "malijamii";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo mysqli_connect_error();
    exit();
} else {
    $businessName = $_POST['businessName'];
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productPrice = $_POST['productPrice'];
    $productImage = $_FILES['productImage'];

    $checkBusiness = "SELECT * FROM users WHERE businessName='$businessName'";
    $result = $conn->query($checkBusiness);
    if ($result->num_rows == 0) {
        echo "Business not found";
        exit();
    }

    $checkProduct = "SELECT * FROM products WHERE businessName='$businessName' AND productName='$productName'";
    $result = $conn->query($checkProduct);
    if ($result->num_rows > 0) {
        echo "Product already exists";
        exit();
    }

    $targetDirectory = "C:/xampp2/htdocs/REACTJS PROJECT/database/product_images/";

    // Create the target directory if it doesn't exist
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    $fileExtension = strtolower(pathinfo($productImage['name'], PATHINFO_EXTENSION));

    $randomString = uniqid();
    $targetFileName = $businessName . "_" . $randomString . '.' . $fileExtension;

    $targetFilePath = $targetDirectory . $targetFileName;

    $allowedExtensions = array("jpg", "jpeg", "png", "gif");

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Invalid file format. Allowed formats: jpg, jpeg, png, gif";
        exit();
    }

    if (move_uploaded_file($productImage['tmp_name'], $targetFilePath)) {
        $baseURL = "http://localhost/REACTJS PROJECT/database/product_images/";
        $imageURL = $baseURL . $targetFileName;

        $sql = "INSERT INTO products (businessName, productName, productDescription, productPrice, productImage)
        VALUES ('$businessName', '$productName', '$productDescription', '$productPrice', '$imageURL')";

        $res = mysqli_query($conn, $sql);

        if ($res) {
            echo "Product uploaded successfully";
        } else {
            echo "Error executing SQL query: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading product image. Error code: " . $_FILES['productImage']['error'];
    }

    $conn->close();
}
?>
