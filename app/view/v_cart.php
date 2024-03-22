<?php

use App\model\Admin;
use App\model\Bill;
use App\model\Cart;
use App\model\Category;
use App\model\Comment;
use App\model\Product;
use App\model\User;
// render cart products 
$cartHtml = '';
$productSummary = '';
$cartAmount = 0;
$cartTotal = 0;
$tax = 0;
$btnLink = "";
$btnText = "";
$userCart = [];

if (isset($_SESSION['userLogin'])) {
    extract($_SESSION['userLogin']);
    if (isset($_SESSION['cart']) && key_exists($id_user, $_SESSION['cart'])) {
        $userCart = $_SESSION['cart'][$id_user]['cart'];
    }
} else {
    if (isset($_SESSION['cart']) && key_exists('guest', $_SESSION['cart'])) {
        $userCart = $_SESSION['cart']['guest'];
    }
}

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 && !empty($userCart)) {

    $btnLink = "/checkOut";
    $btnText = 'Tiếp tục';

    $cartProducts = [];
    if (!empty($userCart)) {
        $cartProducts = $userCart;
    }
    $cartAmount = count($cartProducts);

    foreach ($cartProducts as $productId => $item) {
        extract($item);
        $linkToDetail = "/productDetail?idProduct=$id_product";
        $deleteLink = "/deleteProduct?idProduct=$id_product";
        $cartTotal += $price * $qty;
        $tax = $cartTotal * 0.1;
        $imgPath = "./public/images/product/" . $img;
        $newCateModel = new category();
        $categoryName = $newCateModel->getCategoryById(intval($newCateModel->getIdCategoryByIdProducts($id_product)['id_category']))['name'];
        $formatedProductPrice = formatVND($price);
        $priceView = formatVND($item['price'] * $qty);

        $cartHtml .=
            <<<HTML
                    <!-- single cart product start -->
                    <div class="cart__product flex-between v-center g12">
                        <div class="flex g12 v-center">
                            <div class="mobile">
                                <input type="checkbox" name="product$id_product" id="product$id_product" value="$id_product">
                            </div>
                            <label for="product$id_product" class="cart__product__banner">
                                <img src="$imgPath" alt="" class="img-cover">
                            </label>
                        </div>
                        <a href="$linkToDetail" class="row g20 v-center flex-full flex-between">
                        <!-- <div class="auto-grid g20 cart__product__info"> -->
                            <div class="flex-column g12">
                                <div class="title-medium ttu cart__product__name">$name</div>
                                <div class="body-medium cart__product__category">Danh mục: $categoryName</div>
                            </div>
                            <div class="title-medium cart__product__price" data-price="$item[price]">$formatedProductPrice</div>
                            <div class="cart__product__qty__form flex g12">
                                <button class="minus-btn icon-btn"><i class="fa-solid fa-minus" data-product-id="$id_product"></i></button>
                                <input class="fw-smb primary-text qty__input form__input" type="number" name="amount" id="amount" value="$qty"
                                    min="1" max="10" readonly>
                                <button class="plus-btn icon-btn"><i class="fa-solid fa-plus" data-product-id="$id_product"></i></button>
                            </div>
                            <a href="$deleteLink" class="icon-btn desktop remove-btn" data-product-id="$id_product"><i class="fal fa-times"> </i></a>
                        </a>
                    </div>
                    <!-- single cart product end -->
                HTML;

        $productSummary .=
            <<<HTML
                    <!-- single summary product name - price start -->
                    <div class="summary__product flex v-center g12">
                        <div class="title-medium ttu summary__product__name">$name</div>X
                        <div class="title-medium summary__product__qty">$qty</div>
                        <div class="light-devider pi20 flex-full" style="height: .1rem"></div>
                        <div class="title-medium ttu summary__product__price" data-price="$item[price]">$price</div>
                    </div>
                    <!-- single summary product name - price end -->
                HTML;
    }
} else {
    $cartHtml =
        <<<HTML
                <div class="block tac">
                    <div class="text-38 primary-text">Giỏ hàng của bạn đang trống</div>
                    <a href="/product" class="btn primary-btn rounded-100">Mua sắm ngay</a>
                </div>
            HTML;

    $btnText = "Tiếp tục mua sắm";
    $btnLink = "/";
}
?>


<!-- cart top bar start -->
<div class="mobile-top__bar mobile-top__bar--shop p12 flex-center">
    <div class="mobile-top__inner flex-full flex-between v-center g12">
        <button class="icon-btn back-btn"><i class="fal fa-chevron-left"></i></button>
        <form action="#" class="form mobile__search-form flex-full">
            <div class="form__group width-full por">
                <button class="icon-btn poa" style="top: 50%; transform: translateY(-50%)">
                    <i class="fal fa-search"></i>
                </button>
                <input type="text" class="form__input rounded-100 width-full" style="padding-left: 4rem">
            </div>
        </form>
        <button class="icon-btn trash-btn"><i class="fal fa-trash-alt"></i></button>
    </div>
</div>
<!-- cart top bar end -->

<!-- cart start -->
<main class="cart__main mt80 section">
    <div class="cart__title flex-between a-end">
        <div class="flex a-end g6">
            <span class="text-46 primary-masking-text cart__amount" style="line-height: unset;">
                <?= $cartAmount ?>
            </span>
            <span class="primary-masking-text ttu">sản phẩm</span>
        </div>
        <div class="flex-column a-end g12">
            <div class="text-68 ttu">Giỏ hàng</div>
            <div class="light-devider" style="width: 10rem; height: .4rem;"></div>
            <div class="label-large ttu">legous / cart</div>
        </div>
    </div>
    <div class="auto-grid g30 mt60">
        <div class="cart__product-wrapper flex-column g20" style="grid-column: span 2">
            <?= $cartHtml ?>
        </div>
        <div class="block">
            <div class="summary__main desktop rounded-8 p20 flex-column g12 box-shadow1">
                <div class="block">
                    <div class="flex flex-between v-center">
                        <div class="title-medium fw-smb">Ưu đãi</div>
                        <button class="text-btn btn primary-text rounded-100 coupon__open--toggle-btn">
                            <i class="fal fa-arrow-right"></i>
                            Nhập mã giảm giá
                        </button>
                    </div>
                    <form action="?mod=cart&act=coupon" class="form coupon__form mt12">
                        <div class="form__group row g12 flex-between">
                            <input type="text" class="form__input coupon__input flex-full" style="max-width: 100%">
                            <button type="submit" class="primary-btn rounded-8 btn flex-full">Nhập</button>
                        </div>
                    </form>
                </div>
                <div class="flex mt12 v-center g12">
                    <div class="title-medium">Thuế: </div>
                    <div class="title medium primary-text fw-bold">10%</div>
                </div>
                <div class="flex mt12 v-center g12">
                    <div class="title-medium">Tiền sản phẩm</div>
                    <div class="light-devider flex-full pi20" style="height: .1rem; margin-inline: 1rem;"></div>
                    <div class="title medium primary-text fw-bold cart__total">
                        <?= formatVND($cartTotal) ?>
                    </div>
                </div>
                <div class="flex mt12 v-center">
                    <div class="title-large fw-smb">Tổng tiền</div>
                    <div class="light-devider flex-full pi20" style="height: .1rem; margin-inline: 1rem;"></div>
                    <div class="primary-masking-text headline-small cart__total-with-tax">
                        <?= formatVND($cartTotal + $tax) ?>
                    </div>
                </div>
                <a href="<?= $btnLink ?>" class="btn primary-btn rounded-8 ttu summary-btn" id="summary-btn1" style="background: black; color: white;">
                    <i class="fal fa-arrow-right"></i>
                    <?= $btnText ?>
                </a>
                <!-- summary total end -->
            </div>
        </div>
    </div>
</main>
<!-- cart end -->


<!-- cart bottom bar start -->
<div class="cart__bottom-bar p10 mobile">
    <div class="cart__bottom-bar__inner rounded-8 box-shadow1 p10">
        <div class="flex-between">
            <div class="flex g12 v-center">
                <input type="checkbox" id="checkAll">
                <label for="checkAll" class="title-medium fw-smb primary-text" style="user-select: none">Tất cả
                    <span class="cart__amount"><?= $cartAmount ?></span>
                </label>
            </div>
            <button class="text-btn fw-smb btn rounded-100">
                <i class="fal fa-arrow-right"></i>
                Thêm mã giả giá
            </button>
        </div>
        <div class="flex v-center">
            <div class="title-large fw-bold">Tổng tiền</div>
            <div class="light-devider flex-full mi20" style="height: .1rem"></div>
            <div class="body-large primary-masking-text cart__total-with-tax">
                <?= formatVND($cartTotal + $tax) ?>
            </div>
        </div>
        <a href="<?= $btnLink ?>" class="btn bar-btn rounded-8 ttu mt12 width-full summary-btn" id="summary-btn1" style="background: black; color: white;">
            <i class="fal fa-arrow-right"></i>
            <?= $btnText ?>
        </a>
    </div>
</div>
<!-- cart bottom bar end -->

<script>
    jQuery(document).ready(() => {
        // Function to update the summary
        function updateSummary(product) {
            var productPrice = parseFloat(product.find('.cart__product__price').attr('data-price'));
            var productQuantity = parseInt(product.find('.qty__input').val());
            var subtotal = productPrice * productQuantity;
            // product.find('.cart__product__price').text(formatCurrency(subtotal));

            // Update summary product price
            var summaryQuantity = 0;
            var summarySubtotal = 0;
            jQuery('.cart__product').each(function() {
                var cartProduct = jQuery(this);
                var cartProductPrice = parseFloat(cartProduct.find('.cart__product__price').attr('data-price'));
                var cartProductQuantity = parseInt(cartProduct.find('.qty__input').val());
                summaryQuantity += cartProductQuantity;
                summarySubtotal += cartProductPrice * cartProductQuantity;
            });
            jQuery('.summary__product__qty').text(summaryQuantity);
            jQuery('.summary__product__price').text(formatCurrency(summarySubtotal));
        }

        // Function to update the summary total
        function updateSummaryTotal() {
            var subtotal = 0;
            jQuery('.cart__product').each(function() {
                var product = jQuery(this);
                var productPrice = parseFloat(product.find('.cart__product__price').attr('data-price'));
                var productQuantity = parseInt(product.find('.qty__input').val());
                subtotal += productPrice * productQuantity;
            });

            var tax = subtotal * 0.1; // Calculate 10% tax
            var total = subtotal + tax;

            jQuery('.cart__total').text(formatCurrency(subtotal));
            jQuery('.cart__total-with-tax').text(formatCurrency(total));
        }

        // AJAX to update quantity
        jQuery(".plus-btn, .minus-btn").on('click', function() {
            var product = jQuery(this).closest('.cart__product');
            var productId = jQuery(this).find('i').data("product-id");
            var action = jQuery(this).hasClass("plus-btn") ? "increase" : "decrease";

            jQuery.ajax({
                type: "POST",
                url: "./app/library/lb_updateCart.php",
                data: {
                    action: action,
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        product.find('.qty__input').val(response.quantity);
                        updateSummary(product);
                        updateSummaryTotal();
                    } else {
                        alert("Failed to update quantity.");
                    }
                },
                error: function() {
                    alert("An error occurred while updating the quantity.");
                }
            });
        });

        // Function to format currency
        function formatCurrency(value) {
            var formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            return formatter.format(value);
        }
    });



    // remove product mobile
    $(document).ready(function() {
        $('.trash-btn').on('click', function(e) {
            e.preventDefault();
            //  Get all the checked checkboxes within the cart products
            var checkedCheckboxes = $('.cart__product input[type="checkbox"]:checked');

            // Create an array to store the product IDs
            var productIds = [];

            // Iterate over the checked checkboxes and retrieve the product IDs
            checkedCheckboxes.each(function() {
                var productId = $(this).val();
                productIds.push(productId);
            });

            $.ajax({
                url: './views/libs/removeProduct.php',
                type: 'POST',
                data: JSON.stringify({
                    productIds: productIds
                }),
                dataType: 'json',
                contentType: 'application/json',
                success: function(response) {
                    // Update the cart HTML by replacing the content of the "cart__product-wrapper" element
                    $('.cart__product-wrapper').html(response.cartHtml);

                    // Update the cart total and amount elements on the page
                    $('.cart__total').text(response.cartInfo.cartTotal);
                    $('.cart__amount').text(response.cartInfo.cartAmount);
                    $('.cart__total-with-tax').text(response.cartInfo.cartTotalWithTax);
                    $('.summary-btn').text(response.cartInfo.btnText);
                    $('.summary-btn').attr("href", response.cartInfo.btnLink);
                },
                error: function() {
                    // Handle error if the request fails
                    console.log('An error occurred while removing the product.');
                }
            });
        });
    });
</script>