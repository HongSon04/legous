<?php
if (isset($_SESSION['userLogin']) && $_GET['loginInfo']) {
    extract($_SESSION['userLogin']);
    header("Location: /");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        echo $email, $password;
        if ($email !== '' && $password !== '') {

            $newUser = new user();
            $user = $newUser->checkUser($email, $password);
            if ($user) {
                extract($user);
                $loginInfo = [
                    "email_user" => $email,
                    "password_user" => $password,
                    "id_user" => $id
                ];

                // Check if a session cart exists for the user
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                    // Transfer products from the session cart to the cart table

                    // Retrieve the products from the session cart
                    $cartProducts = $_SESSION['cart'];

                    // Loop through the session cart products and insert them into the cart table
                    foreach ($cartProducts as $productId => $product) {
                        $name = $product['name'];
                        $price = $product['price'];
                        $img = $product['img'];
                        $qty = $product['qty'];
                        $totalCost = $price * $qty;
                        $newCartModel = new cart();
                        // Call a function to insert the product into the cart table
                        $newCartModel->insertCart($id, $productId, $name, $price, $img, $qty, $totalCost);
                        // redirect

                        header("Location: /viewCart");

                    }

                    // redirect
                    header("Location: /viewCart");
                }

                if ($role == 0) {
                    $_SESSION['role'] = $role;

                    $_SESSION['userLogin'] = $loginInfo;
                    print_r($_SESSION['userLogin']);
                    setcookie('accounts_user' . $_SESSION['userLogin']['id_user'], $loginInfo['id_user'], (time() + (60 * 60 * 24 * 30)));
                    header("Location: /");
                    exit();
                } else if ($role == 2023) {
                    $_SESSION['role'] = $role;

                    $_SESSION['admin'] = $loginInfo;

                    header("Location: /adminDashboard");
                    exit();
                }
                header("Location: /");
            } else {
                $loginMessage = '<span class="primary-text form__message fw-smb label-medium"></span>';
                header("Location: /login");
                exit();
            }
        }
    }
}
?>