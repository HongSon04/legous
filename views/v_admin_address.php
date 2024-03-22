<?php
if (@$_POST['act_search']) {
    $inputSearch = $_POST['act_search'];
    $addressList = searchAddress($inputSearch);
} else {
    $addressList = getAllAddress();
}

?>
<section class="dashboard">
    <!----======== Header DashBoard ======== -->
    <div class="top">
        <i class="fas fa-angle-left sidebar-toggle"></i>
        <div class="search-box">
            <form style="width: 100%;display:flex; justify-content: center;" action="" method="post">
                <i class="far fa-search"></i>
                <input name="act_search" type="text" placeholder="Tìm kiếm...">
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
              line-height: 32px;">Địa Chỉ</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="?mod=admin&act=address" class="label-large"
                    style="text-decoration: none;">Địa Chỉ</a>
            </div>

        </div>
    </div>
    <!----======== End Header DashBoard ======== -->

    <!----======== Body DashBoard ======== -->
    <div class="containerAdmin">
        <div class="width-full d-flex align-items-center justify-content-between">
            <div class="content-filter dropdown-center width-full d-flex align-items-center justify-content-between">
                <button id="btn_addMore_admin" type="button"
                    style="width:130px;height:45px;background-color:#6750a4;border-radius:10px"><a
                        style="color: white; font-size: 12px; text-decoration: none; padding: 10px 5px;"
                        href="?mod=admin&act=address-add">Thêm địa chỉ</a></button>
                <button id="filter" class="flex-center g8" style="padding: 10px 16px;
                  border: 1px solid #79747E; border-radius: 100px;
                  margin-left: auto;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M7.5 13.5H10.5V12H7.5V13.5ZM2.25 4.5V6H15.75V4.5H2.25ZM4.5 9.75H13.5V8.25H4.5V9.75Z"
                            fill="#6750A4" />
                        <span class="label-medium fw-smb" style="color: #6750a4;">Lọc</span>
                    </svg>
                </button>
            </div>
        </div>
        <table id="example1" class="content-table width-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ Và Tên</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Địa Chỉ Chi Tiết</th>
                    <th>Phone</th>
                    <th>Khác</th>
                </tr>
            </thead>
            <tbody>
                <!-- Thêm các hàng dữ liệu vào đây -->
                <?php
                foreach ($addressList as $item) {
                    $userInfo = getUserById($item['id_user']);
                    ?>
                <tr>
                    <td>
                        <?php echo $item['id'] ?>
                    </td>
                    <td>
                        <?php echo $userInfo[0]['fullname'] ?>
                    </td>
                    <td>
                        <?php print_r($userInfo[0]['email']) ?>
                    </td>
                    <td>
                        <?php echo $item['address'] ?>
                    </td>

                    <td>
                        <?php echo $item['address_detail'] ?>
                    </td>
                    <td>
                        <?php echo $item['phone'] ?>
                    </td>
                    <td><a href="?mod=admin&act=address-edit&id=<?php echo $item['id'] ?>">Xem chi tiết</a></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- <div class="flex mt30">
          <div class="options-number flex g16" >
            <button class="primary-btn" style="padding: 10px 15px;">1</button>
            <button class="btn">2</button>
            <button class="btn">3</button>
            <button class="btn">4</button>
            <button class="btn">5</button>
            <a href="" class="flex-center g8"><i class="fa-solid fa-arrow-right"></i><span class="title-medium" >Next</span></a>
          </div>
        </div> -->
    </div>

    <!----======== End Body DashBoard ======== -->

</section>