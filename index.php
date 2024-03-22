<?php
session_start();
ob_start();

require_once(__DIR__ . '/public/router.php');
require_once(__DIR__ . '/app/controller/index.php');
require_once(__DIR__ . '/app/controller/user.php');
require_once(__DIR__ . '/app/controller/admin.php');
require_once(__DIR__ . '/app/controller/cart.php');
require_once(__DIR__ . '/app/controller/comment.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Controller\Controller;
use App\controller\UserController;
use App\controller\AdminController;
use App\controller\CartController;
use App\controller\CommentController;

// ? Libary
require_once(__DIR__ . '/app/library/lb_format.php');
require_once(__DIR__ . '/app/library/lb_returnView.php');

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

require_once realpath("vendor/autoload.php");

$newCouponModel = new App\model\Coupon();
foreach ($newCouponModel->getAllCoupon() as $item) {
  if ($item['expired_date'] <= date('Y-m-d 00:00:00')) {
    $newCouponModel->delCoupon($item['id']);
  }
}

if (empty($_SESSION['admin'])) {
  require_once(__DIR__ . '/app/view/v_header.php');
}

$router = new Router();
$router
  ->get('/', [Controller::class, 'index'])
  ->get('/productDetail', [Controller::class, 'productDetail'])
  ->get('/product', [Controller::class, 'product'])
  ->get('/login', [UserController::class, 'login'])
  ->get('/logout', [UserController::class, 'logout'])
  ->post('/loginInfo', [UserController::class, 'loginInfo'])
  ->post('/registerInfo', [UserController::class, 'registerInfo'])
  ->get('/productCate', [Controller::class, 'productCategory'])
  ->post('/productAddInfo', [AdminController::class, 'productAddInfo'])

  ->post('/uploadComment', [CommentController::class, 'uploadComment'])
  ->post('/editComment', [CommentController::class, 'editComment'])
  ->get('/reportComment', [CommentController::class, 'reportComment'])

  ->get('/viewCart', [CartController::class, 'viewCart'])
  ->get('/checkOut', [CartController::class, 'checkOut'])
  ->post('/addCart', [CartController::class, 'addCart'])
  ->get('/deleteProduct', [CartController::class, 'delCart'])
  ->post('/confirmOrder', [CartController::class, 'confirmOrder'])
  ->post('/sendMail', [CartController::class, 'sendMail'])

  ->get('/profileUser', [UserController::class, 'profileUser'])
  ->get('/historyOrderUser', [UserController::class, 'historyOrderUser'])
  ->post('/changeInfoUser', [UserController::class, 'changeInfoUser'])
  ->get('/editProfileUser', [UserController::class, 'editProfileUser'])
  ->get('/passwordUser', [UserController::class, 'passwordUser'])
  ->get('/addressUser', [UserController::class, 'addressUser'])
  ->get('/historyOrderUser', [UserController::class, 'historyOrderUser'])

  ->get('/admin', [AdminController::class, 'admin'])
  ->get('/adminDashboard', [AdminController::class, 'admin'])
  ->get('/adminProduct', [AdminController::class, 'products'])
  ->get('/adminProductFilter', [AdminController::class, 'productsCategoryFil'])
  ->get('/adminProductAdd', [AdminController::class, 'productAdd'])
  ->get('/adminProductDetail', [AdminController::class, 'productDetail'])
  ->post('/productDetailHandler', [AdminController::class, 'productDetailHandler'])
  ->get("/adminProductDelete", [AdminController::class, 'productDelete'])
  ->get('/adminUser', [AdminController::class, 'users'])
  ->get('/adminOrder', [AdminController::class, 'orders'])
  ->get('/adminUserAdd', [AdminController::class, 'userAdd'])
  ->post('/adminUserAddHandler', [AdminController::class, 'userAddHandler'])
  ->get('/adminUserEdit', [AdminController::class, 'userEdit'])
  ->post('/adminUserEditHandler', [AdminController::class, 'userEditHandler'])
  ->post('/adminOrderStatus', [AdminController::class, 'orderStatus'])
  ->get('/adminComment', [AdminController::class, 'comments'])
  ->post('/adminCommentShow', [AdminController::class, 'commentShow'])
  ->post('/adminCommentDelete', [AdminController::class, 'commentDelete'])
  ->post('/adminCommentHidden', [AdminController::class, 'commentHidden'])
  ->get('/AdminCategories', [AdminController::class, 'categories'])
  ->get('/adminBanner', [AdminController::class, 'banners'])
  ->get('/adminAddress', [AdminController::class, 'address'])
  ->get('/adminCoupon', [AdminController::class, 'coupon'])
  ->get('/adminCreateCoupon', [AdminController::class, 'createCoupon'])
  ->post('/adminCreateCouponHandler', [AdminController::class, 'createCouponHandler'])
  ->post('/editCouponHandler', [AdminController::class, 'editCouponHandler'])
  ->get('/adminDeleteCoupon', [AdminController::class, 'deleteCoupon'])

  ->get('/adminTest', [AdminController::class, 'test']);
echo $router->resolve(
  $_SERVER['REQUEST_URI'],
  strtolower($_SERVER['REQUEST_METHOD'])
);

if (isset($_SESSION['MAIL'])) {

  $userMail = "vohongson8520@gmail.com";
  $userName = "Son Vo";
  $_SESSION['MAIL'];

  $newCartModel = new \App\model\Cart();
  $getAllCart = $newCartModel->getCartByIdBill($_SESSION['MAIL']['idBill']);
  $i = 0;
  foreach ($getAllCart as $item) {
    $i++;
  }
  $getIDBill = $_SESSION['MAIL']['idBill'];
  $getUser = $_SESSION['MAIL']['name'];
  $getUserEmail = $_SESSION['MAIL']['email'];
  $getAddress = $_SESSION['MAIL']['address'];
  $getAddressDetail = $_SESSION['MAIL']['address_detail'];
  $getTotal = $_SESSION['MAIL']['total'];

  // Instantiation and passing `true` enables exceptions

  if (isset($_SESSION['MAIL'])) {
    $mail = new PHPMailer(true);
    try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
      $mail->isSMTP(); // gửi mail SMTP
      $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
      $mail->SMTPAuth = true; // Enable SMTP authentication
      $mail->Username = 'vohongson2810@gmail.com'; // SMTP username
      $mail->Password = 'cdzwkmcjuonlahrt'; // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port = 587; // TCP port to connect to

      //Recipients
      $mail->setFrom('vohongson2810@gmail.com', 'Son');
      $mail->addAddress($userMail, $userName); // Add a recipient
      // $mail->addReplyTo('info@example.com', 'Information');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      // Attachments
      // $mail->addAttachment('template.html'); // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

      // Content
      $mail->isHTML(true);   // Set email format to HTML
      $mail->Subject = 'Don Hang Xac Nhan';
      $mail->Body = 'Xin chao ban, <br> <b>Chung toi da nhan duoc don hang cua ban</b>';
      $mail->Body = "
<!DOCTYPE html
  PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html dir='ltr' xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office' lang='en'>
<head>
</head>
<body class='body' style='width:100%;height:100%;padding:0;Margin:0'>
  <div dir='ltr' class='es-wrapper-color' lang='en' style='background-color:#F6F6F6'>
    <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0' role='none'
      style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#F6F6F6'>
      <tr>
        <td valign='top' style='padding:0;Margin:0'>
          <table cellpadding='0' cellspacing='0' class='es-header' align='center' role='none'
            style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important;background-color:transparent;background-repeat:repeat;background-position:center top'>
            <tr>
              <td align='center' style='padding:0;Margin:0'>
                <table class='es-header-body' cellspacing='0' cellpadding='0' bgcolor='#ffffff' align='center'
                  role='none'
                  style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px'>
                  <tr>
                    <td
                      style='Margin:0;padding-top:20px;padding-right:20px;padding-bottom:10px;padding-left:20px;background-position:center center'
                      align='left'>
                      <!--[if mso]><table style='width:560px' cellpadding='0' cellspacing='0'><tr><td style='width:270px' valign='top'><![endif]-->
                      <table class='es-left' cellspacing='0' cellpadding='0' align='left' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                        <tr>
                          <td class='es-m-p20b' align='left' style='padding:0;Margin:0;width:270px'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                              <tr>
                                <td align='left' style='padding:0;Margin:0;padding-bottom:5px;font-size:0'><a
                                    target='_blank' href='https://viewstripo.email/'
                                    style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                    helvetica neue', helvetica, sans-serif;font-size:16px;color:#659C35'><img
                                      src='https://ecqljin.stripocdn.email/content/guids/CABINET_18b8cec0e9d05b2837cef6557539624eafb67190e85dcb69d53c8b4100238cc8/images/logodark.png'
                                      alt=''
                                      style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'
                                      class='adapt-img' width='170'></a></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <!--[if mso]></td><td style='width:20px'></td><td style='width:270px' valign='top'><![endif]-->
                      <table class='es-right' cellspacing='0' cellpadding='0' align='right' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right'>
                        <tr>
                          <td align='left' style='padding:0;Margin:0;width:270px'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                              <tr>
                                <td style='padding:0;Margin:0'>
                                  <table class='es-menu' width='100%' cellspacing='0' cellpadding='0'
                                    role='presentation'
                                    style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                    <tr class='links'>
                                      <td
                                        style='Margin:0;border:0;padding-bottom:10px;padding-top:10px;padding-right:5px;padding-left:5px'
                                        width='33.33%' valign='top' bgcolor='transparent' align='center'><a
                                          target='_blank'
                                          style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                          helvetica neue', helvetica,
                                          sans-serif;font-size:16px;display:block;color:#659C35'
                                          href='localhost:8080'>Trang Chủ</a></td>
                                      <td
                                        style='Margin:0;border:0;padding-bottom:10px;padding-top:10px;padding-right:5px;padding-left:5px'
                                        width='33.33%' valign='top' bgcolor='transparent' align='center'><a
                                          target='_blank'
                                          style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                          helvetica neue', helvetica,
                                          sans-serif;font-size:16px;display:block;color:#659C35'
                                          href='localhost:8080/product'>Sản Phẩm</a></td>
                                      <td
                                        style='Margin:0;border:0;padding-bottom:10px;padding-top:10px;padding-right:5px;padding-left:5px'
                                        width='33.33%' valign='top' bgcolor='transparent' align='center'><a
                                          target='_blank'
                                          style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                          helvetica neue', helvetica,
                                          sans-serif;font-size:16px;display:block;color:#659C35'
                                          href='tel:9999'>9999</a></td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table><!--[if mso]></td></tr></table><![endif]-->
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <table cellpadding='0' cellspacing='0' class='es-content' align='center' role='none'
            style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important'>
            <tr>
              <td align='center' style='padding:0;Margin:0'>
                <table bgcolor='#ffffff' class='es-content-body' align='center' cellpadding='0' cellspacing='0'
                  role='none'
                  style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px'>
                  <tr>
                    <td align='left' style='padding:0;Margin:0;background-position:center top'>
                      <table cellpadding='0' cellspacing='0' width='100%' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                        <tr>
                          <td align='center' valign='top' style='padding:0;Margin:0;width:600px'>
                            <table cellpadding='0' cellspacing='0' width='100%' role='presentation'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                              <tr>
                                <td align='center' style='padding:0;Margin:0;position:relative'><a target='_blank'
                                    href='https://viewstripo.email'
                                    style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                    helvetica neue', helvetica, sans-serif;font-size:14px;color:#659C35'><img
                                      class='adapt-img'
                                      src='https://ecqljin.stripocdn.email/content/guids/bannerImgGuid/images/91191577364120504.png'
                                      alt='' title='' width='600' height='300'
                                      style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'></a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <table cellpadding='0' cellspacing='0' class='es-content' align='center' role='none'
            style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important'>
            <tr>
              <td align='center' style='padding:0;Margin:0'>
                <table bgcolor='#ffffff' class='es-content-body' align='center' cellpadding='0' cellspacing='0'
                  role='none'
                  style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px'>
                  <tr>
                    <td align='left'
                      style='padding:0;Margin:0;padding-top:20px;padding-right:20px;padding-left:20px;background-position:center top'>
                      <table cellpadding='0' cellspacing='0' width='100%' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                        <tr>
                          <td align='center' valign='top' style='padding:0;Margin:0;width:560px'>
                            <table cellpadding='0' cellspacing='0' width='100%' role='presentation'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                              <tr>
                                <td align='center' style='padding:0;Margin:0'>
                                  <h2 style='Margin:0;font-family:arial, ' helvetica neue', helvetica,
                                    sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:26px;font-style:normal;font-weight:bold;line-height:31px;color:#659c35'>
                                    Đơn Hàng Đang Chuẩn Bị Giao Cho Bạn</h2>
                                </td>
                              </tr>
                              <tr>
                                <td align='center' style='padding:0;Margin:0;padding-top:10px'>
                                  <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, ' helvetica neue',
                                    helvetica,
                                    sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px'>
                                    Vui lòng ấn nút xác nhận đơn hàng để đơn hàng giao nhanh đến bạn,nếu bạn không phải
                                    là người đặt vui lòng bỏ qua Mail này và đơn hàng sẽ tự hủy trong 24 giờ !!</p>
                                </td>
                              </tr>
                              <tr>
                                <td align='center'
                                  style='Margin:0;padding-top:20px;padding-right:10px;padding-bottom:20px;padding-left:10px'>
                                  <span class='es-button-border'
                                    style='border-style:solid;border-color:#659C35;background:#659C35;border-width:0px;display:inline-block;border-radius:0px;width:auto'><a
                                      href='https://viewstripo.email/' class='es-button' target='_blank'
                                      style='mso-style-priority:100 !important;text-decoration:none !important;mso-line-height-rule:exactly;font-family:arial, '
                                      helvetica neue', helvetica, sans-serif;font-size:18px;color:#FFFFFF;padding:10px
                                      20px;display:inline-block;background:#659C35;border-radius:0px;font-weight:normal;font-style:normal;line-height:22px;width:auto;text-align:center;letter-spacing:0;mso-padding-alt:0;mso-border-alt:10px
                                      solid #659C35'>Xác Nhận Đơn Hàng</a></span>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td align='left'
                      style='Margin:0;padding-top:20px;padding-right:20px;padding-bottom:10px;padding-left:20px;background-position:center top'>
                      <!--[if mso]><table style='width:560px' cellpadding='0' cellspacing='0'><tr><td style='width:280px' valign='top'><![endif]-->
                      <table class='es-left' cellspacing='0' cellpadding='0' align='left' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                        <tr>
                          <td class='es-m-p20b' align='left' style='padding:0;Margin:0;width:280px'>
                            <table
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-left:1px solid transparent;border-top:1px solid transparent;border-bottom:1px solid transparent;background-color:#EFEFEF;background-position:center top'
                              width='100%' cellspacing='0' cellpadding='0' bgcolor='#efefef' role='presentation'>
                              <tr>
                                <td align='left'
                                  style='Margin:0;padding-top:20px;padding-right:20px;padding-bottom:10px;padding-left:20px'>
                                  <h4 style='Margin:0;font-family:arial, ' helvetica neue', helvetica,
                                    sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:14px;font-style:normal;font-weight:normal;line-height:17px;color:#659c35'>
                                    Tóm Tắt:</h4>
                                </td>
                              </tr>
                              <tr>
                                <td align='left'
                                  style='padding:0;Margin:0;padding-right:20px;padding-left:20px;padding-bottom:20px'>
                                  <table
                                    style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%'
                                    class='cke_show_border' cellspacing='1' cellpadding='1' border='0' align='left'
                                    role='presentation'>
                                    <tr>
                                      <td style='padding:0;Margin:0;font-size:14px;line-height:21px'>ID Đơn Hàng #:</td>
                                      <td style='padding:0;Margin:0'><strong><span
                                            style='font-size:14px;line-height:21px'>9844523</span></strong></td>
                                    </tr>
                                    <tr>
                                      <td style='padding:0;Margin:0;font-size:14px;line-height:21px'>Ngày Đặt Hàng:</td>
                                      <td style='padding:0;Margin:0'><strong><span
                                            style='font-size:14px;line-height:21px'>Ngày 19 Tháng 1 Năm 2024</span></strong>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style='padding:0;Margin:0;font-size:14px;line-height:21px'>Tổng Tiền:</td>
                                      <td style='padding:0;Margin:0'><strong><span
                                            style='font-size:14px;line-height:21px'>$getTotal dong</span></strong></td>
                                    </tr>
                                  </table>
                                  <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, ' helvetica neue',
                                    helvetica,
                                    sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px'>
                                    <br>
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <!--[if mso]></td><td style='width:0px'></td><td style='width:280px' valign='top'><![endif]-->
                      <table class='es-right' cellspacing='0' cellpadding='0' align='right' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right'>
                        <tr>
                          <td align='left' style='padding:0;Margin:0;width:280px'>
                            <table
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-left:1px solid transparent;border-right:1px solid transparent;border-top:1px solid transparent;border-bottom:1px solid transparent;background-color:#EFEFEF;background-position:center top'
                              width='100%' cellspacing='0' cellpadding='0' bgcolor='#efefef' role='presentation'>
                              <tr>
                                <td align='left'
                                  style='Margin:0;padding-top:20px;padding-right:20px;padding-bottom:10px;padding-left:20px'>
                                  <h4 style='Margin:0;font-family:arial, ' helvetica neue', helvetica,
                                    sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:14px;font-style:normal;font-weight:normal;line-height:17px;color:#659c35'>
                                    Địa Chỉ Giao Hàng:</h4>
                                </td>
                              </tr>
                              <tr>
                                <td align='left'
                                  style='padding:0;Margin:0;padding-right:20px;padding-left:20px;padding-bottom:20px'>
                                  <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, ' helvetica neue',
                                    helvetica,
                                    sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px'>
                                    $getUser</p>
                                  <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, ' helvetica neue',
                                    helvetica,
                                    sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px'>
                                    Công Viên Phần Mềm Quang Trung</p>
                                  
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table><!--[if mso]></td></tr></table><![endif]-->
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <table cellpadding='0' cellspacing='0' class='es-content' align='center' role='none'
            style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important'>
            <tr>
              <td align='center' style='padding:0;Margin:0'>
                <table bgcolor='#ffffff' class='es-content-body' align='center' cellpadding='0' cellspacing='0'
                  role='none'
                  style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px'>
                  <tr>
                    <td align='left'
                      style='padding:0;Margin:0;padding-right:20px;padding-left:20px;padding-top:15px;background-position:center top'>
                      <table cellpadding='0' cellspacing='0' width='100%' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                        <tr>
                          <td align='center' valign='top' style='padding:0;Margin:0;width:560px'>
                            <table cellpadding='0' cellspacing='0' width='100%'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:1px solid #cccccc;border-bottom:1px solid #cccccc;background-position:center top'
                              role='presentation'>
                              <tr>
                                <td align='left' style='padding:0;Margin:0;padding-top:10px'>
                                  <table border='0' cellspacing='1' cellpadding='1'
                                    style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px'
                                    class='cke_show_border' role='presentation'>
                                    <tr>
                                      <td style='padding:0;Margin:0'>
                                        <h4 style='Margin:0;font-family:arial, ' helvetica neue', helvetica,
                                          sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:14px;font-style:normal;font-weight:normal;line-height:28px;color:#333333'>
                                          Tổng Thu<strong> (3 sản phẩm):</strong></h4>
                                      </td>
                                      <td style='padding:0;Margin:0;color:#659c35'><strong>$getTotal dong</strong></td>
                                    </tr>
                                    <tr>
                                      <td style='padding:0;Margin:0'>
                                        <h4 style='Margin:0;font-family:arial, ' helvetica neue', helvetica,
                                          sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:14px;font-style:normal;font-weight:normal;line-height:28px;color:#333333'>
                                          Phí Giao Hàng:</h4>
                                      </td>
                                      <td style='padding:0;Margin:0;color:#ff0000'><strong>Free</strong></td>
                                    </tr>
                                    <tr>
                                      <td style='padding:0;Margin:0'>
                                        <h4 style='Margin:0;font-family:arial, ' helvetica neue', helvetica,
                                          sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:14px;font-style:normal;font-weight:normal;line-height:28px;color:#333333'>
                                          Giảm Giá:</h4>
                                      </td>
                                      <td style='padding:0;Margin:0;color:#ff0000'><strong>Mien Phi</strong></td>
                                    </tr>
                                    <tr>
                                      <td style='padding:0;Margin:0'>
                                        <h4 style='Margin:0;font-family:arial, ' helvetica neue', helvetica,
                                          sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:14px;font-style:normal;font-weight:normal;line-height:28px;color:#333333'>
                                          Tổng Đơn Hàng:</h4>
                                      </td>
                                      <td style='padding:0;Margin:0;color:#659c35'><strong> $getTotal dong</strong></td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td align='left'
                      style='Margin:0;padding-right:20px;padding-left:20px;padding-top:30px;padding-bottom:30px;background-position:left top'>
                      <!--[if mso]><table style='width:560px' cellpadding='0' cellspacing='0'><tr><td style='width:270px' valign='top'><![endif]-->
                      <table class='es-left' cellspacing='0' cellpadding='0' align='left' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                        <tr>
                          <td class='es-m-p20b' align='left' style='padding:0;Margin:0;width:270px'>
                            <table width='100%' cellspacing='0' cellpadding='0'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:center center'
                              role='presentation'>
                              <tr>
                                <td align='left' style='padding:0;Margin:0'>
                                  <h4 style='Margin:0;font-family:arial, ' helvetica neue', helvetica,
                                    sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:14px;font-style:normal;font-weight:normal;line-height:17px;color:#659c35'>
                                    Contact Us:</h4>
                                </td>
                              </tr>
                              <tr>
                                <td align='left' style='padding:0;Margin:0;padding-top:10px;padding-bottom:15px'>
                                  <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, ' helvetica neue',
                                    helvetica,
                                    sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px'>
                                    We prepare healthy, ready-to-eat,weekly meal plans and delivers them to your door.
                                  </p>
                                </td>
                              </tr>
                              <tr>
                                <td style='padding:0;Margin:0'>
                                  <table class='es-table-not-adapt' cellspacing='0' cellpadding='0' role='presentation'
                                    style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                    <tr>
                                      <td valign='top' align='left'
                                        style='padding:0;Margin:0;padding-bottom:5px;padding-right:10px;padding-top:5px;font-size:0'>
                                        <img
                                          src='https://ecqljin.stripocdn.email/content/guids/CABINET_45fbd8c6c971a605c8e5debe242aebf1/images/30981556869899567.png'
                                          alt='' width='16'
                                          style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'>
                                      </td>
                                      <td align='left' style='padding:0;Margin:0'>
                                        <table width='100%' cellspacing='0' cellpadding='0' role='presentation'
                                          style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                          <tr>
                                            <td align='left' style='padding:0;Margin:0'>
                                              <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, '
                                                helvetica neue', helvetica,
                                                sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px'>
                                                <a target='_blank' href='mailto:help@mail.com'
                                                  style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                                  helvetica neue', helvetica,
                                                  sans-serif;font-size:14px;color:#333333'>help@mail.com</a>
                                              </p>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td valign='top' align='left'
                                        style='padding:0;Margin:0;padding-bottom:5px;padding-right:10px;padding-top:5px;font-size:0'>
                                        <img
                                          src='https://ecqljin.stripocdn.email/content/guids/CABINET_45fbd8c6c971a605c8e5debe242aebf1/images/58031556869792224.png'
                                          alt='' width='16'
                                          style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'>
                                      </td>
                                      <td align='left' style='padding:0;Margin:0'>
                                        <table width='100%' cellspacing='0' cellpadding='0' role='presentation'
                                          style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                          <tr>
                                            <td align='left' style='padding:0;Margin:0'>
                                              <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, '
                                                helvetica neue', helvetica,
                                                sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px'>
                                                <a target='_blank' href='tel:+14155555553'
                                                  style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                                  helvetica neue', helvetica,
                                                  sans-serif;font-size:14px;color:#333333'>+14155555553</a>
                                              </p>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td valign='top' align='left'
                                        style='padding:0;Margin:0;padding-bottom:5px;padding-right:10px;padding-top:5px;font-size:0'>
                                        <img
                                          src='https://ecqljin.stripocdn.email/content/guids/CABINET_45fbd8c6c971a605c8e5debe242aebf1/images/78111556870146007.png'
                                          alt='' width='16'
                                          style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'>
                                      </td>
                                      <td align='left' style='padding:0;Margin:0'>
                                        <table width='100%' cellspacing='0' cellpadding='0' role='presentation'
                                          style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                          <tr>
                                            <td align='left' style='padding:0;Margin:0'>
                                              <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, '
                                                helvetica neue', helvetica,
                                                sans-serif;line-height:21px;letter-spacing:0;color:#333333;font-size:14px'>
                                                San Francisco</p>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td align='left' style='padding:0;Margin:0;padding-top:15px'><span
                                    class='es-button-border'
                                    style='border-style:solid;border-color:#659C35;background:#659C35;border-width:0px;display:inline-block;border-radius:0px;width:auto'><a
                                      href='https://viewstripo.email/' class='es-button' target='_blank'
                                      style='mso-style-priority:100 !important;text-decoration:none !important;mso-line-height-rule:exactly;font-family:arial, '
                                      helvetica neue', helvetica, sans-serif;font-size:18px;color:#FFFFFF;padding:10px
                                      20px 10px
                                      20px;display:inline-block;background:#659C35;border-radius:0px;font-weight:normal;font-style:normal;line-height:22px;width:auto;text-align:center;letter-spacing:0;mso-padding-alt:0;mso-border-alt:10px
                                      solid #659C35'>GET
                                      IT NOW</a></span></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <!--[if mso]></td><td style='width:20px'></td><td style='width:270px' valign='top'><![endif]-->
                      <table class='es-right' cellspacing='0' cellpadding='0' align='right' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right'>
                        <tr>
                          <td align='left' style='padding:0;Margin:0;width:270px'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                              <tr>
                                <td align='center' style='padding:0;Margin:0;font-size:0'><img class='adapt-img'
                                    src='https://ecqljin.stripocdn.email/content/guids/CABINET_45fbd8c6c971a605c8e5debe242aebf1/images/52821556874243897.jpg'
                                    alt=''
                                    style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'
                                    width='270'></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table><!--[if mso]></td></tr></table><![endif]-->
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <table cellpadding='0' cellspacing='0' class='es-footer' align='center' role='none'
            style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important;background-color:transparent;background-repeat:repeat;background-position:center top'>
            <tr>
              <td align='center' style='padding:0;Margin:0'>
                <table class='es-footer-body'
                  style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#333333;width:600px'
                  cellspacing='0' cellpadding='0' bgcolor='#333333' align='center' role='none'>
                  <tr>
                    <td
                      style='padding:0;Margin:0;padding-top:20px;padding-right:20px;padding-left:20px;background-position:center center;background-color:#659C35'
                      bgcolor='#659C35' align='left'>
                      <table width='100%' cellspacing='0' cellpadding='0' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                        <tr>
                          <td valign='top' align='center' style='padding:0;Margin:0;width:560px'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                              <tr>
                                <td style='padding:0;Margin:0'>
                                  <table class='es-menu' width='100%' cellspacing='0' cellpadding='0'
                                    role='presentation'
                                    style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                    <tr class='links'>
                                      <td
                                        style='Margin:0;border:0;padding-bottom:0px;padding-top:0px;padding-right:5px;padding-left:5px'
                                        width='33.33%' valign='top' bgcolor='transparent' align='center'><a
                                          target='_blank'
                                          style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                          helvetica neue', helvetica,
                                          sans-serif;font-size:14px;display:block;color:#ffffff'
                                          href='localhost:8080'>Trang Chủ</a></td>
                                      <td
                                        style='Margin:0;border:0;padding-bottom:0px;padding-top:0px;padding-right:5px;padding-left:5px;border-left:1px solid #ffffff'
                                        width='33.33%' valign='top' bgcolor='transparent' align='center'><a
                                          target='_blank'
                                          style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                          helvetica neue', helvetica,
                                          sans-serif;font-size:14px;display:block;color:#ffffff'
                                          href='localhost:8080/product'>Sản Phẩm</a></td>
                                      <td
                                        style='Margin:0;border:0;padding-bottom:0px;padding-top:0px;padding-right:5px;padding-left:5px;border-left:1px solid #ffffff'
                                        width='33.33%' valign='top' bgcolor='transparent' align='center'><a
                                          target='_blank'
                                          style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '
                                          helvetica neue', helvetica,
                                          sans-serif;font-size:14px;display:block;color:#ffffff'
                                          href='localhost:8080'>9999</a></td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td
                      style='Margin:0;padding-top:20px;padding-right:20px;padding-left:20px;padding-bottom:15px;background-position:center center;background-color:#659C35'
                      bgcolor='#659C35' align='left'>
                      <table width='100%' cellspacing='0' cellpadding='0' role='none'
                        style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                        <tr>
                          <td valign='top' align='center' style='padding:0;Margin:0;width:560px'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation'
                              style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                              <tr>
                                <td align='center' style='padding:0;Margin:0;padding-bottom:15px;font-size:0'>
                                  <table class='es-table-not-adapt es-social' cellspacing='0' cellpadding='0'
                                    role='presentation'
                                    style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                    <tr>
                                      <td valign='top' align='center' style='padding:0;Margin:0;padding-right:15px'><img
                                          title='Facebook'
                                          src='https://ecqljin.stripocdn.email/content/assets/img/social-icons/circle-white/facebook-circle-white.png'
                                          alt='Fb' width='32'
                                          style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'>
                                      </td>
                                      <td valign='top' align='center' style='padding:0;Margin:0;padding-right:15px'><img
                                          title='X.com'
                                          src='https://ecqljin.stripocdn.email/content/assets/img/social-icons/circle-white/x-circle-white.png'
                                          alt='X' width='32'
                                          style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'>
                                      </td>
                                      <td valign='top' align='center' style='padding:0;Margin:0'><img title='Youtube'
                                          src='https://ecqljin.stripocdn.email/content/assets/img/social-icons/circle-white/youtube-circle-white.png'
                                          alt='Yt' width='32'
                                          style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td align='center' style='padding:0;Margin:0'>
                                  <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, ' helvetica neue',helvetica,sans-serif;line-height:20px;letter-spacing:0;color:#ffffff;font-size:13px'>You are receiving this email because you have visited our site or asked us about aregular newsletter. Make sure our messages get to your inbox (and not your bulk orjunk folders).</p>
                                </td>
                              </tr>
                              <tr>
                                <td align='center'
                                  style='padding:0;Margin:0;padding-bottom:10px;padding-top:15px;font-size:0'><imgsrc='https://ecqljin.stripocdn.email/content/guids/CABINET_c6d6983b8f90c1ab10065255fbabfbaf/images/15841556884046468.png'alt=''style='display:block;font-size:14px;border:0;outline:none;text-decoration:none'width='140'></td>
                              </tr>
                              <tr>
                                <td align='center' style='padding:0;Margin:0;padding-top:5px'>
                                  <p style='Margin:0;mso-line-height-rule:exactly;font-family:arial, ' helvetica neue',helvetica,sans-serif;line-height:20px;letter-spacing:0;color:#ffffff;font-size:13px'><a target='_blank'  style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '  helvetica neue', helvetica, sans-serif;font-size:13px;color:#FFFFFF'  href='https://viewstripo.email/'>Privacy</a> | <a target='_blank'  style='mso-line-height-rule:exactly;text-decoration:none;font-family:arial, '  helvetica neue', helvetica, sans-serif;font-size:13px;color:#FFFFFF'  class='unsubscribe' href=''>Unsubscribe</a>
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
</div></body></html>
            ";
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      $mail->send();
      echo 'Message has been sent';
    } catch (Exception $e) {
      // echo 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
    }
    unset($_SESSION['MAIL']);
    header('Location: /');
  }
}

if (empty($_SESSION['admin'])) {
  require_once(__DIR__ . '/app/view/v_footer.php');
}
