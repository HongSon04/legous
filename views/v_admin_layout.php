<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/assets/resources/sass/css/app.css">
    <link rel="icon" type="image/x-icon" href="./public/assets/media/images/favicon/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"
        type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Space+Mono&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./public/assets/resources/sass/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="./public/assets/resources/js/jquery.js"></script>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <title>Admin Dashboard Panel</title>
</head>

<body>
    <!--===== Header Responsive Mobile =====-->
    <div class="headMobie">
        <div class="col-12 d-flex justify-content-around align-items-center">
            <div id="menuButton" style="padding-left: 30px;" class="col-4"><i class="fas fa-bars"></i></div>
            <div class="col-4">
                <a href="#">
                    <div class="logo-name d-flex justify-content-center align-items-center">
                        <div class="logo-image">
                            <img style="width: 20px; height: 20px;" src="./public/assets/media/images/logo.png" alt="">
                        </div>

                        <span class="logo_name title-large fw-black" style="color: black;">LEGOUS</span>
                    </div>
                </a>
            </div>
            <div id="searchButtonBar" class="col-4 text-end" style="margin-right: 30px;"><i class="far fa-search "></i>
            </div>
        </div>
    </div>
    <div class="navBarMobile">
        <div class="navBarMobile_item">
            <div class="close-button" id="closeButton">
                <!-- Add the close button here -->
                <i class="fas fa-times"></i>
            </div>
            <ul>
                <li><a class="title-large" href="?mod=admin&act=home">Bảng Điều Khiển</a></li>
                <li><a class="title-large" href="?mod=admin&act=products">Sản Phẩm</a></li>
                <li><a class="title-large" href="?mod=admin&act=categories">Danh Mục</a></li>
                <li><a class="title-large" href="?mod=admin&act=orders">Đơn Hàng</a></li>
                <li><a class="title-large" href="?mod=admin&act=client">Khách Hàng</a></li>
                <li><a class="title-large" href="?mod=admin&act=address">Địa Chỉ</a></li>
                <li><a class="title-large" href="?mod=admin&act=comments">Bình Luận</a></li>
                <li><a class="title-large" href="?mod=admin&act=banner">Banner</a></li>
                <li><a class="title-large" href="?mod=admin&act=coupon">Mã Giảm Giá</a></li>
                <li><a class="title-large" href="?mod=user&act=logOut-account">Đăng Xuất</a></li>
            </ul>
        </div>
    </div>
    <div class="searchBarMobile">
        <div class="close-button" id="closeButton1">
            <!-- Add the close button here -->
            <i class="fas fa-times"></i>

        </div>
        <div class="search-box">
            <input type="text" placeholder="Tìm Kiếm Tại Đây...">
            <i class="far fa-search"></i>
        </div>
    </div>

    <!--===== End Header Responsive Mobile =====-->
    <main id="mainAdmin">

        <nav>
            <div class="logo-name">
                <div class="logo-image">
                    <img src="./public/assets/media/images/logo.png" alt="">
                </div>

                <span class="logo_name display-small fw-black">LEGOUS</span>
            </div>

            <div class="menu-items">
                <ul class="nav-links">
                    <li class="<?= (strpos($view_name, 'home')) ? 'active' : '' ?>"><a href="?mod=admin&act=home">
                            <i class="far fa-chart-line"></i>
                            <span class="link-name title-small">Bảng Điều Khiển</span>
                        </a></li>
                    <li class="<?= (strpos($view_name, 'products')) ? 'active' : '' ?>"><a
                            href="?mod=admin&act=products&page=1">
                            <i class="far fa-store"></i>
                            <span class="link-name title-small">Sản Phẩm</span>
                        </a></li>
                    <li class="<?= (strpos($view_name, 'categories')) ? 'active' : '' ?>"><a
                            href="?mod=admin&act=categories&page=1">
                            <i class="fal fa-clipboard-list-check"></i>
                            <span class="link-name title-small">Danh Mục</span>
                        </a></li>
                    <li class="<?= (strpos($view_name, 'orders')) ? 'active' : '' ?>"><a href="?mod=admin&act=orders">
                            <i class="fal fa-shopping-bag"></i>
                            <span class="link-name title-small">Đơn Hàng</span>
                        </a></li>
                    <li class="<?= (strpos($view_name, 'client')) ? 'active' : '' ?>"><a href="?mod=admin&act=client">
                            <i class="fal fa-user"></i>
                            <span class="link-name title-small">Khách Hàng</span>
                        </a></li>
                    <li class="<?= (strpos($view_name, 'address')) ? 'active' : '' ?>"><a href="?mod=admin&act=address">
                            <i class="far fa-location"></i>
                            <span class="link-name title-small">Địa chỉ</span>
                        </a></li>
                    <li class="<?= (strpos($view_name, 'comments')) ? 'active' : '' ?>"><a
                            href="?mod=admin&act=comments">
                            <i class="far fa-comments"></i>
                            <span class="link-name title-small">Bình luận</span>
                        </a></li>
                    <li class="<?= (strpos($view_name, 'banner')) ? 'active' : '' ?>"><a href="?mod=admin&act=banner">
                            <i class="fal fa-images"></i>
                            <span class="link-name title-small">Banner</span>
                        </a></li>
                    <li class="<?= (strpos($view_name, 'coupon')) ? 'active' : '' ?>"><a href="?mod=admin&act=coupon">
                            <i class="far fa-ticket"></i>
                            <span class="link-name title-small">Mã Giảm Giá</span>
                        </a></li>

                </ul>

                <ul class="logout-mode">
                    <li><a href="?mod=user&act=logOut-account">
                            <i class="far fa-sign-out-alt"></i>
                            <span class="link-name title-small">Logout</span>
                        </a></li>

                    <li class="mode">
                        <a href="#">
                            <i class="far fa-moon-stars"></i>
                            <span class="link-name title-small">Dark Mode</span>
                        </a>

                        <div class="mode-toggle">
                            <span class="switch"></span>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <?php
        require_once 'v_' . $view_name . '.php';
        // require_once 'v_admin_home.php';
        ?>

    </main>

    <!-- Owl Carousel JS -->
    <script src="./public/assets/resources/js/owl.carousel.min.js"></script>
    <script src="./public/assets/resources/js/admin.js"></script>
    <!----======== Bootstrap ======== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>




    </script>
    <script>
        $('.owl-carousel').owlCarousel({
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1100: {
                    items: 3
                },
                1440: {
                    items: 4
                }

            }
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./public/assets/resources/js/jquery.dataTables.min.js"></script>
    <script src="./public/assets/resources/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>