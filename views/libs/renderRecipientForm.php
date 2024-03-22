<?php 
    echo
        <<<HTML
            <div class="title-medium fw-bold ttu">địa chỉ giao hàng</div>
            <div class="form__group">
                <div class="form__label label-large fw-smb">Tên người nhận <span class="error60">*</span></div>
                <input type="text" class="form__input recipient-name__input" name="recipient-name">
                <div class="form__message"></div>
            </div>
            <div class="form__group">
                <div class="form__label label-large fw-smb">Số điện thoại <span class="error60">*</span></div>
                <input type="text" class="form__input recipient-phone__input" name="recipient-phone">
                <div class="form__message"></div>
            </div>
            <div class="form__group">
                <div class="form__label label-large fw-smb">Tỉnh/Thành phố, Quận/Huyện, Phường/Xã <span class="error60">*</span></div>
                <input type="text" class="form__input recipient-address__input" name="recipient-address">
                <div class="form__message"></div>
            </div>
            <div class="form__group">
                <div class="form__label label-large fw-smb">Địa chỉ cụ thể <span class="error60">*</span></div>
                <input type="text" class="form__input recipient-address-detail__input" name="recipient-address-detail">
                <div class="form__message"></div>
            </div>
        HTML;
?>