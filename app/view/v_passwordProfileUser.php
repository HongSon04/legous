<?php
use App\model\User;

$value_old_password = '';
$message_oldPassword = '';
$message_newPassword = 'Mật khẩu phải có ít nhất 8 kí tự.';
$id_user = isset($_SESSION['userLogin']['id_user']) ? $_SESSION['userLogin']['id_user'] : $_SESSION['admin']['id_user'];
$newUserModel = new User();
$password_fromDB = $newUserModel->get_password($id_user);
if (isset($_POST['btn_change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    if (strlen($new_password) >= 8) {
        if ($old_password == $password_fromDB) {
            $newUserModel = new User();
            $newUserModel->update_password($new_password, $id_user);
            $value_old_password = $new_password;
            $message_oldPassword = 'Đã cập nhật mật khẩu thành công.';
        } else if ($old_password == "") {
            $message_oldPassword = 'Vui lòng điền mật khẩu để xác nhận.';
        } else if ($old_password != $password_fromDB) {
            $message_oldPassword = 'Mật khẩu xác nhận không đúng.';
        }
    } else {
        $value_old_password = $old_password;
        $message_newPassword = 'Mật khẩu phải có ít nhất 8 kí tự.';
    }

    if ($_POST['new_password'] == $password_fromDB) {
        $value_old_password = $old_password;
        $message_oldPassword = 'Cập nhật mật khẩu thất bại.';
        $message_newPassword = 'Mật khẩu mới phải khác với mật khẩu cũ.';
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
                        <?= $username ?>
                    </span>
                    <span>/</span>
                    <span>Cập nhật mật khẩu</span>
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
                <form action="?mod=user&act=password" method="POST" class="register__form">
                    <!-- <input type="hidden" vak> -->
                    <!-- normal form group -->
                    <div class="form__group">
                        <span class="form__label">Mật khẩu cũ</span>
                        <input type="password" value="<?= $value_old_password ?>"
                            class="form__input password--input old_password" name="old_password"
                            placeholder="Nhập mật khẩu cũ">
                        <!-- <label for="" class="label__place">Nhập mật khẩu cũ</label> -->
                        <span class="form__message form__message-oldPassword">
                            <?= $message_oldPassword ?>
                        </span>
                        <!-- button show-hidden password -->
                        <button class="hidden-show__password">
                            <i class="fal fa-eye-slash eye-icon eye-active"></i>
                            <i class="fal fa-eye eye-icon"></i>
                        </button>
                    </div>
                    <div class="form__group">
                        <span class="get_passworDb" style="display: none;">
                            <?= $password_fromDB ?>
                        </span>
                        <span class="get_newPassword" style="display: none;">
                            <?= $new_password ?>
                        </span>
                        <span class="form__label">Mật khẩu mới</span>
                        <input type="password" class="form__input password--input new_password" name="new_password"
                            placeholder="Nhập mật khẩu mới ">
                        <!-- <label for="" class="label__place">Nhập mật khẩu mới</label> -->
                        <span class="form__message">
                            <?= $message_newPassword ?>
                        </span>
                        <!-- button show-hidden password -->
                        <button name="btn_update" class="hidden-show__password">
                            <i class="fal fa-eye-slash eye-icon eye-active"></i>
                            <i class="fal fa-eye eye-icon"></i>
                        </button>

                    </div>
                    <div class="form__group--submit">
                        <input type="submit" name="btn_change_password" value="Lưu thay đổi"
                            class="btn__submit primary-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="form__address--container" style="display: none;"></div>
</main>
<script src="./public/js/validator_ofNQT.js"></script>
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
    let message_oldPassword = document.querySelector('.form__message-oldPassword').innerText;
    if (message_oldPassword != "" && message_oldPassword != "Đã cập nhật mật khẩu thành công.") {
        let old_password = document.querySelector('.old_password');
        old_password.focus();
        old_password.classList.add('error_input');
        old_password.parentElement.children[2].classList.add('error_formMessage');
    }

    if (get_newPassword.innerText == "" || get_newPassword.innerText.length < 8 || get_newPassword.innerText == (get_newPassword.parentElement.children[0]).innerText) {
        (get_newPassword.parentElement.children[3]).focus();
        (get_newPassword.parentElement.children[3]).classList.add('error_input');
        (get_newPassword.parentElement.children[4]).classList.add('error_formMessage');
    }
</script>