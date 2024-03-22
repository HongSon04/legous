<section class="dashboard">
    <!----======== Header DashBoard ======== -->
    <div class="top">
        <i class="fas fa-angle-left sidebar-toggle"></i>
        <div class="search-box">
            <form style="width: 100%;display:flex; justify-content: center;" action="" method="post">
                <i class="far fa-search"></i>
                <input type="text" placeholder="Tìm kiếm...">
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
              line-height: 32px;">Bình Luận</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="?mod=admin&act=comments" class="label-large"
                    style="text-decoration: none;">Bình Luận</a>
            </div>
        </div>
    </div>
    <!----======== End Header DashBoard ======== -->

    <!----======== Body DashBoard ======== -->
    <div class="containerAdmin">

        <table id="example1" class="content-table width-full">
            <thead>
                <tr>

                    <th>ID</th>
                    <th>Họ Và Tên</th>
                    <th>Email</th>
                    <th>Bị Tố cáo</th>
                    <th>Bình Luận</th>
                    <th>Tạo Ngày</th>
                    <th>Khác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($getComment)) {
                    foreach ($getComment as $comment) {
                        $getUserByID = getUserInfo($comment['id_user']);
                        foreach ($getUserByID as $item) {
                            ?>
                            <?php
                            if ($comment['reported'] > 0 && $comment['is_appear'] == 1) {
                                ?>
                                <tr class="reported" style="background: #f8d7da; border-color: #f5c6cb">
                                    <td>
                                        <?php echo $comment['id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $item['fullname'] ?>
                                    </td>
                                    <td>
                                        <?php echo $item['email'] ?>
                                    </td>
                                    <td>
                                        <?php echo $comment['reported'] ?>
                                    </td>
                                    <td style="width: 300px; max-width: 300px;">
                                        <p>
                                            <?php echo $comment['content'] ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $comment['create_date'] ?>
                                        </p>
                                    </td>
                                    <td><a href="?mod=admin&act=hiddenCmt&id=<?php echo $comment['id'] ?>">Ẩn</a> / <a
                                            href="?mod=admin&act=delCmt&id=<?php echo $comment['id'] ?>">Xóa</a></td>
                                </tr>
                                <?php
                            } elseif ($comment['is_appear'] == 0) {
                                ?>
                                <tr class="notAppear">
                                    <td>
                                        <?php echo $comment['id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $item['fullname'] ?>
                                    </td>
                                    <td>
                                        <?php echo $item['email'] ?>
                                    </td>
                                    <td>
                                        <?php echo $comment['reported'] ?>
                                    </td>
                                    <td style="width: 300px; max-width: 300px;">
                                        <p>
                                            <?php echo $comment['content'] ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $comment['create_date'] ?>
                                        </p>
                                    </td>
                                    <td><a href="?mod=admin&act=showCmt&id=<?php echo $comment['id'] ?>">Hiện</a> / <a
                                            href="?mod=admin&act=delCmt&id=<?php echo $comment['id'] ?>">Xóa</a></td>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $comment['id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $item['fullname'] ?>
                                    </td>
                                    <td>
                                        <?php echo $item['email'] ?>
                                    </td>
                                    <td>
                                        <?php echo $comment['reported'] ?>
                                    </td>
                                    <td style="width: 300px; max-width: 300px;">
                                        <p>
                                            <?php echo $comment['content'] ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $comment['create_date'] ?>
                                        </p>
                                    </td>
                                    <td><a href="?mod=admin&act=hiddenCmt&id=<?php echo $comment['id'] ?>">Ẩn</a> / <a
                                            href="?mod=admin&act=delCmt&id=<?php echo $comment['id'] ?>">Xóa</a></td>
                                </tr>
                                <?php

                            }
                            ?>
                            <?php
                        }
                    }
                }
                ?>
                <!-- Thêm các hàng dữ liệu vào đây -->
            </tbody>
        </table>

    </div>
    </div>

    <!----======== End Body DashBoard ======== -->

</section>