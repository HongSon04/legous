<?php
/** render summary */
$summaryHtml = '';
$total = 0;
$totalFormated = 0;
$subTotal = 0;


foreach ($cart as $item) {
    extract($item);

    $subTotal += $price * $qty;
    $tax = $subTotal * 0.1;
    $total = $subTotal + $tax;
    $totalFormated = formatVND($subTotal + $tax);

    $priceFormated = formatVND($price);
    $summaryHtml .=
        <<<HTML
            <!-- single summary product start -->
            <div class="summary__product flex v-center">
                <div class="title-medium fw-smb summary__product__name">$name</div>
                <span style="margin-left: 1rem">x $qty</span>
                <div class="light-devider flex-full" style="margin-inline: 1rem; height: .1rem;"></div>
                <div class="summary__product__price">$priceFormated</div>
            </div>
            <!-- single summary product end -->
        HTML;
}

$disable = '';
$total < 2100000 ? $disable = 'disabled' : '';

/** render shipping methods */
$shippingMethods = getShippingMethods();
function renderShippingMethods($shippingMethods, $disable) {
    $html = '';
    if (isset($shippingMethods) && is_array($shippingMethods)) {
        foreach ($shippingMethods as $shippingMethod) {
            extract($shippingMethod);
            $priceFormated = formatVND($price);

            // Check if the shipping method is free and disable it if the total is less than 2100000
            if ($price == 0 && $disable) {
                $html .= <<<HTML
                    <!-- single shipping method start -->
                    <label class="addon-method shipping-method pi20 pb12 flex-between box-shadow1 rounded-8 disabled">
                        <div class="flex g12">
                            <input type="radio" disabled>
                            <div class="shipping-method__info flex-column flex-between">
                                <div class="title-medium fw-smb">$name</div>
                                <div class="title-small">$description</div>
                            </div>
                        </div>
                        <span class="label-large fw-smb">$priceFormated</span>
                    </label>
                    <!-- single shipping method end -->
                HTML;
            } else {
                $html .= <<<HTML
                    <!-- single shipping method start -->
                    <label for="shipping-$id" class="addon-method shipping-method pi20 pb12 flex-between box-shadow1 rounded-8">
                        <div class="flex g12">
                            <input type="radio" required name="shipping" value="$price" id="shipping-$id">
                            <div class="shipping-method__info flex-column flex-between">
                                <div class="title-medium fw-smb">$name</div>
                                <div class="title-small">$description</div>
                            </div>
                        </div>
                        <span class="label-large fw-smb">$priceFormated</span>
                    </label>
                    <!-- single shipping method end -->
                HTML;
            }
        }
    }
    return $html;
}

/** render payment method */
$paymentMethods = getPaymentMethods();
function renderPaymentMethods($paymentMethods)
{
    $html = '';
    if (isset($paymentMethods) && is_array($paymentMethods)) {
        foreach ($paymentMethods as $paymentMethod) {
            extract($paymentMethod);
            $html .=
                <<<HTML
                    <!-- single payment method start -->
                    <label for="payment-$id" class="addon-method payment-method pi20 pb12 flex-between box-shadow1 rounded-8">
                        <div class="flex g12">
                            <input type="radio" required value="$id" id="payment-$id" name="payment">
                            <div class="payment-method__info flex-column flex-between">
                                <div class="title-medium fw-smb">$name</div>
                                <div class="title-small">$description</div>
                            </div>
                        </div>
                    </label>
                    <!-- single payment method end -->
                HTML;
        }
    }
    return $html;
}

/** render user address */
$addressView = $addressDetailView = $emailView = $phoneView = $updateAddressNoti = "";
if (isset($_SESSION['userLogin']) && is_array($_SESSION['userLogin'])) {
    /** get user information */
    $userLogin = $_SESSION['userLogin'];
    extract($userLogin);
    /** get user address */
    $userAddress = getDefaultAddressByIdUser($id_user);

    if (isset($userAddress) && !empty($userAddress)) {
        $addressView = $userAddress[0]['address'];
        $addressDetailView = $userAddress[0]['address_detail'];
        $emailView = $email;
        $phoneView = $userAddress[0]['phone'];
    } else {
        $updateAddressNoti = 
            <<<HTML
                <a href="?mod=user&act=address" class="primary-text">Bạn chưa có thông tin đặt hàng mặc định! Thêm thông tin tại đây</a>
            HTML;
    }
} else {
    $updateAddressNoti =
        <<<HTML
            <a href="?mod=user&act=address" class="primary-text">Bạn chưa có thông tin mua hàng! Đăng nhập để cập nhật ngay (Bạn vẫn có thể mua hàng kể cả khi không đăng nhập)</a>
        HTML;
}
?>

<!-- cart top bar start -->
<div class="mobile-top__bar mobile-top__bar--shop p12 flex-center">
    <div class="mobile-top__inner flex-full flex-between v-center g12">
        <button class="icon-btn back-btn"><i class="fal fa-chevron-left"></i></button>
        <!-- <form action="#" class="form mobile__search-form flex-full">
            <div class="form__group width-full por">
                <button class="icon-btn poa" style="top: 50%; transform: translateY(-50%)">
                    <i class="fal fa-search"></i>
                </button>
                <input type="text" class="form__input rounded-100 width-full" style="padding-left: 4rem">
            </div>
        </form> -->
        <!-- <button class="icon-btn trash-btn"><i class="fal fa-trash-alt"></i></button> -->

        <!-- guest widget -->
        <!-- <button class="icon-btn user-btn"><i class="fal fa-user"></i></button> -->

        <!-- member widget -->
        <div class="por member-widget">
                <button class="icon-btn more-btn"><i class="far fa-ellipsis-h"></i></button>
                <ul class="poa option__list oh p10 box-shadow1 rounded-8">
                    <li class="option__item">
                        <a href="#" class="option__link ttc">trang chủ</a>
                    </li>
                    <li class="option__item">
                        <a href="#" class="option__link ttc">chia sẻ</a>
                    </li>
                    <li class="option__item">
                        <a href="#" class="option__link ttc">tìm kiếm</a>
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
<!-- cart top bar end -->

<form action="?mod=cart&act=checkout" method="post" class="checkout__form mt80">
    <!-- checkout section start -->
    <section class="checkout__section section">
        <!-- checkout title start -->
        <div class="flex-column g12 checkout__title">
            <h1 class="text-46 ">ĐỊA CHỈ ĐẶT HÀNG</h1>
            <div class="light-devider" style="height: .4rem; width: 15rem"></div>
            <div class="label-large">LEGOUS / CART / CHECKOUT</div>
        </div>
        <!-- checkout title end -->

        <div class="auto-grid g20 mt30">
            <!-- address update suggestion -->
            <!-- checkout main start -->
            <main class="checkout__main" style="grid-column: span 2">
                <!-- checkout form start -->
                <div class="checkout__main--info">
                    <div class="form__group__wrapper flex-column g12 box-shadow1 p20 rounded-8">
                        <?= $updateAddressNoti ?>
                        <div class="form__group">
                            <div class="form__label label-large fw-smb">Tỉnh/Thành phố, Quận/Huyện, Phường/Xã <span
                                    class="error60">*</span></div>
                            <input type="text" class="form__input address__input" name="address"
                                value="<?= $addressView ?>">
                            <div class="form__message"></div>
                        </div>
                        <div class="form__group">
                            <div class="form__label label-large fw-smb">Địa chỉ cụ thể <span class="error60">*</span>
                            </div>
                            <input type="text" class="form__input address-detail__input" name="address-detail"
                                value="<?= $addressDetailView ?>">
                            <div class="form__message"></div>
                        </div>
                        <div class="form__group">
                            <div class="form__label label-large fw-smb">Email <span class="error60">*</span></div>
                            <input type="text" class="form__input email__input" name="email" value="<?= $emailView ?>">
                            <div class="form__message"></div>
                        </div>
                        <div class="form__group">
                            <div class="form__label label-large fw-smb">Số điện thoại <span class="error60">*</span>
                            </div>
                            <input type="text" class="form__input phone__input" name="phone" value="<?= $phoneView ?>">
                            <div class="form__message"></div>
                        </div>
                    </div>
                    <div class="flex-column g30 box-shadow1 p20 rounded-8 mt20">
                        <div class="toggle-open-form flex v-center g8">
                            <input type="checkbox" id="openRecipientForm" onclick="toggleRecipientForm()">
                            <label for="openRecipientForm" class="label-large fw-smb" style="user-select: none;">Địa chỉ
                                giao hàng khác với địa chỉ đặt hàng</label>
                        </div>
                        <div class="form__group__wrapper flex-column g20" id="recipient__form">
                            <!-- render recipient form here -->
                        </div>
                    </div>
                </div>
                <!-- checkout form end -->
                <!-- checkout: shipping method and payment method start -->
                <div class="checkout__main--addon mt20">
                    <div class="shipping-method__wrapper p20 rounded-8 box-shadow1">
                        <div class="title-medium fw-smb">Phương thức vận chuyển <span class="error60">*</span></div>
                        <div class="shipping-methods flex-column g12 mt20">
                            <?= renderShippingMethods($shippingMethods, $disable) ?>
                        </div>
                    </div>
                    <div class="payment-method__wrapper mt20 p20 rounded-8 box-shadow1">
                        <div class="title-medium fw-smb">Phương thức thanh toán <span class="error60">*</span></div>
                        <div class="payment-methods flex-column g12 mt20">
                            <?= renderPaymentMethods($paymentMethods) ?>
                        </div>
                    </div>
                </div>
                <!-- checkout: shipping method and payment method end -->
            </main>
            <!-- checkout main end -->
            <!-- checkout summary detail start -->
            <div class="block">
                <div class="checkout-summary__detail desktop flex-column g20 p20 rounded-8 box-shadow1">
                    <div class="summary__product__wrapper flex-column g12">
                        <?= $summaryHtml ?>
                    </div>

                    <!-- <div class="light-devider" style="height: .1rem;"></div> -->

                    <div class="body-medium fw-smb">Thuế: <span class="primary-text">10%</span></div>
                    <div class="body-medium fw-smb">Phí vận chuyển: <span class="primary-text shipping-fee"> Chưa
                            có</span>
                    </div>

                    <div class="flex flex-between v-center">
                        <div class="title-large fw-smb">Tổng tiền</div>
                        <div class="light-devider flex-full" style="margin-inline: 1rem; height: .1rem;"></div>
                        <div class="summary__total primary-masking-text">
                            <?= $totalFormated ?>
                        </div>
                    </div>
                    <button type="submit" class="rounded-8 primary-btn btn" style="background: black; color: white;"><i
                            class="fal fa-arrow-right" style="color: white"></i> Đặt hàng ngay</button>
                </div>
            </div>
            <!-- checkout summary detail end -->
        </div>
    </section>
    <!-- checkout section end -->

    <!-- checkout summary start -->
    <!-- <section class="section checkout-summary auto-grid g30 desktop"> -->
    <!-- checkout summary title start -->
    <!-- <div class="checkout-summary__title flex-column g12">
            <div class="text-68">TỔNG ĐƠN</div>
            <div class="light-devider" style="height: .4rem; width: 15rem"></div>
            <div class="label-large">LEGOUS / CART / CHECKOUT</div>
        </div> -->
    <!-- checkout summary title end -->

    <!-- checkout summary detail start -->
    <!-- <div class="checkout-summary__detail flex-column g20">
            <div class="summary__product__wrapper flex-column g12">
            
            </div> -->

    <!-- <div class="light-devider" style="height: .1rem;"></div> -->

    <!-- <div class="body-medium fw-smb">Thuế: <span class="primary-text">10%</span></div>
            <div class="body-medium fw-smb">Phí vận chuyển: <span class="primary-text shipping-fee"> Chưa có</span>
            </div>

            <div class="flex flex-between v-center">
                <div class="title-large fw-smb">Tổng tiền</div>
                <div class="light-devider flex-full" style="margin-inline: 1rem; height: .1rem;"></div>
                <div class="summary__total primary-masking-text">
                </div>
            </div>
            <button type="submit" class="rounded-8 primary-btn btn" style="background: black; color: white;"><i
                    class="fal fa-arrow-right" style="color: white"></i> Đặt hàng ngay</button>
        </div> -->
    <!-- checkout summary detail end -->
    <!-- </section> -->
    <!-- checkout summary end -->

    <!-- cart bottom bar start -->
    <div class="cart__bottom-bar p10 mobile">
        <div class="cart__bottom-bar__inner rounded-8 box-shadow5 p10">
            <div class="flex-between">
                <!-- <div class="flex g12 v-center">
                    <input type="checkbox" id="checkAll">
                    <label for="checkAll" class="title-medium fw-smb primary-text" style="user-select: none">Tất cả
                        <span class="cart__amount"></span>
                    </label>
                </div> -->
                <button class="text-btn fw-smb btn rounded-100">
                    <i class="fal fa-arrow-right"></i>
                    Thêm mã giả giá
                </button>
            </div>
            <div class="flex v-center">
                <div class="title-large fw-bold">Tổng tiền</div>
                <div class="light-devider flex-full mi20" style="height: .1rem"></div>
                <div class="body-large primary-masking-text summary__total">
                    <?= $totalFormated ?>
                </div>
            </div>
            <button type="submit" class="btn bar-btn rounded-8 ttu mt12 width-full summary-btn" id="summary-btn1"
                style="background: black; color: white;">
                <i class="fal fa-arrow-right" style="color: white"></i>
                Đặt hàng ngay
            </button>
        </div>
    </div>
    <!-- cart bottom bar end -->
</form>
<script src="./public/assets/resources/js/validator.js"></script>
<script>
    function toggleRecipientForm() {
        const recipientCheckbox = document.getElementById('openRecipientForm');

        if (recipientCheckbox.checked) {
            // Checkbox is checked, send a request to retrieve and render the form
            const xhr = new XMLHttpRequest();
            xhr.open('GET', './views/libs/renderRecipientForm.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Request was successful, render the form
                        const recipientFormContainer = document.getElementById('recipient__form');
                        recipientFormContainer.innerHTML = xhr.responseText;
                    } else {
                        // Request encountered an error
                        console.error('Request error:', xhr.status);
                    }
                }
            };
            xhr.send();
        } else {
            // Checkbox is unchecked, hide the form
            const recipientFormContainer = document.getElementById('recipient__form');
            recipientFormContainer.innerHTML = '';
        }
    }
</script>
<script>
    Validator({
        formSelector: '.checkout__form',
        formGroupSelector: '.form__group',
        formMessage: '.form__message',
        submitUrl: './views/libs/checkoutHandler.php',
        // redirectUrl: './views/libs/checkoutHandler.php',
        redirectUrl: '?mod=cart&act=confirm',

        rules: [
            /** user info validation */
            Validator.isRequired('.address__input', 'Vui lòng điền địa chỉ của bạn'),
            Validator.isRequired('.address-detail__input', 'Bạn có thể điền số nhà cụ thể hoặc mô tả địa chỉ của mình!'),
            Validator.isRequired('.email__input', 'Vui lòng điền email của bạn'),
            Validator.isEmail('.email__input'),
            Validator.isRequired('.phone__input', 'Vui lòng điền số điện thoại của bạn'),
            Validator.isPhone('.phone__input'),

            /** recipient info validation */
            Validator.isRequired('.recipient-name__input'),
            Validator.isUsername('.recipient-name__input', 30),
            Validator.isRequired('.recipient-phone__input'),
            Validator.isPhone('.recipient-phone__input'),
            Validator.isRequired('.recipient-address__input'),
            Validator.isRequired('.recipient-address-detail__input'),
        ]
    })
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get the shipping method radio buttons
        var shippingRadios = document.querySelectorAll('input[name="shipping"]');

        // Add event listener to each shipping method radio button
        shippingRadios.forEach(function (radio) {
            radio.addEventListener("change", function () {
                // Get the selected shipping price
                var shippingPrice = this.value;

                // Send an AJAX request to update the summary
                updateSummary(shippingPrice);
            });
        });
    });

    function updateSummary(shippingPrice) {
        // Send an AJAX request to update the summary
        $.ajax({
            url: "./views/libs/updateSummary.php",
            method: "POST",
            data: { shippingPrice: shippingPrice },
            success: function (response) {
                console.log(response.total);
                // Parse the response and update the summary elements
                document.querySelectorAll('.summary__total').forEach(item => {
                    item.textContent = response.total;
                });
                document.querySelectorAll('.shipping-fee').forEach(item => {
                    item.textContent = response.shippingFee;
                });
                
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    }
</script>