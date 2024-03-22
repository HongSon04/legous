<?php

use App\model\Bill;
use App\model\User;
use App\model\Comment;
use App\model\Category;

$newCategoryModel = new Category();
$getAllCategory = $newCategoryModel->getCategories();
?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <div class="detail flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Sản Phẩm</h1>
        </div>

        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="/adminProduct?&page=1" class="label-large" style="text-decoration: none;">Sản Phẩm</a>
            </div>
        </div>
    </div>
    <!----======== End Header DashBoard ======== -->

    <!----======== Body DashBoard ======== -->
    <div class="containerAdmin">
        <div class="width-full mb-3">
            <div class="content-filter dropdown-center width-full d-flex align-items-center justify-content-between">
                <button id="btn_addMore_admin" type="button" style="width:130px;height:45px;background-color:#6750a4;border-radius:10px"><a style="color: white; font-size: 14px; font-weight: 500; text-decoration: none; padding: 10px 5px;" href="/adminProductAdd">Thêm Sản Phẩm</a></button>

            </div>
            <?php if (isset($_SESSION['thongbao'])) : ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['thongbao'] ?>
                </div>
            <?php endif;
            unset($_SESSION['thongbao']) ?>

        </div>
        <table id="example1" class="content-table width-full">
            <thead>
                <tr>
                    <th style="text-align: start;">
                        <input type="checkbox" class="checkboxAll" style="width: 18px; height: 18px;">
                        </input>
                    </th>
                    <th>Hình Ảnh</th>
                    <th>Tên Mô Hình</th>
                    <th>Danh Mục</th>
                    <th>Giá</th>
                    <th>Đã Bán</th>
                    <th>Sản Phẩm Còn Lại</th>
                    <th>Khác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($getproductAdmin as $item) {
                    $newCategoryModel = new Category();
                    $getCategoryById = $newCategoryModel->getCategoryById($item['id_category']);

                ?>
                    <tr>
                        <td style="text-align: start;">
                            <input type="checkbox" class="checkboxChild" style="width: 18px; height: 18px;">
                            </input>
                        </td>
                        <td><img style="width: 100px; height: 100px;" src="./public/images/product/<?= $item['img'] ?>" alt=""></td>
                        <td><?= $item['name'] ?></td>
                        <td>Danh Mục: <?= $getCategoryById['name'] ?></td>
                        <td><?= number_format($item['price']) ?> VNĐ</td>
                        <td><?= $item['purchases'] ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td><a href="/adminProductDetail?id=<?= $item['id'] ?>">Xem chi tiết</a>
                            <div><i class="fa-solid fa-minus"></i></div>
                            <a href="/adminProductDelete?id=<?= $item['id'] ?>">Xóa</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>


    </div>



    <!----======== End Body DashBoard ======== -->

</section>
<script src="/public/assets/resources/js/pagination.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".checkboxAll").click(function() {
            if ($(this).is(":checked")) {
                $(".checkboxChild").prop("checked", true);
            } else {
                $(".checkboxChild").prop("checked", false);
            }
        });
    });
</script>