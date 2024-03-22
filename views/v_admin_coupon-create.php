<?php
$getTotalBill = getBill();
$getProduct = getProducts();
$getUser = getUser();
$getCmt = getAllComment();
$totalBill = 0;
$totalSales = 0;
$totalUser = 0;
$totalCmt = 0;
$totalQuan = 0;
foreach($getTotalBill as $item) {
    if($item['status'] == 4) {
        $totalBill += $item['total'];
    }
}
foreach($getProduct as $item) {
    $totalSales += $item['purchases'];
}
foreach($getProduct as $item) {
    $totalQuan += $item['qty'];
}
foreach($getUser as $item) {
    $totalUser++;
}
foreach($getCmt as $item) {
    $totalCmt++;
}
if(isset($_POST['createCouponSubmit'])) {
    $error = [];
    $qtyTotal = [];
    if(isset($_POST['namecoupon']) && !empty($_POST['namecoupon'])) {
        $namecoupon = $_POST['namecoupon'];
    } else {
        $error['namecoupon'] = "Không được để trống Tên Coupon";
    }

    if(isset($_POST['qtycoupon']) && !empty($_POST['qtycoupon'])) {
        $qtycoupon = $_POST['qtycoupon'];
        for($i = 0; $i < $qtycoupon; $i++) {
            $randomString = bin2hex(random_bytes(5)); // Tạo chuỗi ngẫu nhiên gồm 10 ký tự
            array_push($qtyTotal, $randomString);
        }
    } else {
        $error['qtycoupon'] = "Không được để trống số lượng";
    }

    if(isset($_POST['discountpercent']) && !empty($_POST['discountpercent'])) {
        $discountpercent = $_POST['discountpercent'];
    } else {
        $error['discountpercent'] = "Không được để trống Mức Giảm Giá";
    }

    if(isset($_POST['expiredDate']) && !empty($_POST['expiredDate'])) {
        $expiredDate = $_POST['expiredDate'];
    } else {
        $error['expiredDate'] = "Không được để trống Ngày Hết Hạn";
    }

    if(isset($_POST['description']) && !empty($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $error['description'] = "Không được để trống Mô Tả";
    }
    foreach($qtyTotal as $item) {
        addNewCoupon(strtoupper($item), $namecoupon, $discountpercent, $expiredDate, $description, date("Y-m-d"));
    }
    header("Location: ?mod=admin&act=createcoupon");
}
if(isset($_POST['editCouponsubmit'])) {
    $error = [];
    $getEditID = (int)$_GET['editId'];
    if(isset($_POST['namecoupon']) && !empty($_POST['namecoupon'])) {
        $namecoupon = $_POST['namecoupon'];
    } else {
        $error['namecoupon'] = "Không được để trống Tên Coupon";
    }

    if(isset($_POST['discountpercent']) && !empty($_POST['discountpercent'])) {
        $discountpercent = $_POST['discountpercent'];
    } else {
        $error['discountpercent'] = "Không được để trống Mức Giảm Giá";
    }

    if(isset($_POST['expiredDateEdit']) && !empty($_POST['expiredDateEdit'])) {
        $expiredDateEdit = $_POST['expiredDateEdit'];
    } else {
        $error['expiredDateEdit'] = "Không được để trống Ngày Hết Hạn";
    }

    if(isset($_POST['description']) && !empty($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $error['description'] = "Không được để trống Mô Tả";
    }
    editCoupon($getEditID, $namecoupon, $discountpercent, $description, $expiredDateEdit);
    header("Location: ?mod=admin&act=coupon");
}

?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <div class="top">
        <i class="fas fa-angle-left sidebar-toggle"></i>
        <div class="search-box">
            <form style="width: 100%;display:flex; justify-content: center;" action="" method="post">
                <i class="far fa-search"></i>
                <input type="text" placeholder="Tìm kiếm..." disabled="disabled">
            </form>
        </div>
        <div class="info-user">
            <div class="notifiComment">
                <i class="far fa-comment-alt btnShowFeature"></i>
                <ul class="showFeatureAdminHeader box-shadow1">
                    <?php
                    $getCmt = getAllComment();
                    if (empty($getCmt)) {
                        ?>
                    <li>
                        <div class="col-12 d-flex">
                            <p class="title-medium text-center">Hiện đang không có dữ liệu nào</p>
                        </div>
                    </li>
                    <?php
                    } else {
                        arsort($getCmt);
                        $getCmt = array_slice($getCmt, 0, 6, true);
                        foreach ($getCmt as $item) {

                            $getUser = getUserById($item['id_user']);
                            $getProduct = getProductById($item['id_product']);
                            ?>
                    <li>
                        <div class="col-12 d-flex">
                            <div class="col-2">
                                <?php
                                        if ($getUser[0]['img'] == NULL || empty($getUser[0]['img'])) {
                                            ?>
                                <img class="notifiAdminImg" src="./upload/users/avatar-none.png" alt="">

                                <?php
                                        } else {
                                            ?>
                                <img class="notifiAdminImg" src="./upload/users/<?php echo $getUser[0]['img'] ?>"
                                    alt="">
                                <?php
                                        }
                                        ?>
                            </div>
                            <div class="col-10">
                                <p class="notifiAdminText body-small"><strong>
                                        <?php echo $getUser[0]['fullname'] ?>
                                    </strong><span> đã bình luận ở sản phẩm <strong><a href="">
                                                <?php echo $getProduct['name'] ?>
                                            </a></strong></span></p>
                            </div>
                        </div>
                    </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="notifiBell">
                <i class="fal fa-bell btnShowFeature"></i>
                <ul class="showFeatureAdminHeader box-shadow1">
                    <?php
                    $getBill = getBill();
                    if (empty($getBill)) {
                        ?>
                    <li>
                        <div class="col-12 d-flex">
                            <p class="title-medium text-center">Hiện đang không có dữ liệu nào</p>
                        </div>
                    </li>
                    <?php
                    } else {
                        arsort($getBill);
                        $getBill = array_slice($getBill, 0, 6, true);
                        foreach ($getBill as $item) {

                            $getUser = getUserById($item['id_user']);
                            ?>
                    <li>
                        <div class="col-12 d-flex">
                            <div class="col-2">
                                <?php
                                        if ($getUser[0]['img'] == NULL || empty($getUser[0]['img'])) {
                                            ?>
                                <img class="notifiAdminImg" src="./upload/users/avatar-none.png" alt="">

                                <?php
                                        } else {
                                            ?>
                                <img class="notifiAdminImg" src="./upload/users/<?php echo $getUser[0]['img'] ?>"
                                    alt="">

                                <?php
                                        }
                                        ?>
                            </div>
                            <div class="col-10">
                                <p class="notifiAdminText body-small"><strong>
                                        <?php
                                                if ($getUser[0]['fullname'] == NULL && empty($getUser[0]['fullname'])) {
                                                    echo "User ẩn";

                                                } else {
                                                    echo $getUser[0]['fullname'];

                                                }
                                                ?>
                                    </strong><span> vừa mua
                                        một mô hình với mã đơn hàng <strong>
                                            <?php echo $item['id'] ?>
                                        </strong></span></p>
                            </div>
                        </div>
                    </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="imgUserAdmin">
                <?php
                $getID = $_SESSION['admin']['id_user'];
                $getUser = getUserById($getID);
                if (!empty($getUser['img']) || $getUser != NULL) {
                    ?>
                <img style="" class="btnShowFeature" src="./upload/users/<?php echo $getUser[0]['img'] ?>" alt="">
                <?php
                } else {
                    ?>
                <img style="" class="btnShowFeature" src="./upload/users/avatar-none.png" alt="">
                <?php
                }
                ?>
                <ul class="showFeatureAdminHeader box-shadow1">
                    <li><a class="body-small" href="?mod=user&act=logOut-account">Đăng Xuất</a></li>
                </ul>
            </div>
        </div>
    </div>

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
                    <span class="label-large">Admin /</span><a href="?mod=admin&act=coupon" class="label-large"
                        style="text-decoration: none;">Mã Giảm Giá</a> <span class="label-large">/</span> <a
                        class="label-large" href="?mod=admin&act=createcoupon" style="text-decoration: none">Tạo Mã Giảm
                        Giá</a>
                </div>

            </div>
        </div>
        <!----======== Body DashBoard ======== -->
        <div class="containerAdmin">
            <div class="col-12 d-block d-xxl-flex d-xl-flex createCoupon my-5">
                <div class="box-shadow1 col-12 col-xxl-7 col-xl-7 createCoupon_left p30">
                    <?php
                    if(isset($_GET['editId'])) {
                        $getCouponById = getCouponById($_GET['editId']);
                        ?>
                    <form action="" method="post">
                        <div class="col-12 d-flex createCoupon_items">
                            <div class="col-12 infoCoupon" style="margin-left: unset">
                                <div class="col-12">
                                    <label for="namecoupon" class="label-large">Mô Tả</label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="text" name="namecoupon" id="namecoupon"
                                        placeholder="Tên Mã" value="<?php echo $getCouponById[0]['name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex createCoupon_items">
                            <div class="col-6">
                                <div class="col-12">
                                    <label for="discountpercent" class="label-large">Mức Giảm (%)</label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="text" name="discountpercent" id="discountpercent"
                                        placeholder="VD 10" value="<?php echo $getCouponById[0]['discount'] ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <label for="expiredDateEdit" class="label-large">Ngày Hết Hạn:
                                        <?php echo $getCouponById[0]['expired_date'] ?>
                                    </label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="date" name="expiredDateEdit" id="expiredDateEdit"
                                        placeholder="Ngày Hết Hạn">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex createCoupon_items">
                            <div class="col-12 infoCoupon" style="margin-left: unset">
                                <div class="col-12">
                                    <label for="description" class="label-large">Mô Tả</label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="text" name="description" id="description"
                                        placeholder="Mô Tả ngắn" value="<?php echo $getCouponById[0]['description'] ?>">
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Chỉnh sửa" name="editCouponsubmit"
                            class="editCouponsubmit label-large createCouponSubmit">
                    </form>
                    <?php
                    } else {
                        ?>
                    <form action="" method="post">
                        <div class="col-12 d-flex createCoupon_items">
                            <div class="col-6">
                                <div class="col-12">
                                    <label for="namecoupon" class="label-large">Tên Mã</label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="text" name="namecoupon" id="namecoupon"
                                        placeholder="Tên Mã">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <label for="qtycoupon" class="label-large">Số Lượng Mã</label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="text" name="qtycoupon" id="qtycoupon"
                                        placeholder="Số Lượng Mã">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex createCoupon_items">
                            <div class="col-6">
                                <div class="col-12">
                                    <label for="discountpercent" class="label-large">Mức Giảm (%)</label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="text" name="discountpercent" id="discountpercent"
                                        placeholder="VD 10">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <label for="expiredDate" class="label-large">Ngày Hết Hạn</label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="date" name="expiredDate" id="expiredDate"
                                        placeholder="Ngày Hết Hạn">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex createCoupon_items">
                            <div class="col-12 infoCoupon" style="margin-left: unset">
                                <div class="col-12">
                                    <label for="description" class="label-large">Mô Tả</label>
                                </div>
                                <div class="col-12">
                                    <input class="body-large" type="text" name="description" id="description"
                                        placeholder="Mô Tả ngắn">
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Tạo Ngay" name="createCouponSubmit"
                            class="createCouponSubmit label-large">
                    </form>
                    <?php
                    }
                    ?>
                </div>
                <div
                    class="box-shadow1 mt-5 mt-xxl-0 mt-xl-0 ms-xxl-5 ms-xl-5 col-12 col-xxl-5 col-xl-5 createCoupon_right p20">
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
                        $getAllCoupon = getAllCoupon();
                        foreach($getAllCoupon as $item) {
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
                                                Mã Coupon: <?php echo $item['coupon_code'] ?>
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
                                                    <li class="title-small"><a
                                                            href="?mod=admin&act=createcoupon&editId=<?php echo $item['id'] ?>">Sửa</a>
                                                    </li>
                                                    <li class="title-small"><a
                                                            href="?mod=admin&act=delcoupon&editId=<?php echo $item['id'] ?>">Xóa</a>
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