<?php

use App\model\User;
use App\model\Bill;
use App\model\Comment;

if (@$_GET['id']) {
    $idUser = $_GET['id'];
    $newUserModel = new User();
    $userInfo = $newUserModel->getUserInfo($idUser);
}
?>
<section class="dashboard" style="position: relative;">
    <!----======== Header DashBoard ======== -->

    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">

            <!----======== End Header DashBoard ======== -->
            <div class="containerAdmin_order-detail p30">
                <div class="localDashboard">
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <div class="col-12">
                                <h2>Chi Tiết Khách Hàng</h2>
                            </div>
                            <div class="col-12">
                                <span class="label-large client-edit">Admin /</span><a href="/adminUser" class="label-large" style="text-decoration: none;"> Khách Hàng</a>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
                <form enctype="multipart/form-data" action="/adminUserEditHandler?id=<?= (int)$_GET['id'] ?>" method="POST">
                    <div class="sliderDashboard_order-add-create sliderDashboard_order-detail rounded-4">
                        <div class="body_sliderDashboard_order-add-create p20 row col-12">
                            <div class="col-7">
                                <div class="left-order-add-create">
                                    <h2>Họ Và Tên</h2>
                                    <input name="fullname" class="" type="text" value="<?php echo $userInfo[0]['fullname'] ?>" placeholder="Nhập Họ Và Tên" aria-label="default input example">
                                    <?php
                                    if (isset($error['fullname']) && !empty($error['fullname']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['fullname']}</p>";
                                    ?>
                                </div>
                                <div class="left-order-add-create">
                                    <h2>Tên Đăng Nhập</h2>
                                    <input name="username" class="" type="text" value="<?php echo $userInfo[0]['username'] ?>" placeholder="Nhập Tên Đăng Nhập" aria-label="default input example">
                                    <?php
                                    if (isset($error['username']) && !empty($error['username']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['username']}</p>";
                                    ?>
                                </div>

                                <div class="left-order-add-create">
                                    <h2>Mật Khẩu</h2>
                                    <input name="password" class="" type="text" value="<?php echo $userInfo[0]['password'] ?>" placeholder="Nhập Mật Khẩu" aria-label="default input example">
                                    <?php
                                    if (isset($error['password']) && !empty($error['password']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['password']}</p>";
                                    ?>
                                </div>
                                <div class="left-order-add-create">
                                    <h2>Email</h2>
                                    <input name="email" class="" type="text" value="<?php echo $userInfo[0]['email'] ?>" placeholder="Email" aria-label="default input example">
                                    <?php
                                    if (isset($error['email']) && !empty($error['email']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['email']}</p>";
                                    ?>
                                </div>
                                <div class="left-order-add-create">
                                    <h2>Số điện thoại</h2>
                                    <input name="phone" class="" type="text" value="<?php echo $userInfo[0]['phone'] ?>" placeholder="Nhập Số Điện Thoại" aria-label="default input example">
                                    <?php
                                    if (isset($error['phone']) && !empty($error['phone']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['phone']}</p>";
                                    ?>
                                </div>
                                <div class="Dropdowns_categogy">
                                    <h2>Vai Trò</h2>
                                    <div class="custom-select">
                                        <!-- Dropdown -->
                                        <select name="role" id="dropdown" onchange="updateInput()">
                                            <option selected="<?php echo ($userInfo[0]['role'] == 0) ? 'checked' : ''; ?>" value="0">User thường</option>
                                            <option selected="<?php echo ($userInfo[0]['role'] == 2023) ? 'checked' : ''; ?>" value="2023">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5 col-md">
                                <div class="right-order-add-create p30 d-flex justify-content-center flex-column ">
                                    <div class="img_order-add-create rounded-4">
                                        <?php
                                        $upload_dir = './public/upload/users/';
                                        //Đường dẫn của file sau khi upload
                                        $upload_file = $upload_dir . $userInfo[0]['img'];
                                        if (empty($userInfo[0]['img']) || $userInfo[0]['img'] == NULL || !file_exists($upload_file)) {
                                        ?>
                                            <td><img src="./public/upload/users/anonyUser.png"></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><img src="./public/upload/users/<?php echo $userInfo[0]['img'] ?>">
                                            </td>
                                        <?php
                                        }

                                        ?>
                                    </div>
                                    <hr>
                                    <div style="width: 100%;" id="drop-area">
                                        <h3>Kéo thả ảnh ở đây</h3>
                                        <input name="file" type="file" id="fileInput">
                                    </div>

                                    <div style="width: 100%;" id="demo" class="demo .box-shadow1">

                                    </div>
                                    <div style="width: 100%;" id="deleteButtonImg" class="button_delete_img row">
                                        <div class="col-4"></div>
                                        <div class="col-8 d-flex j-end">
                                            <input name="btn_update" value="Cập Nhật" type="submit" class="btn btn-primary">
                                            <input value="Xóa" type="button" id="deleteButtonAll" class="btn btn-danger">
                                            <input name="btn_cancelled" type="submit" value="Thoát" class="btn_cancelled">
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($error['status']) && !empty($error['status']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['status']}</p>";
                                    ?>

                                    <div class="poupDashboard col-12 text-start mt-5">
                                        <div class="poupDashboard_item">
                                            <p class="title-small">Bạn có chắc muốn xóa tài khoản này không ?</p>
                                            <p class="title-small">Sẽ xóa tất cả bao gồm:</p>
                                            <ul>
                                                <li class="label-large">Xóa Địa Chỉ</li>
                                                <li class="label-large">Xóa Đơn Hàng</li>
                                                <li class="label-large">Xóa Thông Tin</li>
                                                <li class="label-large">Xóa Bình Luận</li>
                                            </ul>
                                            <a href=""><input class="popupDashboard_del btn btn-danger" type="submit" value="Xóa" name="btn_delete"></a>
                                            <button class="popupDashboard_canc label-large">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
</section>

<script>
    document.getElementById('deleteButtonImg').addEventListener('click', function() {
        this.style.display = 'none';
        document.querySelector('.poupDashboard').style.display = 'block';
    });

    document.querySelector('.popupDashboard_canc').addEventListener('click', function() {
        document.querySelector('.poupDashboard').style.display = 'none';
        document.getElementById('deleteButtonImg').style.display = 'block';
    });
</script>