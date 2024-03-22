<?php

namespace App\controller;

use App\model\comment;
use App\model\user;

class CommentController extends Controller
{
    public function uploadComment()
    {
        if (isset($_POST['submitComment'])) {
            if (!empty($_POST['inputComment'])) {
                $inputCmt = htmlentities($_POST['inputComment']);
                print_r($inputCmt);
            }
            $newUserModel = new user();
            $newCommentModel = new comment();
            $getIdUser = $_SESSION['userLogin']['id_user'];
            $id_product = $_GET['idProduct'];
            $getUsername = $newUserModel->getUserById($getIdUser)['username'];
            $getEmail = $newUserModel->getUserById($getIdUser)['email'];
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $now = date("Y-m-d H:i:s");
            $idCmt = $newCommentModel->insertComment($getIdUser, $id_product, $getUsername, $getEmail, $inputCmt, $now);
            if (isset($_FILES['file'])) {
                //Thư mục chứa file upload
                $upload_dir = './public/upload/users/';

                //Xử lý upload đúng file ảnh
                $type_allow = array('png', 'jpg', 'jpeg', 'gif');

                foreach ($_FILES['file']['name'] as $key => $value) {
                    //Đường dẫn của file sau khi upload
                    $upload_file = $upload_dir . $_FILES['file']['name'][$key];

                    //PATHINFO_EXTENSION lấy đuôi file
                    $type = pathinfo($_FILES['file']['name'][$key], PATHINFO_EXTENSION);

                    if (!in_array(strtolower($type), $type_allow)) {
                        $error['type'] = "Chỉ được upload file có đuôi PNG, JPG, GIF, JPEG";
                    }

                    #Upload file có kích thước cho phép (<20mb ~ 29.000.000BYTE)
                    $file_size = $_FILES['file']['size'][$key];
                    if ($file_size > 29000000) {
                        $error['file_size'] = "Chỉ được upload file bé hơn 20MB";
                    }
                    $filename = pathinfo($_FILES["file"]["name"][$key], PATHINFO_FILENAME);

                    #Kiểm tra trùng file trên hệ thống
                    if (file_exists($upload_file)) {
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
                        if (empty($error)) {
                            if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $upload_file)) {
                                $image = $new_filename . $type;
                                $newCommentModel = new comment();
                                $idCmt = $newCommentModel->getLastIDComment()['id'];
                                $newCommentModel->addImgCmt($idCmt, $image);
                            } else {
                                echo "Upload file thất bại";
                            }
                        }
                    } else {
                        if (empty($error)) {
                            if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $upload_file)) {
                                $image = $filename . '.' . $type;
                                $newCommentModel = new comment();
                                $idCmt = $newCommentModel->getLastIDComment()['id'];
                                $newCommentModel->addImgCmt($idCmt, $image);
                            } else {
                                echo "Upload file thất bại";
                            }
                        }
                    }
                }
            }
            header("Location: /productDetail?idProduct={$id_product}");
        }
    }

    public function editComment()
    {
        if (isset($_POST['editComment'])) {
            if (!empty($_POST['inputEditComment'])) {
                $inputEditCmt = $_POST['inputEditComment'];
            } else {
                $error['inputEditCmt'] = "Bình luận này không được để trống";
                exit();
            }
            $id_product = $_GET['idProduct'];
            $getIDCmt = (int) $_GET['editCmt'];
            $newCommentModel = new comment();
            $getAllCmtImg = $newCommentModel->getImgCommentById($getIDCmt);

            $newCommentModel->editCommentById($getIDCmt, $inputEditCmt);
            foreach ($getAllCmtImg as $item) {
                $delete_dir = "./public/upload/users/{$item['src']}";
                if (file_exists($delete_dir)) {
                    unlink($delete_dir);
                }
                $newCommentModel->delImgByIdCmt($getIDCmt);
            }
            if (isset($_FILES['file']) && !empty($_FILES['file'])) {
                //Thư mục chứa file upload
                $upload_dir = './public/upload/users/';
                //Xử lý upload đúng file ảnh
                $type_allow = array('png', 'jpg', 'jpeg', 'gif');

                foreach ($_FILES['file']['name'] as $key => $value) {
                    //Đường dẫn của file sau khi upload
                    $upload_file = $upload_dir . $_FILES['file']['name'][$key];
                    //PATHINFO_EXTENSION lấy đuôi file
                    $type = pathinfo($_FILES['file']['name'][$key], PATHINFO_EXTENSION);

                    if (!in_array(strtolower($type), $type_allow)) {
                        $error['type'] = "Chỉ được upload file có đuôi PNG, JPG, GIF, JPEG";
                    }

                    #Upload file có kích thước cho phép (<20mb ~ 29.000.000BYTE)
                    $file_size = $_FILES['file']['size'][$key];

                    if ($file_size > 29000000) {
                        $error['file_size'] = "Chỉ được upload file bé hơn 20MB";
                    }

                    $filename = pathinfo($_FILES["file"]["name"][$key], PATHINFO_FILENAME);

                    #Kiểm tra trùng file trên hệ thống
                    if (file_exists($upload_file)) {
                        // Xử lý đổi tên file tự động

                        #Tạo file mới
                        // TênFile.ĐuôiFile
                        $new_filename = $filename . '- Copy';
                        $new_upload_file = $upload_dir . $new_filename . $type;
                        $k = 1;

                        while (file_exists($new_upload_file)) {
                            $new_filename = $filename . " - Copy({$k})";
                            $k++;
                            $new_upload_file = $upload_dir . $new_filename . $type;
                        }
                        $filename = $new_filename;
                        $upload_file = $new_upload_file;
                    }
                    if (empty($error)) {
                        if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $upload_file)) {
                            $image = $filename . '.' . $type;
                            $getIDCmt = (int) $_GET['editCmt'];
                            $comment = new comment();
                            $comment->addImgCmt($getIDCmt, $image);
                        } else {
                            echo "Upload file thất bại";
                        }
                    }
                }
            }
            header("Location: /productDetail?idProduct={$id_product}");
        }
    }

    public function deleteComment()
    {
        $getID = (int) $_GET['reportId'];
        $getIdProduct = $_GET['idProduct'];
        $newCommentModel = new comment();
        $getAllCmtImg = $newCommentModel->getAllCmtImgByID($getID);
        foreach ($getAllCmtImg as $item) {
            $delete_file = './public/upload/users/' . $item['src'];
            unlink($delete_file);
            $newCommentModel->delImgCmtByID($item['id']);
        }
        $newCommentModel->delCmtByID($getID);
        header("Location: /productDetail?idProduct={$getIdProduct}");
    }

    public function reportComment()
    {
        $getID = $_GET['reportId'];
        $getReported = $_GET['reported'];
        $getIdProduct = $_GET['idProduct'];
        $reported = (int) $getReported + 1;
        $newCommentModel = new comment();
        if ($reported >= 5) {
            $newCommentModel->editCmtStatus($getID, 0);
        }else {
            $newCommentModel->reported($getID, $reported);
        }
        header("Location: /productDetail?idProduct={$getIdProduct}");
    }
}
?>