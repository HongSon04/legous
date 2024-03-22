<?php
     if(isset($_SESSION['userLogin']) && (is_array($_SESSION['userLogin']) || is_object($_SESSION['userLogin']) && count($_SESSION['userLogin']) > 0)){
        extract($_SESSION['userLogin']);
        $id_user = $_SESSION['userLogin']['id_user'];
    }
    $tbody_html = '';
    $dost_html = '';
    if(count(get_allBill($id_user)) > 0) {  
        # phân trang
        // Lấy tổng số đơn hàng từ cơ sở dữ liệu hoặc từ nơi khác
        $total_orders = get_total_orders($id_user);
        // Tính toán tổng số trang
        $total_pages = ceil($total_orders / $itemsPage);
        // Trang hiện tại (lấy từ yêu cầu hoặc mặc định là 1)
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        // Tính toán trang kế tiếp
        $next_page = ($current_page % $total_pages) + 1;
        $order_history = get_orderHistory($id_user, $current_page, $itemsPage);
        foreach ($order_history as $item ) {
            extract($item);
            $getHTML = "";
            if($status == 1){
                $getHTML = '<span class="label-large-prominent canceled">Đã hủy</span>';
            }elseif($status == 2){
                $getHTML = '<span style="color: black;" class="label-large-prominent pending">Chờ lấy hàng</span>';
            }elseif($status == 3){
                $getHTML = '<span class="label-large-prominentd elivered">Đang giao hàng</span>';
            }elseif($status == 4){
                $getHTML = '<span class="label-large-prominent return">Hoàn/Trả</span>';
            }elseif($status == 5){
                $getHTML = '<span class="label-large-prominent  pending">Đã giao hàng</span>';
            }
            else{
                $getHTML = '<span style="color: gray;" class="label-large-prominent">Chờ xác nhận</span>';
            }
            $name_payment = get_namePayment($id_payment);
            $tbody_html .=' <tr>
                    <td class="label-large-prominent"><span># '.$id.'</span></td>
                    <td class="label-large-prominent"><span>'.$username.'</span></td>
                    <td class="label-large-prominent"><span></span></td>
                    <td class="label-large-prominent"><span>'.$create_date.'</span></td>
                    <td class="label-large-prominent delivered"><span>'.$getHTML.'</span></td>
                    <td class="label-large-prominent"><span class="price">'.formatVND($total).'</span></td>
                    <td class="label-large-prominent">
                        <a href="?mod=user&act=order-detail&id='.$id.'" class="label-large-prominent">Xem chi tiết</a>
                    </td>
                </tr>
            ';
        };
        if(!isset($total_pages)){
            $total_pages = 1  ; // Gán giá trị mặc định nếu biến chưa được khai báo
        }
        // Hiển thị các nút phân trang
        for ($i = 1; $i <= $total_pages; $i++) {
            $activeClass = ($i == (int)$current_page) ? 'dots-active' : '';
            $dost_html .= '<div class="list__dots--item flex-center rounded-8 '.$activeClass.'">
                                <a style=" color: #551A8B;" href="?mod=user&act=order-history&page='.$i.'">
                                    ' . $i . 
                                '</a>
                            </div>';
        }
        $show_main = '<div class="main__inner--bottom-right">
                            <div class="main__inner--bottom-right--content flex-column">
                                <div class="bottom-right--content_main flex full">
                                    <table class="full">
                                        <thead class="full">
                                            <tr>
                                                <!-- <th class="label-large-prominent"><input type="checkbox"></th> -->
                                                <th class="label-large-prominent">Order ID</th>
                                                <th class="label-large-prominent">Tên Khách Hàng</th>
                                                <th class="label-large-prominent">PTTT</th>
                                                <th class="label-large-prominent">Ngày Đặt</th>
                                                <th class="label-large-prominent">Trạng Thái</th>
                                                <th class="label-large-prominent">Tổng </th>
                                                <th class="label-large-prominent">Khác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        '.$tbody_html.'
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bottom-right--content_bottom flex-between full">
                                <div class="list__dots flex g16">
                                    '.$dost_html.'<div class="btn__next--dots flex-center label-large btn-next flex g8"><a style="display: flex; gap: 0.5rem; color: #551A8B;" href="?mod=user&act=order-history&page='.$next_page.'"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#6750A4"/>
                                        </svg>Trang tiếp theo</a></div>
                                </div>
                                <div style="color: #551A8B; cursor: pointer;" onclick="button_back()" class="btn-back flex-center label-large flex g8">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z" fill="#6750A4"/>
                                    </svg> Trở lại trang trước
                            </div>
                    </div>';
    }else {
        $show_main = '<div class="main__inner--bottom-right">
                            <div class="no_bill">
                                <span>Tài Khoản chưa có đơn hàng nào...</span>
                            </div>
                            <div class="bottom-right--content_bottom flex-between full">
                                <div class="list__dots flex g16">
                                </div>
                            <div style="color: #551A8B; cursor: pointer;" onclick="button_back()" class="btn-back flex-center label-large flex g8">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z" fill="#6750A4"/>
                                    </svg>
                                    Trở lại trang trước
                            </div>
                    </div>';
    }
?>

<header class="header flex-full width-full flex-center pof">
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
                <a href="?mod=page&act=shop" class="header__nav__link">Cửa hàng</a>
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
                                    style="background-image: url('<?= constant('PRODUCT_PATH') . $specialProduct['img'] ?>')">
                                    <div class="product__overlay poa flex-center">
                                        <div class="flex g12 in-stock__btn-set">
                                            <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                                            <button class="icon-btn love-btn"><i class="fa fa-heart"></i></button>
                                            <button class="icon-btn"><i class="fal fa-shopping-cart"></i></button>
                                        </div>
                                        <!-- <div class="flex g12 sold-out__btn-set">
                                            <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                                            <button class="icon-btn"><i class="fal fa-plus"></i></button>
                                            <button class="icon-btn"><i class="fal fa-arrow-right"></i></button>
                                        </div> -->
                                    </div>
                                </a>
                                <a href="#" class="product__info">
                                    <div class="product__info__name title-medium fw-smb"><?= $specialProduct['name'] ?></div>
                                    <div class="product__info__price body-medium"><?= formatVND($specialProduct['price']) ?></div>
                                </a>
                                <div class="product__info flex-between width-full">
                                    <div class="product__info__view body-medium">1,2m+ views</div>
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
                <a href="?mod=cart&act=viewCart" class="icon-btn open-respon-btn"><i class="fal fa-shopping-cart"></i></a>
            </li>
        </ul>
        <!-- header respon nav end -->

    </div>

    <!-- header search box start -->
    <div class="header__search-box pof">
        <button class="icon-btn close-search-box__btn" style="align-self: flex-end;">
            <i class="fal fa-times"></i>
        </button>
        <form action="" class="form search__form">
            <div class="form__group flex-center por">
                <input type="text" class="form__input search__form__input" placeholder="Nhập tên sản phẩm">
                <button class="icon-btn search__form__btn"><i class="far fa-search"></i></button>
            </div>
        </form>
        <div class="search__product__wrapper mia flex-column g16" style="overflow-y: auto; width: 50vw; height: 50rem">
            <!-- single search product start -->
            <!-- <div class="search__product flex-between p20 rounded-8 width-full">
                <div class="flex g12">
                    <div class="search__product__banner">
                        <img src="./public/assets/media/images/product/v944cyfrwt851.webp" alt="">
                    </div>
                    <div class="search__product__info flex-column flex-between">
                        <a href="" class="search__product__name title-large underline">Itachi - Susano
                            Ribcage</a>
                        <div class="search__product__price title-medium">2.344.900 VND</div>
                    </div>
                </div>
                <div class="flex-between flex-column a-end">
                    <button class="icon-btn delete-search-product__btn"><i class="fal fa-times"></i></button>
                    <div class="flex g12">
                        <button class="icon-btn"><i class="fal fa-share"></i></button>
                        <button class="icon-btn love-btn toggle-btn"><i class="fal fa-heart"></i></button>
                        <button class="icon-btn"><i class="fal fa-shopping-cart"></i></button>
                    </div>
                </div>
            </div> -->
            <!-- single search product end -->
        </div>
    </div>
    <!-- header search box end -->

</header>
<main class="main__user">
    <div class="main__inner">
        <div class="main__inner--top">
            <div class="avatar__image">
                <img srcset="<?=$avatarImage_user?> 2x" alt="" class="avatar__image--user">
            </div>
            <div class="info__user">
                <div class="info__user--top">
                    <span class="user__name"><?=$username?></span>
                    <span>/</span>
                    <span><?=$title?></span>
                </div>
                <div class="info__user--bottom">
                    <span class="info__user--desc">
                        Cập nhật tên người dùng và quản lý tài khoản của bạn
                    </span>
                </div>
            </div>
            <?php include_once 'views/box_changeAccountUser.php'; ?>
        </div>
        <div class="main__inner--bottom">
            <?=$show_main?>
        </div>
    </div>
</main>
<script>
    // Function to format the value with currency symbol and rounding for VND
    function formatCurrency(value) {
        const formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            maximumFractionDigits: 0,
        });
        return formatter.format(value);
    }
</script>
