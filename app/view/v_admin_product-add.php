<?php

use App\model\Category;
use App\model\Product;
use App\model\Comment;
use App\model\User;
use App\model\Bill;

$newCategoryModel = new Category();
$getAllCategory = $newCategoryModel->getCategories();



?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <!----======== End Header DashBoard ======== -->
    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Thêm Sản Phẩm</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="/adminProductAdd" class="label-large" style="text-decoration: none;">Thêm Sản Phẩm</a>
            </div>
            <!-- <div class="flex-center g8">
            <span><i class="fa-solid fa-calendar-days"></i></span>
            <input class="label-large-prominent" type="datetime-local" style="color: #625B71; border: none; font-size: 16px;
                ">
          </div> -->
        </div>
    </div>
    <!----======== Body DashBoard ======== -->
    <div class="containerAdmin_order-detail p30">
        <div class="sliderDashboard_order-add-create sliderDashboard_order-detail rounded-4">

            <?php if (isset($_SESSION['thongbao'])) : ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['thongbao'] ?>
                </div>
            <?php endif;
            unset($_SESSION['thongbao']) ?>
            <?php if (isset($_SESSION['loi'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['loi'] ?>
                </div>
            <?php endif;
            unset($_SESSION['loi']) ?>

            <form action="/productAddInfo" method="post" enctype="multipart/form-data">
                <div class="body_sliderDashboard_order-add-create p20 row">
                    <div class="col-7">
                        <div class="left-order-add-create">
                            <label class="title-medium">Tên Sản Phẩm</label>
                            <input type="text" name="name" placeholder="Nhập tên sản phẩm" aria-label="default input example">
                        </div>
                        <div class="describe-order_detail">
                            <label class="title-medium">Mô Tả</label>
                            <textarea name="description" id="tiny" cols="30" rows="10" placeholder="Nhập mô tả sản phẩm"></textarea>

                        </div>
                        <div class="Dropdowns_categogy">
                            <label class="title-medium">Danh mục</label>
                            <div class="custom-select">
                                <!-- Dropdown -->
                                <select id="id_category" name="id_category">
                                    <?php foreach ($getAllCategory as $item) : ?>
                                        <option value="<?= $item['id'] ?>">
                                            <?= $item['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="margin-bottom: 30px;">
                                <label class="title-medium">Sản phẩm còn lại</label>
                                <input type="text" name="qty" placeholder="1000" aria-label="default input example">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="title-medium">Giá</label>
                                <input type="text" id="price" name="price" placeholder="Nhập giá tiền" aria-label="default input example">
                            </div>
                            <div class="col-6">
                                <label class="title-medium">Giá khuyến mãi</label>
                                <input type="text" placeholder="Nhập giá khuyến mãi" aria-label="default input example">
                            </div>
                        </div>
                        <div class="row">
                            <div class="rol-6 mt-3">
                                <input style="background-color:#6750a4;color: #fff ;padding: 10px 15px; font-size: 14px; font-weight: 500;" class="btn btn-primary" type="submit" name="submit" value="Tạo Sản Phẩm">

                            </div>

                        </div>
                    </div>
                    <div class="col-5 col-md">
                        <div class="right-order-add-create p30 d-flex justify-content-center flex-column ">
                            <div class="img_order-add-create rounded-4">
                                <img id="previewImage" src="">
                            </div>
                            <hr>
                            <div style="width: 100%;" id="drop-area">
                                <label class="title-medium">Kéo thả ảnh ở đây</label>
                                <br>
                                <input type="file" id="fileInput" name="file">
                            </div>
                        </div>
                    </div>

                </div>
        </div>
        </form>

    </div>

    </div>

    <!----======== End Body DashBoard ======== -->

</section>
<script>
    document.getElementById('fileInput').addEventListener('change', function() {
        var file = this.files;
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
    tinymce.init({
        selector: 'textarea', // change this value according to your HTML
        menubar: 'file edit view'
    });
</script>