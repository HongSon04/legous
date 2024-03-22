<?php

if (@isset($_POST['btn_update'])) {
    $error = array();

    if (!empty($_POST['address'])) {
        $address = $_POST['address'];
    } else {
        $address = "";
    }
    if (!empty($_POST['detailedAddress'])) {
        $detailedAddress = $_POST['detailedAddress'];
    } else {
        $error['detailedAddress'] = "Không được để trống địa chỉ chi tiết";
    }
    if (!empty($_POST['phone'])) {
        $phone = $_POST['phone'];
    } else {
        $error['phone'] = "Không được để trống số điện thoại";
    }
    $role = $_POST['role'];
    $id = $_GET['id'];
    if (empty($error)) {
        updateAddresById($id, $phone, $role, $address, $detailedAddress);
    }

    header("Location: ?mod=admin&act=address");

}
if (@isset($_POST['btn_delete'])) {
    $id = $_GET['id'];
    delete_address($id);
    header("Location: ?mod=admin&act=address");
}
if (@isset($_POST['btn_cancelled'])) {
    header("Location: ?mod=admin&act=address");
}

?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->
    <div class="top">
        <i class="fas fa-angle-left sidebar-toggle"></i>
        <form style="width: 100%;display:flex; justify-content: center;" action="" method="post">
            <div class="search-box">
                <i class="far fa-search"></i>
                <input type="text" placeholder="Tìm kiếm..." disabled="disabled">
            </div>
        </form>
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
                                <h2>Chi Tiết Địa Chỉ</h2>
                            </div>
                            <div class="col-12">
                                <span class="label-large client-edit">Admin /</span><a href="?mod=admin&act=address"
                                    class="label-large" style="text-decoration: none;"> Địa Chỉ</a>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
                <form enctype="multipart/form-data" action="" method="POST">
                    <div class="sliderDashboard_order-add-create sliderDashboard_order-detail rounded-4">
                        <div class="body_sliderDashboard_order-add-create p20 row col-12">
                            <div class="col-7">
                                <?php
                                $getAddress = get_addressByid($_GET['id']);
                                ?>
                                <div class="left-order-add-create">
                                    <h2>Địa Chỉ</h2>
                                    <input name="address" class="" type="text"
                                        value="<?php echo $getAddress[0]['address'] ?>" placeholder="Nhập Địa Chỉ"
                                        aria-label="default input example">
                                    <?php
                                    if (isset($error['address']) && !empty($error['address']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['address']}</p>";
                                    ?>
                                </div>
                                <div class="left-order-add-create">
                                    <h2>Địa Chỉ Chi Tiết</h2>
                                    <input name="detailedAddress" class="" type="text"
                                        value="<?php echo $getAddress[0]['address_detail'] ?>"
                                        placeholder="Nhập Địa Chỉ Chi Tiết" aria-label="default input example">
                                    <?php
                                    if (isset($error['detailedAddress']) && !empty($error['detailedAddress']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['detailedAddress']}</p>";
                                    ?>
                                </div>

                                <div class="left-order-add-create">
                                    <h2>Phone</h2>
                                    <input name="phone" class="" type="number"
                                        value="<?php echo $getAddress[0]['phone'] ?>" placeholder="Nhập Số Điện Thoại"
                                        aria-label="default input example">
                                    <?php
                                    if (isset($error['phone']) && !empty($error['phone']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['phone']}</p>";
                                    ?>
                                </div>
                            </div>
                            <div class="Dropdowns_categogy">
                                <h2>Chọn</h2>
                                <div class="custom-select">
                                    <!-- Dropdown -->
                                    <select name="role" id="dropdown" onchange="updateInput()">
                                        <option
                                            selected="<?php echo ($getAddress[0]['is_default'] == 0) ? 'checked' : ''; ?>"
                                            value="0">Địa Chỉ Thường</option>
                                        <option
                                            selected="<?php echo ($getAddress[0]['is_default'] == 1) ? 'checked' : ''; ?>"
                                            value="1">Địa Chỉ Mặc Định</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 col-md">
                            <div class="right-order-add-create p30 d-flex justify-content-center flex-column ">
                                <div style="width: 100%;" id="deleteButtonImg" class="button_delete_img row">
                                    <div class="col-4"></div>
                                    <div class="col-8 d-flex j-end">
                                        <input name="btn_update" value="Cập Nhật" type="submit" class="btn btn-primary">
                                        <input name="btn_delete" value="Xóa" type="submit" id="deleteButtonAll"
                                            class="btn btn-danger">
                                        <input name="btn_cancelled" type="submit" value="Thoát" class="btn_cancelled">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
</section>