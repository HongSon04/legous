<?php
use App\model\Address;
use App\model\User;

$address_html = '';
$address_setDefault_html = '';
$address_default = '';
$set_defaultButton = '';
#code
$id_user = $_SESSION['userLogin']['id_user'];
# nếu chỉ có 1 địa chỉ thì set mặc định cho địa chỉ đó
$newAddressModel = new Address();
if (count($newAddressModel->get_address($id_user)) == 1) {
    foreach ($newAddressModel->get_address($id_user) as $key) {
        extract($key);
        $id_address = $id;
        $newAddressModel->set_defaultAddress($id_address);
    }
}
# get user name account
$newUserModel = new user();
extract($newUserModel->checkAccount($id_user));
$name_userAccount = $username;
$newAddressModel = new Address();
$list_addressUser = $newAddressModel->getAllAddressByUser($id_user);

# lấy ra địa chỉ được set là mặc định
$id_addressDefault = 0;
$newAddressModel = new Address();
if ($newAddressModel->check_addressDefault() != "") {
    foreach ($newAddressModel->check_addressDefault() as $key) {
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
if (isset($_POST['button_address'])) {
    if ($_POST['full_userName'] != "" && $_POST['phoneUser'] != "" && $_POST['address'] != "" && $_POST['address-detail'] != "") {
        $name_user = $_POST['full_userName'];
        $phone_user = $_POST['phoneUser'];
        $address_user = $_POST['address'];
        $address_detail = $_POST['address-detail'];
        if (isset($_POST['set_defaultAddress'])) {
            $address_default = 1;
            $newAddressModel = new Address();
            $newAddressModel->un_addressDefault($id_addressDefault);
        } else {
            # nếu là địa chỉ đầu tiên thì set là địa chỉ mặc định   
            if (count($newAddressModel->get_address($id_user)) == 0) {
                $address_default = 1;
            } else {
                $address_default = 0;
            }
            $message_name = 'Vui lòng điền thông tin';
        }
        # kiểm tra số điện thoại có thỏa mãn điều kiện hay không
        $phone = $_POST["phoneUser"];
        $pattern = "/^0[2|3|5|6|7|8|9][0-9]{8}$/";
        if (preg_match($pattern, $phone)) {
            $id_user = $_SESSION['userLogin']['id_user'];
            $newAddressModel = new Address();
            $newAddressModel->add_address($name_user, $phone_user, $address_detail, $address_user, $address_default, $id_user);
            header('location: /addressUser');
            exit;
        } else {
            $class_add = 'show';
            $message_phoneError = 'Số điện thoại không hợp lệ.';
        }
    }
    # kiểm tra xử lí khi điền form thiếu thông tin...
    if ($_POST['full_userName'] == "" && $_POST['phoneUser'] == "" && $_POST['address'] == "" && $_POST['address-detail'] == "") {
        $class_add = 'show';
        $error_message = 'error_formMessage';
        $error_input = 'error_input';
        $message_name = 'Chưa điền thông tin!';
        $message_phone = 'Chưa điền thông tin!';
        $message_address = 'Chưa điền thông tin!';
        $message_addressDetail = 'Chưa điền thông tin!';
    } else if ($_POST['full_userName'] != '') {
        $name_value = $_POST['full_userName'];
        $class_add = 'show';
        $error_message = 'error_formMessage';
        $error_input = 'error_input';
        $message_name = '';
    }
    if ($_POST['phoneUser'] != '') {
        $phone_value = $_POST['phoneUser'];
        $class_add = 'show';
        $error_message = 'error_formMessage';
        $error_input = 'error_input';
        $message_phone = '';
    }
    if ($_POST['address'] != '') {
        $address_value = $_POST['address'];
        $class_add = 'show';
        $error_message = 'error_formMessage';
        $error_input = 'error_input';
        $message_address = '';
    }
    if ($_POST['address-detail'] != '') {
        $addressDetail_value = $_POST['address-detail'];
        $class_add = 'show';
        $error_message = 'error_formMessage';
        $error_input = 'error_input';
        $message_addressDetail = '';
    }
}

# thay đổi địa chỉ được set default
if (isset($_POST['btn_set_addressDefault'])) {
    $id_address = $_POST['id-Address'];
    if ($is_addressDefault == 1) {
        $newAddressModel = new Address();
        $newAddressModel->un_addressDefault($id_addressDefault);
    }
    $newAddressModel = new Address();
    $newAddressModel->set_defaultAddress($id_address);
    header('location: /addressUser');
}

# xử lí sự kiện "trở lại" trong popup
if (isset($_POST['back_address'])) {
    header('location: /addressUser');
}

# edit UI
foreach ($list_addressUser as $key) {
    extract($key);
    $id_address = $id;
    if ($is_default == 1) {
        $address_setDefault_html = '<form action="" class="form__address" method="POST">
                                            <input type="hidden" name="id-Address" value="' . $id . '">
                                            <div class="form__address--left">
                                                <div class="form__address--left---rows-1">
                                                    <span>' . $username . '</span>
                                                    <span>|</span>
                                                    <span>(+84) ' . $phone . '</span>
                                                </div>
                                                <div class="form__address--left---rows-2">
                                                    <span>' . $address . '</span>
                                                    <span>' . $address_detail . '</span>
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
                                                        <a onclick="btn_editAddress()" href="?mod=user&act=edit-address&id-address=' . $id_address . '">Cập nhật</a>
                                                    </div>
                                                    <div class="form__address--right---btn_bottom">
                                                        <input class="address__dafault label-large" type="submit" name="set__address--default" value="Thiết lập mặc định">
                                                    </div>
                                                </div>
                                            </div>  
                                        </form>
                                        <hr class="ouline-variant">';
    }
    if ($is_default == 0) {
        $address_html .= '<form action="" class="form__address" method="POST">
                                <input type="hidden" name="id-Address" value="' . $id . '">
                                <div class="form__address--left">
                                    <div class="form__address--left---rows-1">
                                        <span>' . $username . '</span>
                                        <span>|</span>
                                        <span>(+84) ' . $phone . '</span>
                                    </div>
                                    <div class="form__address--left---rows-2">
                                        <span>' . $address . '</span>
                                        <span>' . $address_detail . '</span>
                                    </div>
                                    <div class="form__address--left---rows-3">
                                        ' . $address_default . '
                                    </div>
                                </div>
                                <div class="form__address--right">
                                    <div class="form__address--right---btn">
                                        <div class="form__address--right---btn_top">
                                            <a onclick="btn_editAddress()" href="?mod=user&act=edit-address&id-address=' . $id_address . '">Cập nhật</a>
                                            <span>|</span>
                                            <a href="?mod=user&act=delete-address&id-address=' . $id . '">Xóa</a>
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

<main class="main__user">
    <div class="main__inner">
        <div class="main__inner--top">
            <div class="avatar__image">
                <img srcset="<?= $avatarImage_user ?> 2x" alt="" class="avatar__image--user">
            </div>
            <div class="info__user">
                <div class="info__user--top">
                    <span class="user__name">
                        <?= $name_userAccount ?>
                    </span>
                    <span>/</span>
                    <span>Địa chỉ</span>
                </div>
                <div class="info__user--bottom">
                    <span class="info__user--desc">
                        Cập nhật và quản lý tài khoản của bạn
                    </span>
                </div>
            </div>
            <?php require_once './app/view/box_changeAccountUser.php'; ?>
        </div>
        <div class="main__inner--bottom">
            <!-- user side bar start -->
            <?php require_once './app/view/userSiderbar.php' ?>
            <!-- user side bar end -->

            <div class="main__inner--bottom-right">
                <h4>Danh sách địa chỉ</h4>

                <?= $address_setDefault_html ?>
                <?= $address_html ?>

                <div class="add_new-addres--box">
                    <div class="form__group form__group--submit">
                        <button onclick="btn_addAddress()" class="btn__submit" id="button_add-address">+ Thêm địa chỉ
                            mới</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- form address -->
<section class="form__address--container full address__form <?= $class_add ?>" id="form_add-address">
    <form action="" method="POST" class="form__address--content">
        <div class="form__address--content-rows1 flex">
            <!-- normal form group -->
            <div class="form__group without-title">
                <!-- <span class="form__label"></span> -->
                <input type="text" name="full_userName"
                    class="form__input input--name form__inputAddress <?= $error_input ?>" value="<?= $name_value ?>"
                    placeholder=" ">
                <label for="" class="label__place <?= $error_message ?>">Họ và tên</label>
                <span class="form__message <?= $error_message ?>">
                    <?= $message_name ?>
                </span>
            </div>
            <!-- normal form group -->
            <div class="form__group without-title">
                <!-- <span class="form__label"></span> -->
                <input type="number" name="phoneUser"
                    class="form__input input--phone form__inputAddress <?= $error_input ?>" value="<?= $phone_value ?>"
                    placeholder=" ">
                <label for="" class="label__place <?= $error_message ?>">Số điện thoại</label>
                <span class="form__message <?= $error_message ?>">
                    <?= $message_phone ?>
                    <?= $message_phoneError ?>
                </span>
            </div>
        </div>
        <div class="form__address--content-rows2">
            <!-- normal form group -->
            <div class="form__group without-title">
                <!-- <span class="form__label"></span> -->
                <input type="text" name="address"
                    class="form__input input--address_top form__inputAddress <?= $error_input ?>"
                    value="<?= $address_value ?>" placeholder=" ">
                <label for="" class="label__place <?= $error_message ?>">Tỉnh/Thành phố, Quận/Huyện, Phường/Xã</label>
                <span class="form__message <?= $error_message ?>">
                    <?= $message_address ?>
                </span>
            </div>
        </div>
        <div class="form__address--content-rows2">
            <!-- normal form group -->
            <div class="form__group without-title">
                <!-- <span class="form__label"></span> -->
                <input type="text" name="address-detail"
                    class="form__input input--address_bottom form__inputAddress <?= $error_input ?>"
                    value="<?= $addressDetail_value ?>" placeholder=" ">
                <label for="" class="label__place <?= $error_message ?>">Địa chỉ cụ thể</label>
                <span class="form__message <?= $error_message ?>">
                    <?= $message_addressDetail ?>
                </span>
            </div>
        </div>
        <div class="form__address--content-rows3">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3822.266122569526!2d105.8491695157099!3d21.02255898954545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a49315938351%3A0x641317b16f65f28c!2sVăn%20phòng%20Google%20Việt%20Nam!5e0!3m2!1svi!2svn!4v1649056555625!5m2!1svi!2svn"
                style="border:0; width: 100%; height: 100%;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="form__address--content-rows4">
            <input type="checkbox" name="set_defaultAddress">
            <label for="" class="label-large">Đặt làm địa chỉ mặc định</label>
        </div>
        <div class="form__address--content-rows5">
            <div class="form__group">
                <button name="back_address" class="label-large" id="">Trở lại</button>
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
    let phone = document.querySelector('.input--phone');
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].parentElement.children[2].innerText === "") {
            inputs[i].classList.remove("error_input");
            inputs[i].parentElement.children[1].classList.remove('error_formMessage');
            inputs[i].parentElement.children[2].classList.remove('error_message');
        }
    }
</script>