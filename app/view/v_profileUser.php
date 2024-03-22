<?php
use App\model\User;


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
                        <?= $checkUses['username'] ?>
                    </span>
                    <span>/</span>
                    <span>Tổng quan</span>
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
                <form action="/changeInfoUser" method="POST" class="general_form">
                    <!-- normal form group -->
                    <div class="form__group">
                        <span class="form__label">Tên đăng nhập</span>
                        <input type="text" name="username" class="form__input username--input"
                            placeholder="<?= $checkUses['username'] ?>">
                        <!-- <label for="" class="label__place">Tên đăng nhập</label> -->
                        <span class="form__message"></span>
                    </div>
                    <div class="form__group">
                        <span class="form__label">Email</span>
                        <input type="email" name="email" class="form__input email--input"
                            placeholder="<?= $checkUses['email'] ?>">
                        <!-- <label for="" class="label__place">Email</label> -->
                        <span class="form__message"></span>
                    </div>
                    <div class="form__group--submit">
                        <input type="submit" name="button__submit" value="Lưu thay đổi" class="btn__submit primary-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="form__address--container" style="display: none;"></div>
</main>
<script src="./public/assets/resources/js/validator.js"></script>
<script>
    Validator({
        formSelector: '.general_form',
        formGroupSelector: '.form__group',
        formMessage: '.form__message',
        submitUrl: '?mod=user&act=general',
        redirectUrl: '?mod=user&act=general',
        rules: [
            Validator.isRequired('.username--input'),
            Validator.isUsernameAlreadyExist('.username--input', 'Vui lòng điền tên đăng nhập', './views/libs/usernameValidator.php'),
            Validator.isRequired('.email--input', 'Vui lòng nhập email của bạn.'),
            Validator.isEmail('.email--input'),
            Validator.isEmailAlreadyExist('.email--input', 'Email này đã tồn tại trên hệ thống', './views/libs/emailValidator.php'),
        ]
    })
</script>