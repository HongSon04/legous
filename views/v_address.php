<?php
    $address_html = '';
    $address_setDefault_html = '';
    $address_default = '';
    $set_defaultButton = '';
     #code
    $id_user = $_SESSION['userLogin']['id_user'];
    # nếu chỉ có 1 địa chỉ thì set mặc định cho địa chỉ đó
    if(count(get_address($id_user)) == 1) {
        foreach (get_address($id_user) as $key) {
            extract($key);
            $id_address = $id;
            set_defaultAddress($id_address);
        }
    }
    # get user name account
    extract(checkAccount($id_user));
    $name_userAccount = $username;

     $list_addressUser = getAllAddressByUser($id_user);

     # lấy ra địa chỉ được set là mặc định
     $id_addressDefault = 0;
    if(check_addressDefault() != "") {
        foreach (check_addressDefault() as $key) {
            extract($key);
            $id_addressDefault = $id;
            $is_addressDefault = $is_default;
        }
    }
 
     $class_add = '';
     $error_input = '';
     $error_message = '';
     #lưu trữ thông tin người dùng nhập
     $name_value = '';
     $phone_value = '';
     $address_value = '';
     $addressDetail_value = '';
     # hiển thị thông báo của form message
    $message_name = 'Khuyến khích sử dụng tên thật.';
    $message_phone = 'Thông tin bắt buộc.';
    $message_address = 'Thông tin bắt buộc.';
    $message_addressDetail = 'Địa chỉ cụ thể giúp dễ dàng trong việc giao hàng.';
    #xử lí thêm địa chỉ
    $message_phoneError = '';
     if(isset($_POST['button_address'])) {
        if($_POST['full_userName'] != "" && $_POST['phoneUser'] != "" && $_POST['address'] != "" && $_POST['address-detail'] != "")  {
            $name_user = $_POST['full_userName'];
            $phone_user = $_POST['phoneUser'];
            $address_user = $_POST['address'];
            $address_detail = $_POST['address-detail'];
            if(isset($_POST['set_defaultAddress'])) {
                $address_default = 1;
                un_addressDefault($id_addressDefault);
            }else {
                # nếu là địa chỉ đầu tiên thì set là địa chỉ mặc định   
                if(count(get_address($id_user)) == 0) {
                    $address_default = 1;
                }else {
                    $address_default = 0;
                }
                $message_name = 'Vui lòng điền thông tin';
            }
            # kiểm tra số điện thoại có thỏa mãn điều kiện hay không
            $phone = $_POST["phoneUser"];
            $pattern =  "/^0[2|3|5|6|7|8|9][0-9]{8}$/";
            if (preg_match($pattern, $phone)) {
                $id_user = $_SESSION['userLogin']['id_user'];
                add_address($name_user, $phone_user, $address_detail, $address_user, $address_default, $id_user);
                header('location: ?mod=user&act=address');
                exit;
            } else {
                $class_add = 'show';
                $message_phoneError = 'Số điện thoại không hợp lệ.';
            }
        }
        # kiểm tra xử lí khi điền form thiếu thông tin...
        if($_POST['full_userName'] == "" && $_POST['phoneUser'] == "" && $_POST['address'] == "" && $_POST['address-detail'] == "") {
            $class_add = 'show';
            $error_message = 'error_formMessage';
            $error_input = 'error_input';
            $message_name = 'Chưa điền thông tin!';
            $message_phone = 'Chưa điền thông tin!';
            $message_address = 'Chưa điền thông tin!';
            $message_addressDetail = 'Chưa điền thông tin!';
        }else if($_POST['full_userName'] != ''){
            $name_value = $_POST['full_userName'];
            $class_add = 'show';
            $error_message = 'error_formMessage';
            $error_input = 'error_input';
            $message_name = '';
        }if($_POST['phoneUser'] != '') {
            $phone_value = $_POST['phoneUser'];
            $class_add = 'show';
            $error_message = 'error_formMessage';
            $error_input = 'error_input';
            $message_phone = '';
        }if($_POST['address'] != '') {
            $address_value = $_POST['address'];
            $class_add = 'show';
            $error_message = 'error_formMessage';
            $error_input = 'error_input';
            $message_address = '';
        }if($_POST['address-detail'] != '') {
            $addressDetail_value = $_POST['address-detail'];
            $class_add = 'show';
            $error_message = 'error_formMessage';
            $error_input = 'error_input';
            $message_addressDetail = '';
        }
     }

     # thay đổi địa chỉ được set default
     if(isset($_POST['btn_set_addressDefault'])) {
         $id_address = $_POST['id-Address'];
         if($is_addressDefault == 1) {
             un_addressDefault($id_addressDefault);
         }
         set_defaultAddress($id_address);
         header('location: ?mod=user&act=address');
     }

     # xử lí sự kiện "trở lại" trong popup
     if(isset($_POST['back_address'])) {
         header('location: ?mod=user&act=address');
     }

    # edit UI
    foreach ($list_addressUser as $key) {
        extract($key);
        $id_address = $id;
        if($is_default == 1) {
            $address_setDefault_html = '<form action="" class="form__address" method="POST">
                                            <input type="hidden" name="id-Address" value="'.$id.'">
                                            <div class="form__address--left">
                                                <div class="form__address--left---rows-1">
                                                    <span>'.$username.'</span>
                                                    <span>|</span>
                                                    <span>(+84) '.$phone.'</span>
                                                </div>
                                                <div class="form__address--left---rows-2">
                                                    <span>'.$address.'</span>
                                                    <span>'.$address_detail.'</span>
                                                </div>
                                                <div class="form__address--left---rows-3">
                                                    <div class="label__default rounded-8 label-large">
                                                        Mặc định
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form__address--right">
                                                <div class="form__address--right---btn">
                                                    <div class="form__address--right---btn_top">
                                                        <a onclick="btn_editAddress()" href="?mod=user&act=edit-address&id-address='.$id_address.'">Cập nhật</a>
                                                    </div>
                                                    <div class="form__address--right---btn_bottom">
                                                        <input class="address__dafault label-large" type="submit" name="set__address--default" value="Thiết lập mặc định">
                                                    </div>
                                                </div>
                                            </div>  
                                        </form>
                                        <hr class="ouline-variant">';
        } 
        if($is_default == 0) {
            $address_html .= '<form action="" class="form__address" method="POST">
                                <input type="hidden" name="id-Address" value="'.$id.'">
                                <div class="form__address--left">
                                    <div class="form__address--left---rows-1">
                                        <span>'.$username.'</span>
                                        <span>|</span>
                                        <span>(+84) '.$phone.'</span>
                                    </div>
                                    <div class="form__address--left---rows-2">
                                        <span>'.$address.'</span>
                                        <span>'.$address_detail.'</span>
                                    </div>
                                    <div class="form__address--left---rows-3">
                                        '.$address_default.'
                                    </div>
                                </div>
                                <div class="form__address--right">
                                    <div class="form__address--right---btn">
                                        <div class="form__address--right---btn_top">
                                            <a onclick="btn_editAddress()" href="?mod=user&act=edit-address&id-address='.$id_address.'">Cập nhật</a>
                                            <span>|</span>
                                            <a href="?mod=user&act=delete-address&id-address='.$id.'">Xóa</a>
                                        </div>
                                        <div class="form__address--right---btn_bottom">
                                            <input type="submit" name="btn_set_addressDefault" value="Thiết lập mặc định">
                                        </div>
                                    </div>
                                </div>  
                            </form>
                            <hr class="ouline-variant">';
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
                    <span class="user__name"><?= $name_userAccount ?></span>
                    <span>/</span>
                    <span>Địa chỉ</span>
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
                <h4>Danh sách địa chỉ</h4>
                
                <?= $address_setDefault_html ?>
                <?= $address_html ?>

                <div class="add_new-addres--box">
                    <div class="form__group form__group--submit">
                        <button onclick="btn_addAddress()" class="btn__submit" id="button_add-address">+ Thêm địa chỉ mới</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- form address -->
<section class="form__address--container full address__form <?=$class_add?>" id="form_add-address">
    <form action="" method="POST" class="form__address--content">
        <div class="form__address--content-rows1 flex">
            <!-- normal form group -->
            <div class="form__group without-title">
                <!-- <span class="form__label"></span> -->
                <input type="text" name="full_userName" class="form__input input--name form__inputAddress <?=$error_input?>" value="<?=$name_value?>" placeholder=" ">
                <label for="" class="label__place <?=$error_message?>">Họ và tên</label>
                <span class="form__message <?=$error_message?>"><?=$message_name?></span>
            </div>
            <!-- normal form group -->
            <div class="form__group without-title">
                <!-- <span class="form__label"></span> -->
                <input type="number" name="phoneUser" class="form__input input--phone form__inputAddress <?=$error_input?>" value="<?=$phone_value?>" placeholder=" ">
                <label for="" class="label__place <?=$error_message?>">Số điện thoại</label>
                <span class="form__message <?=$error_message?>"><?=$message_phone?><?=$message_phoneError?></span>
            </div>
        </div>
        <div class="form__address--content-rows2">
            <!-- normal form group -->
            <div class="form__group without-title">
                <!-- <span class="form__label"></span> -->
                <input type="text" name="address" class="form__input input--address_top form__inputAddress <?=$error_input?>" value="<?=$address_value?>" placeholder=" ">
                <label for="" class="label__place <?=$error_message?>">Tỉnh/Thành phố, Quận/Huyện, Phường/Xã</label>
                <span class="form__message <?=$error_message?>"><?=$message_address?></span>
            </div>
        </div>
        <div class="form__address--content-rows2">
            <!-- normal form group -->
            <div class="form__group without-title">
                <!-- <span class="form__label"></span> -->
                <input type="text" name="address-detail" class="form__input input--address_bottom form__inputAddress <?=$error_input?>" value="<?=$addressDetail_value?>" placeholder=" ">
                <label for="" class="label__place <?=$error_message?>">Địa chỉ cụ thể</label>
                <span class="form__message <?=$error_message?>"><?=$message_addressDetail?></span>
            </div>
        </div>
        <div class="form__address--content-rows3">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3822.266122569526!2d105.8491695157099!3d21.02255898954545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a49315938351%3A0x641317b16f65f28c!2sVăn%20phòng%20Google%20Việt%20Nam!5e0!3m2!1svi!2svn!4v1649056555625!5m2!1svi!2svn" style="border:0; width: 100%; height: 100%;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="form__address--content-rows4">
            <input type="checkbox" name="set_defaultAddress">
            <label for="" class="label-large">Đặt làm địa chỉ mặc định</label>
        </div>
        <div class="form__address--content-rows5">
            <div class="form__group">
                <button  name="back_address" class="label-large" id="">Trở lại</button>
                <input type="submit" name="button_address" value="Lưu thông tin" class="label-large add_address">
            </div>
        </div>
    </form>
</section>
<script src="./public/assets/resources/js/validator_ofNQT.js"></script>
<script>
    Validator({
        formSelector: '.address__form',
        formGroupSelector: '.form__group',
        formMessage: '.form__message',
        rules: [
            Validator.isPhone('.input--phone'),
            Validator.isRequired('.input--name'),
            Validator.isRequired('.input--address_top'),
            Validator.isRequired('.input--address_bottom'),
        ]
    })
</script>
<script>
    var inputs = document.querySelectorAll(".form__inputAddress");
    let phone =document.querySelector('.input--phone');
    for (var i = 0; i < inputs.length; i++) {
        if(inputs[i].parentElement.children[2].innerText === "") {
            inputs[i].classList.remove("error_input");
            inputs[i].parentElement.children[1].classList.remove('error_formMessage');
            inputs[i].parentElement.children[2].classList.remove('error_message');
        }
    }
</script>