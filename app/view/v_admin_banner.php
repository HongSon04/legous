<?php

use App\model\Bill;
use App\model\User;
use App\model\Comment;
use App\model\Address;
?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->

    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Banner</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="#" class="label-large" style="text-decoration: none;">Banner</a>
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
                        <img src="./public/images/banners/carousel itachi.png" alt="banner">
                    </div>
                    <div id="img_banner" class="img_banner_admin-options trans-bounce col-12">
                        <img src="./public/images/banners/carouselsasuke.png" alt="banner">
                    </div>
                    <div id="img_banner" class="img_banner_admin-options trans-bounce col-12">
                        <img src="./public/images/banners/carousel luffy.png" alt="banner">
                    </div>

                    <a href="#!" class="width-full">
                        <div class="img_banner_admin_add trans-bounce flex-center col-12">
                            <i class="fa-solid fa-plus display-medium"></i>
                        </div>
                    </a>

                </div>

                <div class="banner_admin_right d-flex flex-column g16 col-10">
                    <div id="banner" class="banner_admin active d-inline-flex justify-content-between col-12 trans-bounce" style="padding: 53px 100px;">
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
                                <img src="./public/images/banners/itachi-susano_banner.svg" alt="">
                            </div>
                        </div>
                    </div>

                    <div id="banner" class="banner_admin d-inline-flex justify-content-between col-12" style="padding: 53px 100px;">
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
                                <img src="./public/images/banners/sasuke-susano_banner.svg" alt="">
                            </div>
                        </div>
                    </div>

                    <div id="banner" class="banner_admin d-inline-flex justify-content-between col-12" style="padding: 53px 100px;">
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
                                <img src="./public/images/banners/luffy_banner.svg" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="options_banner_admin d-flex  flex-column col-12 g16">
                        <div class="text-options d-inline-flex">
                            <span class="title-medium">Chọn giao diện</span>
                        </div>
                        <div class="container-options_banner d-inline-flex g20 col-12">
                            <div class="options_banner active col-4 trans-bounce">
                                <img src="./public/images/banners/bannerselect1.png" alt="">
                            </div>
                            <div class="options_banner col-4 trans-bounce">
                                <img src="./public/images/banners/bannerselect2.png" alt="">
                            </div>
                            <div class="options_banner col-4 trans-bounce">
                                <img src="./public/images/banners/bannerselect3.png" alt="">
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