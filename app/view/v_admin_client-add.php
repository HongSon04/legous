<?php

use App\model\user;
use App\model\Bill;
use App\model\Comment;

$newUserModel = new user();

?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Thêm Tài Khoản</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="/adminUser" class="label-large" style="text-decoration: none;">Khách Hàng</a>
            </div>
            <!-- <div class="flex-center g8">
            <span><i class="fa-solid fa-calendar-days"></i></span>
            <input class="label-large-prominent" type="datetime-local" style="color: #625B71; border: none; font-size: 16px;
                ">
          </div> -->
        </div>
    </div>
    <!----======== End Header DashBoard ======== -->
    <div class="containerAdmin_order-detail p30">

        <form enctype="multipart/form-data" action="/adminUserAddHandler" method="POST">
            <div class="sliderDashboard_order-add-create sliderDashboard_order-detail rounded-4">
                <div class="body_sliderDashboard_order-add-create p20 row">
                    <div class="col-7">
                        <div class="left-order-add-create">
                            <h2>Họ Và Tên</h2>
                            <input name="fullname" class="" type="text" placeholder="Nhập Họ Và Tên" aria-label="default input example">
                            <?php
                            if (isset($error['fullname']) && !empty($error['fullname']))
                                echo "<p class='text-danger text-error title-medium'>{$error['fullname']}</p>";
                            ?>
                        </div>
                        <div class="left-order-add-create">
                            <h2>Tên Đăng Nhập</h2>
                            <input name="username" class="" type="text" placeholder="Nhập Tên Đăng Nhập" aria-label="default input example">
                            <?php
                            if (isset($error['username']) && !empty($error['username']))
                                echo "<p class='text-danger text-error title-medium'>{$error['username']}</p>";
                            ?>
                        </div>
                        <div class="left-order-add-create">
                            <h2>Mật Khẩu</h2>
                            <input name="password" class="" type="password" placeholder="Nhập Mật Khẩu" aria-label="default input example">
                            <?php
                            if (isset($error['password']) && !empty($error['password']))
                                echo "<p class='text-danger text-error title-medium'>{$error['password']}</p>";
                            ?>
                        </div>
                        <div class="left-order-add-create">
                            <h2>Email</h2>
                            <input name="email" class="" type="email" placeholder="Email" aria-label="default input example">
                            <?php
                            if (isset($error['email']) && !empty($error['email']))
                                echo "<p class='text-danger text-error title-medium'>{$error['email']}</p>";
                            ?>
                        </div>
                        <div class="left-order-add-create">
                            <h2>Số điện thoại</h2>
                            <input name="phone" class="" type="number" placeholder="Nhập Số Điện Thoại" aria-label="default input example">
                            <?php
                            if (isset($error['phone']) && !empty($error['phone']))
                                echo "<p class='text-danger text-error title-medium'>{$error['phone']}</p>";
                            ?>
                        </div>
                        <div class="left-order-add-create">
                            <h2>Địa Chỉ</h2>
                            <input name="address" class="" type="text" placeholder="Nhập Địa chỉ" aria-label="default input example">
                            <?php
                            if (isset($error['address']) && !empty($error['address']))
                                echo "<p class='text-danger text-error title-medium'>{$error['address']}</p>";
                            ?>
                        </div>
                        <div class="describe-order_detail">
                            <h2>Mô Tả</h2>
                            <textarea name="bio" id="" cols="30" rows="10" placeholder="Nhập mô tả người dùng"></textarea>
                            <?php
                            if (isset($error['bio']) && !empty($error['bio']))
                                echo "<p class='text-danger text-error title-medium'>{$error['bio']}</p>";
                            ?>
                        </div>

                        <div class="Dropdowns_categogy">
                            <h2>Vai Trò</h2>
                            <div class="custom-select">
                                <!-- Dropdown -->
                                <select name="role" id="dropdown" onchange="updateInput()">
                                    <option value="0">User thường</option>
                                    <option value="2023">Admin</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-5 col-md">
                        <div class="right-order-add-create p30 d-flex justify-content-center flex-column ">
                            <div class="img_order-add-create rounded-4">
                            </div>
                            <hr>
                            <div style="width: 100%;" id="drop-area">
                                <h3>Kéo thả ảnh ở đây</h3>
                                <input name="file" type="file" id="fileInput">
                            </div>
                            <?php
                            if (isset($error['img']) && !empty($error['img']))
                                echo "<p class='text-danger text-error title-medium'>{$error['img']}</p>";
                            ?>

                            <div style="width: 100%;" id="demo" class="demo .box-shadow1">

                            </div>
                            <div style="width: 100%;" id="deleteButtonImg" class="button_delete_img row">
                                <div class="col-4"></div>
                                <div class="col-8 d-flex flex-end">
                                    <input name="btn_update" value="Thêm Tài Khoản" type="submit" class="btn btn-primary "></input>
                                    <input name="btn_cancelled" type="submit" value="Thoát" class="btn_cancelled">
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <span class="flex"></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
</section>