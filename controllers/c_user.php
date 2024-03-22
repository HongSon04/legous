<?php
session_start();
ob_start();
// Gữi/nhận dữ liệu thông qua models
// Hiển thị dữ liệu thông qua view
include_once 'models/m_user.php';
include_once 'config.php';
if (isset($_GET['act'])) {
    if (isset($_SESSION['userLogin'])) {
        extract($_SESSION['userLogin']);
        $id_user = $_SESSION['userLogin']['id_user'];
    } else if (isset($_SESSION['admin'])) {
        extract($_SESSION['admin']);
        $id_user = $_SESSION['admin']['id_user'];
    }
    $checkUses = checkAccount($id_user);
    $avatar_user = '';
    if (is_array($checkUses)) {
        extract($checkUses);
        if ($img == "") {
            $avatarImage_user = USER_PATH . 'avatar-none.png';
        } else if ($img != '') {
            $avatarImage_user = USER_PATH . $img;
        }
    }
    $active__general = '';
    $active__profile = '';
    $active__password = '';
    $active__address = '';
    $active__order = '';
    $active__deleteAccount = '';
    switch ($_GET['act']) {
        case 'general':
            // lấy dữ liệu
            include_once 'models/m_user.php';
            // hiển thị dữ liệu
            $view_name = 'general';
            #add class
            $active__general = 'menu__active';
            # code bên trang v_general.php nha... <3
            break;

        case 'editprofile':
            // lấy dữ liệu
            include_once 'models/m_user.php';
            // hiển thị dữ liệu
            $view_name = 'editprofile';
            #add class
            $active__profile = 'menu__active';
            # code bên trang v_editprofile.php nha... <3
            break;

        case 'password':
            include_once 'models/m_user.php';
            $view_name = 'user_password';
            # add class
            $active__password = 'menu__active';
            break;

        case 'address':
            include_once 'models/m_user.php';
            include_once 'models/m_address.php';
            // hiển thị dữ liệu
            $view_name = 'address';
            #add class
            $active__address = 'menu__active';
            # qua v_address.php kiếm code đi fen....
            break;

        case 'edit-address':
            include_once 'models/m_user.php';
            include_once 'models/m_address.php';
            $view_name = 'form-editAddress';
            break;

        case 'delete-address':
            include_once 'models/m_user.php';
            include_once 'models/m_address.php';
            $view_name = 'form-editAddress';
            # xóa địa chỉ
            $id_user = $_SESSION['userLogin']['id_user'];
            if (isset($_GET['id-address']) && ($_GET['id-address']) > 0) {
                $id_address = $_GET['id-address'];
                delete_address($id_address);
                header('location: ?mod=user&act=address');
            }
            break;

        case 'order-history':
            include_once 'models/m_user.php';
            $view_name = 'user_orderHistory';
            #add class
            $active__order = 'menu__active';
            $title = 'Lịch sử đơn hàng';
            $itemsPage = '';
            $itemsPage = 10; // số bill mỗi trang
            if (isset($_SESSION['userLogin']['id_user'])) {
                $id_user = $_SESSION['userLogin']['id_user'];
            }
            break;

        case 'order-detail':
            include_once 'models/m_user.php';
            $view_name = 'user_orderDetail';
            $title = 'Lịch sử đơn hàng';
            if (isset($_GET['id'])) {
                $id_order = ($_GET['id']);
                $order = get_order($id_order);
                $product_order = get_product_order($id_order);
            }
            break;

        case 'logOut-account':
            include_once 'models/m_user.php';
            unset($_SESSION['userLogin']);
            unset($_SESSION['admin']);
            header('location: ?mod=page&act=login');
            break;

        case 'change_account':
            // lấy dữ liệu
            include_once 'models/m_user.php';
            if (isset($_GET['id'])) {
                $id_account = $_GET['id'];
                extract(checkAccounts($id_account));
                $loginInfo = [
                    "email_user" => $email,
                    "password_user" => $password,
                    "id_user" => $id
                ];
                $_SESSION['userLogin'] = $loginInfo;
                header('location:?mod=user&act=general');
            }
            break;

        case 'delete-account':
            include_once 'models/m_user.php';
            include_once 'models/m_address.php';
            include_once 'models/m_comment.php';
            $view_name = 'user-deleteAccount';
            #add class
            $active__deleteAccount = 'menu__active';
            break;
        default:
            break;
    }
    require_once 'views/v_user_layout.php';
}
?>