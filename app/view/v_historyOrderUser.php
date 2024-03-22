<?php

use App\model\Bill;
use App\model\Payment;

if (isset($_SESSION['userLogin']) && (is_array($_SESSION['userLogin']) || is_object($_SESSION['userLogin']) && count($_SESSION['userLogin']) > 0)) {
    extract($_SESSION['userLogin']);
    $id_user = $_SESSION['userLogin']['id_user'];
}
$tbody_html = '';
$dost_html = '';
$newBillModel = new Bill();
if (count($newBillModel->get_allBill($id_user)) > 0) {
    # phân trang
    // Lấy tổng số đơn hàng từ cơ sở dữ liệu hoặc từ nơi khác
    $total_orders = $newBillModel->get_total_orders($id_user);
    // Tính toán tổng số trang
    $total_pages = ceil($total_orders / $itemsPage);
    // Trang hiện tại (lấy từ yêu cầu hoặc mặc định là 1)
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    // Tính toán trang kế tiếp
    $next_page = ($current_page % $total_pages) + 1;
    $order_history = $newBillModel->get_orderHistory($id_user, $current_page, $itemsPage);
    foreach ($order_history as $item) {
        extract($item);
        $getHTML = "";
        if ($status == 1) {
            $getHTML = '<span style="color: gray;" class="label-large-prominent">Chờ xác nhận</span>';
        } elseif ($status == 2) {
            $getHTML = '<span style="color: black;" class="label-large-prominent pending">Chờ lấy hàng</span>';
        } elseif ($status == 3) {
            $getHTML = '<span class="label-large-prominentd elivered">Đang giao hàng</span>';
        } elseif ($status == 4) {
            $getHTML = '<span class="label-large-prominent return">Hoàn/Trả</span>';
        } elseif ($status == 5) {
            $getHTML = '<span class="label-large-prominent  pending">Đã giao hàng</span>';
        } else {
            $getHTML = '<span class="label-large-prominent canceled">Đã hủy</span>';
        }
        $newPaymentModel = new Payment();
        $name_payment = $newPaymentModel->get_namePayment($id_payment);

        $tbody_html .= ' <tr>
                    <td class="label-large-prominent"><span># ' . $id . '</span></td>
                    <td class="label-large-prominent"><span>' . $username . '</span></td>
                    <td class="label-large-prominent"><span>Miễn Phí Vận Chuyển</span></td>
                    <td class="label-large-prominent"><span>' . $create_date . '</span></td>
                    <td class="label-large-prominent delivered"><span>' . $getHTML . '</span></td>
                    <td class="label-large-prominent"><span class="price">' . formatVND($total) . '</span></td>
                    <td class="label-large-prominent">
                        <a href="historyOrderUserDetail?id=' . $id . '" class="label-large-prominent">Xem chi tiết</a>
                    </td>
                </tr>
            ';
    };
    if (!isset($total_pages)) {
        $total_pages = 1; // Gán giá trị mặc định nếu biến chưa được khai báo
    }
    // Hiển thị các nút phân trang
    for ($i = 1; $i <= $total_pages; $i++) {
        $activeClass = ($i == (int) $current_page) ? 'dots-active' : '';
        $dost_html .= '<div class="list__dots--item flex-center rounded-8 ' . $activeClass . '">
                                <a style=" color: #551A8B;" href="/historyOrderUser?page=' . $i . '">
                                    ' . $i .
            '</a>
                            </div>';
    }
    $show_main = '<div class="main__inner--bottom-right">
                            <div class="main__inner--bottom-right--content flex-column">
                                <div class="bottom-right--content_main flex full">
                                    <table class="full">
                                        <thead class="full">
                                            <tr>
                                                <!-- <th class="label-large-prominent"><input type="checkbox"></th> -->
                                                <th class="label-large-prominent">Order ID</th>
                                                <th class="label-large-prominent">Tên Khách Hàng</th>
                                                <th class="label-large-prominent">PTTT</th>
                                                <th class="label-large-prominent">Ngày Đặt</th>
                                                <th class="label-large-prominent">Trạng Thái</th>
                                                <th class="label-large-prominent">Tổng </th>
                                                <th class="label-large-prominent">Khác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        ' . $tbody_html . '
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bottom-right--content_bottom flex-between full">
                                <div class="list__dots flex g16">
                                    ' . $dost_html . '<div class="btn__next--dots flex-center label-large btn-next flex g8"><a style="display: flex; gap: 0.5rem; color: #551A8B;" href="/historyOrderUser?page=' . $next_page . '"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#6750A4"/>
                                        </svg>Trang tiếp theo</a></div>
                                </div>
                                <div style="color: #551A8B; cursor: pointer;" onclick="button_back()" class="btn-back flex-center label-large flex g8">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z" fill="#6750A4"/>
                                    </svg> Trở lại trang trước
                            </div>
                    </div>';
} else {
    $show_main = '<div class="main__inner--bottom-right">
                            <div class="no_bill">
                                <span>Tài Khoản chưa có đơn hàng nào...</span>
                            </div>
                            <div class="bottom-right--content_bottom flex-between full">
                                <div class="list__dots flex g16">
                                </div>
                            <div style="color: #551A8B; cursor: pointer;" onclick="button_back()" class="btn-back flex-center label-large flex g8">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z" fill="#6750A4"/>
                                    </svg>
                                    Trở lại trang trước
                            </div>
                    </div>';
}
?>


<main class="main__user">
    <div class="main__inner">
        <div class="main__inner--top">
            <div class="avatar__image">
                <img srcset="<?= $avatarImage_user ?> 2x" alt="" class="avatar__image--user">
            </div>
            <div class="info__user">
                <div class="info__user--top">
                    <span class="user__name">
                        <?= $checkUses['username'] ?>
                    </span>
                    <span>/</span>
                    <span>
                        <?= $title ?>
                    </span>
                </div>
                <div class="info__user--bottom">
                    <span class="info__user--desc">
                        Cập nhật tên người dùng và quản lý tài khoản của bạn
                    </span>
                </div>
            </div>
            <?php include_once './app/view/box_changeAccountUser.php'; ?>
        </div>
        <div class="main__inner--bottom">
            <?= $show_main ?>
        </div>
    </div>
</main>
<script>
    // Function to format the value with currency symbol and rounding for VND
    function formatCurrency(value) {
        const formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            maximumFractionDigits: 0,
        });
        return formatter.format(value);
    }
</script>