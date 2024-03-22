<?php

use App\model\User;
use App\model\Bill;
use App\model\Comment;

$newUserModel = new User();
$user_list = $newUserModel->getUser();
?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->
    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Khách Hàng</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="/adminClient" class="label-large" style="text-decoration: none;">Khách Hàng</a>
            </div>

        </div>
    </div>
    <!----======== End Header DashBoard ======== -->

    <!----======== Body DashBoard ======== -->
    <div class="containerAdmin">
        <div class="width-full d-flex align-items-center justify-content-between">
            <div class="content-filter dropdown-center width-full d-flex align-items-center justify-content-between">
                <button id="btn_addMore_admin" type="button" style="width:130px;height:45px;background-color:#6750a4;border-radius:10px"><a style="color: white; font-size: 12px; text-decoration: none; padding: 10px 5px;" href="/adminUserAdd">Thêm Khách Hàng</a></button>
            </div>
        </div>
        <table id="example1" class="content-table width-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ Và Tên</th>
                    <th>Ảnh</th>
                    <th>Tài Khoản</th>
                    <th>Mật Khẩu</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Khác</th>
                </tr>
            </thead>
            <tbody>
                <!-- Thêm các hàng dữ liệu vào đây -->
                <?php
                foreach ($user_list as $item) {
                ?>
                    <tr>
                        <td>
                            <?php echo $item['id'] ?>
                        </td>
                        <td>
                            <?php echo $item['fullname'] ?>
                        </td>
                        <?php
                        $upload_dir = './public/upload/users/';
                        //Đường dẫn của file sau khi upload
                        $upload_file = $upload_dir . $item['img'];
                        if (empty($item['img']) || $item['img'] == NULL || !file_exists($upload_file)) {
                        ?>
                            <td><img style="width:50px; height: 50px; border-radius: 3px" src="./public/upload/users/anonyUser.png" alt=""></td>
                        <?php
                        } else {
                        ?>
                            <td><img style="width:50px; height: 50px; border-radius: 3px" src="./public/upload/users/<?php echo $item['img'] ?>" alt=""></td>
                        <?php
                        }
                        ?>
                        <td>
                            <?php echo $item['username'] ?>
                        </td>
                        <td>
                            <?php echo $item['password'] ?>
                        </td>
                        <td>
                            <?php echo $item['email'] ?>
                        </td>
                        <td>
                            <?php echo $item['phone'] ?>
                        </td>
                        <td><a href="/adminUserEdit?id=<?php echo $item['id'] ?>">Xem chi tiết</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</section>
<script>
    if (window.innerWidth < 1300) {
        document.querySelector('nav').classList.add("close");
    }
</script>