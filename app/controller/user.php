<?php

namespace App\controller;

use App\model\Cart;
use App\model\User;

class UserController extends Controller {
    public function login() {
        $loginMessage = '';
        if (isset($_SESSION['userLogin'])) {
            header("Location: /");
        } else if (isset($_SESSION['admin'])) {
            header("Location: /admin");
            exit();
        }
        include_once('./app/view/v_login.php');
    }

    public function loginInfo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = md5($password);
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
    public function registerInfo() {
        if (isset($_SESSION['userLogin'])) {
            header("Location: /");
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $password = md5($password);
                if ($username !== '' && $email !== '' && $password !== '') {
                    $newUser = new user();
                    $userId = $newUser->insertUser($username, $email, $password);
                    $getLastUser = $newUser->lastIndexOfUser();

                    extract($getLastUser);
                    $list_infoUser = [
                        "id_user" => $id,
                        "name_user" => $username,
                        "password_user" => $password,
                        "email_user" => $email
                    ];
                    $_SESSION['userLogin'] = $list_infoUser;
                }
            }
        }
        exit();
    }

    public function logout() {
        session_destroy();
        header("Location: /");
        exit();
    }

    public function profileUser() {
        if (isset($_SESSION['userLogin'])) {
            extract($_SESSION['userLogin']);
            $id_user = $_SESSION['userLogin']['id_user'];
        } else if (isset($_SESSION['admin'])) {
            extract($_SESSION['admin']);
            $id_user = $_SESSION['admin']['id_user'];
        }
        $newUserModel = new user();
        $checkUses = $newUserModel->checkAccount($id_user);
        $avatar_user = '';
        if (is_array($checkUses)) {
            extract($checkUses);
            if ($img == "") {
                $avatarImage_user = "./public/upload/users/" . 'avatar-none.png';
            } else if ($img != '') {
                $avatarImage_user = "./public/upload/users/" . $img;
            }
        }
        $active__general = '';
        $active__profile = '';
        $active__password = '';
        $active__address = '';
        $active__order = '';
        $active__deleteAccount = '';
        $active__general = 'menu__active';

        include './app/view/v_profileUser.php';
    }

    public function historyOrderUser() {
        if (isset($_SESSION['userLogin'])) {
            extract($_SESSION['userLogin']);
            $id_user = $_SESSION['userLogin']['id_user'];
        } else if (isset($_SESSION['admin'])) {
            extract($_SESSION['admin']);
            $id_user = $_SESSION['admin']['id_user'];
        }
        $newUserModel = new user();
        $checkUses = $newUserModel->checkAccount($id_user);
        $avatar_user = '';
        if (is_array($checkUses)) {
            extract($checkUses);
            if ($img == "") {
                $avatarImage_user = "./public/upload/users/" . 'avatar-none.png';
            } else if ($img != '') {
                $avatarImage_user = "./public/upload/users/" . $img;
            }
        }
        $active__general = '';
        $active__profile = '';
        $active__password = '';
        $active__address = '';
        $active__order = '';
        $active__deleteAccount = '';
        $active__general = 'menu__active';

        $active__order = 'menu__active';
        $title = 'Lịch sử đơn hàng';
        $itemsPage = '';
        $itemsPage = 10; // số bill mỗi tra
        include './app/view/v_historyOrderUser.php';
    }

    public function changeInfoUser() {
        $id = $_SESSION['userLogin']['id_user'];
        $newUserModel = new user();
        $user = $newUserModel->getUserById($id)[0];
        // xử lí khi người dùng nhập form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['username'] != "" && $_POST['email'] != "") {
                $new_username = $_POST['username'];
                $id_user = $_SESSION['userLogin']['id_user'];
                $new_email = $_POST['email'];
                $newUserModel->update_userName_email($new_username, $new_email, $id_user);
                header('location: /profileUser');
                exit();
            }
        }
    }

    public function editProfileUser() {
        if (isset($_SESSION['userLogin'])) {
            extract($_SESSION['userLogin']);
            $id_user = $_SESSION['userLogin']['id_user'];
        } else if (isset($_SESSION['admin'])) {
            extract($_SESSION['admin']);
            $id_user = $_SESSION['admin']['id_user'];
        }
        $newUserModel = new user();
        $checkUses = $newUserModel->checkAccount($id_user);
        $avatar_user = '';
        if (is_array($checkUses)) {
            extract($checkUses);
            if ($img == "") {
                $avatarImage_user = "./public/upload/users/" . 'avatar-none.png';
            } else if ($img != '') {
                $avatarImage_user = "./public/upload/users/" . $img;
            }
        }
        $active__profile = 'menu__active';

        include './app/view/v_editProfileUser.php';
    }

    public function passwordUser() {
        if (isset($_SESSION['userLogin'])) {
            extract($_SESSION['userLogin']);
            $id_user = $_SESSION['userLogin']['id_user'];
        } else if (isset($_SESSION['admin'])) {
            extract($_SESSION['admin']);
            $id_user = $_SESSION['admin']['id_user'];
        }
        $newUserModel = new user();
        $checkUses = $newUserModel->checkAccount($id_user);
        $avatar_user = '';
        if (is_array($checkUses)) {
            extract($checkUses);
            if ($img == "") {
                $avatarImage_user = "./public/upload/users/" . 'avatar-none.png';
            } else if ($img != '') {
                $avatarImage_user = "./public/upload/users/" . $img;
            }
        }
        $active__password = 'menu__active';
        include './app/view/v_passwordProfileUser.php';
    }

    public function addressUser() {
        if (isset($_SESSION['userLogin'])) {
            extract($_SESSION['userLogin']);
            $id_user = $_SESSION['userLogin']['id_user'];
        } else if (isset($_SESSION['admin'])) {
            extract($_SESSION['admin']);
            $id_user = $_SESSION['admin']['id_user'];
        }
        $newUserModel = new user();
        $checkUses = $newUserModel->checkAccount($id_user);
        $avatar_user = '';
        if (is_array($checkUses)) {
            extract($checkUses);
            if ($img == "") {
                $avatarImage_user = "./public/upload/users/" . 'avatar-none.png';
            } else if ($img != '') {
                $avatarImage_user = "./public/upload/users/" . $img;
            }
        }
        $active__password = 'menu__active';
        include './app/view/v_addressProfileUser.php';
    }
}
