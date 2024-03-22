<?php
    $value_old_password = '';
    $message_oldPassword = '';
    $message_newPassword = 'Mật khẩu phải có ít nhất 8 kí tự.';
    $id_user = isset($_SESSION['userLogin']['id_user']) ? $_SESSION['userLogin']['id_user'] : $_SESSION['admin']['id_user'];
    $password_fromDB = get_password($id_user);
    if (isset($_POST['btn_change_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        if (strlen($new_password) >= 8) {
            if ($old_password == $password_fromDB) {
                update_password($new_password, $id_user);
                $value_old_password = $new_password;
                $message_oldPassword = 'Đã cập nhật mật khẩu thành công.';
            } else if($old_password == "") {
                $message_oldPassword = 'Vui lòng điền mật khẩu để xác nhận.';
            }else if($old_password != $password_fromDB) {
                $message_oldPassword = 'Mật khẩu xác nhận không đúng.';
            }
        } 
        else {
            $value_old_password = $old_password;
            $message_newPassword = 'Mật khẩu phải có ít nhất 8 kí tự.';
        }

        if($_POST['new_password'] == $password_fromDB) {
            $value_old_password = $old_password;
            $message_oldPassword = 'Cập nhật mật khẩu thất bại.';
            $message_newPassword = 'Mật khẩu mới phải khác với mật khẩu cũ.';
        }
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
                        <span class="body-medium">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dicta consequuntur assumenda</span>
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
                    <span>Cập nhật mật khẩu</span>
                </div>
                <div class="info__user--bottom">
                    <span class="info__user--desc">
                        Cập nhật và quản lý tài khoản của bạn
                    </span>
                </div>
            </div>
            <?php require_once 'views/box_changeAccountUser.php'; ?>
        </div>
        <div class="main__inner--bottom">
            <!-- user side bar start -->
            <?php require_once 'views/userSiderbar.php' ?>
            <!-- user side bar end -->

            <div class="main__inner--bottom-right">
                <form action="?mod=user&act=password" method="POST" class="register__form">
                    <!-- <input type="hidden" vak> -->
                    <!-- normal form group -->
                    <div class="form__group">
                        <span class="form__label">Mật khẩu cũ</span>
                        <input type="password" value="<?= $value_old_password ?>" class="form__input password--input old_password" name="old_password" placeholder="Nhập mật khẩu cũ">
                        <!-- <label for="" class="label__place">Nhập mật khẩu cũ</label> -->
                        <span class="form__message form__message-oldPassword"><?= $message_oldPassword ?></span>
                        <!-- button show-hidden password -->
                        <button class="hidden-show__password">
                            <i class="fal fa-eye-slash eye-icon eye-active"></i>
                            <i class="fal fa-eye eye-icon"></i>
                        </button>
                    </div>
                    <div class="form__group">
                        <span class="get_passworDb" style="display: none;"><?= $password_fromDB ?></span>
                        <span class="get_newPassword" style="display: none;"><?= $new_password ?></span>
                        <span class="form__label">Mật khẩu mới</span>
                        <input type="password" class="form__input password--input new_password" name="new_password"  placeholder="Nhập mật khẩu mới ">
                        <!-- <label for="" class="label__place">Nhập mật khẩu mới</label> -->
                        <span class="form__message"><?= $message_newPassword ?></span>
                        <!-- button show-hidden password -->
                        <button name="btn_update" class="hidden-show__password">
                            <i class="fal fa-eye-slash eye-icon eye-active"></i>
                            <i class="fal fa-eye eye-icon"></i>
                        </button>

                    </div>
                    <div class="form__group--submit">
                        <input type="submit" name="btn_change_password" value="Lưu thay đổi" class="btn__submit primary-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="form__address--container" style="display: none;"></div>
</main>
<script src="./public/assets/resources/js/validator_ofNQT.js"></script>
<script>
    Validator({
        formSelector: '.register__form',
        formGroupSelector: '.form__group',
        formMessage: '.form__message',
        rules: [
            Validator.isRequired('.password--input'),
            Validator.isPassword('.password--input'),
        ]
    })


    let get_newPassword = document.querySelector('.get_newPassword');
    let message_oldPassword =document.querySelector('.form__message-oldPassword').innerText;
    if(message_oldPassword != "" && message_oldPassword != "Đã cập nhật mật khẩu thành công.") {
        let old_password = document.querySelector('.old_password');
        old_password.focus();
        old_password.classList.add('error_input');
        old_password.parentElement.children[2].classList.add('error_formMessage');
    }

    if(get_newPassword.innerText == "" || get_newPassword.innerText.length < 8 || get_newPassword.innerText  == (get_newPassword.parentElement.children[0]).innerText) {
        (get_newPassword.parentElement.children[3]).focus();
        (get_newPassword.parentElement.children[3]).classList.add('error_input');
        (get_newPassword.parentElement.children[4]).classList.add('error_formMessage');
    }
</script>