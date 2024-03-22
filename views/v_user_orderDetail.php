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
        <div class="main__inner--bottom flex-column">
            <div class="main__inner--bottom-container flex-column rounded-2 p30 g30 ">
                <?php
                foreach ($order as $item) {
                    extract($item);
                    if($phone_recipient == 1 || $address_recipient == 1 || $address_detail_recipient == 1 ) {
                        $fullname_order = $username;
                        $email_order = $email_user;
                        $phone_order = $phone_user;
                        $address_ship = $address_detail_user;
                    }else {
                        $fullname_order = $name_recipient;
                        $email_order = $email_recipient;
                        $phone_order = $phone_recipient;
                        $address_ship = $address_detail_recipient;
                    }
                    $name_payment = get_namePayment($id_payment);
                    $name_shipping = get_nameShipping($id_shipping);
                    $fullname = get_fullname($id_user);
                    $getHTML = "";
                    if ($status == 1) {
                        $getHTML = '<span class="label-large-prominent canceled">Đã hủy</span>';
                    } elseif ($status == 2) {
                        $getHTML = '<span style="color: black;" class="label-large-prominent pending">Chờ lấy hàng</span>';
                    } elseif ($status == 3) {
                        $getHTML = '<span class="label-large-prominentd elivered">Đang giao hàng</span>';
                    } elseif ($status == 4) {
                        $getHTML = '<span class="label-large-prominent return">Hoàn/Trả</span>';
                    } elseif ($status == 5) {
                        $getHTML = '<span class="label-large-prominent  pending">Đã giao hàng</span>';
                    } else {
                        $getHTML = '<span style="color: gray;" class="label-large-prominent">Chờ xác nhận</span>';
                    }
                    echo '
                            <div class="main__inner--bottom  fist--container flex-column">
                                Mã đơn hàng : #' . $id . '
                                <div class="fist--container date  center ">
                                    <i style="margin-right: 1rem;" class="fa-solid fa-calendar-days"></i>' . $create_date . '
                                </div>
                                <div class="pending">' . $getHTML . '</div>
                            </div>
                            <div class="main__inner--bottom light-devider " style="height: .1rem; width: 100%"></div>
                            <div class="main__inner--bottom second--container flex   g30">
                                <div class="second--container box-content flex g30 ">
                                    <i class="fa-regular fa-user"></i>
                                    <div class="box-content content flex-column  g8">
                                        <h3>Khách hàng</h3>
                                        <p style="font-size: 1.5rem";>Họ và tên:  ' . $fullname_order . '</p>
                                        <p>Email: ' . $email_order . '</p>
                                        <p>Điện thoại: ' . $phone_order . '</p>
                                        
                                    </div>
                                </div>
                                <div class="second--container box-content flex g30 ">
                                    <i class="fa-solid fa-wallet"></i>
                                    <div class="box-content content flex-column  g8">
                                        <h3>Thông tin đặt hàng</h3>
                                        <p>Phương thức vận chuyển: </br> ' . $name_shipping . ' </p>
                                        <p>Phương thức thanh toán:  </br>' . $name_payment . '</p>
                                        
                                    </div>
                                </div>
                                <div class="second--container box-content flex g30 ">
                                    <i class="fa-solid fa-wallet"></i>
                                    <div class="box-content content flex-column  g8">
                                        <h3>Giao hàng tới</h3>
                                        <p>Địa chỉ: ' . $address_ship . ' </p>
                                        
                                    </div>
                                </div>
                            </div>

                        ';
                }
                ?>
                <div class="main__inner--bottom light-devider " style="height: .1rem; width: 100%"></div>
                <div class="main__inner--bottom finally--container flex-column ">
                    <h2>Sản phẩm</h2>
                    <div class="box__table">
                        <table>
                            <thead>
                                <tr>
                                    <!-- <th class="label-large-prominent"><input type="checkbox"></th> -->
                                    <th class="label-large-prominent">Tên Sản Phẩm</th>
                                    <th class="label-large-prominent">Giá Sản Phẩm</th>
                                    <th class="label-large-prominent">Số Lượng</th>
                                    <th class="label-large-prominent">Tổng Giá</th>
                                </tr>
                            </thead>
                            <?php
                            $total_price = 0;
                            foreach ($product_order as $item) {
                                extract($item);
                                $total_price += $total_cost;
                                echo '<tbody>
                                        <tr>
                                            <td class="label-large-prominent"><span>' . $name . '</span></td>
                                            <td class="label-large-prominent"><span>' . formatVND($price) . '</span></td>
                                            <td class="label-large-prominent"><span>' . $qty . '</span></td>
                                            <td class="label-large-prominent"><span>' . formatVND($total_cost) . '</span></td>
                                        </tr>
                                    </tbody>
                                    ';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="main__inner--info-order full flex-column g30">
                <div class="main__inner--info-orderTop flex j-end">
                    <div class="ain__inner--info-orderTop---items flex-column g12">
                        <?php
                        $tax = $total_price / 100 * 10;
                        $shipping_price = get_priceShipping($id_shipping);
                        $coupon = 0;
                        if ($id_coupon != '') {
                            $coupon = get_priceCoupon($id_coupon);
                        }
                        $total_all = ($total_price + $tax + $shipping_price) - $coupon;
                        echo '
                                <div class="main__inner--info-orderTop---item flex flex-between g60">
                                <span>Tổng giá trị sản phẩm</span>
                                <span>' . formatVND($total_price) . '</span>
                                </div>
                                <div class="main__inner--info-orderTop---item flex flex-between g60">
                                    <span>Thuế (10%)</span>
                                    <span>' . formatVND($tax) . '</span>
                                </div>
                                <div class="main__inner--info-orderTop---item flex flex-between g60">
                                        <span>Phí vận chuyển</span>
                                        <span>' . formatVND($shipping_price) . '</span>
                                </div>
                                <div class="main__inner--info-orderTop---item flex flex-between g60">
                                    <span>Giảm giá</span>
                                    <span>- ' . formatVND($coupon) . '</span>
                                </div>
                                <div class="main__inner--info-orderTop---item flex flex-between g60">
                                    <span class="all_price">Tổng giá</span>
                                    <span class="all_price">' . formatVND($total_all) . '</span>
                                </div>
                                
                            ';

                        ?>

                    </div>
                </div>
                <div class="main__inner--info-orderBottom flex v-center label-large text-btn btn rounded-100"
                    onclick="button_back()" style="width: fit-content">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z"
                            fill="#6750A4" />
                    </svg>
                    Trở về lịch sử đơn hàng
                </div>
            </div>
        </div>
    </div>
    <div class="form__address--container" style="display: none;"></div>
</main>