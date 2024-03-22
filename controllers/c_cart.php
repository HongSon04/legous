<?php
session_start();
ob_start();
// Gữi/nhận dữ liệu thông qua model
// Hiển thị dữ liệu thông qua view
if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'addCart':
            include_once 'models/m_cart.php';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $img = $_POST['img'];
                $qty = $_POST['qty'];
                $id = $_POST['id'];

                $product = [
                    "name" => $name,
                    "price" => $price,
                    "img" => $img,
                    "qty" => $qty,
                    "id_product" => $id,
                ];

                // Check if the user is logged in
                if (isset($_SESSION['userLogin'])) {
                    $user_id = $_SESSION['userLogin']['id_user'];

                    if (!isset($_SESSION['cart'][$user_id]) || !is_array($_SESSION['cart'][$user_id])) {
                        $_SESSION['cart'][$user_id] = ['cart' => []];
                    }

                    // Check if the product is already in the user's cart
                    $isProductAvailableForUser = false;

                    foreach ($_SESSION['cart'][$user_id]['cart'] as $key => $value) {
                        if ($id == $key) {
                            $isProductAvailableForUser = true;
                            $_SESSION['cart'][$user_id]['cart'][$id]['qty'] += $qty; // Update the quantity
                            break;
                        }
                    }

                    if (!$isProductAvailableForUser) {
                        $_SESSION['cart'][$user_id]['cart'][$id] = $product;
                    }
                } else {
                    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
                        $_SESSION['cart']['guest'] = [];
                    }

                    // Check if the product is already in the cart
                    $isAvailable = false;
                    $productKey = -1;

                    // Loop through the cart to find the product by its unique identifier (e.g., product ID)
                    foreach ($_SESSION['cart']['guest'] as $key => $value) {
                        if ($id == $key) {
                            $isAvailable = true;
                            $productKey = $key;
                            break;
                        }
                    }

                    if ($isAvailable) {
                        // If the product is already in the cart, update the quantity
                        $newQty = $qty + $_SESSION['cart']['guest'][$productKey]['qty'];
                        $_SESSION['cart']['guest'][$productKey]['qty'] = $newQty;
                    } else {
                        // If the product is not in the cart, add it
                        $_SESSION['cart']['guest'][$id] = $product;
                    }
                }

                header('Location: ?mod=cart&act=viewCart');
            }
            break;

        case 'viewCart':
            if (isset($_SESSION['cart'])) {
                // print_r($_SESSION['cart']);
                // unset($_SESSION['cart']);
            }
            $view_name = 'cart';
            break;

        case 'checkout':        
            include_once 'models/m_shipping.php';
            include_once 'models/m_payment.php';
            include_once 'models/m_address.php';
            include_once 'models/m_bill.php';
            include_once 'models/m_cart.php';

            $cart = [];
            if (isset($_SESSION['userLogin']) && is_array($_SESSION['userLogin'])) {
                extract($_SESSION['userLogin']);
                $cart = $_SESSION['cart'][$id_user]['cart'];
            } else if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $cart = $_SESSION['cart']['guest'];
            }
            $view_name = 'checkout';
            break;

        case 'confirm':
            include_once 'models/m_bill.php';
            include_once 'models/m_cart.php';
            include_once 'models/m_user.php';
            include_once 'models/m_shipping.php';
            include_once 'models/m_payment.php';
            
            $view_name = 'confirm';
            break;
        case 'buyNow':
            include_once 'models/m_bill.php';
            include_once 'models/m_cart.php';
            include_once 'models/m_user.php';
            include_once 'models/m_shipping.php';
            include_once 'models/m_payment.php';
            include_once 'models/m_address.php';
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                /** buy now - checkout product */
                $product_name = $_POST['name'];
                $product_price = $_POST['price'];
                $product_img = $_POST['img'];
                $product_qty = $_POST['qty'];
                $product_id = $_POST['id'];
                $product_totalCost = $product_price * $product_qty;

                $checkoutProduct = [
                    'name' => $product_name,
                    'price' => $product_price,
                    'img' => $product_img,
                    'qty' => $product_qty,
                    'id_product' => $product_id
                ];
                $_SESSION['checkoutProduct'] = $checkoutProduct;
                // print_r($_SESSION['checkoutProduct']);
            }
            $view_name = 'checkoutBuyNow';
            break;
        case 'deleteProduct':
            if (isset($_GET['idProduct'])) {
                $idProduct = $_GET['idProduct'];

                unset($_SESSION['cart']['guest'][$idProduct]);

                if (isset($_SESSION['userLogin'])) {
                    $idUser = $_SESSION['userLogin']['id_user'];
                    unset($_SESSION['cart'][$idUser]['cart'][$idProduct]);
                }
                
                header("Location: ?mod=cart&act=viewCart");
                exit();
            }
            break;

        case 'coupon':
            
            break;
        default:

            break;
    }
    include_once 'views/v_user_layout.php';
}
