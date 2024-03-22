<?php
    $id_user = $_SESSION['userLogin']['id_user'];
    $id_bill = 0;
    $message_password = '';
    $message_checkbox = '';
    extract(checkAccount($id_user));
    foreach (get_allBill($id_user) as $key) {
        extract($key);
        $id_bill = $id;
    }
    // print_r(get_id_comments($id_user));
    
    if(isset($_POST['deleteAccount'])) {
        if($_POST['old_password'] == $password) {
            if(isset($_POST['confirm_delete'])) {
                delete_bill_fromCart($id_user);
                delete_bill($id_user);
                delete_address_byIduser($id_user);
                delete_blogComment_byIduser($id_user);
                foreach (get_id_comments($id_user) as $key) {
                    extract($key);
                    $id_Cmt = $id;
                    delImgByIdCmt($id_Cmt);
                }
                delete_comments_byIduser($id_user);
                delete_acccount($id_user);
                session_destroy();
                header('location: ?mod=page&act=home');
                setcookie('accounts_user'.$_SESSION['userLogin']['id_user'], $loginInfo['id_user'], (time() - (60 * 60 * 24 * 30)));
            }else {
                $message_password = 'Vui lòng nhập lại mật khẩu và xác nhận để xóa.';
                $message_checkbox = 'Cần xác nhận trước khi xóa.';
            }
        } else if($_POST['old_password'] == '') {
            $message_password = 'Nhập mật khẩu để xác nhận.';
            if(!isset($_POST['confirm_delete'])) {
                $message_checkbox = 'Cần xác nhận trước khi xóa.';
            }
        } else if($_POST['old_password'] != $password) {
            $message_password = 'Mật khẩu xác nhận không đúng.';
            if(!isset($_POST['confirm_delete'])) {
                $message_checkbox = 'Cần xác nhận trước khi xóa.';
            }
        }
    }
?>
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
                    <span>Xóa tài khoản</span>
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
                <form action="" method="POST" class="deleteAccount__form">
                    <span class="old_password" style="display: none;"><?= $password ?></span>
                    <div class="form__group">
                        <label for="username"
                            class="form_label">Xóa tài khoản của bạn</label>
                        <span class="label-large">Nếu muốn giảm thông báo qua email, bạn có thể tắt chúng tại đây hoặc nếu bạn chỉ muốn thay đổi tên người dùng của mình, bạn có thể làm điều đó tại đây. Xin lưu ý, việc xóa tài khoản là quyết định cuối cùng. Sẽ không có cách nào để khôi phục tài khoản của bạn.</span>
                    </div>
                    <!-- checkbox form group -->
                    <div class="form__group">
                        <label for="old_password" class="form__label">Mật khẩu cũ</label>
                        <input type="password" class="form__input password--input" name="old_password" placeholder="Nhập mật khẩu cũ">
                        <!-- <label for="" class="label__place">Nhập mật khẩu cũ</label> -->
                        <span class="form__message"><?= $message_password ?></span>
                        <button name="btn_update" class="hidden-show__password">
                            <i class="fal fa-eye-slash eye-icon eye-active"></i>
                            <i class="fal fa-eye eye-icon"></i>
                        </button>
                    </div>
                    <div class="form__group without-title">
                        <div class="flex g6">
                            <input type="checkbox" name="confirm_delete" class="input input_checkbox">
                            <label class="form__label">Tôi đã hiểu rõ, xóa tài khoản là quyết định của tôi</label>
                        </div>
                        <span class="form__message"><?= $message_checkbox ?></span>
                    </div>
                    <div class="form__group form__group--submit">
                        <div class="box__delete--account">
                            <i class="far fa-trash-alt">
                                <input type="submit" name="deleteAccount" value="Xóa tài khoản" class="btn__delete">
                            </i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="./public/assets/resources/js/validator_ofNQT.js"></script>   
<script>
    Validator({
        formSelector: '.deleteAccount__form',
        formGroupSelector: '.form__group',
        formMessage: '.form__message',
        rules: [
            Validator.isRequired('.password--input'),
            Validator.isPassword('.password--input'),
        ]
    })
</script>
<script>
    let input_password =document.querySelector('.password--input');
    let old_password =document.querySelector('.old_password').innerText;
    document.querySelectorAll('.form__message').forEach(e => {
        if(e.innerText != "") {
            e.classList.add('error_formMessage');
            input_password.classList.add('error_input'); 
        }
    });

    if(input_password.value == '' || input_password.value!= old_password) {
        input_password.focus();
    }
</script>