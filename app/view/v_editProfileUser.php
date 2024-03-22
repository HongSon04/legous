<?php
use App\model\User;
if (is_array($checkUses)) {
    extract($checkUses);
}
if ($country == "") {
    $country_label = "Quốc gia";
} else {
    $country_label = $country;
}
if ($fullname == "") {
    $fullname_label = "Tên đầy đủ";
} else {
    $fullname_label = $fullname;
}
if ($bio == "") {
    $bio_label = "Bio";
} else {
    $bio_label = $bio;
}

// xử lí khi người dùng nhập form
if (isset($_POST['button__submit'])) {
    $id_user = $_POST['id_user'];
    $bio = $_POST['bio'];
    $new_avatar = $_FILES['avatar__user']['name'];
    if ($new_avatar != "") {
        $target_file = "./public/upload/users/" . $new_avatar;
        move_uploaded_file($_FILES["avatar__user"]["tmp_name"], $target_file);
        // lấy ảnh từ db về
        $newUserModel = new user();
        foreach ($newUserModel->get_imgAvatar($id_user) as $key) {
            $path_img = $key;
        }
        if ($path_img != "avatar-none.png") {
            $hinh = "./public/upload/users/" . $path_img;
            if (file_exists($hinh)) {
                unlink($hinh);
            }
        }
    } else {
        $new_avatar = $img;
    }
    if ($_POST['new_fullname'] != "") {
        $new_fullname = $_POST['new_fullname'];
    } else {
        $new_fullname = $fullname;
    }
    if ($_POST['country'] != "") {
        $country = $_POST['country'];
    }
    if ($_POST['bio'] != "") {
        $bio = $_POST['bio'];
    }
    $newUserModel = new user();
    $newUserModel->update_fullName_country_bio_avatar($new_fullname, $country, $bio, $new_avatar, $id_user);
    header('location: /editProfile');
}
if (isset($_POST['delete_avatar'])) {
    $id_user = $_POST['id_user'];
    // lấy ảnh từ db về
    $newUserModel = new user();
    foreach ($newUserModel->get_imgAvatar($id_user) as $key) {
        $path_img = $key;
    }
    $hinh = "./public/upload/users/" . $path_img;
    echo var_dump($hinh);
    if (file_exists($hinh)) {
        unlink($hinh);
    }
    $new_avatar = "";
    $newUserModel->remove_avatar($new_avatar, $id_user);
    header('location: /editProfile');
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
                    <span>Chỉnh sửa thông tin</span>
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
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
                    <div class="form__group--uploadImage">
                        <div class="form__upload-image">
                            <div class="box__image--user">
                                <img srcset="<?= $avatarImage_user ?> 2x" alt="" class="image__user--upload">
                            </div>
                            <div class="box__btn">
                                <input type="file" name="avatar__user" class="input_file">
                                <button type="submit" name="delete_avatar"
                                    class="delete__upload--avatarImage box-shadow1">
                                    Xóa
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- normal form group -->
                    <div class="form__group">
                        <span class="form__label">Tên</span>
                        <input type="text" name="new_fullname" class="form__input" placeholder="<?= $fullname_label ?>">
                        <!-- <label for="" class="label__place">Tên đầy đủ</label> -->
                        <span class="form__message">Chúng tôi khuyến khích sử dụng tên thật để dễ dàng trong việc xác
                            thực</span>
                    </div>
                    <!-- normal form group -->
                    <div class="form__group">
                        <span class="form__label">Quốc gia</span>
                        <input type="text" name="country" class="form__input" placeholder="<?= $country_label ?>">
                        <!-- <label for="" class="label__place">Quốc gia</label> -->
                        <span class="form__message"></span>
                    </div>
                    <!-- normal form group -->
                    <div class="form__group">
                        <span class="form__label">Bio</span>
                        <textarea class="form__input--texterea" name="bio" id="" cols="30" rows="12"
                            placeholder="<?= $bio_label ?>"></textarea>
                        <!-- <label for="" class="label__place label__place--bio">Bio</label> -->
                        <span class="form__message">Mô tả ngắn gọn thông tin của bạn.</span>
                    </div>
                    <div class="form__group form__group--submit">
                        <input type="submit" name="button__submit" value="Lưu thay đổi" class="btn__submit primary-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="form__address--container" style="display: none;"></div>
</main>