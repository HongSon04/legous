<?php

namespace App\controller;

use App\model\Cart;
use App\model\Comment;
use App\model\Order;
use App\model\Product;
use App\model\User;


class CartController extends Controller
{

    public function viewCart()
    {

        view('v_cart');
    }

    public function addCart()
    {
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
            header('Location: /viewCart');
        }
        exit();
    }
    public function delCart()
    {
        if (isset($_GET['idProduct'])) {
            $idProduct = $_GET['idProduct'];

            unset($_SESSION['cart']['guest'][$idProduct]);

            if (isset($_SESSION['userLogin'])) {
                $idUser = $_SESSION['userLogin']['id_user'];
                unset($_SESSION['cart'][$idUser]['cart'][$idProduct]);
            }

            header("Location: /viewCart");
            exit();
        }
        exit();
    }

    public function checkOut()
    {
        view('v_checkout');
    }

    public function confirmOrder()
    {
        include '../WD18317/app/library/lb_checkoutHandler.php';
    }
}


