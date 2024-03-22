<?php

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_GET['idProduct']) && $_GET['idProduct'] != 0) {
    $idProduct = $_GET['idProduct'];
    $product = getProductById($idProduct);
    $productThumbnails = getThumbnailsById($idProduct);
    $view = rand(10, 100);
    updateProductViewById($idProduct, $view);
    // print_r($productThumbnails);
    extract($product);

    $priceFormated = formatVND($price);

    $btnsHtml = '';
    $btnsHtmlMobile = '';
    $btnText = '';

    if ($qty > 0) {
        $btnText = 'MUA NGAY';
        $btnsHtml .=
            <<<HTML
                    <form action="?mod=cart&act=addCart" method="post" class="flex-column g12">
                        <button class="btn elevated-btn rounded-100" type="submit">THÊM VÀO GIỎ HÀNG</button>
                        <input type="hidden" name="name" value="$name">
                        <input type="hidden" name="price" value="$price">
                        <input type="hidden" name="img" value="$img">
                        <input type="hidden" name="id" value="$idProduct">
                        <input type="hidden" name="qty" class="data-qty" value="1">
                    </form>
                    <form action="?mod=cart&act=buyNow" method="post" class="flex-column g12">
                        <button class="btn primary-btn rounded-100" type="submit"><i class="fal fa-arrow-right"></i>MUA NGAY</button>
                        <input type="hidden" name="name" value="$name">
                        <input type="hidden" name="price" value="$price">
                        <input type="hidden" name="img" value="$img">
                        <input type="hidden" name="id" value="$idProduct">
                        <input type="hidden" name="qty" class="data-qty" value="1">
                    </form>
                HTML;
        $btnsHtmlMobile .=
            <<<HTML
                <div class="flex-between">
                    <div class="flex-column flex-between">
                        <h4 class="title-large fw-black">
                            $priceFormated
                        </h4>
                        <a href="" class="add-coupon-btn primary-text label-large fw-black">Thêm phiếu giảm giá</a>
                    </div>
                    <form action="?mod=cart&act=addCart" method="post" class="flex-column g12">
                        <button class="product__btn flex-center por">
                            <i class="far fa-cart-plus" style="
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%,-50%);
                            color: black;
                            z-index: 1"></i>
                            <input class="icon-btn fab" name="addCart" type="submit" value="">
                        </button>
                        <input type="hidden" name="name" value="$name">
                        <input type="hidden" name="price" value="$price">
                        <input type="hidden" name="img" value="$img">
                        <input type="hidden" name="id" value="$idProduct">
                        <input type="hidden" name="qty" class="data-qty" value="1">
                    </form>
                </div>
                <form action="?mod=cart&act=buyNow" method="post" class="flex-column g12">
                    <button type="submit" class="btn primary-btn rounded-8"><i class="fal fa-arrow-right"></i>
                        $btnText
                    </button>
                    <input type="hidden" name="name" value="$name">
                    <input type="hidden" name="price" value="$price">
                    <input type="hidden" name="img" value="$img">
                    <input type="hidden" name="id" value="$idProduct">
                    <input type="hidden" name="qty" class="data-qty" value="1">
                </form>
            HTML;
        ;
    } else {
        $btnText = 'ĐẶT TRƯỚC';
        $btnsHtml .=
            <<<HTML
                <button class="btn primary-btn rounded-100">$btnText</button>
            HTML;
        $btnsHtmlMobile =
            <<<HTML
                <div class="flex-between">
                    <div class="flex-column flex-between">
                        <h4 class="title-large fw-black">
                            $priceFormated
                        </h4>
                        <a href="" class="add-coupon-btn primary-text label-large fw-black">Thêm phiếu giảm giá</a>
                    </div>
                    <form action="?mod=cart&act=addCart" method="post" class="flex-column g12">
                        <button class="product__btn flex-center por" disabled>
                            <i class="far fa-cart-plus" style="
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%,-50%);
                            color: black;
                            z-index: 1"></i>
                            <input class="icon-btn fab" name="addCart" type="submit" value="">
                        </button>
                        <input type="hidden" name="name" value="$name">
                        <input type="hidden" name="price" value="$price">
                        <input type="hidden" name="img" value="$img">
                        <input type="hidden" name="id" value="$idProduct">
                        <input type="hidden" name="qty" class="data-qty" value="1">
                    </form>
                </div>
                <form action="?mod=cart&act=buyNow" method="post" class="flex-column g12">
                    <button type="submit" class="btn primary-btn rounded-8"><i class="fal fa-arrow-right"></i>
                        $btnText
                    </button>
                    <input type="hidden" name="name" value="$name">
                    <input type="hidden" name="price" value="$price">
                    <input type="hidden" name="img" value="$img">
                    <input type="hidden" name="id" value="$idProduct">
                    <input type="hidden" name="qty" class="data-qty" value="1">
                </form>
            HTML;
        ;
    }


    $idCategory = getIdCategoryByIdProducts($idProduct);
    $relatedProducts = getRelatedProduct($idCategory, 12);
    $randomProducts = getProducts(12);

    function renderCarouselProduct($products)
    {
        shuffle($products);
        $productsHtml = '';

        foreach ($products as $product) {
            extract($product);
            $imgPath = constant('PRODUCT_PATH') . $img;
            $linkToDetail = "?mod=page&act=productDetail&idProduct=$id";

            $priceView = '';
            $salePriceView = '';
            $loveBtn = '<button class="icon-btn love-btn toggle-btn" data-product-id="' . $id . '"><i class="fal fa-heart"></i></button>';

            if (isset($price) && $price > 0) {
                $priceView = '<div class="product__info__price body-medium">' . formatVND($price) . '</div>';
            } else {
                $priceView = '<div class="product__info__price body-medium">Đang cập nhật</div>';
            }

            if (isset($promotion) and $promotion > 0) {
                $salePrice = $price - $price * $promotion / 100;
                $salePriceView = '<div class="product__info__sale-price body-medium">' . formatVND($salePrice) . '</div>';
                $priceView = '<del class="product__info__price body-small">' . formatVND($price) . '</del>';
            } else {
                $salePriceView = '';
                $priceView = '<div class="product__info__price body-medium">' . formatVND($price) . '</div>';
            }

            $loveBtnClass = '';
            $loveBtnIcon = 'far fa-heart';

            if (isset($_SESSION['loveProducts']) && !empty($_SESSION['loveProducts']) && is_array($_SESSION['loveProducts'])) {
                if (in_array($id, $_SESSION['loveProducts'])) {
                    $loveBtnClass = 'active';
                    $loveBtnIcon = 'fa fa-heart';
                }
                $loveBtn = '<button class="icon-btn love-btn toggle-btn ' . $loveBtnClass . '" data-product-id="' . $id . '"><i class="' . $loveBtnIcon . '"></i></button>';
            } else {
                $loveBtn =
                    <<<HTML
                                <button class="icon-btn love-btn toggle-btn" data-product-id="$id">
                                    <i class="fal fa-heart"></i>
                                </button>
                            HTML;
            }

            $views = formatViewsNumber($views);

            $productBtn = '';
            if ($qty > 0) {
                $productBtn =
                    <<<HTML
                        <div class="flex g12 in-stock__btn-set">
                            <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                            $loveBtn
                            <form action="?mod=cart&act=addCart" method="post" class="flex-column g12">
                                <button type="submit" class="icon-btn">
                                    <i class="fal fa-cart-plus"></i>
                                </button>
                                <input type="hidden" name="name" value="$name">
                                <input type="hidden" name="price" value="$price">
                                <input type="hidden" name="img" value="$img">
                                <input type="hidden" name="id" value="$id">
                                <input type="hidden" name="qty" class="data-qty" value="1">
                            </form>
                        </div>
                    HTML;
            } else {
                $productBtn =
                    <<<HTML
                        <div class="flex g12 sold-out__btn-set">
                            <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                            <button class="icon-btn"><i class="fal fa-plus"></i></button>
                            <button class="icon-btn"><i class="fal fa-arrow-right"></i></button>
                        </div>
                    HTML;
            }

            $productsHtml .=
                <<<HTML
                <!-- single product start -->
                <div class="product product__carousel">
                    <a href="$linkToDetail" class="product__banner oh banner-contain rounded-8 por"
                        style="background-image: url($imgPath)">
                        <div class="product__overlay poa flex-center">
                            $productBtn
                        </div>
                    </a>
                    <a href="#" class="product__info">
                        <div class="product__info__name title-medium fw-smb">$name</div>
                        $priceView
                        $salePriceView
                    </a>
                    <div class="product__info flex-between width-full">
                        <div class="product__info__view body-medium">$views views</div>
                        <div class="product__info__rated flex g6 v-center body-medium">
                            4.4 <i class="fa fa-star start"></i>
                        </div>
                    </div>
                </div>
                <!-- single product end -->
            HTML;
        }
        return $productsHtml;
    }

    /** comment render */
    $comments = getProductCommentByProductId($idProduct);
    $commentHtml = '';
    foreach ($comments as $item) {
        $commentHtml .=
            <<<HTML
                    <!-- single comment start -->
                    <div class="comment__item mb30">
                        <div class="flex g12 comment__user">
                            <div class="user__avt avt"><img src="/public/assets/media/images/users/user-1.svg"
                                    alt="user 1" class="imgcover"></div>
                            <div class="flex-column flex-between">
                                <div class="user__name title-medium fw-smb">Lorem ipsum</div>
                                <div class="user-comment__date title-small">29/12/2023</div>
                            </div>
                        </div>
                        <div class="comment__content body-medium fw-normal mt12">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt cum qui voluptate! Libero est
                            vero sequi perspiciatis, ratione, praesentium, ipsam quisquam autem voluptates et minus
                            animi voluptas saepe. Asperiores, modi!
                        </div>
                    </div>
                    <!-- single comment end -->
                HTML;
    }
}
/** render gallery thumbnails */
$galleryThumbnailsHtml = '';
foreach ($productThumbnails as $item) {
    extract($item);
    $imgPath = constant('PRODUCT_PATH') . $src;
    $galleryThumbnailsHtml .=
        <<<HTML
            <div class="gallery__thumbnails__item">
                <img src="$imgPath" alt="" class="img-cover">
            </div>
        HTML;
}
if (isset($_POST['submitComment'])) {
    if (!empty($_POST['inputComment'])) {
        $inputCmt = htmlentities($_POST['inputComment']);
    }
    $getIdUser = $_SESSION['userLogin']['id_user'];
    $id_product = $_GET['idProduct'];
    $getUsername = getUserInfo($getIdUser)[0]['username'];
    $getEmail = getUserInfo($getIdUser)[0]['username'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $now = date("Y-m-d H:i:s");
    $idCmt = insertComment($getIdUser, $id_product, $getUsername, $getEmail, $inputCmt, $now);
    if (isset($_FILES['file'])) {
        //Thư mục chứa file upload
        $upload_dir = './upload/users/';

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
                        addImgCmt($idCmt, $image);
                    } else {
                        echo "Upload file thất bại";
                    }
                }
            } else {
                if (empty($error)) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $upload_file)) {
                        $image = $filename . '.' . $type;
                        addImgCmt($idCmt, $image);
                    } else {
                        echo "Upload file thất bại";
                    }
                }
            }
        }
    }
    header("Location: ?mod=page&act=productDetail&idProduct={$id_product}");
}

if (isset($_POST['editComment'])) {
    if (!empty($_POST['inputEditComment'])) {
        $inputEditCmt = $_POST['inputEditComment'];
    } else {
        $error['inputEditCmt'] = "Bình luận này không được để trống";
        exit();
    }
    $id_product = $_GET['idProduct'];
    $getIDCmt = (int) $_GET['editCmt'];
    $getAllCmtImg = getImgCommentById($getIDCmt);

    editCommentById($getIDCmt, $inputEditCmt);
    foreach ($getAllCmtImg as $item) {
        $delete_dir = "./upload/users/{$item['src']}";
        if (file_exists($delete_dir)) {
            unlink($delete_dir);
        }
        delImgByIdCmt($getIDCmt);
    }
    if (isset($_FILES['file']) && !empty($_FILES['file'])) {
        //Thư mục chứa file upload
        $upload_dir = './upload/users/';
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
                    addImgCmt($getIDCmt, $image);
                } else {
                    echo "Upload file thất bại";
                }
            }
        }
    }
    header("Location: ?mod=page&act=productDetail&idProduct={$id_product}");
}
?>

<!-- shop mobile top navigation bar start -->
<div class="mobile-top__bar mobile-top__bar--shop p12 flex-center">
    <div class="mobile-top__inner flex-full flex-between v-center g12">
        <button class="icon-btn back-btn"><i class="fal fa-chevron-left"></i></button>
        <form action="?mod=page&act=search" method="get" class="form mobile__search-form flex-full">
            <div class="form__group width-full por">
                <i class="fal fa-search poa" style="left: 2rem; top: 30%; transform: translate(-50%)"></i>
                <input type="text" name="query" class="form__input rounded-100 width-full" style="padding-left: 4rem">
            </div>
        </form>
        <a href="?mod=cart&act=viewCart" class="icon-btn cart-btn"><i class="fal fa-shopping-cart"></i></a>

        <!-- guest widget -->
        <!-- <button class="icon-btn user-btn"><i class="fal fa-user"></i></button> -->

        <!-- member widget -->
        <div class="por member-widget">
            <button class="icon-btn more-btn"><i class="far fa-ellipsis-h"></i></button>
            <ul class="poa option__list oh p10 box-shadow1 rounded-8">
                <li class="option__item">
                    <a href="?mod=page&act=home" class="option__link ttc">trang chủ</a>
                </li>
                <li class="option__item">
                    <a href="#" class="option__link ttc">chia sẻ</a>
                </li>
                <li class="option__item">
                    <a href="?mod=page&act=search" class="option__link ttc">tìm kiếm</a>
                </li>
                <li class="option__item">
                    <a href="#" class="option__link ttc">tin nhắn</a>
                </li>
                <li class="option__item">
                    <a href="#" class="option__link ttc">tài khoản của tôi</a>
                </li>
                <li class="option__item">
                    <a href="#" class="option__link ttc">báo cáo</a>
                </li>
                <li class="option__item">
                    <a href="#" class="option__link ttc">trợ giúp</a>
                </li>
                <li class="option__item">
                    <a href="#" class="option__link ttc">phản hồi</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- shop mobile top navigation bar end -->

<!-- product overview start -->
<main class="section single-product__main auto-grid g30 mt80" style="display: grid !important">
    <div class="product__gallery mobile">
        <div class="gallery__spotlight">
            <img src="./public/assets/media/images/product/<?= $img ?>" alt="" class="img-cover">
        </div>
        <div class="gallery__thumbnails flex g12 mt12">
            <?= $galleryThumbnailsHtml ?>
        </div>
    </div>
    <div class="product__gallery por desktop" style="place-items: center">
        <div class="gallery__spotlight flex-center">
            <img src="./public/assets/media/images/product/<?= $img ?>" alt="" class="img-contain">
        </div>
        <div class="gallery__thumbnails flex g12">
            <?= $galleryThumbnailsHtml ?>
        </div>
    </div>
    <div class="product__info flex-column g30" style="grid-column: span 2">
        <span class="label-large text-navagtion desktop">LEGOUS / CỬA HÀNG / SẢN PHẨM</span>
        <div class="flex-between v-center">
            <div class="product__name text-38 fw-smb" style="font-family: inherit;">
                <?= $name ?>
            </div>
            <button class="icon-btn love-btn toggle-btn mobile transparent"><i class="fal fa-heart"></i></button>
        </div>
        <div class="flex-between v-center">
            <span class="text-38 fw-normal primary-text" style="font-family: inherit;">
                <?= formatVND($price) ?>
            </span>
            <span class="label-medium">
                <?= $qty ?> sản phẩm
            </span>
        </div>
        <div class="qty__form flex v-center g12">
            Số lượng:
            <button class="minus-btn icon-btn outline-btn"><i class="fal fa-minus"></i></button>
            <input type="number" min="0" max="<?= $qty ?>" class="qty__input form__input tac"
                style="border: none; ouline: none; width: 3rem" value="1" readonly>
            <button class="plus-btn icon-btn outline-btn"><i class="fal fa-plus"></i></button>
        </div>
        <div class="flex g12 desktop">
            <?= $btnsHtml ?>
        </div>
    </div>
</main>
<!-- product overview end -->

<!-- product info start -->
<section class="product-info__section mt30">
    <div class="tab__container full">
        <div class="tabs flex-center width-full">
            <div class="tab__item active">
                <span class="tab__item__label label-large ttu tac">MÔ TẢ SẢN PHẨM</span>
            </div>
            <div class="tab__item">
                <span class="tab__item__label label-large ttu tac">THÔNG TIN CHI TIẾT</span>
            </div>
            <div class="tab__item">
                <span class="tab__item__label label-large ttu tac">ĐÁNH GIÁ</span>
            </div>
            <div class="tab__item">
                <span class="tab__item__label label-large ttu tac">THÔNG TIN ĐẶT HÀNG</span>
            </div>
        </div>
        <div class="panels">
            <div class="panel__item body-large active">
                <?= $short_detail ?>
            </div>
            <div class="panel__item body-large">
                <?= $description ?>
            </div>
            <div class="panel__item comment__panel">
                <div class="block">
                    <div class="title-large fw-black">
                        <?php
                        $productId = $_GET['idProduct'];
                        $productCmt = getProductCommentByProductId($productId);
                        $i = 0;
                        foreach ($productCmt as $item) {
                            if ($item['id_product'] == $productId) {
                                $i++;
                            }
                        }
                        ?>
                        <?php echo $i ?> comments
                    </div>
                    <?php
                    if (isset($_SESSION['userLogin'])) {
                        if (isset($_GET['editCmt'])) {
                            $getIDCmt = $_GET['editCmt'];
                            $editCmtById = getCommentById($getIDCmt);
                            $imgImtById = getImgCommentById($_GET['editCmt']);
                            $getIDProduct = $_GET['idProduct'];
                            if ($editCmtById[0]['id_user'] == $_SESSION['userLogin']['id_user']) {
                                ?>
                    <form enctype="multipart/form-data" action="" class="form comment__form" method="post">
                        <input type="file" name="file[]" id="file-1" class="inputfile inputfile-1"
                            data-multiple-caption="{count} đã chọn" multiple />
                        <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                viewBox="0 0 20 17">
                                <path
                                    d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                            </svg> <span>Chọn ảnh&hellip;</span></label>

                        <div class="flex" style="align-items: center;">
                            <input type="text" name="inputEditComment" class="form__input comment__input"
                                placeholder="Comment" value="<?php if (!empty($editCmtById))
                                                print_r($editCmtById[0]['content']) ?>">
                            <button name="editComment" value="submitComment" type="submit"
                                class="icon-btn send-comment__btn"><i class="fal fa-paper-plane"></i></button>
                        </div>
                        <?php
                                            if (!empty($imgImtById)) {
                                                ?>
                        <div class="comment_media">
                            <?php
                                            foreach ($imgImtById as $item) {
                                                ?>
                            <div class="comment_media_item">
                                <img src="./upload/users/<?php echo $item['src'] ?>" alt="">
                            </div>
                            <?php
                                            }
                                            echo "</div>";
                                            }
                                            ?>
                            <?php
                                        ?>

                    </form>
                    <?php
                            } else {
                                header("Location: ?mod=page&act=productDetail&idProduct={$getIDProduct}")

                                    ?>
                    <?php
                            }
                        } else {
                            ?>
                    <form enctype="multipart/form-data" action="" class="form comment__form" method="post">
                        <input type="file" name="file[]" id="file-1" class="inputfile inputfile-1"
                            data-multiple-caption="{count} đã chọn" multiple />
                        <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                viewBox="0 0 20 17">
                                <path
                                    d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                            </svg> <span>Chọn ảnh&hellip;</span></label>

                        <div class="flex" style="align-items: center;">
                            <input type="text" name="inputComment" id="inputComment" class="form__input comment__input"
                                placeholder="Comment">
                            <button name="submitComment" value="submitComment" type="submit"
                                class="icon-btn send-comment__btn" id="submitComment"><i
                                    class="fal fa-paper-plane"></i></button>
                        </div>
                    </form>
                    <?php
                        }
                    }
                    ?>

                </div>
                <div class="mt30 comment__wrapper">
                    <!-- product comments here  -->
                    <!-- single comment start -->
                    <?php

                    $productId = $_GET['idProduct'];
                    $productCmt = getProductCommentByProductId($productId);
                    foreach ($productCmt as $item) {
                        $getUserByID = getUserById($item['id_user']);
                        $idCmt = $item['id'];
                        $productImgCmt = getImgCommentById($idCmt);
                        if ($item['is_appear'] == 1) {
                            ?>
                    <div class="comment__item mb30 p30 box-shadow1" style="position: relative;">
                        <div class="flex comment__user">
                            <div class="flex g12">
                                <div class="user__avt avt"><img
                                        src="./upload/users/<?php echo $getUserByID[0]['img'] ?>" alt="user 1"
                                        class="imgcover"></div>
                                <div class="flex-column flex-between">
                                    <div class="user__name title-medium fw-smb">
                                        <?php
                                                if (!empty($getUserByID[0]['fullname']) || $getUserByID[0]['fullname'] != null) {
                                                    echo $getUserByID[0]['fullname'];
                                                } else {
                                                    echo "Người dùng ẩn danh";
                                                }
                                                ?>
                                    </div>
                                    <div class="user-comment__date title-small">
                                        <?php echo $item['create_date'] ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    if (isset($_SESSION['userLogin'])) {
                                        ?>
                            <div class="moreFeatureComment">
                                <ul class="ulDadMoreFeatureComment">
                                    <li class="liDadMoreFeatureComment">
                                        <div class="ellipsisBtn">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="divMoreFeatureComment box-shadow1">
                                            <ul class="ulSonMoreFeatureComment p10">
                                                <?php
                                                            if ($_SESSION['userLogin']['id_user'] == $item['id_user']) {
                                                                ?>
                                                <li class="liSonMoreFeatureComment"><a
                                                        href="?mod=page&act=productDetail&idProduct=<?php echo $productId ?>&editCmt=<?php echo $item['id'] ?>">Chỉnh
                                                        Sửa</a></li>
                                                <li class="liSonMoreFeatureComment liSonDeleteFeatureComment">
                                                    <p>Xóa</p>
                                                </li>
                                                <?php
                                                            } else {
                                                                ?>
                                                <li class="liSonMoreFeatureComment"><a
                                                        href="?mod=page&act=reportCmt&reportId=<?php echo $item['id'] ?>&reported=<?php echo $item['reported'] ?>&idProduct=<?php echo $productId ?>">Tố
                                                        Cáo</a></li>
                                                <?php
                                                            }
                                                            ?>
                                                <!-- Note: Xóa ảnh cũ khi xóa comment -->
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <?php

                                    }
                                    ?>
                        </div>
                        <div class="comment__content body-medium fw-normal mt12">
                            <p style="word-wrap: break-word;">
                                <?= $item['content'] ?>
                            </p>
                        </div>
                        <div class="comment_media">
                            <?php
                                    if (!empty($productImgCmt)) {
                                        foreach ($productImgCmt as $result) {
                                            ?>
                            <div class="comment_media_item">
                                <img src="./upload/users/<?php echo $result['src'] ?>" alt="">
                            </div>
                            <?php
                                        }
                                    }
                                    ?>
                        </div>
                        <div class="poup_item-bg" style="display: none;">
                            <div class="poup_item">
                                <p class="title-medium">Bạn có chắc chắn muốn xóa bình luận này ?</p>
                                <a class="popup_item_delete"
                                    href="?mod=page&act=delCmt&reportId=<?php echo $item['id'] ?>&idProduct=<?php echo $productId ?>"><button>Xóa</button></a>
                                <button class="popup_item_canc">Hủy</button>
                            </div>
                        </div>
                    </div>

                    <?php
                        } else {
                            ?>
                    <div class=" comment__item mb30 p30">
                        <div class="flex g12 comment__user comment__hidden">
                            <div class="user__avt avt"><img src="./upload/users/profile.jpg" alt="admin 1"
                                    class="imgcover"></div>
                            <div class="flex-column flex-between">
                                <div class="user__name title-medium fw-smb">
                                    <p>Bình luận này đang vi phạm chính sách nên đã bị ẩn</p>
                                </div>
                                <div class="user-comment__date title-small">
                                    <p>By Admin</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                        }
                    }
                    ?>
                    <!-- single comment end -->
                </div>
            </div>
            <div class="panel__item">
                <?php
                if (isset($_SESSION['userLogin']) && is_array($_SESSION['userLogin'])) {
                    $idUser = $_SESSION['userLogin']['id_user'];
                    $userAddress = get_addressByIdUser($idUser);
                    if (isset($userAddress) && !empty($userAddress)) {
                        extract($userAddress);
                        echo
                            <<<HTML
                                    <div class="bill-info__panel auto-grid g20">
                                        <div class="bill-info__box p20 rounded-8 box-shadow1 flex-column g12">
                                            <h4 class="box__title title-medium fw-smb">Người nhận</h4>
                                            <div class="box__content flex-column g12">
                                                <h4 class="title-large">$username</h4>
                                                <p class="body-medium">Sđt: $phone</p>
                                                <p class="body-medium">Email: $_SESSION[userLogin][email]</p>
                                                <p class="body-medium">Địa chỉ: $address</p>
                                                <p class="body-medium">Địa chỉ cụ thể: $address_detail</p>
                                            </div>
                                        </div>
                                        <!-- <div class="bill-info__box p20 rounded-8 box-shadow1 flex-column g12">
                                            <h4 class="box__title title-medium fw-smb">Người đặt</h4>
                                            <div class="box__content flex-column g12">
                                                <h4 class="title-large">Hồ Duy Hoàng Giang</h4>
                                                <p class="body-medium">Sđt: 0934630736</p>
                                                <p class="body-medium">Email: giang@gmail.com</p>
                                                <p class="body-medium">Địa chỉ: 212B, Baker street, London</p>
                                            </div>
                                        </div> -->
                                        <div class="bill-info__box p20 rounded-8 box-shadow1 flex-column g12">
                                            <h4 class="box__title title-medium fw-smb">Phương thức thanh toán</h4>
                                            <div class="box__content flex-column g12">
                                                <p class="body-medium">Tiền mặt</p>
                                                <label for="#" class="body-small default-label">Mặc định</label>
                                            </div>
                                        </div>
                                        <div class="bill-info__box p20 rounded-8 box-shadow1 flex-column g12">
                                            <h4 class="box__title title-medium fw-smb">Phương thức vận chuyển</h4>
                                            <div class="box__content flex-column g12">
                                                <p class="body-medium">Thông thường (25k / 3 - 5 ngày)</p>
                                                <label for="#" class="body-small default-label">Mặc định</label>
                                            </div>
                                        </div>
                                    </div>
                                HTML;
                    } else {
                        echo
                            <<<HTML
                                    <h2 class="fw-smb headline-medium tac ttu mt30 mb30 primary-text">Chưa có thông tin</h2>
                                    <a href="?mod=user&act=address" class="btn primary-btn elevated-btn rounded-100">Thêm địa chỉ</a>
                                HTML;
                    }
                } else {
                    echo
                        <<<HTML
                                <h2 class="fw-smb headline-medium tac ttu mt30 mb30 primary-text">Chưa có thông tin</h2>
                                <div class="row g12 flex-center">
                                    <a href="?mod=page&act=login" class="btn primary-btn elevated-btn rounded-100">Tạo tài khoản ngay</a>
                                    <a href="?mod=page&act=login#login-section" class="btn primary-btn rounded-100">Đăng nhập</a>
                                </div>
                            HTML;
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- product info end -->

<!-- related products section start -->
<section class="section related-product__section">
    <div class="block">
        <div class="text-38">
            SẢN PHẨM LIÊN QUAN
        </div>
        <span class="label-large">LEGOUS / SHOP / PRODUCT</span>
    </div>
    <div class="product__wrapper product__wrapper--normal product__wrapper--normal--slick__1 auto-grid g20 mt30">
        <?= renderCarouselProduct($relatedProducts) ?>
    </div>
</section>
<!-- related products section end -->

<!-- sale banner start -->
<section class="section sale-banner grid-2">
    <div class="flex-column g16">
        <div class="fw-black text-logo">Legous</div>
        <div class="flex g6 v-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                <path
                    d="M22.275 17.1375C24.675 17.25 25.2938 19.2938 25.3313 20.25H28.6875C28.5375 16.5375 25.8938 14.2688 22.2188 14.2688C18.075 14.2688 15 16.875 15 22.7625C15 26.4 16.7438 30.7125 22.2 30.7125C26.3625 30.7125 28.5938 27.6187 28.65 25.1813H25.2937C25.2375 26.2875 24.45 27.7687 22.2375 27.8813C19.7812 27.8062 18.75 25.8938 18.75 22.7625C18.75 17.3438 21.15 17.175 22.275 17.1375ZM22.5 3.75C12.15 3.75 3.75 12.15 3.75 22.5C3.75 32.85 12.15 41.25 22.5 41.25C32.85 41.25 41.25 32.85 41.25 22.5C41.25 12.15 32.85 3.75 22.5 3.75ZM22.5 37.5C14.2313 37.5 7.5 30.7687 7.5 22.5C7.5 14.2313 14.2313 7.5 22.5 7.5C30.7687 7.5 37.5 14.2313 37.5 22.5C37.5 30.7687 30.7687 37.5 22.5 37.5Z"
                    fill="white" />
            </svg>/2023
        </div>
    </div>
    <div class="flex-column g16">
        <div class="text-38">GIẢM GIÁ CỰC SỐC MỪNG
            HALLOWEEN 20%</div>
        <span class="label-large">Khi nhập mã LEGOUS20</span>
    </div>
</section>
<!-- sale banner end -->

<!-- maybe you love section start -->
<section class="section related-product__section">
    <div class="block">
        <div class="text-38">
            CÓ THỂ BẠN SẼ THÍCH
        </div>
        <span class="label-large">LEGOUS / SHOP / PRODUCT</span>
    </div>
    <div class="product__wrapper product__wrapper--normal product__wrapper--normal--slick__1 auto-grid g20 mt30">
        <?= renderCarouselProduct($randomProducts) ?>
    </div>
</section>
<!-- maybe you love section end -->

<!-- single product bottom nav bar start -->
<div class="p10 flex-center single-product__bottom-bar mobile">
    <div class="bottom-bar__inner flex-full p10 flex-column g12 rounded-12 box-shadow5">
        <?= $btnsHtmlMobile ?>
    </div>
</div>
<!-- single product bottom nav bar end -->
<script>
'use strict';;
(function(document, window, index) {
    var inputs = document.querySelectorAll('.inputfile');
    Array.prototype.forEach.call(inputs, function(input) {
        var label = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener('change', function(e) {
            var fileName = '';
            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}',
                    this.files.length);
            else
                fileName = e.target.value.split('\\').pop();

            if (fileName)
                label.querySelector('span').innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });

        // Firefox bug fix
        input.addEventListener('focus', function() {
            input.classList.add('has-focus');
        });
        input.addEventListener('blur', function() {
            input.classList.remove('has-focus');
        });
    });
}(document, window, 0));

if (document.querySelectorAll('.moreFeatureComment')) {
    document.querySelectorAll('.moreFeatureComment').forEach(function(button) {
        button.addEventListener('click', function() {
            var divMoreFeatureComment = this.querySelector('.divMoreFeatureComment');
            if (divMoreFeatureComment.style.display === 'none') {
                divMoreFeatureComment.style.display = 'block';
            } else {
                divMoreFeatureComment.style.display = 'none';
            }
        });
    });
}
</script>
<script>
var deleteButtons = document.querySelectorAll('.liSonDeleteFeatureComment');
deleteButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var commentItem = this.closest('.comment__item');
        commentItem.querySelector('.poup_item-bg').style.display = 'block';
    });
});

var cancelButtons = document.querySelectorAll('.popup_item_canc');
cancelButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var commentItem = this.closest('.comment__item');
        commentItem.querySelector('.poup_item-bg').style.display = 'none';
    });
});
</script>