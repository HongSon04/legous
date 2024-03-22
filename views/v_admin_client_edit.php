<?php

if (@isset($_POST['btn_update'])) {
    $error = array();
    // Validation for each input field
    if (!empty($_POST['fullname'])) {
        $fullname = $_POST['fullname'];
    } else {
        $error['fullname'] = "Không được để trống Họ Và Tên";
    }
    foreach (getUser() as $item) {
        if ($item['username'] == $_POST['username']) {
            $error['username'] = "Tên đăng nhập này đã được sử dụng";
        } elseif ($item['email'] == $_POST['email']) {
            $error['email'] = "Email này đã được sử dụng";
        }
    }
    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $error['username'] = "Không được để trống tên đăng nhập";
    }
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $error['password'] = "Không được để trống mật khẩu";
    }
    if (!empty($_POST['phone'])) {
        $phone = $_POST['phone'];
    } else {
        $error['phone'] = "Không được để trống số điện thoại";
    }
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $error['email'] = "Không được để trống số điện thoại";
    }
    $role = $_POST['role'];
    $id = $_GET['id'];
    $bio = $_POST['bio'];

    // Check if a file was uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        //Thư mục chứa file upload
        $upload_dir = './upload/users/';
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
        // TênFile.ĐuôiFile
        $filename = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);

        #Kiểm tra trùng file trên hệ thống
        if (file_exists($upload_file)) {
            // $error['file_exists'] = "File đã tồn tại trên hệ thống";
            // Xử lý đổi tên file tự động
            #Tạo file mới
            $new_filename = $filename . '- Copy.';
            $new_upload_file = $upload_dir . $new_filename . $type;
            $k = 1;
            while (file_exists($new_upload_file)) {
                $new_filename = $filename . " - Copy({$k}).";
                $k++;
                $new_upload_file = $upload_dir . $new_filename . $type;
            }
            $upload_file = $new_upload_file;
            if (empty($error)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                    $image = $new_filename . $type;
                } else {
                    echo "Upload file thất bại";
                }
            }
        } else {
            if (empty($error)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                    $image = $filename . '.' . $type;
                } else {
                    echo "Upload file thất bại";
                }
            }
        }
    } else {
        // If no file was uploaded, use the existing image
        $image = $userInfo[0]['img'];
    }

    if (empty($error)) {
        // Only delete the old image file if a new image was uploaded
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0 && $image != $userInfo[0]['img']) {
            $delete_file = './upload/users/' . $userInfo[0]['img'];
            unlink($delete_file);
        }

        editUserProfile($id, $fullname, $username, $password, $email, $image, $role, $bio, $phone);
        header("Location: ?mod=admin&act=client");
    } else {
        $error['upload'] = "Upload ảnh thất bại";
    }

}
if (@isset($_POST['btn_delete'])) {
    $id = $_GET['id'];
    //Thư mục chứa file Delete
    $getAllBilById = get_allBill($id);
    foreach ($getAllBilById as $item) {
        if ($item['status'] == 1 || $item['status'] == 2 || $item['status'] == 3) {
            $error['status'] = "Không thể xóa User này vì hiện đang có đơn hàng đang chuẩn bị hoặc đang giao";
        }
    }

    if (isset($error['status']) && !empty($error['status'])) {
        $error['status'] = "Không thể xóa User này vì hiện đang có đơn hàng đang chuẩn bị hoặc đang giao";
    } else {
        // Xóa hình ảnh của user
        foreach (getCommentByIdUser($id) as $comment) {
            foreach (getAllCmtImg($comment['id']) as $item) {
                $delete_dir = './upload/users/';
                $delete_file = $delete_dir . $item['src'];
                unlink($delete_file);
            }
        }
        foreach (getCommentByIdUser($id) as $comment) {
            foreach (getAllCmtImg($comment['id']) as $item) {

                delImgByIdCmt($comment['id']);
            }
            delCmt($comment['id']);
        }
        foreach (getAllAddressByUser($id) as $item) {
            delete_address_byIduser($item['id_user']);
        }
        foreach (getAllCartByIdUser($id) as $item) {
            delete_bill_fromCart($item['id_user']);
        }
        foreach (getAllBillByIdUser($id) as $item) {
            delete_bill($item['id_user']);
        }
        // Xóa user
        deleteUser($id);
        // Chuyển hướng người dùng
        header("Location: ?mod=admin&act=client");
    }


}
if (@isset($_POST['btn_cancelled'])) {
    header("Location: ?mod=admin&act=client");
}

?>
<section class="dashboard" style="position: relative;">
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
                                <h2>Chi Tiết Khách Hàng</h2>
                            </div>
                            <div class="col-12">
                                <span class="label-large client-edit">Admin /</span><a href="?mod=admin&act=client"
                                    class="label-large" style="text-decoration: none;"> Khách Hàng</a>
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
                                <div class="left-order-add-create">
                                    <h2>Họ Và Tên</h2>
                                    <input name="fullname" class="" type="text"
                                        value="<?php echo $userInfo[0]['fullname'] ?>" placeholder="Nhập Họ Và Tên"
                                        aria-label="default input example">
                                    <?php
                                    if (isset($error['fullname']) && !empty($error['fullname']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['fullname']}</p>";
                                    ?>
                                </div>
                                <div class="left-order-add-create">
                                    <h2>Tên Đăng Nhập</h2>
                                    <input name="username" class="" type="text"
                                        value="<?php echo $userInfo[0]['username'] ?>" placeholder="Nhập Tên Đăng Nhập"
                                        aria-label="default input example">
                                    <?php
                                    if (isset($error['username']) && !empty($error['username']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['username']}</p>";
                                    ?>
                                </div>

                                <div class="left-order-add-create">
                                    <h2>Mật Khẩu</h2>
                                    <input name="password" class="" type="text"
                                        value="<?php echo $userInfo[0]['password'] ?>" placeholder="Nhập Mật Khẩu"
                                        aria-label="default input example">
                                    <?php
                                    if (isset($error['password']) && !empty($error['password']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['password']}</p>";
                                    ?>
                                </div>
                                <div class="left-order-add-create">
                                    <h2>Email</h2>
                                    <input name="email" class="" type="text" value="<?php echo $userInfo[0]['email'] ?>"
                                        placeholder="Email" aria-label="default input example">
                                    <?php
                                    if (isset($error['email']) && !empty($error['email']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['email']}</p>";
                                    ?>
                                </div>
                                <div class="left-order-add-create">
                                    <h2>Số điện thoại</h2>
                                    <input name="phone" class="" type="text" value="<?php echo $userInfo[0]['phone'] ?>"
                                        placeholder="Nhập Số Điện Thoại" aria-label="default input example">
                                    <?php
                                    if (isset($error['phone']) && !empty($error['phone']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['phone']}</p>";
                                    ?>
                                </div>
                                <div class="Dropdowns_categogy">
                                    <h2>Vai Trò</h2>
                                    <div class="custom-select">
                                        <!-- Dropdown -->
                                        <select name="role" id="dropdown" onchange="updateInput()">
                                            <option
                                                selected="<?php echo ($userInfo[0]['role'] == 0) ? 'checked' : ''; ?>"
                                                value="0">User thường</option>
                                            <option
                                                selected="<?php echo ($userInfo[0]['role'] == 2023) ? 'checked' : ''; ?>"
                                                value="2023">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5 col-md">
                                <div class="right-order-add-create p30 d-flex justify-content-center flex-column ">
                                    <div class="img_order-add-create rounded-4">
                                        <?php
                                        $upload_dir = './upload/users/';
                                        //Đường dẫn của file sau khi upload
                                        $upload_file = $upload_dir . $userInfo[0]['img'];
                                        if (empty($userInfo[0]['img']) || $userInfo[0]['img'] == NULL || !file_exists($upload_file)) {
                                            ?>
                                            <td><img src="./upload/users/anonyUser.png"></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td><img src="./upload/users/<?php echo $userInfo[0]['img'] ?>">
                                            </td>
                                            <?php
                                        }

                                        ?>
                                    </div>
                                    <hr>
                                    <div style="width: 100%;" id="drop-area">
                                        <h3>Kéo thả ảnh ở đây</h3>
                                        <input name="file" type="file" id="fileInput">
                                    </div>

                                    <div style="width: 100%;" id="demo" class="demo .box-shadow1">

                                    </div>
                                    <div style="width: 100%;" id="deleteButtonImg" class="button_delete_img row">
                                        <div class="col-4"></div>
                                        <div class="col-8 d-flex j-end">
                                            <input name="btn_update" value="Cập Nhật" type="submit"
                                                class="btn btn-primary">
                                            <input value="Xóa" type="button" id="deleteButtonAll"
                                                class="btn btn-danger">
                                            <input name="btn_cancelled" type="submit" value="Thoát"
                                                class="btn_cancelled">
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($error['status']) && !empty($error['status']))
                                        echo "<p class='text-danger text-error title-medium'>{$error['status']}</p>";
                                    ?>

                                    <div class="poupDashboard col-12 text-start mt-5">
                                        <div class="poupDashboard_item">
                                            <p class="title-small">Bạn có chắc muốn xóa tài khoản này không ?</p>
                                            <p class="title-small">Sẽ xóa tất cả bao gồm:</p>
                                            <ul>
                                                <li class="label-large">Xóa Địa Chỉ</li>
                                                <li class="label-large">Xóa Đơn Hàng</li>
                                                <li class="label-large">Xóa Thông Tin</li>
                                                <li class="label-large">Xóa Bình Luận</li>
                                            </ul>
                                            <a href=""><input class="popupDashboard_del btn btn-danger" type="submit"
                                                    value="Xóa" name="btn_delete"></a>
                                            <button class="popupDashboard_canc label-large">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
</section>

<script>
    document.getElementById('deleteButtonImg').addEventListener('click', function () {
        this.style.display = 'none';
        document.querySelector('.poupDashboard').style.display = 'block';
    });

    document.querySelector('.popupDashboard_canc').addEventListener('click', function () {
        document.querySelector('.poupDashboard').style.display = 'none';
        document.getElementById('deleteButtonImg').style.display = 'block';
    });
</script>