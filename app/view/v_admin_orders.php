<?php

use App\model\Address;
use App\model\Admin;
use App\model\Bill;
use App\model\Cart;
use App\model\Comment;
use App\model\Product;
use App\model\User;
use App\model\Category;

$tb = "";
$newAdminModel = new Admin();
$get_Order = $newAdminModel->get_Order_bill();
if (isset($_GET['filter'])) {
    $get_Order = $newAdminModel->get_Order_bill($_GET['filter']);
    if (isset($_GET['status'])) {
        $get_Order = $newAdminModel->get_Order_bill($_GET['filter'], $_GET['status']);
    }
}
if (isset($_POST['btn_search'])) {
    $kyw_order = $_POST['kyw_order'];
    $newAdminModel = new Admin();
    $search_us_bill = $newAdminModel->searchUser($kyw_order);
    if (empty($search_us_bill)) {
        // không làm gì hết
        $get_Order = [];
    } else {
        $get_us_bill = $search_us_bill[0]['id'];
        $get_Order = $newAdminModel->get_Order_bill("", "", $get_us_bill);
    }
}
// Cut code here
if (isset($_GET['id'])) {
    $Get_Id_Order = $_GET['id'];
    $newAdminModel = new Admin();
    $Id_bill = $newAdminModel->get_OneOrder_bill($Get_Id_Order);
    $id_User = $Id_bill['id_user'];
    $newUserModel = new User();
    $newAddressModel = new Address();
    $newCartModel = new Cart();
    $name_user = $newUserModel->getUserById($id_User);
    $getAddress = $newAddressModel->getAddress();
    // $getAddress = $newAddressModel->getAddress($name_user['id']);
    $get_product_order = $newCartModel->get_product_order($Id_bill['id']);
    $shipping = $newAdminModel->shipping($Id_bill['id_shipping']);
    $payment = $newAdminModel->payment($Id_bill['id_payment']);
    if (isset($_POST['submit'])) {
        $change_status = $_POST['change_status'];
        $newAdminModel = new Admin();
        $newAdminModel->update_Change_status($change_status, $Get_Id_Order);
        header('Location: /adminOrder');
    }
    $newCartModel = new Cart();
    $getAll = $newCartModel->getAllCart();
    if (isset($_POST['delete_bill'])) {
        if (count($newCartModel->check_idbillCart($Get_Id_Order)) > 0) {
            $tb = '<div class="alert alert-danger" role="alert">Bạn không thể xóa đơn hàng đã có sản phẩm</div>';
        } else {
            $newAdminModel = new Admin();
            $newAdminModel->del_bill($_GET['id']);
            header('Location: /adminOrder');
        }
    }
} elseif (isset($_GET['detail_id'])) {
    $Get_Id_Order = $_GET['detail_id'];
    $Id_bill = $newAdminModel->get_OneOrder_bill($Get_Id_Order);
    $id_User = $Id_bill['id_user'];
    $newUserModel = new User();
    $newAddressModel = new Address();
    $newCartModel = new Cart();
    $name_user = $newUserModel->getUserById($id_User);
    $getAddress = $newAddressModel->getAddress();
    // $getAddress = $newAddressModel->getAddress($name_user['id']);
    $get_product_order = $newCartModel->get_product_order($Id_bill['id']);
    $shipping = $newAdminModel->shipping($Id_bill['id_shipping']);
    $payment = $newAdminModel->payment($Id_bill['id_payment']);
    if (isset($_POST['submit'])) {
        $change_status = $_POST['change_status'];
        $newAdminModel = new Admin();
        $newAdminModel->update_Change_status($change_status, $Get_Id_Order);
        header('Location: /adminOrder');
    }
}
?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
            line-height: 32px;">Đơn Hàng</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
          align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="#" class="label-large" style="text-decoration: none;">Đơn
                    Hàng</a>
            </div>
            <div class="flex-center g8">
            </div>
        </div>
    </div>
    <!----======== End Header DashBoard ======== -->

    <!----======== Body DashBoard ======== -->
    <div class="containerAdmin">
        <div class="flex-column width-full">
            <div class="content-filter dropdown-center width-full d-flex align-items-center justify-content-between">
                <button id="btn_addMore_admin" type="button" style="width:130px;height:45px;background-color:#6750a4;border-radius:10px"><a style="color: white; font-size: 12px; text-decoration: none; padding: 10px 5px;" href="/adminOrderAdd">Thêm Đơn Hàng</a></button>
            </div>
        </div>
        <table id="example1" class="content-table width-full">
            <thead>
                <tr>
                    <th style="text-align: start;">
                        <input type="checkbox" class="checkboxAll" style="width: 18px; height: 18px;">
                        </input>
                    </th>
                    <th>Order ID</th>
                    <th>Tên Khách Hàng</th>
                    <th>Phương Thức Thanh Toán</th>
                    <th>Ngày Đặt</th>
                    <th>Trạng Thái</th>
                    <th>Tổng giá</th>
                    <th>Khác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($get_Order as $value) : ?>

                    <?php
                    $newUserModel = new User();
                    $newAdminModel = new Admin();
                    $newProductModel = new Product();
                    $getUser = $newUserModel->getUserById($value['id_user']);
                    $getPayment = $newAdminModel->payment($value['id_payment']);
                    $getProduct = $newProductModel->getProductById($value['id_user']);
                    $getShipping = $newAdminModel->shipping($value['id_shipping']);
                    // print_r($getUser);
                    //number_format
                    $formatted_number = number_format($value['total'], 0, ',', '.');
                    $status_order = '';
                    if ($value['status'] == 1) {
                        $status_order = '<td style="color:#00C58A;">Đang Chờ</td>';
                    } elseif ($value['status'] == 2) {
                        $status_order = '<td style="color:#707070;">Chờ Lấy Hàng</td>';
                    } elseif ($value['status'] == 3) {
                        $status_order = '<td style="color:#FF9900;">Đang Giao</td>';
                    } elseif ($value['status'] == 4) {
                        $status_order = '<td style="color:#B3261E;">Hoàn Đơn</td>';
                    } elseif ($value['status'] == 6) {
                        $status_order = '<td style="color:#B3261E;">Đã Hủy</td>';
                    } elseif ($value['status'] == 5) {
                        $status_order = '<td style="color:#00B3FF;">Đã Giao</td>';
                    }
                    ?>
                    <?php
                    $bill_cl_st = '';
                    if ($value['status'] == 6)
                        $bill_cl_st = 'style = "background-color: rgba(128, 128, 128, 0.233);"';
                    elseif ($value['status'] == 5)
                        $bill_cl_st = 'style = "background-color:rgba(34,187,51, 0.3);"';
                    ?>
                    <tr <?= $bill_cl_st ?>>
                        <td style="text-align: start;">
                            <input type="checkbox" class="checkboxChild" style="width: 18px; height: 18px;">
                            </input>
                        </td>
                        <td>
                            <?= $value['id'] ?>
                        </td>
                        <td>
                            <?= $getUser['fullname'] ?>
                        </td>
                        <td>
                            <?= $getPayment[0]['name'] ?>
                        </td>
                        <td>
                            <?= $value['create_date'] ?>
                        </td>
                        <?= $status_order ?>
                        <td>
                            <?= $formatted_number ?> đ
                        </td>
                        <td><a href=" /adminOrder?detail_id=<?= $value['id'] ?>">Xem chi tiết</a>
                            <div><i class="fa-solid fa-minus"></i></div>
                            <a href=" /adminOrder?id=<?= $value['id'] ?>">Cập nhật</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (@$_GET['detail_id']) : ?>
            <div class="popup_detail-order" id="myModal" class="modal">
                <div class="popup_detail--content" class="modal-content">
                    <a href="/adminOrder" style="width:100%;"><span style="float: inline-end;font-size:20px; cursor: pointer;" class="close">&times;</span> </a>
                    <button onclick="window.print()"><span class="fa-solid fa-print"> printer</span></button>
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <div class="modal-header" style="padding:60px;">
                                <h5 class="modal-title d-flex align-items-center" id="staticBackdropLabel"><img src="./public/images/logo.png" alt="">
                                    <p style="margin-left:10px; font-size:40px; color:#000000;">LEGOUS</p>
                                </h5>
                            </div>
                        </div>
                        <div style="width:300px;" class="col-6">
                            <img src="https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIyLTA3L3JtNTY0LWVsZW1lbnQtMDE1LXYuanBn.jpg" alt="">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:30px;">
                        <div class="col-6">
                            <h3 class="d-flex aline-item-center">Công ty mô hình đồ chơi Legous</h3>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Công ty</h4>
                                </div>
                                <div>:Công ty 6TV Legous</div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Địa Chỉ</h4>
                                </div>
                                <div style="width:312px;">:Công viên phần miềm Quang Trung - Quận12 - HCM</div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Chủ shop</h4>
                                </div>
                                <div>admin</div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Số Điện Thoại</h4>
                                </div>
                                <div>:
                                    <?= $name_user['phone'] ?>
                                </div>
                            </div>
                            <h3 style="margin:10px 0;" class="d-flex aline-item-center">Người Đặt</h3>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Tên Người Mua</h4>
                                </div>
                                <div>:
                                    <?= $name_user['fullname'] ?>
                                </div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Địa Chỉ Người Mua</h4>
                                </div>
                                <div>:
                                    <?php
                                    if (empty($getAddress['address'])) {
                                        echo "LandMark81";
                                    } else {
                                        $getAddress['address'];
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Email</h4>
                                </div>
                                <div>:
                                    <?= $name_user['email'] ?>
                                </div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Số Điện Thoại</h4>
                                </div>
                                <div>:
                                    <?= $name_user['phone'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="d-flex aline-item-center">Người Nhận</h3>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Tên Người Mua</h4>
                                </div>
                                <div>:
                                    <?= $Id_bill['name_recipient'] ?>
                                </div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Địa Chỉ Người Mua</h4>
                                </div>
                                <div>:
                                    <?= $Id_bill['address_recipient'] ?>
                                </div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Email</h4>
                                </div>
                                <div>:
                                    <?= $Id_bill['email_recipient'] ?>
                                </div>
                            </div>
                            <div class="d-flex aline-item-center">
                                <div class="width-fix">
                                    <h4>Số Điện Thoại</h4>
                                </div>
                                <div>:
                                    <?= $Id_bill['phone_recipient'] ?>
                                </div>
                            </div>
                            <h3 style="margin:10px 0;" class="d-flex aline-item-center">Đơn Hàng</h3>
                            <div class="row d-flex">
                                <div class="d-flex align-items-center">
                                    <div class="width-fix">
                                        <h4>Cách Thức Giao Hàng</h4>
                                    </div>
                                    :
                                    <?php
                                    if (empty($shipping['name'])) {
                                        echo "Giao Hàng Tiết Kiệm";
                                    } else {
                                        $shipping['name'];
                                    }
                                    ?>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="width-fix">
                                        <h4>Áp Dụng Mã Giảm Giá</h4>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="width-fix">
                                        <h4>Phương thức thanh toán</h4>
                                    </div>
                                    :
                                    <?php
                                    if (empty($payment['name'])) {
                                        echo "Thanh Toán Khi Nhận Hàng";
                                    } else {
                                        $payment['name'];
                                    }
                                    ?>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="width-fix">
                                        <h4>Ngày Đặt Hàng </h4>
                                    </div>
                                    :
                                    <?= $Id_bill['create_date'] ?>
                                </div>
                                <?php
                                $tax = $Id_bill['total'] * 0.1;
                                $total = $Id_bill['total'] - $tax;
                                $formatted_number_id = number_format($total, 0, ',', '.');
                                ?>
                                <div class="d-flex align-items-center">
                                    <div class="width-fix">
                                        <h4>Địa Chỉ Nhận hàng Hàng</h4>
                                    </div>
                                    :
                                    <?= $Id_bill['address_recipient'] ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="table_order">
                        <table>
                            <tr>
                                <td>Mã đơn hàng</td>
                                <td>Tên sản phẩm - danh mục</td>
                                <td style="width:160px;">Ghi chú</td>
                                <td>Số lượng</td>
                                <td>Thuế (-10%)</td>
                                <td>Tổng Tiền</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div>
                                        <?php foreach ($get_product_order as $value) : ?>
                                            <?php
                                            $newCategoryModel = new Category();
                                            $category_bill = $newCategoryModel->getCategoryById($value['id_product']);
                                            ?>
                                            <div class="d-flex">
                                                <p>
                                                    <?= $value['name'] ?>
                                                </p> -
                                                <p>
                                                    Lego
                                                </p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div>
                                        -
                                        <?= number_format($tax, 0, ',', '.') ?>đ
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p>
                                            <?= $formatted_number_id ?>đ
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>TỔNG CỘNG </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4 text-center">
                            <p>Nhà cung cấp</p>
                            <p>ngày... tháng....năm</p>
                            <p>(Ký & ghi rõ họ tên)</p>
                        </div>
                        <div class="col-4 text-center">
                            <p>Người giao hàng</p>
                            <p>ngày... tháng....năm</p>
                            <p>(Ký & ghi rõ họ tên)</p>
                        </div>
                        <div class="col-4 text-center">
                            <p>Người nhận</p>
                            <p>ngày... tháng....năm</p>
                            <p>(Ký & ghi rõ họ tên)</p>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<?php endif; ?>
<?php if (@$_GET['id']) : ?>
    <div style=" 
                            font-size: 16px;
                            display:block;
                            position: fixed; /* Stay in place */
                            z-index: 99; /* Sit on top */
                            padding-top: 15px; /* Location of the box */
                            left: 0;
                            top: 0;
                            width: 100%; /* Full width */
                            height: 100%; /* Full height */
                            overflow: auto; /* Enable scroll if needed */
                            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */" id="myModal" class="modal">
        <!-- Modal content -->
        <div style=" background-color: #fefefe;
                            margin: auto;
                            padding: 20px;
                            border: 1px solid #888;
                            width: 70%;" class="modal-content">
            <a href="/adminOrder" style="width:100%;"><span style="float: inline-end;font-size:20px; cursor: pointer;" class="close">&times;</span></a>
            <form action="/adminOrderStatus?id=<?= $_GET['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="row d-flex">
                    <?= $tb ?>
                    <div class="col-6" style="overflow: auto; height:600px;">
                        <h1 style="margin-bottom: 20px;">Người Nhận</h1>
                        <hr>
                        <div style="margin-bottom: 20px;">
                            <h4>Tên Người Nhận</h4>
                            <p>
                                <?= $Id_bill['name_recipient'] ?>
                            </p>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <h4>Địa Người Nhận</h4>
                            <p>
                                <?= $Id_bill['address_recipient'] ?>
                            </p>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <h4>Email</h4>
                            <p>
                                <?= $Id_bill['email_recipient'] ?>
                            </p>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <h4>Số Điện Thoại</h4>
                            <p>
                                <?= $Id_bill['phone_recipient'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <h1 style="margin-bottom: 20px;">Đơn Hàng</h1>
                        <div class="row d-flex">
                            <hr>
                            <div style="margin-bottom: 20px;">
                                <h4>Tên Đơn Hàng - Danh Mục:</h4>
                                <?php foreach ($get_product_order as $value) : ?>
                                    <?php
                                    $newCategoryModel = new Category();
                                    $category_bill = $newCategoryModel->getCategoryById($value['id_product']);
                                    ?>
                                    <div class="d-flex">
                                        <p>
                                            <?= $value['name'] ?>
                                        </p> -
                                        <p>
                                            Lego
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div style="margin-bottom: 20px;" class="d-flex align-items-center">
                                <h4 style="margin:0 5px 0 0 ;">Cách Thức Giao Hàng:</h4>
                                <p>
                                    <?php
                                    if (empty($shipping['name'])) {
                                        echo "Giao Hàng Tiết Kiệm";
                                    } else {
                                        $shipping['name'];
                                    }
                                    ?>
                                </p>
                            </div>
                            <div style="margin-bottom: 20px;" class="d-flex align-items-center">
                                <h4 style="margin:0 5px 0 0 ;">Áp Dụng Mã Giảm Giá:</h4>
                                <p></p>
                            </div>
                            <div style="margin-bottom: 20px;" class="d-flex align-items-center">
                                <h4 style="margin:0 5px 0 0 ;">Phương thức thanh toán:</h4>
                                <p>
                                    <?php
                                    if (empty($payment['name'])) {
                                        echo "Thanh Toán Khi Nhận Hàng";
                                    } else {
                                        $payment['name'];
                                    }
                                    ?>
                                </p>
                            </div>
                            <div style="margin-bottom: 20px;" class="d-flex align-items-center">
                                <h4 style="margin:0 5px 0 0 ;">Ngày Đặt Hàng: </h4>
                                <p>
                                    <?= $Id_bill['create_date'] ?>
                                </p>
                            </div>
                            <?php
                            $tax = $Id_bill['total'] * 0.1;
                            $total = $Id_bill['total'] - $tax;
                            $formatted_number_id = number_format($total, 0, ',', '.');
                            ?>
                            <div>
                                <h4>Địa Chỉ Nhận hàng Hàng:</h4>
                                <p>
                                    <?= $Id_bill['address_recipient'] ?>
                                </p>
                                <hr>
                            </div>
                            <div>
                                <h5 style="margin:0 5px 0 0 ;">(Thuế
                                    10%):-
                                    <?= number_format($tax, 0, ',', '.') ?>đ
                                </h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <h4 style="margin:0 5px 0 0 ;">Tổng Đơn Hàng: </h4>


                                <p>
                                    <?= $formatted_number_id ?>đ
                                </p>
                            </div>
                            <div class="custom-select">
                                <hr>
                                <h4>Trạng Thái Đơn Hàng:(Hiện tại)</h4>
                                <!-- Dropdown -->

                                <select id="id_category" name="change_status">
                                    <?php
                                    if ($Id_bill['status'] == 1) {
                                        echo '
                                      <option style="display:none;" value="1">Đang Chờ</option>
                                      <option value="2">Chờ Lấy Hàng</option>
                                      <option value="3">Đang Giao</option>
                                      <option style="display:none;" value="4">Hoàn Đơn</option>
                                      <option value="5">Đã Giao</option>
                                      <option value="6">Hủy Đơn</option>
                                      ';
                                    } elseif ($Id_bill['status'] == 2) {
                                        echo '
                                      <option style="display:none;" value="2">Chờ Lấy Hàng</option>
                                      <option value="3">Đang Giao</option>
                                      <option value="4">Hoàn Đơn</option>
                                      <option value="5">Đã Giao</option>
                                      <option value="6">Hủy Đơn</option>
                                      <option value="1">Đang Chờ</option>
                                      ';
                                    } elseif ($Id_bill['status'] == 3) {
                                        echo '
                                      <option style="display:none;" value="3">Đang Giao</option>
                                      <option value="4">Hoàn Đơn</option>
                                      <option value="5">Đã Giao</option>
                                      <option value="6">Hủy Đơn</option>
                                      <option style="display:none;" value="1">Đang Chờ</option>
                                      <option style="display:none;" value="2">Chờ Lấy Hàng</option>
                                      ';
                                    } elseif ($Id_bill['status'] == 4) {
                                        echo '
                                      <option style="display:none;" value="4">Hoàn Đơn</option>
                                      <option value="5">Đã Giao</option>
                                      <option value="6">Hủy Đơn</option>
                                      <option value="1">Đang Chờ</option>
                                      <option value="2">Chờ Lấy Hàng</option>
                                      <option value="3">Đang Giao</option>
                                      ';
                                    } elseif ($Id_bill['status'] == 5) {
                                        echo '
                                      <option value="5">Đã Giao</option>
                                      <option style="display:none;" value="6">Hủy Đơn</option>
                                      <option style="display:none;" value="1">Đang Chờ</option>
                                      <option style="display:none;" value="2">Chờ Lấy Hàng</option>
                                      <option style="display:none;" value="3">Đang Giao</option>
                                      <option style="display:none;" value="4">Hoàn Đơn</option>
                                      ';
                                    } elseif ($Id_bill['status'] == 6) {
                                        echo '
                                      <option value="6">Hủy Đơn</option>
                                      <option style="display:none;" value="1">Đang Chờ</option>
                                      <option style="display:none;" value="2">Chờ Lấy Hàng</option>
                                      <option style="display:none;" value="3">Đang Giao</option>
                                      <option style="display:none;" value="4">Hoàn Đơn</option>
                                      <option style="display:none;" value="5">Đã Giao</option>
                                      ';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary float-end p-3">Cập
                            nhật</button>
                        <a type="submit" data-bs-toggle="modal" role="button" href="#exampleModalToggle" name="submit" class="btn btn-danger mx-5 float-end p-3">Xóa Đơn Hàng</a>
            </form>

        </div>
    </div>
<?php endif; ?>
</div>
</div>

<!-- Popup thông báo -->
<form action="" method="post">
    <div style="background-color: rgba(128, 128, 128, 0.99);" class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center ">
                    <h5 class="modal-title d-flex align-items-center" id="staticBackdropLabel"><img src="./public/images/logo.png" alt="">
                        <p style="margin-left:10px; font-size:20px; color:#6750a4;">XÁC NHẬN</p>
                    </h5>
                </div>
                <div class="modal-body text-center">
                    <h3 class="text-danger">Bạn có muốn xóa đơn hàng này ?</h3>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button style="padding:12px 20px;" type="button" class="btn btn-danger" data-bs-dismiss="modal">Không
                        Xóa</button>
                    <input style="padding:12px 20px;" class="btn btn-primary" type="submit" name="delete_bill" value="Chập Nhận Xóa">
                </div>
            </div>
        </div>
    </div>
</form>

<!--End popup thông báo -->
<!----======== End Body DashBoard ======== -->

</section>
</script>
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