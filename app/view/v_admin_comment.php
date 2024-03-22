<?php

use App\model\Comment;
use App\model\User;
use App\model\Bill;

?>
<section class="dashboard">

    <div class="flex-column p30 g30" style="align-self: stretch; align-items: flex-start;">
        <div class="text">
            <h1 class="label-large-prominent" style="font-size: 24px;
              line-height: 32px;">Bình Luận</h1>
        </div>
        <!--DateTimelocal-->
        <div class="flex-between width-full" style="gap: 8px;
            align-items: center;">
            <div class="flex g8">
                <span class="label-large">Admin /</span><a href="/adminComment" class="label-large" style="text-decoration: none;">Bình Luận</a>
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
                        $newUserModel = new User();
                        $getUserByID = $newUserModel->getUserInfo($comment['id_user']);
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
                                    <td><a href="/adminCommentHidden?id=<?php echo $comment['id'] ?>">Ẩn</a> / <a href="/adminCommentDelete?id=<?php echo $comment['id'] ?>">Xóa</a></td>
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
                                    <td><a href="/adminCommentShow?id=<?php echo $comment['id'] ?>">Hiện</a> / <a href="/adminCommentDelete?id=<?php echo $comment['id'] ?>">Xóa</a></td>
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
                                    <td><a href="/adminCommentHidden?id=<?php echo $comment['id'] ?>">Ẩn</a> / <a href="/adminCommentDelete?id=<?php echo $comment['id'] ?>">Xóa</a></td>
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