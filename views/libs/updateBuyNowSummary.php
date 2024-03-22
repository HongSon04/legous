<?php
session_start();
ob_start();

function formatVND($amount)
{
    $formattedAmount = number_format($amount, 0, ',', '.');
    $formattedAmount .= ' đ';

    return $formattedAmount;
}
// Retrieve the shipping price from the AJAX request
$shippingPrice = $_POST['shippingPrice'];

// Calculate the total and shipping fee based on the shipping price
$subTotal = 0;
$tax = 0;
$cart = [];
if (isset($_SESSION['checkoutProduct']) && is_array($_SESSION['checkoutProduct'])) {
    extract($_SESSION['checkoutProduct']);
    $subTotal += $price * $qty;
    $tax = $subTotal * 0.1;
} 

$total = $subTotal + $tax + $shippingPrice;

// Prepare the response data
$response = [
    'total' => formatVND($total),
    'shippingFee' => formatVND($shippingPrice)
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);


function pdo_get_connection()
{
    $dburl = "mysql:host=localhost;dbname=legous_db;charset=utf8";
    $username = 'root';
    $password = '';

    $conn = new PDO($dburl, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
function pdo_query($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $rows = $stmt->fetchAll();
        return $rows;
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}

function getCartByUserId($idUser)
{
    $sql = "SELECT * FROM cart WHERE id_user = $idUser";
    return pdo_query($sql);
}
?>