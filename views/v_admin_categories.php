<section class="dashboard">
    <!----======== Header DashBoard ======== -->
    <div class="top">
        <i class="fas fa-angle-left sidebar-toggle"></i>
        <div class="search-box">
            <form action="?mod=admin&act=categories&page=<?=$page_nows?>&search_category" method="post">
            <i class="far fa-search"></i>
            <input name="kyw_cg" type="text" placeholder="Tìm kiếm...">
            <button name="search_cg" type="submit"></button>
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
    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Danh Mục</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="#" class="label-large"
                    style="text-decoration: none;">Danh Mục</a>
            </div>
            <!-- <div class="flex-center g8">
            <span><i class="fa-solid fa-calendar-days"></i></span>
            <input class="label-large-prominent" type="datetime-local" style="color: #625B71; border: none; font-size: 16px;
                ">
          </div> -->
        </div>
    </div>
    <!----======== End Header DashBoard ======== -->

    <!----======== Body DashBoard ======== -->
    <div class="containerAdmin">
        <div class="width-full ">
            <div class="content-filter dropdown-center width-full d-flex align-items-center justify-content-between">
                <button id="btn_addMore_admin" type="button"
                    style="width:130px;height:45px;background-color:#6750a4;border-radius:10px"><a
                        style="color: white;font-size: 14px; font-weight: 500; text-decoration: none; padding: 10px 5px;"
                        href="?mod=admin&act=categories-add">Thêm danh mục</a></button>
                <button id="filter" class="flex-center g8" style="padding: 10px 16px;
                  border: 1px solid #79747E; border-radius: 100px;
                  margin-left: auto;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M7.5 13.5H10.5V12H7.5V13.5ZM2.25 4.5V6H15.75V4.5H2.25ZM4.5 9.75H13.5V8.25H4.5V9.75Z"
                            fill="#6750A4" />
                        <span class="label-medium fw-smb" style="color: #6750a4;">Lọc</span>
                    </svg>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="?mod=admin&act=categories&page=1">Mới nhất</a></li>
                    <li><a href="?mod=admin&act=categories&page=1&sort=1">Cũ nhất</a></li>
                    <li><a href="?mod=admin&act=categories&page=1&sort=3">Tên A - Z</a></li>
                    <li><a href="?mod=admin&act=categories&page=1&sort=2">Tên Z - A</a></li>
                </ul>
            </div>

        </div>
        <!-- text -->

        <!-- end text -->
        <table class="content-table width-full">
            <thead>
            <?=@$tb?>
                <tr>
                    <th>ID</th>
                    <th>Tên Danh Mục</th>
                    <th>Hình danh mục</th>
                    <th>Mô tả danh mục</th>
                    <th>Số lượng sản phẩm</th>
                    <th>Ngày đã tạo</th>
                    <th>Xóa</th>
                    <th>Khác</th>
                </tr>
            </thead>
            <tbody>
                <!-- Thêm các hàng dữ liệu vào đây -->
                <?php if (empty($get_Category)): ?>\
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>"
                        <?= $_GET['search_category'] ?>" không tồn tại
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php else: ?>
                    <?php foreach ($get_Category as $item): ?>
                        <tr>
                            <td>
                                <?= $item['id'] ?>
                            </td>
                            <td>
                                <?= $item['name'] ?>
                            </td>
                            <td style="width:100px;"><img style="width: 100%;
                        height: auto; 
                        display: block;
                        object-fit: cover;" src="./public/assets/media/images/category/<?= $item['img'] ?>" alt="">
                            </td>
                            <td style="text-align:left;">
                                <?= $item['description'] ?>
                            </td>
                            <td>
                                <?= count_products_category($item['id'])[0]['SLSP'] ?> sản phẩm
                            </td>
                            <td>
                                <?= $item['create_date'] ?>
                            </td>
                            <td>
                                <a href="?mod=admin&act=categories&page=1&del=<?=$item['id'] ?>" name="btn_xoa_category"><i class="fa-solid fa-trash"></i></a>
                            </td>
                            <td><a href="?mod=admin&act=categories&page=<?= $page_nows ?>&id=<?= $item['id'] ?>" id="myButton"><i
                                        style="font-size:20px;" class="fa-solid fa-gear"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <?php

        if (@$_GET['id']):
            $getidCategories = getidCategories($_GET['id'])
                ?>
        <div style=" 
                  font-size: 16px;
                  display:block;
                  position: fixed; /* Stay in place */
                  z-index: 1; /* Sit on top */
                  padding-top: 100px; /* Location of the box */
                  left: 0;
                  top: 0;
                  width: 100%; /* Full width */
                  height: 100%; /* Full height */
                  overflow: auto; /* Enable scroll if needed */
                  background-color: rgb(0,0,0); /* Fallback color */
                  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */" id="myModal" class="modal">
            <!-- Modal content -->
            <div style=" background-color: #fefefe;
                  margin: auto;
                  padding: 20px;
                  border: 1px solid #888;
                  width: 50%;" class="modal-content">
                <a href="?mod=admin&act=categories&page=<?= $page_nows ?>" style="width:100%;"><span
                        style="float: inline-end;font-size:20px; cursor: pointer;" class="close">&times;</span></a>
                <form action="?mod=admin&act=categories&page=<?= $page_nows ?>&id=<?= $id_category ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input style="font-size: 16px; margin-bottom:20px;" type="text" name="name_cg"
                            value="<?= $getidCategories['name'] ?>" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text"></div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả danh mục</label>
                            <textarea id="tiny" cols="30" rows="10"
                                style="font-size: 16px;height:100px;margin-bottom:20px;" name="description_cg"
                                class="form-control"
                                placeholder="Nhập mô tả sản phẩm"><?= $getidCategories['description'] ?></textarea>
                        </div>
                        <div class="Dropdowns_categogy">
                            <div class="row">
                                <div class="custom-select col-6">
                                    <label>Cho xuất hiện danh mục</label>
                                    <!-- Dropdown -->
                                    <select id="id_category" name="is_appear">
                                        <?php
                                            if ($get_appear == 1) {
                                                echo '
                                          <option value="1">Có</option>
                                          <option value="0">Không</option>
                                          ';
                                            } else {
                                                echo '
                                          <option value="0">Không</option>
                                          <option value="1">Có</option>
                                          ';
                                            }

                                            ?>

                                    </select>
                                </div>
                                <div class="custom-select col-6">
                                    <label>Danh mục đặt biệt</label>
                                    <!-- Dropdown -->
                                    <select id="id_category" name="is_special">
                                        <?php
                                            if ($get_special == 1) {
                                                echo '
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                        ';
                                            } else {
                                                echo '
                                        <option value="0">Không</option>
                                        <option value="1">Có</option>
                                        ';
                                            }

                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cập nhật ảnh</label>
                            <input style="font-size: 16px;" name="file" type="file" id="fileInput">
                        </div>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary float-end">Cập nhật</button>

                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- <div class="flex mb30 " style="<? //php if(isset($_GET['search_category']))'display:none':''?>"> -->
        <div class="flex mb30" style="<?php if (isset($_GET['search_category'])): ?>display:none;<?php endif; ?>">

            <!-- <div class="options-number flex g16" >
              <?php for ($i = 1; $i <= $number_Page; $i++): ?>
              <a style="text-decoration:none; padding: 10px 12px ;border-radius:8px;" href="?mod=admin&act=categories&page=<?= $i ?>" class="<?= ($page_nows == $i) ? 'primary-btn' : '' ?>" style="padding: 10px 15px;"><?= $i ?></a>
              <?php $page = $i; ?>
              <?php endfor; ?>
              <?php
              ?>
                <a style="text-decoration:none;" href="?mod=admin&act=categories&page=<?php
                if ($number_Page == $page_nows) {
                    echo '1';
                } else {
                    echo "$page";
                }
                // ?>" class="flex-center g8"><i class="fa-solid fa-arrow-right"></i> </a>
          </div> -->

            <?php if ($page_nows > $number_Page || $page_nows < 1): ?>
            <h1 class='flex-center flex-full mt-5'>Danh mục này không tồn tại</h1>
            <?php elseif ($count_Categoris > 0 && $number_Page > 1): ?>
            <ul id="paging" class="pagination flex g16 mt30">
                <?php if ($page_nows > 1): ?>
                <li class="pagination__item">
                    <a href="?mod=admin&act=categories&page=<?= $page_nows - 1 ?>"
                        class="btn body-small pagination__link"><i class="fal fa-arrow-left"
                            style="margin-right: .6rem"></i>Previous</a>
                </li>
                <?php endif; ?>

                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="pagination__item <?= ($page_nows == $i) ? 'active' : '' ?>">
                    <a href="?mod=admin&act=categories&page=<?= $i ?>" class="btn body-small pagination__link">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>

                <?php if ($page_nows < $number_Page): ?>
                <li class="pagination__item">
                    <a href="?mod=admin&act=categories&page=<?= $page_nows + 1 ?>"
                        class="btn body-small pagination__link">Next<i class="fal fa-arrow-right"
                            style="margin-left: .6rem"></i></a>
                </li>
                <?php endif; ?>
            </ul>
            <?php endif; ?>

        </div>
    </div>
    </div>

    <!----======== End Body DashBoard ======== -->

</section>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById('myModal');
    var button = document.getElementById('myButton');
    var closeBtn = modal.querySelector(".close");

    button.addEventListener("click", function() {
        modal.style.display = "block";
    });

    closeBtn.addEventListener("click", function() {
        modal.style.display = "none";
    });
});
tinymce.init({
    selector: 'textarea', // change this value according to your HTML
    menubar: 'file edit view'
});
</script>