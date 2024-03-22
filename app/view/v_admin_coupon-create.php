<?php

use App\model\Bill;
use App\model\Comment;
use App\model\Product;
use App\model\User;
use App\model\Coupon;

$newBillModel = new Bill();
$newProductModel = new Product();
$newUserModel = new User();
$newCommentModel = new Comment();
$getTotalBill = $newBillModel->getBill();
$getProduct = $newProductModel->getProducts();
$getUser = $newUserModel->getUser();
$getCmt = $newCommentModel->getAllComment();
$totalBill = 0;
$totalSales = 0;
$totalUser = 0;
$totalCmt = 0;
$totalQuan = 0;
foreach ($getTotalBill as $item) {
    if ($item['status'] == 4) {
        $totalBill += $item['total'];
    }
}
foreach ($getProduct as $item) {
    $totalSales += $item['purchases'];
}
foreach ($getProduct as $item) {
    $totalQuan += $item['qty'];
}
foreach ($getUser as $item) {
    $totalUser++;
}
foreach ($getCmt as $item) {
    $totalCmt++;
}


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
                        line-height: 32px;">Tạo Mã Giảm Giá</h1>
            </div>
            <!--DateTimelocal-->
            <div class="flex-between width-full" style="gap: 8px;
                        align-items: center;">
                <div class="flex g8">
                    <span class="label-large">Admin /</span><a href="/adminCoupon" class="label-large" style="text-decoration: none;">Mã Giảm Giá</a> <span class="label-large">/</span> <a class="label-large" href="/adminCreateCoupon" style="text-decoration: none">Tạo Mã Giảm
                        Giá</a>
                </div>

            </div>
        </div>
        <!----======== Body DashBoard ======== -->
        <div class="containerAdmin">
            <div class="col-12 d-block d-xxl-flex d-xl-flex createCoupon my-5">
                <div class="box-shadow1 col-12 col-xxl-7 col-xl-7 createCoupon_left p30">
                    <?php
                    if (isset($_GET['editId'])) {
                        $newCouponModel = new Coupon();
                        $getCouponById = $newCouponModel->getCouponById($_GET['editId']);
                    ?>
                        <form action="/editCouponHandler" method="post">
                            <div class="col-12 d-flex createCoupon_items">
                                <div class="col-12 infoCoupon" style="margin-left: unset">
                                    <div class="col-12">
                                        <label for="namecoupon" class="label-large">Mô Tả</label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="text" name="namecoupon" id="namecoupon" placeholder="Tên Mã" value="<?php echo $getCouponById[0]['name'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex createCoupon_items">
                                <div class="col-6">
                                    <div class="col-12">
                                        <label for="discountpercent" class="label-large">Mức Giảm (%)</label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="text" name="discountpercent" id="discountpercent" placeholder="VD 10" value="<?php echo $getCouponById[0]['discount'] ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="col-12">
                                        <label for="expiredDateEdit" class="label-large">Ngày Hết Hạn:
                                            <?php echo $getCouponById[0]['expired_date'] ?>
                                        </label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="date" name="expiredDateEdit" id="expiredDateEdit" placeholder="Ngày Hết Hạn">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex createCoupon_items">
                                <div class="col-12 infoCoupon" style="margin-left: unset">
                                    <div class="col-12">
                                        <label for="description" class="label-large">Mô Tả</label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="text" name="description" id="description" placeholder="Mô Tả ngắn" value="<?php echo $getCouponById[0]['description'] ?>">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="Chỉnh sửa" name="editCouponsubmit" class="editCouponsubmit label-large createCouponSubmit">
                        </form>
                    <?php
                    } else {
                    ?>
                        <form action="/adminCreateCouponHandler" method="post">
                            <div class="col-12 d-flex createCoupon_items">
                                <div class="col-6">
                                    <div class="col-12">
                                        <label for="namecoupon" class="label-large">Tên Mã</label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="text" name="namecoupon" id="namecoupon" placeholder="Tên Mã">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="col-12">
                                        <label for="qtycoupon" class="label-large">Số Lượng Mã</label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="text" name="qtycoupon" id="qtycoupon" placeholder="Số Lượng Mã">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex createCoupon_items">
                                <div class="col-6">
                                    <div class="col-12">
                                        <label for="discountpercent" class="label-large">Mức Giảm (%)</label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="text" name="discountpercent" id="discountpercent" placeholder="VD 10">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="col-12">
                                        <label for="expiredDate" class="label-large">Ngày Hết Hạn</label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="date" name="expiredDate" id="expiredDate" placeholder="Ngày Hết Hạn">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex createCoupon_items">
                                <div class="col-12 infoCoupon" style="margin-left: unset">
                                    <div class="col-12">
                                        <label for="description" class="label-large">Mô Tả</label>
                                    </div>
                                    <div class="col-12">
                                        <input class="body-large" type="text" name="description" id="description" placeholder="Mô Tả ngắn">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="Tạo Ngay" name="createCouponSubmit" class="createCouponSubmit label-large">
                        </form>
                    <?php
                    }
                    ?>
                </div>
                <div class="box-shadow1 mt-5 mt-xxl-0 mt-xl-0 ms-xxl-5 ms-xl-5 col-12 col-xxl-5 col-xl-5 createCoupon_right p20">
                    <div class="listCouponHead p10">
                        <div class="col-12 d-flex justify-content-around">
                            <div class="col-6">
                                <h4 class="title-medium">Mã Giảm Giá</h4>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <i class="fas fa-ellipsis-v"></i>
                            </div>
                        </div>
                    </div>
                    <div class="listCoupon_item">
                        <?php
                        $newCouponModel = new Coupon();
                        $getAllCoupon = $newCouponModel->getAllCoupon();
                        foreach ($getAllCoupon as $item) {
                        ?>
                            <div class="listCoupon_items p10">
                                <div class="col-12 d-flex">
                                    <div class="col-10 d-flex justify-content-between">
                                        <div class="col-3">
                                            <h2 class="saleListCoupon title-medium">
                                                <?php echo $item['discount'] ?>
                                            </h2>
                                        </div>
                                        <div class="col-9">
                                            <div class="col-12">
                                                <h1 class="titleSaleListCoupon title-medium">
                                                    <?php echo $item['name'] ?>
                                                </h1>
                                            </div>
                                            <div class="col-12">
                                                <p class="infoSaleListCoupon body-small">
                                                    Mã Coupon:
                                                    <?php echo $item['coupon_code'] ?>
                                                </p>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <p class="timeLeft body-large">Ngày hết hạn:
                                                    <?php echo $item['expired_date'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 buttonShowFeatureCoupon d-flex justify-content-end">
                                        <ul>
                                            <li><i class="fas fa-ellipsis-v"></i>
                                                <div class="hiddenFeatureCoupon">
                                                    <ul>
                                                        <li class="title-small"><a href="/adminCreateCoupon&editId=<?php echo $item['id'] ?>">Sửa</a>
                                                        </li>
                                                        <li class="title-small"><a href="/adminDeleteCoupon?editId=<?php echo $item['id'] ?>">Xóa</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!----======== End Body DashBoard ======== -->
    </div>

</section>
<script>
    document.querySelectorAll('.buttonShowFeatureCoupon').forEach(function(button) {
        button.addEventListener('click', function() {
            var hiddenFeatureCoupon = this.querySelector('.hiddenFeatureCoupon');
            if (hiddenFeatureCoupon.style.display === 'none') {
                hiddenFeatureCoupon.style.display = 'block';
            } else {
                hiddenFeatureCoupon.style.display = 'none';
            }
        });
    });
</script>