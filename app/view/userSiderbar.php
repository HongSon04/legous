<div class="main__inner--bottom-left">
    <ul class="menu__destop--ul">
        <li class="menu__destop--li <?=$active__general?>"><a href="/profileUser">Tổng Quan</a></li>
        <li class="menu__destop--li <?=$active__profile?>"><a href="/editProfileUser">Chỉnh sửa thông tin</a></li>
        <li class="menu__destop--li <?=$active__password?>"><a href="/passwordUser">Mật khẩu</a></li>
        <li class="menu__destop--li <?=$active__address?>"><a href="/addressUser">Địa chỉ</a></li>
        <li class="menu__destop--li <?=$active__order?>"><a href="/historyOrderUser">Lịch sử đơn hàng</a></li>
        <li class="menu__destop--li"><a href="/logout">Đăng xuất</a></li>
        <li class=" menu__destop--li delete__acccount <?=$active__deleteAccount?>"><a href="?mod=user&act=delete-account">Xóa tài khoản</a></li>
    </ul>

    <!-- menu mobile start -->
    <div class="box__menu--mobile">
        <ul class="menu__mobile--ul">
            <li class="menu__mobile--li">
                <a href="/profileUser">
                    <i class="fas fa-home"></i>
                    <span>Tổng quan</span>
                </a>
            </li>
            <li class="menu__mobile--li">
                <a href="/editProfileUser">
                    <i class="fas fa-edit"></i>
                    <span>Chỉnh sửa</span>
                </a>
            </li>
            <li class="menu__mobile--li">
                <a href="/passwordUser">
                    <i class="fas fa-lock"></i>
                    <span>Mật khẩu</span>
                </a>
            </li>
            <li class="menu__mobile--li">
                <a href="/addressUser">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Địa chỉ</span>
                </a>
            </li>
            <li class="menu__mobile--li">
                <a href="/historyOrderUser">
                    <i class="fas fa-history"></i>
                    <span>Đơn hàng</span>
                </a>
            </li class="menu__mobile--li">
            <li class="menu__mobile--li">
                <a href="/logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>
            </li>
            <li class="delete__acccount menu__mobile--li">
                <a href="?mod=user&act=delete-account">
                    <i class="fas fa-user-times"></i>
                    <span>Xóa tài khoản</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- menu mobile end -->
</div>