<?php
session_start();
ob_start();
// unset($_SESSION['admin']);

// Gữi/nhận dữ liệu thông qua models
// Hiển thị dữ liệu thông qua view
if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'home':
            // lấy dữ liệu
            include_once 'models/m_cart.php';
            include_once 'models/m_product.php';
            include_once 'models/m_category.php';
            include_once 'models/m_partner.php';
            include_once 'models/m_user.php';
            $topLoveProduct = getProductsByLove(1);
            $loveProducts = getProductsByLove(12);
            $categories = getCategories();
            $partner = getPartner();
            $upcommingProduct = getFeatureProduct();
            // if(isset($_SESSION['user'])) {
            //     print_r($_SESSION['user']);
            // }

            // hiển thị dữ liệu
            $view_name = 'home';
            break;
        case 'login':
            $loginMessage = '';
            include_once('models/m_user.php');
            /** login */
            // if (isset($_POST['login']) && $_POST['login']) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $_POST['email'];
                $password = $_POST['password'];
                // echo $name , $password;
                if ($email !== '' && $password !== '') {
                    $user = checkUser($email, $password);
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

                                // Call a function to insert the product into the cart table
                                insertCart($id, $productId, $name, $price, $img, $qty, $totalCost);
                                // redirect

                                header('Location: ?mod=cart&act=viewCart');
                            }

                            // redirect
                            header('Location: ?mod=cart&act=viewCart');
                        }

                        if ($role == 0) {
                            $_SESSION['role'] = $role;
                            $_SESSION['userLogin'] = $loginInfo;
                            // setcookie('accounts_user' . $_SESSION['userLogin']['id_user'],
                            //                                                 $loginInfo['id_user'], 
                            //                                                 (time() + (60 * 60 * 24 * 30)));
                            setcookie('accounts_user' . $_SESSION['userLogin']['id_user'], $loginInfo['id_user'], (time() + (60 * 60 * 24 * 30)));
                            header('Location: ?mod=page&act=home&idUser=' . $id);
                            exit();
                        } else if ($role == 2023) {
                            $_SESSION['role'] = $role;
                            $_SESSION['admin'] = $loginInfo;
                            header('Location: ?mod=admin&act=general');
                            exit();
                        }
                    } else {
                        $loginMessage = '<span class="primary-text form__message fw-smb label-medium"></span>';
                        header('Location: ?mod=page&act=login#login-section');
                        exit();
                    }
                }
            }
            if (isset($_SESSION['userLogin'])) {
                extract($_SESSION['userLogin']);
                $_SESSION['role'] = $role;
                header('Location: ?mod=page&act=home');
                exit();
            } else if (isset($_SESSION['admin'])) {
                header('Location: ?mod=admin&act=home');
                exit();
            }
            // hiển thị dữ liệu
            $view_name = 'login';
            break;
        case 'register':
            // lấy dữ liệu
            /** register */
            include_once 'models/m_user.php';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                if ($username !== '' && $email !== '' && $password !== '') {
                    $userId = insertUser($username, $email, $password);
                    $list_infoUser = [
                        "id_user" => $userId,
                        "name_user" => $username,
                        "password_user" => $password,
                        "email_user" => $email
                    ];
                    $_SESSION['user'] = $list_infoUser;
                }
            }
            if (isset($_SESSION['user'])) {
                $emailView = $email_user;
                $passwordView = $password_user;
                header("Location: ?mod=page&act=login#login-section");
                exit();
            }
            ;
            break;
        case 'category':
            // lấy dữ liệu
            include_once 'models/m_product.php';
            include_once 'models/m_category.php';

            $maxPrice = getMaxProductPrice();
            $minPrice = getMinProductPrice();

            $manualMin = $minPrice;
            $manualMax = $maxPrice;
            if (isset($_GET['minPrice']) && isset($_GET['maxPrice'])) {
                $manualMin = $_GET['minPrice'];
                $manualMax = $_GET['maxPrice'];
            }

            if (isset($_GET['idCategory'])) {
                $idCategory = $_GET['idCategory'];
                $category = getCategoryById($idCategory);
                $featureProducts = getFeatureProductOfCategory($idCategory, $limit = 0);
                $categoryProducts = getProductsByCategoryId($idCategory);

                /** filter handler */
                if (isset($_POST['priceFilter']) && $_POST['priceFilter']) {
                    $min = $_POST['minPrice'];
                    $max = $_POST['maxPrice'];

                    $categoryProducts = getCategoryProductsByPriceFilter($min, $max, $idCategory);
                }

                // Check if the 'minPrice' and 'maxPrice' values are set in the POST data
                if (isset($_GET['minPrice']) && isset($_GET['maxPrice'])) {
                    $min = $_GET['minPrice'];
                    $max = $_GET['maxPrice'];

                    // Use the $min and $max values to filter the category products
                    $categoryProducts = getCategoryProductsByPriceFilter($min, $max, $idCategory);
                }

                // name filter approach
                if (isset($_GET['filterName']) and $_GET['filterName'] != '') {
                    $order = $_GET['filterName'];
                    $categoryProducts = getProductsByCategoryId($idCategory, $order);
                }
            }
            // hiển thị dữ liệu
            $view_name = 'category';
            break;
        case 'general':
            include_once 'models/m_user.php';
            $view_name = 'general';
            break;

        // case 'filter':
        //     include_once 'models/m_product.php';
        //     include_once 'models/m_category.php';
        case 'shop':
            include_once 'models/m_product.php';
            include_once 'models/m_category.php';
            $maxPrice = getMaxProductPrice();
            $minPrice = getMinProductPrice();

            $manualMin = $minPrice;
            $manualMax = $maxPrice;

            $view_name = 'shop';
            break;
        case 'editCmt':

            break;
        case 'reportCmt':
            include_once 'models/m_comment.php';
            $getID = $_GET['reportId'];
            $getReported = $_GET['reported'];
            $getIdProduct = $_GET['idProduct'];
            $reported = (int) $getReported + 1;
            reported($getID, $reported);
            header("Location: ?mod=page&act=productDetail&idProduct={$getIdProduct}");
            break;
        case 'delCmt':
            include_once 'models/m_comment.php';
            $getID = (int) $_GET['reportId'];
            $getIdProduct = $_GET['idProduct'];
            $getAllCmtImg = getAllCmtImg($getID);
            foreach ($getAllCmtImg as $item) {
                $delete_file = './upload/users/' . $item['src'];
                unlink($delete_file);
                delImgCmt($item['id']);
            }
            delCmt($getID);
            header("Location: ?mod=page&act=productDetail&idProduct={$getIdProduct}");
            break;
        case 'productDetail';
            include_once 'models/m_product.php';
            include_once 'models/m_category.php';
            include_once 'models/m_img.php';
            include_once 'models/m_comment.php';
            include_once 'models/m_address.php';

            $view_name = 'productDetail';


            break;
        case 'search':

            $view_name = 'searchMobile';
            break;
        case 'contact':

            $view_name = 'contact';
            break;
        case 'aboutUs':

            $view_name = 'aboutUs';
            break;
        default:

            break;
    }
    require_once 'views/v_user_layout.php';
}
?>