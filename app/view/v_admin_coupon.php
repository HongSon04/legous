<?php

use App\model\Bill;
use App\model\Comment;
use App\model\Coupon;
use App\model\User;

?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->


    <!----======== End Header DashBoard ======== -->

    <!----======== Body DashBoard ======== -->

    <!----======== Carousel DashBoard ======== -->

    <div class="containerAdmin" style="margin:0;">
        <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
            <div class="text">
                <h1 class="label-large-prominent" style="font-size: 24px;
                        line-height: 32px;">Mã Giảm Giá</h1>
            </div>
            <!--DateTimelocal-->
            <div class="flex-between width-full" style="gap: 8px;
                        align-items: center;">
                <div class="flex g8">
                    <span class="label-large">Admin /</span><a href="#" class="label-large" style="text-decoration: none;">Mã Giảm Giá</a>
                </div>

            </div>
        </div>
        <!----======== Body DashBoard ======== -->
        <div class="containerAdmin">
            <div class="col-12 manageCoupon d-xxl-flex d-xl-flex d-lg-flex d-md-flex d-block">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-10 manageCoupon_items p30 box-shadow1">
                    <div class="col-12 d-flex">
                        <button class="showmanageCoupon col-3 d-flex align-items-center justify-content-center">
                            <div class="manageCoupon_itemsSetting">
                                <i class="far fa-cog"></i>
                            </div>
                        </button>
                        <div class="manageCoupon_itemsText col-9">
                            <div class="col-12">
                                <h2 class="body-large">Quản Lý Mã Giảm Giá</h2>
                            </div>
                            <div class="col-12 d-flex">
                                <p class="title-small">Hiện có: </p>
                                <?php
                                $i = 0;
                                $newCouponModel = new Coupon();
                                foreach ($newCouponModel->getAllCoupon() as $item) {
                                    $i++;
                                }
                                ?>
                                <span class="title-small">&ensp;
                                    <?php echo $i ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-10 manageCoupon_items p30 box-shadow1 mx-xxl-5 mx-xl-5 mx-lg-5 mx-md-5 mt-5 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                    <div class="col-12 d-flex">
                        <a href="/adminCreateCoupon" class="d-flex align-items-center justify-content-center col-3">
                            <div class="manageCoupon_itemsSetting">
                                <i class="far fa-cog"></i>
                            </div>
                        </a>
                        <div class="manageCoupon_itemsText col-9">
                            <div class="col-12">
                                <h2 class="body-large">Tạo Mã Giảm Giá</h2>
                            </div>
                            <div class="col-12 d-flex">
                                <p class="title-small">Tạo Mã Giảm Giá Mới</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table id="example1" class="example1 content-table width-full">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Tên Mã</th>
                        <th>Mã Giảm Giá</th>
                        <th>Mô Tả</th>
                        <th>Mức Giảm</th>
                        <th>Ngày Tạo</th>
                        <th>Ngày Hết Hạn</th>
                        <th>Khác</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Thêm các hàng dữ liệu vào đây -->
                    <?php
                    $newCouponModel = new Coupon();
                    $getAllCoupon = $newCouponModel->getAllCoupon();
                    foreach ($getAllCoupon as $item) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $item['id'] ?>
                            </td>
                            <td>
                                <?php echo $item['name'] ?>
                            </td>
                            <td>
                                <?php echo $item['coupon_code'] ?>
                            </td>
                            <td>
                                <?php echo $item['description'] ?>
                            </td>
                            <td>
                                <?php echo $item['discount'] ?>
                            </td>
                            <td>
                                <?php echo $item['create_date'] ?>
                            </td>
                            <td>
                                <?php echo $item['expired_date'] ?>
                            </td>
                            <td><a href="/adminCreateCoupon?editId=<?php echo $item['id'] ?>">Xem chi tiết</a></td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
        <!----======== End Body DashBoard ======== -->
    </div>

</section>