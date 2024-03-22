<?php

use App\model\Bill;
use App\model\User;
use App\model\Comment;
use App\model\Address;
?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Địa Chỉ</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="/adminAddress" class="label-large" style="text-decoration: none;">Địa Chỉ</a>
            </div>

        </div>
    </div>
    <!----======== End Header DashBoard ======== -->

    <!----======== Body DashBoard ======== -->
    <div class="containerAdmin">
        <div class="width-full d-flex align-items-center justify-content-between">
            <div class="content-filter dropdown-center width-full d-flex align-items-center justify-content-between">
                <button id="btn_addMore_admin" type="button" style="width:130px;height:45px;background-color:#6750a4;border-radius:10px"><a style="color: white; font-size: 12px; text-decoration: none; padding: 10px 5px;" href="/adminAddressAdd">Thêm địa chỉ</a></button>
            </div>
        </div>
        <table id="example1" class="content-table width-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ Và Tên</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Địa Chỉ Chi Tiết</th>
                    <th>Phone</th>
                    <th>Khác</th>
                </tr>
            </thead>
            <tbody>
                <!-- Thêm các hàng dữ liệu vào đây -->
                <?php
                $newAddressModel = new Address();
                $addressList = $newAddressModel->getAllAddress();
                foreach ($addressList as $item) {
                    $newUserModel = new User();
                    $userInfo = $newUserModel->getUserById($item['id_user']);
                ?>
                    <tr>
                        <td>
                            <?php echo $item['id'] ?>
                        </td>
                        <td>
                            <?php echo $userInfo[0]['fullname'] ?>
                        </td>
                        <td>
                            <?php print_r($userInfo[0]['email']) ?>
                        </td>
                        <td>
                            <?php echo $item['address'] ?>
                        </td>

                        <td>
                            <?php echo $item['address_detail'] ?>
                        </td>
                        <td>
                            <?php echo $item['phone'] ?>
                        </td>
                        <td><a href="/adminAddressEdit?id=<?php echo $item['id'] ?>">Xem chi tiết</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</section>