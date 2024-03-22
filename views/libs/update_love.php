<?php

session_start();
ob_start();

// Check if the loveProducts session variable is set
if (!isset($_SESSION['loveProducts'])) {
    $_SESSION['loveProducts'] = [];
}

$dburl = "mysql:host=localhost;dbname=legous_db;charset=utf8";
$username = 'root';
$password = '';

$conn = new PDO($dburl, $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if the product ID is provided
if (isset($_POST['product_id'])) {
    // Get the product ID from the request
    $productId = $_POST['product_id'];

    // Check if the product ID already exists in the loveProducts list
    $index = array_search($productId, $_SESSION['loveProducts']);

    if ($index === false) {
        // Add the product ID to the loveProducts list if it doesn't exist
        $_SESSION['loveProducts'][] = $productId;
    } else {
        // Remove the product ID from the loveProducts list if it already exists
        unset($_SESSION['loveProducts'][$index]);
    }

    // Perform the database update
    $sql = "UPDATE product SET love = love + 100 WHERE id = :productId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
    $stmt->execute();

    // Return a response (you can customize this based on your needs)
    if ($stmt->rowCount() > 0) {
        echo "Love updated successfully";
    } else {
        echo "Failed to update love";
    }
} else {
    echo "Invalid request";
}
?>


<?php
/**
 * Mở kết nối đến CSDL sử dụng PDO
 */
function pdo_get_connection(){
    $dburl = "mysql:host=localhost;dbname=legous_db;charset=utf8";
    $username = 'root';
    $password = '';

    $conn = new PDO($dburl, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
/**
 * Thực thi câu lệnh sql thao tác dữ liệu (INSERT, UPDATE, DELETE)
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_execute($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        return $conn->lastInsertId(); // Return the last inserted ID
    } catch(PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
/**
 * Thực thi câu lệnh sql truy vấn dữ liệu (SELECT)
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return array mảng các bản ghi
 * @throws PDOException lỗi thực thi câu lệnh
 */

function pdo_query($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $rows = $stmt->fetchAll();
        return $rows;
    }
    catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}
/**
 * Thực thi câu lệnh sql truy vấn một bản ghi
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return array mảng chứa bản ghi
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_query_one($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}
/**
 * Thực thi câu lệnh sql truy vấn một giá trị
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return giá trị
 * @throws PDOException lỗi thực thi câu lệnh
 */

 //Đếm số lượng của product
function pdo_query_value($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return array_values($row)[0];
    }
    catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}
/**
 * Thực thi câu lệnh sql truy vấn một giá trị
 * @param string $amount số tiền
 * @return giá trị tiền đã format
 */

function formatVND($amount) {
    $formattedAmount = number_format($amount, 0, ',', '.');
    $formattedAmount .= ' đ';
    
    return $formattedAmount;
}

function get_current_url() {
    $current_url  = 'http';
    // if ($_SERVER["HTTPS"] == "on") {
    //     $current_url .= "s";
    // }
    $current_url .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $current_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $current_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $current_url;
}



