<?php
// Điều hướng đến các controller

include_once 'models/m_pdo.php';
include_once 'config.php';

// include models
include_once 'models/m_cart.php';
include_once 'models/m_category.php';
include_once 'models/m_product.php';
// require_once 'models/m_comment.php';
// require_once 'models/m_user.php';


if (isset($_GET['mod'])) {
    switch ($_GET['mod']) {
        case 'page':
            $ctrl_name = 'page';
            break;
        case 'cart':
            $ctrl_name = 'cart';
            break;
        case 'user':
            $ctrl_name = 'user';
            break;
        case 'admin':
            $ctrl_name = 'admin';
            break;
        case 'category':
            $ctrl_name = 'category';
            break;
        default:
            header('location:index.php?mod=page&act=home');
        break;
    }
    // controller sẽ là cầu nối nơi điều hướng các trang bên trong nó.
    //VD: v_page_home / "page" là controller và "home" là trang nằm trong controller
    include_once 'controllers/c_' . $ctrl_name . '.php';
} else {
    header("Location: ?mod=page&act=home");
}
