<?php

use App\model\Admin;
use App\model\Category;
use App\model\Product;
use App\model\Comment;
use App\model\User;
use App\model\Bill;

/* if (isset($_POST['id'])) {
    // Chuyển từ phương thức POST sang GET
    header("location: ?mod=admin&act=products-category-fil&id=" . $_POST['id'] . "");
} else {
    $id = 1;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header("location: ?mod=admin&act=products-category-fil&id=1");
    }
} */

$newCategoryModel = new Category();
$getID = (int) ($_GET['id']);
$newAdminModel = new Admin();

$productdetail = $newAdminModel->product_getById($getID);
$getAllCategory = $newCategoryModel->getCategories();

$idProduct = $_GET['id'];

?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <!----======== End Header DashBoard ======== -->
    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Chi Tiết Sản Phẩm</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="/adminProductDetail?id=<?= $productdetail['id'] ?>" class="label-large" style="text-decoration: none;">Chi Tiết Sản Phẩm</a>
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

            <?php if (isset($productdetail) && !empty($productdetail)) : ?>
                <form action="/productDetailHandler?id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                    <div class="body_sliderDashboard_order-add-create p20 row">
                        <div class="col-7">
                            <div class="left-order-add-create">

                                <h2>Tên Sản Phẩm</h2>
                                <input class="" type="text" name="name" value="<?= $productdetail['name'] ?>" placeholder="<?= $productdetail['name'] ?>" aria-label="default input example">
                            </div>
                            <div class="describe-order_detail">
                                <h2>Mô Tả</h2>
                                <textarea name="description" id="tiny" cols="30" rows="10" placeholder="<?= $productdetail['description'] ?>"><?= $productdetail['description'] ?></textarea>
                            </div>
                            <div class="Dropdowns_categogy">
                                <h2>Danh mục</h2>
                                <div class="custom-select">
                                    <!-- Dropdown -->
                                    <select id="dropdown" onchange="updateInput()" name="id_category">
                                        <<?php foreach ($getAllCategory as $item) : ?> <option value="<?= $item['id'] ?>" <?= ($productdetail['id_category'] == $item['id']) ? 'selected' : '' ?>>
                                            <?= $item['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 30px;">
                                    <h2>Sản phẩm còn lại</h2>
                                    <input class="" name="qty" type="text" value="<?= $productdetail['qty'] ?>" placeholder="1000" aria-label="default input example">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h2>Giá</h2>
                                    <input class="" name="price" value="<?= $productdetail['price'] ?>" type="text" placeholder="<?= number_format($productdetail['price']) ?> VNĐ" aria-label="default input example">
                                </div>
                                <div class="col-6">
                                    <h2>Giá khuyến mãi</h2>
                                    <input class="" type="text" placeholder="1.000.000" aria-label="default input example">
                                </div>
                            </div>
                            <div class="row">
                                <div class="rol-6 mt-3">
                                    <input style="background-color:#6750a4;color: #fff ;padding: 10px 15px; font-size: 14px; font-weight: 500;" class="btn btn-primary" type="submit" name="submit" value="Sửa Sản Phẩm">
                                </div>
                            </div>
                        </div>
                        <div class="col-5 col-md">
                            <div class="right-order-add-create p30 d-flex justify-content-center flex-column ">
                                <div class="img_order-add-create rounded-4">
                                    <img id="previewImage" src="./public/images/product/<?= $productdetail['img'] ?>">
                                </div>
                                <hr>
                                <div style="width: 100%;" id="drop-area">
                                    <label class="title-medium">Kéo thả ảnh ở đây</label>
                                    <br>
                                    <input type="file" id="fileInput" name="file" value="<?= $productdetail['img'] ?>">
                                </div>

                                <div style="width: 100%;" id="demo" class="demo .box-shadow1">

                                </div>
                                <div style="width: 100%;" id="deleteButtonImg" class="button_delete_img row">
                                    <div class="col-4"></div>
                                    <div class="col-8 d-flex flex-end">
                                        <input name="btn_update" value="Cập Nhật" type="submit" class="btn btn-primary "></input>
                                        <input name="btn_cancelled" type="submit" value="Thoát" class="btn_cancelled">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            <?php else : ?>
                <h1 class="flex-center">Sản phẩm này chưa tồn tại</h1>
            <?php endif; ?>
        </div>

    </div>

    <!----======== End Body DashBoard ======== -->

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

    tinymce.init({
        selector: 'textarea', // change this value according to your HTML
        menubar: 'file edit view'
    });
</script>