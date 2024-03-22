<?php
session_start();
ob_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && isset($_POST["product_id"])) {
    $product_id = $_POST["product_id"];
    $action = $_POST["action"];

    if ($action === "increase") {
        // Increase quantity in session cart0000
        if (isset($_SESSION['userLogin'])) {
            $idUser = $_SESSION['userLogin']['id_user'];
            $_SESSION["cart"][$idUser]['cart'][$product_id]["qty"]++;
        } else {
            $_SESSION["cart"]['guest'][$product_id]["qty"]++;
        }
    } elseif ($action === "decrease") {
        // Decrease quantity in session cart, but ensure it doesn't go below 0
        if (isset($_SESSION['userLogin'])) {
            $idUser = $_SESSION['userLogin']['id_user'];
            if ($_SESSION["cart"][$idUser]['cart'][$product_id]["qty"] > 0) {
                $_SESSION["cart"][$idUser]['cart'][$product_id]["qty"]--;
            } else {
                $_SESSION["cart"][$idUser]['cart'][$product_id]["qty"] = 1;
            }
        } else {
            if ($_SESSION["cart"]['guest'][$product_id]["qty"] > 0) {
                $_SESSION["cart"]['guest'][$product_id]["qty"]--;
            } else {
                $_SESSION["cart"]['guest'][$product_id]["qty"] = 1;
            }
        }
    }

    // Return updated quantity
    if (isset($_SESSION['userLogin']) && is_array($_SESSION['userLogin']) && !empty($_SESSION['userLogin'])) {
        $productQty = $_SESSION["cart"][$idUser]['cart'][$product_id]["qty"];
    } else {
        $productQty = $_SESSION["cart"]['guest'][$product_id]["qty"];
    }
    $response = [
        "success" => true,
        "quantity" => $productQty
    ];
} else {
    $response = ["success" => false];
}

header("Content-Type: application/json");
echo json_encode($response);

function updateQuantityInDatabase($product_id, $quantity, $user_id) {
    $sql = "UPDATE cart SET qty = $quantity WHERE id_user = $user_id AND id_product = $product_id";
    pdo_execute($sql);
}


/**
 * Thực thi câu lệnh sql thao tác dữ liệu (INSERT, UPDATE, DELETE)
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_execute($sql) {
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

function pdo_get_connection() {
    $dburl = "mysql:host=localhost;dbname=legous_db;charset=utf8";
    $username = 'root';
    $password = '';

    $conn = new PDO($dburl, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
