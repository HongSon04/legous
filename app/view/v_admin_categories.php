<?php

use App\model\Admin;
use App\model\Comment;
use App\model\User;
use App\model\Bill;

if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
    $newAdminModel = new Admin();
    $count_Categoris = $newAdminModel->count_Categoris()['soluong'];
    if (isset($_POST['kyw_cg'])) {
        $get_kyw = $_POST['kyw_cg'];
        header('Location:  /adminCategory?page=1&search_category=' . urlencode($get_kyw));
        exit;
    } else if (isset($_GET['search_category'])) {
        $kyw_cg = $_GET['search_category'];
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
            $get_Category = $newAdminModel->get_Categories(($_GET['page'] - 1) * 4, 4, $kyw_cg, $sort);
        } else {
            if (empty($kyw_cg)) {
                $get_Category = [];
            } else {
                $get_Category = $newAdminModel->get_Categories(($_GET['page'] - 1) * 4, 4, $kyw_cg);
            }
        }
    } else {
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
            $get_Category = $newAdminModel->get_Categories(($_GET['page'] - 1) * 4, 4, "", $sort);
        } else {
            $get_Category = $newAdminModel->get_Categories(($_GET['page'] - 1) * 4, 4);
        }
    }
    $perPage = 4;
    $number_Page = ceil($count_Categoris / 4);
    $page_nows = $_GET['page'];

    $soTrang = ceil($count_Categoris / $perPage);
    $startPage = max(1, $page_nows - 2);
    $endPage = min($startPage + 5, $soTrang);

    if ($endPage - $startPage < 5) {
        $startPage = max(1, $endPage - 5);
    }
    if (isset($_GET['del'])) {
        $newAdminModel = new Admin();
        if ($newAdminModel->count_products_category($_GET['del'])['SLSP'] > 0) {
            $tb = '<div style="position:relative;top:25px;" class="alert alert-danger" role="alert">Bạn không thể xóa danh mục đã có sản phẩm</div>';
        } else {
            $newAdminModel = new Admin();
            $newAdminModel->delete_category($_GET['del']);
            header('Location: /adminCategory?page=1');
        }
    }
}
// Cập nhật dữ liệu
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_category = $_GET['id'];
    $newAdminModel = new Admin();
    $getidCategories = $newAdminModel->getidCategories($id_category);
    $get_appear = $getidCategories['is_appear'];
    $is_special = $getidCategories['is_special'];
    if (!$getidCategories) {
        // Xử lý trường hợp không tìm thấy danh mục
    }
    if (isset($_POST['submit'])) {

        $name_cg = $_POST['name_cg'] ?? '';
        $description_cg = $_POST['description_cg'] ?? '';
        $is_appear = $_POST['is_appear'];
        $is_special = $_POST['is_special'];
        $error = []; // Khởi tạo mảng lỗi
        $img_cg = $getidCategories['img']; // Giữ lại đường dẫn ảnh cũ nếu không có file mới
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            //Thư mục chứa file upload
            $upload_dir = './public/images/category/';
            $upload_new = $_FILES['file']['name'];
            //Đường dẫn của file sau khi upload
            $upload_file = $upload_dir . $_FILES['file']['name'];
            //Xử lý upload đúng file ảnh
            $type_allow = array('png', 'jpg', 'jpeg', 'gif');
            //PATHINFO_EXTENSION lấy đuôi file
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            // echo $type;
            if (!in_array(strtolower($type), $type_allow)) {
                $error['type'] = "Chỉ được upload file có đuôi PNG, JPG, GIF, JPEG";
            }

            #Upload file có kích thước cho phép (<20mb ~ 29.000.000BYTE)
            $file_size = $_FILES['file']['size'];
            if ($file_size > 29000000) {
                $error['file_size'] = "Chỉ được upload file bé hơn 20MB";
            }
            #Kiểm tra trùng file trên hệ thống
            if (file_exists($upload_file)) {
                // $error['file_exists'] = "File đã tồn tại trên hệ thống";
                // Xử lý đổi tên file tự động

                #Tạo file mới
                // TênFile.ĐuôiFile
                $filename = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);
                $new_filename = $filename . '- Copy.';
                $new_upload_file = $upload_dir . $new_filename . $type;
                $k = 1;
                while (file_exists($new_upload_file)) {
                    $new_filename = $filename . " - Copy({$k}).";
                    $k++;
                    $new_upload_file = $upload_dir . $new_filename . $type;
                }
                $upload_file = $new_upload_file;
            }

            if (empty($error)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                    $upload_dir = './public/images/category/';
                    $del_new = $_FILES['file']['name'];
                    //Đường dẫn của file sau khi del
                    $del_file = $upload_dir . $img_cg;
                    unlink($del_file);
                    $img_cg = $upload_new; // Sử dụng $upload_file thay vì $new_filename.$type
                } else {
                    echo "Upload file thất bại";
                }
            }
        }
        if (empty($error)) {
            var_dump($img_cg);
            $newAdminModel = new Admin();
            $newAdminModel->update_Category($id_category, $name_cg, $description_cg, $img_cg, $is_appear, $is_special);
        } else {
            $error = "Loi64";
        }
        // update_Category($id_category, $name_cg, $description_cg);
        // Xử lý sau khi cập nhật thành công.
        header('Location: /adminCategory?page=' . $page_nows);
    }
}
//$getidCategories = getidCategories($_GET['id']);
// hiển thị dữ liệu  
?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Danh Mục</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="#" class="label-large" style="text-decoration: none;">Danh Mục</a>
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
                <button id="btn_addMore_admin" type="button" style="width:130px;height:45px;background-color:#6750a4;border-radius:10px"><a style="color: white;font-size: 14px; font-weight: 500; text-decoration: none; padding: 10px 5px;" href="?mod=admin&act=categories-add">Thêm danh mục</a></button>

            </div>

        </div>
        <!-- text -->

        <!-- end text -->
        <table class="content-table width-full">
            <thead>
                <?= @$tb ?>
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
                <?php if (empty($get_Category)) : ?>\
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Danh Mục không tồn tại
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php else : ?>
                <?php foreach ($get_Category as $item) : ?>
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
                        object-fit: cover;" src="./public/images/category/<?= $item['img'] ?>" alt="">
                        </td>
                        <td style="text-align:left;">
                            <?= $item['description'] ?>
                        </td>
                        <td>
                            100
                        </td>
                        <td>
                            <?= $item['create_date'] ?>
                        </td>
                        <td>
                            <a href=" /adminCategory?page=1&del=<?= $item['id'] ?>" name="btn_xoa_category"><i class="fa-solid fa-trash"></i></a>
                        </td>
                        <td><a href=" /adminCategory?page=<?= $page_nows ?>&id=<?= $item['id'] ?>" id="myButton"><i style="font-size:20px;" class="fa-solid fa-gear"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

        <?php

        if (@$_GET['id']) :
            $newAdminModel = new Admin();
            $getidCategories = $newAdminModel->getidCategories($_GET['id'])
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
                    <a href="/adminCategory?page=<?= $page_nows ?>" style="width:100%;"><span style="float: inline-end;font-size:20px; cursor: pointer;" class="close">&times;</span></a>
                    <form action="/adminCategory?page=<?= $page_nows ?>&id=<?= $id_category ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Tên danh mục</label>
                            <input style="font-size: 16px; margin-bottom:20px;" type="text" name="name_cg" value="<?= $getidCategories['name'] ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text"></div>
                            <div class="mb-3">
                                <label class="form-label">Mô tả danh mục</label>
                                <textarea id="tiny" cols="30" rows="10" style="font-size: 16px;height:100px;margin-bottom:20px;" name="description_cg" class="form-control" placeholder="Nhập mô tả sản phẩm"><?= $getidCategories['description'] ?></textarea>
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

        <!-- <div class="flex mb30 " style="<? //php if(isset($_GET['search_category']))'display:none':''
                                            ?>"> -->
        <div class="flex mb30" style="<?php if (isset($_GET['search_category'])) : ?>display:none;<?php endif; ?>">

            <!-- <div class="options-number flex g16" >
              <?php for ($i = 1; $i <= $number_Page; $i++) : ?>
              <a style="text-decoration:none; padding: 10px 12px ;border-radius:8px;" href=" /adminCategory?page=<?= $i ?>" class="<?= ($page_nows == $i) ? 'primary-btn' : '' ?>" style="padding: 10px 15px;"><?= $i ?></a>
              <?php $page = $i; ?>
              <?php endfor; ?>
              <?php
                ?>
                <a style="text-decoration:none;" href=" /adminCategory?page=<?php
                                                                            if ($number_Page == $page_nows) {
                                                                                echo '1';
                                                                            } else {
                                                                                echo "$page";
                                                                            }
                                                                            // 
                                                                            ?>" class="flex-center g8"><i class="fa-solid fa-arrow-right"></i> </a>
          </div> -->

            <?php if ($page_nows > $number_Page || $page_nows < 1) : ?>
                <h1 class='flex-center flex-full mt-5'>Danh mục này không tồn tại</h1>
            <?php elseif ($count_Categoris > 0 && $number_Page > 1) : ?>
                <ul id="paging" class="pagination flex g16 mt30">
                    <?php if ($page_nows > 1) : ?>
                        <li class="pagination__item">
                            <a href=" /adminCategory?page=<?= $page_nows - 1 ?>" class="btn body-small pagination__link"><i class="fal fa-arrow-left" style="margin-right: .6rem"></i>Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                        <li class="pagination__item <?= ($page_nows == $i) ? 'active' : '' ?>">
                            <a href=" /adminCategory?page=<?= $i ?>" class="btn body-small pagination__link">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page_nows < $number_Page) : ?>
                        <li class="pagination__item">
                            <a href=" /adminCategory?page=<?= $page_nows + 1 ?>" class="btn body-small pagination__link">Next<i class="fal fa-arrow-right" style="margin-left: .6rem"></i></a>
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