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

    <div class="containerAdmin_order-detail p30">
        <div class="localDashboard">
            <div class="col-12 d-flex">
                <div class="col-6">
                    <div class="col-12">
                        <h2>Thêm Danh Mục</h2>
                    </div>
                    <div class="col-12">
                        <span class="label-large">Admin /</span><a href="?mod=admin&act=products&page=1"
                            class="label-large" style="text-decoration: none;"> Danh Mục</a> / <a href="#!"
                            class="label-large" style="text-decoration: none;"> Thêm Danh Mục</a>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="sliderDashboard_order-add-create sliderDashboard_order-detail rounded-4">
                <?= @$error ?>
                <div class="body_sliderDashboard_order-add-create p20 row">
                    <div class="col-7">
                        <div style="margin:0;" class="left-order-add-create">
                            <label style="font-size:20px;" class="form-label">Tên Danh Mục</label>
                            <input style="margin-bottom:5px;" name="add_name_cg" class="" type="text" value=""
                                placeholder="Nhập Họ Và Tên" aria-label="default input example">
                        </div>
                        <div style="margin:0;" class="left-order-add-create">
                            <label style="font-size:20px;" class="form-label">Thêm Mô Tả</label>
                            <textarea style="margin:0;" name="add_description_cg" id="textarea_update_cg" cols="30"
                                rows="10" placeholder="Nhập mô tả của danh mục đó vào đây đi..."></textarea>
                        </div>
                        <div style="margin:0;" class="left-order-add-create flex-column">
                            <label style="font-size:20px;" class="form-label">Màu Nền</label>
                            <input style="height:100px; width:200px;" type="color" name="add_color_cg" id="">
                        </div>



                    </div>
                    <div class="col-5 col-md">
                        <div class="right-order-add-create p30 d-flex justify-content-center flex-column ">
                            <div class="img_order-add-create rounded-4">
                                <img id="previewImage" src="">

                            </div>
                            <hr>
                            <div style="width: 100%;" id="drop-area">
                                <!-- <h3>Kéo thả ảnh ở đây</h3> -->
                                <input name="file" type="file" id="fileInput">
                            </div>

                            <div style="width: 100%;" id="demo" class="demo .box-shadow1">

                            </div>
                            <div style="width: 100%;" id="deleteButtonImg" class="button_delete_img row">
                                <div class="col-8"></div>
                                <div class="col-4 d-flex justify-content-between">
                                    <input name="btn_update_cg" value="Cập Nhật" type="submit"
                                        class="btn btn-primary "></input>
                                    <!-- <button type="button" id="deleteButtonAll" class="btn btn-danger">Xóa</button> -->
                                    <!-- <button class="btn box-shadow1" data-bs-toggle="modal" href="#exampleModalToggle" role="button">HỦY</button> -->
                                    <a style="padding:12px 20px;" class="btn box-shadow1" data-bs-toggle="modal"
                                        href="#exampleModalToggle" role="button">HỦY</a>
                                </div>
                            </div>
                            <!-- Popup thông báo -->
                            <div style="background-color:rgba(128, 128, 128, 0.99);" class="modal fade"
                                id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
                                tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header justify-content-center ">
                                            <h5 class="modal-title d-flex align-items-center" id="staticBackdropLabel">
                                                <img src="./public/assets/media/images/logo.png" alt="">
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
                                                    style="color:white" href="?mod=admin&act=categories&page=1">Hủy Cập
                                                    Nhật</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--End popup thông báo -->
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
<script>
document.getElementById('fileInput').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
});
</script>