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
                        line-height: 32px;">Mã Giảm Giá</h1>
            </div>
            <!--DateTimelocal-->
            <div class="flex-between width-full" style="gap: 8px;
                        align-items: center;">
                <div class="flex g8">
                    <span class="label-large">Admin /</span><a href="#" class="label-large"
                        style="text-decoration: none;">Mã Giảm Giá</a>
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
                                foreach(getAllCoupon() as $item) {
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
                <div
                    class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-10 manageCoupon_items p30 box-shadow1 mx-xxl-5 mx-xl-5 mx-lg-5 mx-md-5 mt-5 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                    <div class="col-12 d-flex">
                        <a href="?mod=admin&act=createcoupon"
                            class="d-flex align-items-center justify-content-center col-3">
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
                    $getAllCoupon = getAllCoupon();
                    foreach($getAllCoupon as $item) {
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
                        <td><a href="?mod=admin&act=createcoupon&editId=<?php echo $item['id'] ?>">Xem chi tiết</a></td>
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