<?php

namespace App\controller;

use App\model\admin;
use App\model\category;
use App\model\product;
use App\model\user;
use App\model\Bill;
use App\model\Address;
use App\model\Cart;
use App\model\Comment;
use App\model\Coupon;

class AdminController extends Controller {
    public function test() {
        echo "aloalo";
    }
    public function admin() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = "admin_home";
        include './app/view/v_admin_layout.php';
        exit();
    }

    public function products() {

        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }

        $newAdminModel = new Admin();
        $newCategoryModel = new Category();
        $newProductModel = new Product();
        $getproductAdmin = $newProductModel->getProduct();
        $totalProducts = $newAdminModel->product_CountTotal();
        $getAllCategory = $newCategoryModel->getCategories();

        $view_name = "admin_products";
        include './app/view/v_admin_layout.php';
    }

    public function productAdd() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_product-add';
        include './app/view/v_admin_layout.php';
    }

    public function productAddInfo() {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $id_category = $_POST['id_category'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $img = $_FILES["file"]["name"];
            $qty = $_POST['qty'];

            if (empty($name) || empty($id_category) || empty($price) || empty($img) || empty($qty)) {
                $_SESSION['loi'] = '<strong>Bạn cần điền đủ thông tin để tạo sản phẩm</strong>';
            } else {
                $newProductModel = new Product();
                $kq = $newProductModel->product_checkName($name);
                if ($kq) {
                    $_SESSION['loi'] = 'Không thể tạo trùng tên của sản phẩm <strong>' . $name . '</strong>';
                } else {
                    $newProductModel = new Product();
                    $newProductModel->product_add($name, $id_category, $description, $price, $img, $qty);
                    $_SESSION['thongbao'] = 'Đã tạo thành công <strong>' . $name . '</strong>';
                }
            }

            if (isset($_FILES['file'])) {
                $upload_dir = './public/images/product/';
                $upload_file = $upload_dir . $_FILES['file']['name'];
                $type_allow = array('png', 'jpg', 'jpeg', 'gif');
                $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

                if (!in_array(strtolower($type), $type_allow)) {
                    $error['type'] = "Chỉ được upload file có đuôi PNG, JPG, GIF, JPEG";
                } else if ($_FILES['file']['size'] > 29000000) {
                    $error['file_size'] = "Chỉ được upload file bé hơn 20MB";
                } else {
                    if (file_exists($upload_file)) {
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
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                            $image = $new_filename . $type;
                        }
                    } else {
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                            $filename = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);
                            $image = $filename . $type;
                        }
                    }
                }
            }
            header("Location: /adminProduct");
            exit;
        }
    }

    public function productDetail() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_product-detail';
        include './app/view/v_admin_layout.php';
    }
    public function productDetailHandler() {
        if (isset($_POST['btn_update'])) {
            $name = $_POST['name'];
            $id_category = $_POST['id_category'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $img = $_FILES["file"]["name"];
            $qty = $_POST['qty'];
            $idProduct = $_GET['id'];
            print_r($img);
            $newCategoryModel = new Category();
            $newAdminModel = new Admin();

            $productdetail = $newAdminModel->product_getById($idProduct);
            $getAllCategory = $newCategoryModel->getCategories();
            // Kiểm tra xem người dùng đã chọn file ảnh mới hay chưa
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $img = $_FILES["file"]["name"];

                // Thực hiện việc upload file ảnh
                $upload_dir = './public/images/product/';
                $upload_file = $upload_dir . $_FILES['file']['name'];

                // Xử lý upload đúng file ảnh
                $type_allow = array('png', 'jpg', 'jpeg', 'gif');
                $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

                if (!in_array(strtolower($type), $type_allow)) {
                    $error['type'] = "Chỉ được upload file có đuôi PNG, JPG, GIF, JPEG";
                } else if ($_FILES['file']['size'] > 29000000) {
                    $error['file_size'] = "Chỉ được upload file bé hơn 20MB";
                } else {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                        $img = $_FILES['file']['name'];
                    }
                }
            } else {

                // Nếu người dùng không chọn file ảnh mới, giữ nguyên ảnh cũ
                $img = $productdetail['img'];
            }

            // Tiến hành cập nhật sản phẩm
            $newProductModel = new Product();
            $newProductModel->product_edit($idProduct, $name, $id_category, $description, $price, $img, $qty);
            $_SESSION['thongbao'] = 'Đã Chỉnh sửa thành công <strong>' . $name . '</strong>';

            // Tải lại trang cập nhật sản phẩm
            header("Location: /adminProductDetail?id=$idProduct");
            exit;
        }

        if (isset($_POST['btn_cancelled']) && !empty($_POST['btn_cancelled'])) {
            header("Location: /adminProduct");
            exit;
        }
    }

    public function productDelete() {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $product_id = $_GET['id'];
            $newAdminModel = new Admin();
            foreach ($newAdminModel->getAllImages($product_id) as $item) {
                unlink("./public/images/product/" . $item['img']);
                $newAdminModel->deleteImage($item['id']);
            }
            $newAdminModel->remove_product($product_id);
            header('location: /adminProduct');
        } else {
            header('location: /adminProduct');
        }
    }
    public function categories() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_categories';
        include './app/view/v_admin_layout.php';
    }

    public function orders() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_orders';
        include './app/view/v_admin_layout.php';
    }

    public function orderStatus() {
        if (isset($_POST['submit'])) {
            $change_status = $_POST['change_status'];
            $newAdminModel = new Admin();
            $Get_Id_Order = $_GET['id'];
            $newAdminModel->update_Change_status($change_status, $Get_Id_Order);
            header('Location: /adminOrder');
        }
    }
    public function users() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_client';
        include './app/view/v_admin_layout.php';
    }
    public function userAdd() {
        $view_name = 'admin_client-add';
        include './app/view/v_admin_layout.php';
    }

    public function userAddHandler() {
        if (isset($_POST['btn_update'])) {
            $error = array();
            if (!empty($_POST['fullname'])) {
                $fullname = $_POST['fullname'];
            } else {
                $error['fullname'] = "Không được để trống tên đăng nhập";
            }
            if (!empty($_POST['username'])) {
                $newUserModel = new user();
                $UserRegis = $newUserModel->getFullNameUser();
                foreach ($UserRegis as $value) {
                    if ($value == $_POST['username']) {
                        $error['username'] = "Tên đăng nhập bị trùng";
                    } else {
                        $username = $_POST['username'];
                    }
                }
            } else {
                $error['username'] = "Không được để trống tên đăng nhập";
            }
            $patternPassword = "/^.{6,}$/";
            if (!empty($_POST['password'])) {
                if (preg_match($patternPassword, $_POST['password'])) {
                    $password = $_POST['password'];
                    $password = md5($password);
                } else {
                    $error['password'] = "Mật khẩu phải có ít nhất 6 ký tự";
                }
            } else {
                $error['phone'] = "Không được để trống mật khẩu";
            }
            $paternPhone = "/^(0[2|3|5|6|7|8|9])+([0-9]{8})$/";
            if (!empty($_POST['phone'])) {
                if (preg_match($paternPhone, $_POST['phone'])) {
                    $phone = $_POST['phone'];
                } else {
                    $error['phone'] = "Số điện thoại không khả dụng";
                }
            } else {
                $error['phone'] = "Không được để trống mật khẩu";
            }

            if (!empty($_POST['email'])) {
                $email = $_POST['email'];
            } else {
                $error['email'] = "Không được để trống email";
            }


            $role = $_POST['role'];
            $bio = $_POST['bio'];
            if (isset($_FILES['file'])) {
                //Thư mục chứa file upload
                $upload_dir = './public/upload/users/';
                //Đường dẫn của file sau khi upload
                $upload_file = $upload_dir . $_FILES['file']['name'];
                //Xử lý upload đúng file ảnh
                $type_allow = array('png', 'jpg', 'jpeg', 'gif');
                //PATHINFO_EXTENSION lấy đuôi file
                $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $filename = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);

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
                    $new_filename = $filename . '- Copy.';
                    $new_upload_file = $upload_dir . $new_filename . $type;
                    $k = 1;
                    while (file_exists($new_upload_file)) {
                        $new_filename = $filename . " - Copy({$k}).";
                        $k++;
                        $new_upload_file = $upload_dir . $new_filename . $type;
                    }
                    $upload_file = $new_upload_file;
                    $filename = $new_filename;
                }
            } else {
                $image = "NULL";
            }
            if (empty($error)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                    $image = $filename . $type;
                    $newUserModel = new user();
                    $newUserModel->addUserProfile($fullname, $username, $password, $email, $image, $role, $bio, $phone);

                    header("Location: /adminUser");
                } else {
                    echo "Upload file thất bại";
                }
            }
        }
        if (@isset($_POST['btn_cancelled'])) {
            header("Location: /adminUser");
        }
    }

    public function userEdit() {
        $view_name = 'admin_client-edit';
        include './app/view/v_admin_layout.php';
    }

    public function userEditHandler() {
        if (@isset($_POST['btn_update'])) {
            $error = array();
            // Validation for each input field
            if (!empty($_POST['fullname'])) {
                $fullname = $_POST['fullname'];
            } else {
                $error['fullname'] = "Không được để trống Họ Và Tên";
            }
            $newUserModel = new user();
            foreach ($newUserModel->getUser() as $item) {
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

            // Check if a file was uploaded
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                //Thư mục chứa file upload
                $upload_dir = './public/upload/users/';
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
                $image = "profile.jpg";
            }

            if (empty($error)) {
                // Only delete the old image file if a new image was uploaded
                /* if (isset($_FILES['file']) && $_FILES['file']['error'] == 0 && $image != $userInfo['img']) {
                    $delete_file = './public/upload/users/' . $userInfo['img'];
                    unlink($delete_file);
                } */
                $newUserModel = new user();
                $newUserModel->editUserProfile($id, $fullname, $username, $password, $email, $image, $role, $phone);
                header("Location: /adminUser");
            } else {
                $error['upload'] = "Upload ảnh thất bại";
                print_r($error);
            }
        }
        if (@isset($_POST['btn_delete'])) {
            $id = $_GET['id'];
            //Thư mục chứa file Delete
            $newBillModel = new Bill();
            $getAllBilById = $newBillModel->get_allBill($id);
            foreach ($getAllBilById as $item) {
                if ($item['status'] == 1 || $item['status'] == 2 || $item['status'] == 3) {
                    $error['status'] = "Không thể xóa User này vì hiện đang có đơn hàng đang chuẩn bị hoặc đang giao";
                }
            }

            if (isset($error['status']) && !empty($error['status'])) {
                $error['status'] = "Không thể xóa User này vì hiện đang có đơn hàng đang chuẩn bị hoặc đang giao";
            } else {
                // Xóa hình ảnh của user
                $commentModel = new Comment();
                foreach ($commentModel->getCommentByIdUser($id) as $comment) {
                    foreach ($commentModel->getAllCmtImgByID($comment['id']) as $item) {
                        $delete_dir = './public/upload/users/';
                        $delete_file = $delete_dir . $item['src'];
                        unlink($delete_file);
                    }
                }
                $commentModel = new Comment();
                foreach ($commentModel->getCommentByIdUser($id) as $comment) {
                    foreach ($commentModel->getAllCmtImgByID($comment['id']) as $item) {
                        $commentModel->delImgByIdCmt($comment['id']);
                    }
                    $commentModel->delCmtByID($comment['id']);
                }
                $newAddressModel = new Address();
                foreach ($newAddressModel->getAllAddressByUser($id) as $item) {
                    $newAddressModel->delete_address_byIduser($item['id_user']);
                }
                $newCartModel = new Cart();
                foreach ($newCartModel->getAllCartByIdUser($id) as $item) {
                    $newCartModel->delete_bill_fromCart($item['id_user']);
                }
                $newBillModel = new Bill();
                foreach ($newBillModel->getAllBillByIdUser($id) as $item) {
                    $newBillModel->delete_bill($item['id_user']);
                }
                // Xóa user
                $newUserModel = new user();
                $newUserModel->deleteUser($id);
                // Chuyển hướng người dùng
                header("Location: /adminUser");
            }
        }
        if (@isset($_POST['btn_cancelled'])) {
            header("Location: /adminUser");
        }
    }
    public function address() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_address';
        include './app/view/v_admin_layout.php';
    }

    public function comments() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_comment';
        include './app/view/v_admin_layout.php';
    }

    public function commentShow() {
        $id = $_GET['id'];
        $newCommentModel = new Comment();
        $newCommentModel->editCmtStatus($id, 1);
        header("Location: /adminComment");
    }

    public function commentHidden() {
        $id = $_GET['id'];
        $newCommentModel = new Comment();
        $newCommentModel->editCmtStatus($id, 0);
        header("Location: /adminComment");
    }

    public function commentDelete() {
        $id = $_GET['id'];
        $newCommentModel = new Comment();
        $newCommentModel->delCmt($id);
        header("Location: /adminComment");
    }

    public function banners() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_banner';
        include './app/view/v_admin_layout.php';
    }

    public function coupon() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_coupon';
        include './app/view/v_admin_layout.php';
    }

    public function createCoupon() {
        if ($_SESSION['role'] == 0 || !empty($_SESSION['userLogin']) || empty($_SESSION['admin'])) {
            header("Location: /");
        }
        $view_name = 'admin_coupon-create';
        include './app/view/v_admin_layout.php';
    }

    public function createCouponHandler() {
        if (isset($_POST['createCouponSubmit'])) {
            $error = [];
            $qtyTotal = [];
            if (isset($_POST['namecoupon']) && !empty($_POST['namecoupon'])) {
                $namecoupon = $_POST['namecoupon'];
            } else {
                $error['namecoupon'] = "Không được để trống Tên Coupon";
            }

            if (isset($_POST['qtycoupon']) && !empty($_POST['qtycoupon'])) {
                $qtycoupon = $_POST['qtycoupon'];
                for ($i = 0; $i < $qtycoupon; $i++) {
                    $randomString = bin2hex(random_bytes(5)); // Tạo chuỗi ngẫu nhiên gồm 10 ký tự
                    array_push($qtyTotal, $randomString);
                }
            } else {
                $error['qtycoupon'] = "Không được để trống số lượng";
            }

            if (isset($_POST['discountpercent']) && !empty($_POST['discountpercent'])) {
                $discountpercent = $_POST['discountpercent'];
            } else {
                $error['discountpercent'] = "Không được để trống Mức Giảm Giá";
            }

            if (isset($_POST['expiredDate']) && !empty($_POST['expiredDate'])) {
                $expiredDate = $_POST['expiredDate'];
            } else {
                $error['expiredDate'] = "Không được để trống Ngày Hết Hạn";
            }

            if (isset($_POST['description']) && !empty($_POST['description'])) {
                $description = $_POST['description'];
            } else {
                $error['description'] = "Không được để trống Mô Tả";
            }
            foreach ($qtyTotal as $item) {
                $newCouponModel = new Coupon();
                $newCouponModel->addNewCoupon(strtoupper($item), $namecoupon, $discountpercent, $expiredDate, $description, date("Y-m-d"));
            }
            header("Location: /adminCreateCoupon");
        }
    }

    public function editCouponHandler() {
        if (isset($_POST['editCouponsubmit'])) {
            $error = [];
            $getEditID = (int) $_GET['editId'];
            if (isset($_POST['namecoupon']) && !empty($_POST['namecoupon'])) {
                $namecoupon = $_POST['namecoupon'];
            } else {
                $error['namecoupon'] = "Không được để trống Tên Coupon";
            }

            if (isset($_POST['discountpercent']) && !empty($_POST['discountpercent'])) {
                $discountpercent = $_POST['discountpercent'];
            } else {
                $error['discountpercent'] = "Không được để trống Mức Giảm Giá";
            }

            if (isset($_POST['expiredDateEdit']) && !empty($_POST['expiredDateEdit'])) {
                $expiredDateEdit = $_POST['expiredDateEdit'];
            } else {
                $error['expiredDateEdit'] = "Không được để trống Ngày Hết Hạn";
            }

            if (isset($_POST['description']) && !empty($_POST['description'])) {
                $description = $_POST['description'];
            } else {
                $error['description'] = "Không được để trống Mô Tả";
            }
            $newCouponModel = new Coupon();
            $newCouponModel->editCoupon($getEditID, $namecoupon, $discountpercent, $description, $expiredDateEdit);
            header("Location: /adminCoupon");
        }
    }

    public function adminDeleteCoupon() {
        $id = $_GET['editId'];
        $newCouponModel = new Coupon();
        $newCouponModel->delCoupon($id);
        header("Location: /adminCoupon");
    }
}
