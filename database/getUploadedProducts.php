<?php


if ($_SERVER["REQUEST_METHOD"] === "GET") {
   
    if (isset($_GET["businessName"])) {
        $businessName = $_GET["businessName"];

    
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "malijamii"; 
        try {
            
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           
            $stmt = $conn->prepare("SELECT * FROM customeruser WHERE businessName = :businessName");
            $stmt->bindParam(":businessName", $businessName);
            $stmt->execute();

           
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

           
            header("Content-Type: application/json");
            echo json_encode($result);
        } catch (PDOException $e) {
          
            echo "Error: " . $e->getMessage();
        } finally {
            
            $conn = null;
        }
    } else {
       
        echo "Error: businessName parameter is missing.";
    }
} else {
   
    echo "Error: Invalid request method.";
}
