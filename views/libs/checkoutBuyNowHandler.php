<?php
session_start();
ob_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /** bill infomation */
    $address_user = $_POST['address'];
    $address_detail_user = $_POST['address-detail'];
    $email_user = $_POST['email'];
    $phone_user = $_POST['phone'];
    $id_shipping = $_POST['shipping'];
    $id_payment = $_POST['payment'];
    $address_recipient = $_POST['recipient-address'];
    $address_detail_recipient = $_POST['recipient-address-detail'];
    $name_recipient = $_POST['recipient-name'];
    $phone_recipient = $_POST['recipient-phone'];

    $total = 0;

    if (isset($_SESSION['checkoutProduct']) && is_array($_SESSION['checkoutProduct'])) {
        $checkoutProduct = $_SESSION['checkoutProduct'];
        extract($checkoutProduct);
        $subTotal = $price * $qty;
        $tax = $subTotal * 0.1;
        /** update product quantity */
        $productQty = getProductQtyById($id_product);
        $newQty = $productQty - $qty;

        /** update product purchases */
        $purchases = rand(10, 100);
        
        $shipping = getShippingMethodByPrice($id_shipping)['price'];
        
        $total = $subTotal + $tax + $shipping;
        if (isset($_SESSION['userLogin'])) {
            /** lây id user insert vào bill, trả lại Id bill */
            extract($_SESSION['userLogin']);

            if (empty($name_recipient)) {
                $name_recipient = getUserInfo($id_user)[0]['username'];
            }

            $idBill = insertBill($id_user, $id_shipping, $id_payment, $email_user, $phone_user, $address_user, $address_detail_user, $name_recipient, $phone_recipient, $address_recipient, $address_detail_recipient, $total, 1);
            $_SESSION['idBill'] = $idBill;
            /** lấy id bill vừa tạo, insert sản phẩm muốn mua ngay vào bảng giỏ hàng */
            insertCartWithIdBill($idBill, $id_user, $id_product, $name, $price, $img, $qty, $subTotal);
            /** update số lượng của sản phẩm vừa mua */
            updateProductQty($id_product, $newQty);

            /** update product purchases */
            updateProductPurchases($id_product, $purchases);

            if (isset($_SESSION['checkoutProduct'])) {
                unset($_SESSION['checkoutProduct']);
            }
            // header("Location: ?mod=cart&act=confirm");
            exit();
        } else {
            /** tạo account cho khách hàng, generate ngẫu nhiên tên đăng nhập và mật khẩu, insert vào database */
            $randomUsername = generateRandomUsername(8);
            $randomPassword = generateRandomPassword(8);
            $id_user = insertUser($randomUsername, $email_user, $randomPassword);
            /** tạo đơn hàng -> trả về idBill */
            $idBill = insertBill($id_user, $id_shipping, $id_payment, $email_user, $phone_user, $address_user, $address_detail_user, $name_recipient, $phone_recipient, $address_recipient, $address_detail_recipient, $total, 1);
            $_SESSION['idBill'] = $idBill;

            /** lấy idBill insert sản phẩm trong giỏ hàng vào db */
            insertCartWithIdBill($idBill, $id_user, $id_product, $name, $price, $img, $qty, $subTotal);

            /** update số lượng của sản phẩm vừa mua */
            updateProductQty($id_product, $newQty);

            /** update product purchases */
            updateProductPurchases($id_product, $purchases);
            
            unset($_SESSION['checkoutProduct']);
            // header("Location: ?mod=cart&act=confirm"); 
            exit();
        }
    } else {
        header("Location: ?mod=page&act=home");
    }
}


function getProductQtyById($idProduct)
{
    $sql = "SELECT qty FROM product WHERE id = $idProduct";
    return pdo_query_value($sql);
}

function updateProductQty($idProduct, $newQty)
{
    $sql = "UPDATE product SET qty = $newQty WHERE id = $idProduct";
    pdo_execute($sql);
}

function getShippingMethodByPrice($price)
{
    $sql = "SELECT * FROM shipping WHERE price = $price";
    return pdo_query_one($sql);
}
function getUserInfo($id)
{
    return pdo_query("SELECT * FROM user WHERE id = {$id}");
}
function insertCartWithIdBill($idBill, $idUser, $id_product, $name, $price, $img, $qty, $totalCost)
{
    $sql = "INSERT INTO 
                cart (id_bill, id_user, id_product, name, price, img, qty, total_cost) 
            VALUES 
                ('$idBill', '$idUser', '$id_product', '$name', '$price', '$img', '$qty', '$totalCost') ";
    pdo_execute($sql);
}

function insertUser($username, $email, $password)
{
    $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)"; // Use parameterized query
    $userId = pdo_execute($sql, $username, $email, $password);
    return $userId; // Return the last inserted ID
}

function generateRandomUsername($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $username = '';

    $charactersLength = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $username .= $characters[rand(0, $charactersLength - 1)];
    }

    return $username;
}

function generateRandomPassword($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
    $password = '';

    $charactersLength = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }

    return $password;
}

function getCartByUserId($idUser)
{
    $sql = "SELECT * FROM cart WHERE id_user = $idUser";
    return pdo_query($sql);
}

function totalBill($cart)
{
    $total = $subTotal = 0;

    foreach ($cart as $item) {
        extract($item);
        $subTotal += $price * $qty;
    }

    $tax = $subTotal * 0.1;

    $total = $subTotal + $tax;

    return $total;
}

function insertBill($id_user, $id_shipping, $id_payment, $email_user, $phone_user, $address_user, $address_detail_user, $name_recipient, $phone_recipient, $address_recipient, $address_detail_recipient, $total, $status)
{
    $sql = "INSERT INTO bill (id_user, id_shipping, id_payment, email_user, phone_user, address_user, address_detail_user, name_recipient, phone_recipient, address_recipient, address_detail_recipient  , total, status) 
                VALUES ('$id_user', '$id_shipping', '$id_payment', '$email_user', '$phone_user', '$address_user', '$address_detail_user', '$name_recipient', '$phone_recipient', '$address_recipient', '$address_detail_recipient', '$total', 1)";
    $billId = pdo_execute($sql);
    return $billId;
}

function updateIdBillInCart($id_user, $id_bill)
{
    $sql = "UPDATE cart
            SET id_bill = $id_bill 
            WHERE id_user = $id_user";
}

function pdo_get_connection()
{
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
function pdo_execute($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        return $conn->lastInsertId(); // Return the last inserted ID
    } catch (PDOException $e) {
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
/**
 * Thực thi câu lệnh sql truy vấn một bản ghi
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return array mảng chứa bản ghi
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_query_one($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    } catch (PDOException $e) {
        throw $e;
    } finally {
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
function pdo_query_value($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return array_values($row)[0];
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
/**
 * Thực thi câu lệnh sql truy vấn một giá trị
 * @param string $amount số tiền
 * @return giá trị tiền đã format
 */

function formatVND($amount)
{
    $formattedAmount = number_format($amount, 0, ',', '.');
    $formattedAmount .= ' đ';

    return $formattedAmount;
}

function get_current_url()
{
    $current_url = 'http';
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

?>