<?php
require_once 'models/m_user.php';
if(isset($_SESSION['userLogin']['id_user']) && (is_array($_SESSION['userLogin']['id_user']) || is_object($_SESSION['userLogin']['id_user']) && count($_SESSION['userLogin']['id_user']) > 0)) {
    extract($_SESSION['userLogin']['id_user']);
    $_SESSION['id_user'] = $id_user;
    if(is_array(checkAccount($id_user))) {
        extract(checkAccount($id_user));
    }
}
?>
<?php
/** header nav rendering */
$subnavHtml = '';
$categories = getCategories();
foreach($categories as $item) {
    extract($item);
    $link = "?mod=page&act=product&idCategory=$id";
    $products = getProductsByCategoryId($id, 1, 3);

    $productHtml = '';
    foreach($products as $product) {
        extract($product);
        $link = "?mod=page&act=productDetail&idProduct=$id";

        $productHtml .=
            <<<HTML
                    <li class="mega-menu__nav--item"><a href="$link" class="mega-menu__nav--link body-large">$name</a></li>
                HTML;
    }

    $subnavHtml .=
        <<<HTML
            <ul class="mega-menu__nav">
                <h4 class="title-large fw-black">$item[name]</h4>
                <div class="block">
                    $productHtml
                </div>
            </ul>
        HTML;
}

// render special product in mega menu
$specialProduct = getSpecialProduct();

/** render user widget */
$userWidgetHtml = '';
if(isset($_SESSION['userLogin']) && !empty($_SESSION['userLogin'])) {
    $id = $_SESSION['userLogin']['id_user'];
    $user = getUserById($id)[0];
    extract($user);
    $userWidgetHtml =
        <<<HTML
            <a href="#" class="user-widget flex flex-center g6">
                <i class="fal fa-user user-widget__icon"></i>
                <div class="username">$user[username]</div>
            </a>
            <div class="flex-between header__subnav__wrapper poa box-shadow1 p20 rounded-8" style="top: 100%; left: 0;">
                <ul class="header__subnav flex-full flex-column g6">
                    <li class="header__nav__item header__subnav__item">
                        <a href="?mod=user&act=general" class="header__nav__link header__subnav__link ttu">Thông tin tài khoản</a>
                    </li>
                    <li class="header__nav__item header__subnav__item">
                        <a href="?mod=user&act=order-history" class="header__nav__link header__subnav__link ttu">lịch sử đơn hàng</a>
                    </li>
                    <li class="header__nav__item header__subnav__item">
                        <a href="?mod=user&act=logOut-account&id-account=$id" class="header__nav__link header__subnav__link ttu error60">Đăng xuất</a>
                    </li>
                    <!-- <li class="" style="padding: 0.4rem 0.8rem;">
                        <button class="btn " id="dark-light__mode" onclick="dark_lightMod(this)">
                            <i class="fas fa-clouds-sun" id="icon_sun"></i>
                            <i class="fas fa-moon-cloud" id="icon_moon"></i>
                            <span id="color__dark-light" class=""></span>
                        </button>
                    </li> -->
                </ul>
            </div>
        HTML;
} else {
    $userWidgetHtml =
        <<<HTML
            <a href="?mod=page&act=login" class="btn primary-btn">Đăng ký ngay</a>
        HTML;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEGOUS - HOME PAGE</title>
    <!-- css link -->
    <link rel="stylesheet" href="./public/assets/resources/sass/css/app.css">
    <!-- favicon link -->
    <link rel="icon" type="image/x-icon" href="./public/assets/media/images/favicon/favicon.svg">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"
        type="text/css" />
    <!-- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Space+Mono&display=swap"
        rel="stylesheet">
    <!-- slick slider link -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- jquery ui link -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- jquery link -->
    <script src="./public/assets/resources/js/jquery.js"></script>
    <!-- ion icon -->
    <script type="module"src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="container-full por">
        <!-- header start -->
        <header class="header desktop flex-full width-full flex-center pof">
            <div class="header__inner flex-full flex-between por v-center">
                <!-- header respon nav start -->
                <ul class="header__nav header__nav-respon">
                    <li class="header__nav__item header__nav-respon__item">
                        <button class="icon-btn open-respon-btn"><i class="fal fa-bars"></i></button>
                    </li>
                </ul>
                <!-- header respon nav end -->
                <a href="?mod=page&act=home"><img src="./public/assets/media/images/logo.svg" alt="" class="logo"></a>
                <ul class="header__nav flex g60">
                    <li class="header__nav__item"><a href="?mod=page&act=home" class="header__nav__link">Trang chủ</a>
                    </li>
                    <li class="header__nav__item">
                        <a href="?mod=page&act=shop&page=1" class="header__nav__link">Cửa hàng</a>
                        <div class="header__subnav__wrapper header__mega-menu poa box-shadow1 rounded-8">
                            <div class="top p20 flex-column g12 mega-menu__item">
                                <div class="title-medium fw-bold">Cửa hàng</div>
                                <span class="body-medium">Khám phá các sản phẩm của Legous. Vào cửa hàng nào!</span>
                            </div>
                            <div class="content flex mega-menu__item">
                                <div class="product__wrapper p20">
                                    <!-- single product start -->
                                    <div class="title-large fw-bold primary-masking-text">Hot deal! Sale off 20%</div>
                                    <div class="product mt12">
                                        <a href="#" class="product__banner oh banner-contain rounded-8 por"
                                            style="background-image: url('<?= constant('PRODUCT_PATH').$specialProduct['img'] ?>')">
                                            <div class="product__overlay poa flex-center">
                                                <div class="flex g12 in-stock__btn-set">
                                                    <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                                                    <button class="icon-btn love-btn"><i
                                                            class="fa fa-heart"></i></button>
                                                    <button class="icon-btn"><i
                                                            class="fal fa-shopping-cart"></i></button>
                                                </div>
                                                <!-- <div class="flex g12 sold-out__btn-set">
                                                    <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                                                    <button class="icon-btn"><i class="fal fa-plus"></i></button>
                                                    <button class="icon-btn"><i class="fal fa-arrow-right"></i></button>
                                                </div> -->
                                            </div>
                                        </a>
                                        <a href="#" class="product__info">
                                            <div class="product__info__name title-medium fw-smb">
                                                <?= $specialProduct['name'] ?>
                                            </div>
                                            <div class="product__info__price body-medium">
                                                <?= formatVND($specialProduct['price']) ?>
                                            </div>
                                        </a>
                                        <div class="product__info flex-between width-full">
                                            <div class="product__info__view body-medium">
                                                <?= formatViewsNumber($specialProduct['price']) ?> views</div>
                                            <div class="product__info__rated flex g6 v-center body-medium">
                                                4.4 <i class="fa fa-star start"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end -->
                                </div>
                                <div class="mega-menu__nav--wrapper p20 auto-grid g30">
                                    <?= $subnavHtml ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="header__nav__item por">
                        <a href="#" class="header__nav__link">Khác</a>
                        <div class="flex-between header__subnav__wrapper poa box-shadow1 p20 rounded-8 g30">
                            <ul class="header__subnav flex-full flex-column">
                                <li class="header__nav__item header__subnav__item">
                                    <a href="#" class="header__nav__link header__subnav__link ttu">liên hệ</a>
                                </li>
                                <li class="header__nav__item header__subnav__item">
                                    <a href="#" class="header__nav__link header__subnav__link ttu">trợ giúp</a>
                                </li>
                                <li class="header__nav__item header__subnav__item">
                                    <a href="#" class="header__nav__link header__subnav__link ttu">về chúng tôi</a>
                                </li>
                                <li class="header__nav__item header__subnav__item">
                                    <a href="#" class="header__nav__link header__subnav__link ttu">chính sách bảo
                                        mật</a>
                                </li>
                                <li class="header__nav__item header__subnav__item">
                                    <a href="#" class="header__nav__link header__subnav__link ttu">chính sách hoàn
                                        tiền</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <ul class="header__nav flex g30">
                    <li class="header__nav__item flex-center">
                        <button class="icon-btn open-search-box__btn rounded-full">
                            <i class="far fa-search"></i>
                        </button>
                    </li>
                    <li class="header__nav__item flex-center">
                        <a href="?mod=cart&act=viewCart" class="icon-btn">
                            <i class="far fa-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="header__nav__item por flex-center">
                        <?= $userWidgetHtml ?>
                    </li>
                </ul>

                <!-- header respon nav start -->
                <ul class="header__nav header__nav-respon">
                    <li class="header__nav__item header__nav-respon__item">
                        <a href="?mod=cart&act=viewCart" class="icon-btn open-respon-btn"><i
                                class="fal fa-shopping-cart"></i></a>
                    </li>
                </ul>
                <!-- header respon nav end -->

            </div>

            <!-- header search box start -->
            <div class="header__search-box pof">
                <button class="icon-btn close-search-box__btn" style="align-self: flex-end;">
                    <i class="fal fa-times"></i>
                </button>
                <form action="?mod=page&act=search" class="form search__form" method="get">
                    <div class="form__group flex-center por">
                        <input type="text" name="query" class="form__input search__form__input"
                            placeholder="Nhập tên sản phẩm">
                        <button type="submit" class="icon-btn search__form__btn"><i class="far fa-search"></i></button>
                    </div>
                </form>
                <div class="search__product__wrapper mia flex-column g16"
                    style="overflow-y: auto; width: 50vw; height: 50rem">
                    <!-- single search product start -->
                    
                    <!-- single search product end -->
                </div>
            </div>
            <!-- header search box end -->

        </header>

        <!-- header respon fullscreen nav start -->
        <ul class="header__nav-respon header__nav-respon-full">
            <li class="header__nav-respon-full__item flex-between v-center">
                <?php 
                    $linkToUser = '';
                    if (isset($_SESSION['userLogin']) && is_array($_SESSION['userLogin']) && !empty($_SESSION['userLogin'])) {
                        $id_user = $_SESSION['userLogin']['id_user'];
                        $linkToUser = "?mod=user&act=general&id_user=$id_user";
                    } else {
                        $linkToUser = "?mod=page&act=login";
                    }
                ?>
                <a href="<?= $linkToUser ?>" class="icon-btn"><i class="fal fa-user"></i></a>
                <button class="icon-btn close-respon-btn"><i class="fal fa-times"></i></button>
            </li>
            <li class="header__nav-respon-full__item flex-between">
                <a href="?mod=page&act=home" class="header__nav-respon-full__link">Trang chủ</a>
            </li>
            <li class="header__nav-respon-full__item flex-between">
                <a href="?mod=page&act=shop&page=1" class="header__nav-respon-full__link">cửa hàng</a>
            </li>
            <li class="header__nav-respon-full__item flex-between">
                <a href="?mod=page&act=contact" class="header__nav-respon-full__link">liên hệ</a>
            </li>
        </ul>
        <!-- header respon fullscreen nav end -->

        <!-- header end -->

        <!-- site content start -->
        <?php
        require_once 'v_'.$view_name.'.php';
        ?>
        <!-- site content end -->

        <!-- footer start -->
        <footer class="footer section auto-grid g60">
            <div class="footer__infomation flex-column g30">
                <a href="#" class="logo">
                    <img src="./public/assets/media/images/logo-white.svg" alt="" class="logo-image" />
                </a>
                <div class="row g30">
                    <div class="footer-column">
                        <h3 class="footer-heading ttu">LEGOUS</h3>
                        <ul class="footer-links">
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Trang chủ</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Cửa hàng</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Liên hệ</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Về chúng tôi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3 class="footer-heading ttu">SUPPORT</h3>
                        <ul class="footer-links">
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Hướng dẫn xây dựng</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Hướng dẫn đặt hàng</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Đăng ký thành viên</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Đăng ký thành viên</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3 class="footer-heading ttu">SOCIAL</h3>
                        <ul class="footer-links">
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Facebook</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Zalo</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Twitter</a>
                            </li>
                            <li>
                                <a href="#!" class="footer-link text-btn btn rounded-100">Instagram</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer__email-form flex-column g30" style="color: white;">
                <div class="text-46 ttu" style="max-width: 75%; color: white">ĐĂNG KÝ NGAY
                    CHỈ BẰNG EMAIL</div>
                <form action="" class="form email__form" method="post" style="width: fit-content">
                    <div class="form__group por flex">
                        <input type="text" class="form__input footer__email-input" id="email" placeholder="Email...">
                        <button type="button" class="btn primary-btn poa form-btn">
                            <i class="fal fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
                <span class="body-medium">LEGOUS là một trang web chuyên về mô hình và lego từ các bộ truyện tranh nổi
                    tiếng cũng như những kiến trúc ở thế giới hiện thực. Mục tiêu của chúng tôi là trở thành một thương
                    hiệu lớn mạnh trong lĩnh vực này. Chúng tôi sẽ cố gắng hết sức để đạt được nó.</span>
            </div>
        </footer>
        <footer class="footer section footer--mini flex j-start g30">
            <span class="footer--mini__item body-small flex g6 v-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                        d="M9.89999 7.6165C10.9667 7.6665 11.2417 8.57484 11.2583 8.99984H12.75C12.6833 7.34984 11.5083 6.3415 9.87499 6.3415C8.03332 6.3415 6.66666 7.49984 6.66666 10.1165C6.66666 11.7332 7.44166 13.6498 9.86666 13.6498C11.7167 13.6498 12.7083 12.2748 12.7333 11.1915H11.2417C11.2167 11.6832 10.8667 12.3415 9.88332 12.3915C8.79166 12.3582 8.33332 11.5082 8.33332 10.1165C8.33332 7.70817 9.39999 7.63317 9.89999 7.6165ZM9.99999 1.6665C5.39999 1.6665 1.66666 5.39984 1.66666 9.99984C1.66666 14.5998 5.39999 18.3332 9.99999 18.3332C14.6 18.3332 18.3333 14.5998 18.3333 9.99984C18.3333 5.39984 14.6 1.6665 9.99999 1.6665ZM9.99999 16.6665C6.32499 16.6665 3.33332 13.6748 3.33332 9.99984C3.33332 6.32484 6.32499 3.33317 9.99999 3.33317C13.675 3.33317 16.6667 6.32484 16.6667 9.99984C16.6667 13.6748 13.675 16.6665 9.99999 16.6665Z"
                        fill="white" />
                </svg>
                /2023 LEGOUS OFFICIAL
            </span>
            <a href="#" class="footer--mini__link body-small">Terms of use</a>
            <a href="#" class="footer--mini__link body-small">Private policy</a>
            <a href="#" class="footer--mini__link body-small">Return policy</a>
            <a href="#" class="footer--mini__link body-small">Cookie policy</a>
            <a href="#" class="footer--mini__link body-small">Support</a>
        </footer>
        <!-- footer end -->
        <div class="form__address--container" style="display: none;"></div>
    </div>
</body>

</html>
<script src="./public/assets/resources/js/main.js"></script>
<script src="./public/assets/resources/js/user.js"></script>
<script src="./public/assets/resources/js/dark-light_mode.js"></script>