<section class="dashboard">
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
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Banner</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="#" class="label-large"
                    style="text-decoration: none;">Banner</a>
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
        <div class="box-banner flex-column width-full">
            <div class="container-banner_admin d-flex g20 col-12">

                <div class="banner_admin_left flex-column g20 col-2">
                    <div id="img_banner" class="img_banner_admin-options active trans-bounce col-12">
                        <img src="./public/assets/media/images/banners/carousel itachi.png" alt="banner">
                    </div>
                    <div id="img_banner" class="img_banner_admin-options trans-bounce col-12">
                        <img src="./public/assets/media/images/banners/carouselsasuke.png" alt="banner">
                    </div>
                    <div id="img_banner" class="img_banner_admin-options trans-bounce col-12">
                        <img src="./public/assets/media/images/banners/carousel luffy.png" alt="banner">
                    </div>

                    <a href="#!" class="width-full">
                        <div class="img_banner_admin_add trans-bounce flex-center col-12">
                            <i class="fa-solid fa-plus display-medium"></i>
                        </div>
                    </a>

                </div>

                <div class="banner_admin_right d-flex flex-column g16 col-10">
                    <div id="banner"
                        class="banner_admin active d-inline-flex justify-content-between col-12 trans-bounce"
                        style="padding: 53px 100px;">
                        <div class="content_banner_left col-8">
                            <div class="text_right_banner flex-column g30">
                                <div class="text_main_banner">
                                    <span>ITACHI - SUSANO RIBCAGE</span>
                                </div>
                                <div class="text_bottom">
                                    <p class="label-medium">Khám phá những mô hình thú vị và độc đáo cùng với LEGOUS!
                                        Tại đây, chúng tôi
                                        cung cấp những mô hình với đa dạng nhân vật và các chủ đề khác nhau, hứa hẹn sẽ
                                        đáp ứng được nhu cầu
                                        mua sắp của bạn.</p>
                                </div>
                                <div class="content_btn_banner_admin d-flex col-12">
                                    <div class="btn-banner_left align-items-center d-flex col-4">
                                        <button class="d-inline-flex box-shadow1"><span class="label-large">Mua
                                                ngay</span></button>
                                    </div>
                                    <div class="btn-banner_right d-flex align-items-center col-9">
                                        <button class="d-inline-flex box-shadow1">
                                            <i class="fa-solid fa-arrow-right label-large"></i>
                                            <span class="label-large">Đến cửa hàng</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content_banner_right col-4">
                            <div class="img_banner_admin trans-bounce">
                                <img src="./public/assets/media/images/banners/itachi-susano_banner.svg" alt="">
                            </div>
                        </div>
                    </div>

                    <div id="banner" class="banner_admin d-inline-flex justify-content-between col-12"
                        style="padding: 53px 100px;">
                        <div class="content_banner_left col-8">
                            <div class="text_right_banner flex-column g30">
                                <div class="text_main_banner">
                                    <span>SASUKE - SUSANO TOÀN THÂN THỂ</span>
                                </div>
                                <div class="text_bottom">
                                    <p class="label-medium">Khám phá những mô hình thú vị và độc đáo cùng với LEGOUS!
                                        Tại đây, chúng tôi
                                        cung cấp những mô hình với đa dạng nhân vật và các chủ đề khác nhau, hứa hẹn sẽ
                                        đáp ứng được nhu cầu
                                        mua sắp của bạn.</p>
                                </div>
                                <div class="content_btn_banner_admin d-flex col-12">
                                    <div class="btn-banner_left align-items-center d-flex col-4">
                                        <button class="d-inline-flex box-shadow1"><span class="label-large">Mua
                                                ngay</span></button>
                                    </div>
                                    <div class="btn-banner_right d-flex align-items-center col-9">
                                        <button class="d-inline-flex box-shadow1">
                                            <i class="fa-solid fa-arrow-right label-large"></i>
                                            <span class="label-large">Đến cửa hàng</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content_banner_right col-4">
                            <div class="img_banner_admin">
                                <img src="./public/assets/media/images/banners/sasuke-susano_banner.svg" alt="">
                            </div>
                        </div>
                    </div>

                    <div id="banner" class="banner_admin d-inline-flex justify-content-between col-12"
                        style="padding: 53px 100px;">
                        <div class="content_banner_left col-8">
                            <div class="text_right_banner flex-column g30">
                                <div class="text_main_banner">
                                    <span id="textmainproduct">MÔ HÌNH LUFFY GEAR 5 XỊN XÒ</span>
                                </div>
                                <div class="text_bottom">
                                    <p id="text-description" class="label-medium">Khám phá những mô hình thú vị và độc
                                        đáo cùng với
                                        LEGOUS! Tại đây, chúng tôi cung cấp những mô hình với đa dạng nhân vật và các
                                        chủ đề khác nhau, hứa
                                        hẹn sẽ đáp ứng được nhu cầu mua sắp của bạn.</p>
                                </div>
                                <div class="content_btn_banner_admin d-flex col-12">
                                    <div class="btn-banner_left align-items-center d-flex col-4">
                                        <button class="d-inline-flex box-shadow1"><span class="label-large">Mua
                                                ngay</span></button>
                                    </div>
                                    <div class="btn-banner_right d-flex align-items-center col-9">
                                        <button class="d-inline-flex box-shadow1">
                                            <i class="fa-solid fa-arrow-right label-large"></i>
                                            <span class="label-large">Đến cửa hàng</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content_banner_right col-4">
                            <div class="img_banner_admin">
                                <img src="./public/assets/media/images/banners/luffy_banner.svg" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="options_banner_admin d-flex  flex-column col-12 g16">
                        <div class="text-options d-inline-flex">
                            <span class="title-medium">Chọn giao diện</span>
                        </div>
                        <div class="container-options_banner d-inline-flex g20 col-12">
                            <div class="options_banner active col-4 trans-bounce">
                                <img src="./public/assets/media/images/banners/bannerselect1.png" alt="">
                            </div>
                            <div class="options_banner col-4 trans-bounce">
                                <img src="./public/assets/media/images/banners/bannerselect2.png" alt="">
                            </div>
                            <div class="options_banner col-4 trans-bounce">
                                <img src="./public/assets/media/images/banners/bannerselect3.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!----======== End Body DashBoard ======== -->

</section>
<script>
const $ = document.querySelector.bind(document)
const $$ = document.querySelectorAll.bind(document) 

const imgbanners = $$('#img_banner');
const banners = $$('#banner');
const option = $$('.options_banner');

imgbanners.forEach((img, index) => {
    const bannerselect = banners[index];
    img.onclick = function() {
        $('.img_banner_admin-options.active').classList.remove('active');
        $('.banner_admin.active').classList.remove('active');


        this.classList.add('active');
        bannerselect.classList.add('active');
        if (index == 1) {
            bannerselect.style.background = 'linear-gradient(110deg, #5E007E 14.03%, #A000D8 96.4%)';

        }
        if (index == 2) {
            $('#text-description').style.color = 'black';
            $('#textmainproduct').style.color = '#5E007E';
            bannerselect.style.background = 'white';

        }
    };
});

option.forEach((options) => {
    options.onclick = function() {
        $('.options_banner.active').classList.remove('active');
        this.classList.add('active');
    }
});
</script>