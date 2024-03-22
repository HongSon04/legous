<?php
$user_name = $_POST['username'];

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=legous_db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM user WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $user_name, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo 'exists';
    } else { 
        echo 'available';
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
