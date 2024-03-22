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
    <div class="containerAdmin_order-detail p30">
        <div class="localDashboard">
            <div class="col-12 d-flex">
                <div class="col-6">
                    <div class="col-12">
                        <h2>Thêm Sản Phẩm</h2>
                    </div>
                    <div class="col-12">
                        <span class="label-large">Admin /</span><a href="?mod=admin&act=products" class="label-large"
                            style="text-decoration: none;"> Sản Phẩm</a>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
        <?=@$error?>
        <div class="sliderDashboard_order-add-create sliderDashboard_order-detail rounded-4 p30">
            <form action="" method="post">
                <div class="row d-flex d-flex justify-content-between ">
                    <div style="width:49%;">
                        <h1 style="margin-bottom: 20px;">Người Nhận</h1>
                        <div class="row">
                            <label for="" class="col-sm-2 col-form-label col-form-label-lg">Họ và Tên</label>
                            <input style="padding:13px;" type="" name="name_us_order"
                                class="form-control form-control-lg" placeholder="">
                        </div>
                        <div class="row">
                            <label for="" class="col-sm-2 col-form-label col-form-label-lg">Địa Chỉ</label>
                            <input style="padding:13px;" type="" name="location_us_order"
                                class="form-control form-control-lg" placeholder="">
                        </div>
                        <div class="row">
                            <label for="" class="col-sm-2 col-form-label col-form-label-lg">Email</label>
                            <input style="padding:13px;" type="" name="email_us_order"
                                class="form-control form-control-lg" placeholder="">
                        </div>
                        <div class="row">
                            <label for="" class="col-sm-2 col-form-label col-form-label-lg">Điện Thoại</label>
                            <input style="padding:13px;" type="" name="phone_us_order"
                                class="form-control form-control-lg" placeholder="">
                        </div>
                    </div>
                    <div style="width:49%;">
                        <h1 style="margin-bottom: 20px;">Đơn Hàng</h1>
                        <!-- <div class="row">
                            <label for="" class="col-sm-2 col-form-label col-form-label-lg">Tên Đơn Hàng</label>
                            <input style="padding:13px;" type="" name="name_order" class="form-control form-control-lg"  placeholder="">
                        </div> -->
                        <div class="row">
                            <label style="width:300px !important;" for=""
                                class="col-sm-2 col-form-label col-form-label-lg">Tổng Đơn</label>
                            <input style="padding:13px;" type="" name="total_order" class="form-control form-control-lg"
                                placeholder="">
                        </div>
                        <div class="row">
                            <label style="width:300px !important;" for=""
                                class="col-sm-2 col-form-label col-form-label-lg">Cách Thức Giao</label>
                            <select name="method_order" style="padding:13px;" class="form-select form-select-lg "
                                aria-label=".form-select-lg example">
                                <option value="1">Thường</option>
                                <option value="2">Miễn Phí</option>
                                <option value="3">Hỏa Tốc</option>
                            </select>
                        </div>
                        <div class="row">
                            <label style="width:300px !important;" for=""
                                class="col-sm-2 col-form-label col-form-label-lg">Trang Thái Đơn</label>
                            <select name="status_order" style="padding:13px;" class="form-select form-select-lg mb-3"
                                aria-label=".form-select-lg example">
                                <option value="1">Đang Chờ</option>
                                <option value="2">Chờ Lấy Hàng</option>
                                <option value="3">Đang Giao</option>
                                <option value="4">Hoàn Đơn</option>
                                <option value="5">Đã Giao</option>
                                <option value="6">Hủy Đơn</option>
                            </select>
                        </div>
                        <div style="width: 100%;" id="deleteButtonImg" class="button_delete_img row">
                            <div class="col-8"></div>
                            <div class="col-4 d-flex justify-content-between">
                                <input name="btn_update_order" value="Cập Nhật" type="submit"
                                    class="btn btn-primary "></input>

                                <a style="padding:12px 20px;" class="btn box-shadow1" data-bs-toggle="modal"
                                    href="#exampleModalToggle" role="button">HỦY</a>
                            </div>
                        </div>
                    </div>

            </form>
            <!-- Popup thông báo -->
            <div style="background-color:rgba(128, 128, 128, 0.99);" class="modal fade" id="exampleModalToggle"
                aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center ">
                            <h5 class="modal-title d-flex align-items-center" id="staticBackdropLabel"><img
                                    src="./public/assets/media/images/logo.png" alt="">
                                <p style="margin-left:10px; font-size:20px; color:#6750a4;">XÁC NHẬN</p>
                            </h5>
                        </div>
                        <div class="modal-body text-center">
                            <h3 class="text-danger">Bạn có muốn hủy quá trình cập nhật ?</h3>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button style="padding:12px 20px;" type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">Tiếp Tục Cập Nhật</button>
                            <button style="padding:12px 20px;" type="button" class="btn btn-primary"><a
                                    style="color:white" href="?mod=admin&act=orders">Hủy Cập Nhật</a></button>
                        </div>
                    </div>
                </div>
            </div>

            <!--End popup thông báo -->
        </div>

    </div>

    <!----======== End Body DashBoard ======== -->

</section>