<script>
    // love buttons handler
    $(document).ready(function () {
        $('.love-btn').click(function () {
            var button = $(this);
            var productId = button.data('product-id');

            // Disable the love button
            button.prop('disabled', true);

            // Make an AJAX request to update the love value
            $.ajax({
                url: './views/libs/update_love.php', // Replace with the correct path to your PHP script
                method: 'POST', // HTTP method (GET, POST, etc.)
                data: { product_id: productId }, // Data to send to the server, e.g., product ID
                success: function (response) {
                    // Handle the response from the server if needed
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    // Enable the love button if there was an error
                    button.prop('disabled', false);
                }
            });
        });
    });
</script>


<?php

/** render feature products */
$featureProductsHtml = '';
foreach ($featureProducts as $item) {
    extract($item);

    $imgPath = constant('PRODUCT_PATH') . $img;

    $priceView = '';
    $salePriceView = '';
    $loveBtn = '<button class="icon-btn love-btn toggle-btn" data-product-id="' . $id . '"><i class="fal fa-heart"></i></button>';

    if (isset($price) && $price > 0) {
        $priceView = '<h4 class="title-medium feature-product__price">' . formatVND($price) . '</h4>';
    } else {
        $priceView = '<h4 class="title-medium feature-product__price">Đang cập nhật</h4>';
    }

    if (isset($promotion) and $promotion > 0) {
        $salePrice = $price - $price * $promotion / 100;
        $salePriceView = '<div class="feature-product__price--sale-price title-medium">' . formatVND($salePrice) . '</div>';
        $priceView = '<del class="feature-product__price body-small">' . formatVND($price) . '</del>';
    } else {
        $salePriceView = '';
        $priceView = '<h4 class="title-medium feature-product__price">' . formatVND($price) . '</h4>';
    }

    $featureProductsHtml .=
        <<<HTML
            <a href="?mod=page&act=singleProduct&idProduct=$id" class="feature-product feature-product__carousel flex g12 p20 rounded-8">
                <div class="feature-product__banner">
                    <img src="$imgPath" alt="" class="img-cover">
                </div>
                <div class="block">
                    <div class="feature-product__content flex-column g8">
                        <h4 class="title-medium feature-product__name">$name</h4>
                        $priceView
                        $salePriceView
                    </div>
                    <div class="product-btns flex g12">
                        <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                        $loveBtn
                        <button class="icon-btn"><i class="fal fa-shopping-cart"></i></button>
                    </div>
                </div>
            </a>
        HTML;
}

/** render regular product */
$productHtml = '';

// Number of products per page
$productsPerPage = 20;

// Current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $productsPerPage;

// Fetch products from the database with LIMIT and OFFSET
$categoryProducts = getCategoryProductWithLimitAndOffset($productsPerPage, $offset, $idCategory);

// Fetch total number of products from the database
$totalProducts = count(getProductsByCategoryId($idCategory));

// Calculate the total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);

// pagination render 
$paginationHtml = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $linkToPage = "?mod=page&act=category&idCategory=$idCategory&page=$i";
        $active = '';
    if ($page == $i) {
        $active = 'active';
    }
    $paginationHtml .=
        <<<HTML
            <li class="pagination__item $active"><a href="$linkToPage" class="pagination__link">$i</a></li>
        HTML;
}
$nextPage = $page + 1;

if ($nextPage >= $totalPages) {
    $linkToNextPage = "";
} else {
    $linkToNextPage = "?mod=page&act=category&idCategory=$idCategory&page=$nextPage";
}

foreach ($categoryProducts as $item) {
    extract($item);
    $imgPath = constant('PRODUCT_PATH') . $img;
    $linkToDetail = "?mod=page&act=productDetail&idProduct=$id";

    $priceView = '';
    $salePriceView = '';

    if (isset($price) && $price > 0) {
        $priceView = '<div class="product__info__price body-large primary-text fw-bold">' . formatVND($price) . '</div>';
    } else {
        $priceView = '<div class="product__info__price body-large primary-text fw-bold">Đang cập nhật</div>';
    }

    if (isset($promotion) and $promotion > 0) {
        $salePrice = $price - $price * $promotion / 100;
        $salePriceView = '<div class="product__info__sale-price body-large primary-text fw-bold">' . formatVND($salePrice) . '</div>';
        $priceView = '<del class="product__info__price body-large primary-text fw-bold">' . formatVND($price) . '</del>';
    } else {
        $salePriceView = '';
        $priceView = '<div class="product__info__price body-large primary-text fw-bold">' . formatVND($price) . '</div>';
    }

    $loveBtnClass = '';
    $loveBtnIcon = 'far fa-heart';

    if (isset($_SESSION['loveProducts']) && !empty($_SESSION['loveProducts']) && is_array($_SESSION['loveProducts'])) {
        if (in_array($id, $_SESSION['loveProducts'])) {
            $loveBtnClass = 'active';
            $loveBtnIcon = 'fa fa-heart';
        }
        $loveBtn = '<button class="icon-btn love-btn toggle-btn ' . $loveBtnClass . '" data-product-id="' . $id . '"><i class="' . $loveBtnIcon . '"></i></button>';
    } else {
        $loveBtn =
            <<<HTML
                <button class="icon-btn love-btn toggle-btn" data-product-id="$id">
                    <i class="fal fa-heart"></i>
                </button>
            HTML;
    }

    $productBtn = '';
    if ($qty > 0) {
        $productBtn =
            <<<HTML
                <div class="flex g12 in-stock__btn-set">
                    <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                    $loveBtn
                    <form action="?mod=cart&act=addCart" method="post" class="flex-column g12">
                        <button type="submit" class="icon-btn">
                            <i class="fal fa-cart-plus"></i>
                        </button>
                        <input type="hidden" name="name" value="$name">
                        <input type="hidden" name="price" value="$price">
                        <input type="hidden" name="img" value="$img">
                        <input type="hidden" name="id" value="$id">
                        <input type="hidden" name="qty" id="data-qty" value="1">
                    </form>
                </div>
            HTML;
    } else {
        $productBtn =
            <<<HTML
                <div class="flex g12 sold-out__btn-set">
                    <button class="icon-btn"><i class="fal fa-share-alt"></i></button>
                    <button class="icon-btn"><i class="fal fa-plus"></i></button>
                    <button class="icon-btn"><i class="fal fa-arrow-right"></i></button>
                </div>
            HTML;
    }

    $views = formatViewsNumber($views);
    
    $productHtml .=
        <<<HTML
            <!-- single product start -->
            <div class="product">
                <a href="$linkToDetail" class="product__banner oh banner-contain rounded-8 por"
                    style="background-image: url($imgPath)">
                    <div class="product__overlay poa flex-center">
                        $productBtn
                    </div>
                </a>
                <a href="$linkToDetail" class="product__info">
                    <div class="product__info__name title-medium fw-smb">$name</div>
                    $salePriceView
                    $priceView
                </a>
                <div class="product__info flex-between width-full">
                    <div class="product__info__view body-medium">$views views</div>
                    <div class="product__info__rated flex g6 v-center body-medium">
                        $purchases lượt mua
                    </div>
                </div>
            </div>
            <!-- single product end -->
HTML;
}

/** category rendering */
/** categroy filter rendering */

$categoryHtml = '';
$categoryFilterHtml = '';
$categoryMobileFilterHtml = '';

foreach ($categories as $item) {
    extract($item);
    $amount = count(getProductsByCategoryId($id));
    $categoryHtml .=
        <<<HTML
                <!-- single category start -->
                <a href="?mod=page&act=category&idCategory=$id" class="category__item flex-center g20 p20 rounded-12"
                    style="background: $bg_color; color: white">
                    <div class="banner-cover category__banner rounded-full"
                        style="background-image: url('./public/assets/media/images/category/$img')">
                    </div>
                    <div class="category__content flex-column g12">
                        <div class="title-medium ttc">$name</div>
                        <span class="body-medium">
                            $description
                        </span>
                        <label for="" class="label large">$amount sản phẩm</label>
                    </div>
                </a>
                <!-- single category end -->
            HTML;

    $url = get_current_url();
    $queryString = parse_url($url, PHP_URL_QUERY);

    $categoryFilterHtml .=
        <<<HTML
                <li class="p12 flex v-center g8">
                    <input class="filter__input" data-id-category="$id" id="idCategory=$id" type="checkbox">
                    <label class="fw-smb ttc" for="idCategory=$id">$name</label>
                </li>
            HTML;

    $categoryMobileFilterHtml .=
        <<<HTML
        <li class="option__list__item p12 flex flex-between">
            <label class="fw-smb ttc" for="idCategory=$id">$name</label>
            <input class="filter__input" data-id-category="$id" id="idCategory=$id" type="checkbox">
        </li>
        HTML;
}

?>

<!-- shop mobile top navigation bar start -->
<div class="mobile-top__bar mobile-top__bar--shop p12 flex-center">
    <div class="mobile-top__inner flex-full flex-between v-center g12">
        <button class="icon-btn back-btn"><i class="fal fa-chevron-left"></i></button>
        <form action="#" class="form mobile__search-form flex-full">
            <div class="form__group width-full por">
                <i class="fal fa-search poa" style="left: 2rem; top: 30%; transform: translate(-50%)"></i>
                <input type="text" class="form__input rounded-100 width-full" style="padding-left: 4rem">
            </div>
        </form>
        <a href="?mod=cart&act=viewCart" class="icon-btn cart-btn"><i class="fal fa-shopping-cart"></i></a>

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
<!-- shop mobile top navigation bar end -->

<!-- shop title start -->
<section class="section shop__title category__title auto-grid g30 mt80">
    <div class="flex-column g6" style="max-width: 27rem">
        <span class="label-large shop__navigation">LEGOUS / CATEGORY</span>
        <h1 class="text-68 category__name">
            <?= $category['name'] ?>
        </h1>
    </div>
    <div class="flex-column g12 flex-full">
        <h4 class="title-medium">SẢN PHẨM NỔI BẬT</h4>
        <div class="feature-product__wrapper oh auto-grid g20 width-full">
            <?= $featureProductsHtml ?>
        </div>
    </div>
</section>
<!-- shop title end -->

<!-- shop product start -->
<main class="section shop__main">
    <div class="flex-between width-full filter-bar">
        <div class="v-center flex-between filter-bar--respon">
            <h4 class="title-medium shop__main__title">SẢN PHẨM</h4>
            <button class="mobile__filter__btn--open btn outline-btn rounded-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M7.5 13.5H10.5V12H7.5V13.5ZM2.25 4.5V6H15.75V4.5H2.25ZM4.5 9.75H13.5V8.25H4.5V9.75Z"
                        fill="#6750A4" />
                </svg>
                Lọc sản phẩm
            </button>
        </div>
        <div class="filter-btn mr20">
            <button class="btn outline-btn toggle-filter-btn rounded-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M7.5 13.5H10.5V12H7.5V13.5ZM2.25 4.5V6H15.75V4.5H2.25ZM4.5 9.75H13.5V8.25H4.5V9.75Z"
                        fill="#6750A4" />
                </svg>
                <span class="btn__text">Ẩn filter</span>
            </button>
        </div>
        <ul class="filter-toggle__list desktop flex g20 flex-full">
            <!-- filter tonggle list item here -->
        </ul>
        <ul class="filter__list open flex g12 flex-full j-end">
            <!-- price filter start -->
            <li class="filter__list__item por">
                <button class="btn elevated-btn rounded-100 filter__list__btn"><i
                        class="fa-solid fa-caret-down"></i>Giá</button>
                <ul class="filter-option__list poa p20 rounded-8 box-shadow1" style="right: 0">
                    <li class="filter-option__item por">
                        <form action="?mod=page&act=category&idCategory=<?= $idCategory ?>" method="post">
                            <!-- normal form group -->
                            <div class="flex g20">
                                <div class="form__group">
                                    <span class="form__group__title">Giá thấp nhất</span>
                                    <input type="number" name="minPrice" class="form__input" placeholder="VD: 1000000">
                                    <span class="form__message"></span>
                                </div>
                                <div class="form__group">
                                    <span class="form__group__title">Giá cao nhất</span>
                                    <input type="number" name="maxPrice" class="form__input" placeholder="VD: 1000000">
                                    <span class="form__message"></span>
                                </div>
                            </div>
                            <input class="btn primary-btn rounded-8 ttu width-full form__btn" name="priceFilter"
                                type="submit" value="LỌC">
                            <div class="form__group mt30">
                                <p>
                                    <label for="amount">Khoảng giá:</label>
                                    <input type="text" id="amount" readonly style="border:0; ; font-weight:bold;">
                                </p>

                                <div id="slider-range"></div>
                            </div>
                        </form>
                    </li>
                </ul>
            </li>
            <!-- price filter end -->

            <!-- category filter start -->
            <!-- <li class="filter__list__item por">
                    <button class="btn elevated-btn rounded-100 filter__list__btn"><i
                            class="fa-solid fa-caret-down"></i>Danh mục</button>
                    <ul class="filter-option__list poa p20 rounded-8 grid-2 g30 box-shadow1" style="right: 0">
                        <li class="filter-option__item flex-column g12" style="color:#7254B7">
                            <ul>
                                <?= $categoryFilterHtml ?>
                            </ul>
                        </li>
                    </ul>
                </li> -->
            <!-- category filter end -->

            <!-- name filter start -->
            <li class="filter__list__item por">
                <button class="btn elevated-btn rounded-100 filter__list__btn"><i
                        class="fa-solid fa-caret-down"></i>Tên</button>
                <ul class="filter-option__list poa p20 rounded-8 grid-2 g30 box-shadow1" style="right: 0">
                    <li class="filter-option__item flex-column g12" style="color:#7254B7">
                        <ul>
                            <li class="p12 flex v-center g8">
                                <input class="filter__input--name" id="name-ASC" value="0" type="checkbox">
                                <label class="fw-smb" for="name-ASC">Từ A - Z</label>
                            </li>
                            <li class="p12 flex v-center g8">
                                <input class="filter__input--name" id="name-DESC" value="1" type="checkbox">
                                <label class="fw-smb" for="name-DESC">Từ Z - A</label>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- name filter end -->

            <!-- date filter start -->
            <!-- <li class="filter__list__item por">
                <button class="btn elevated-btn rounded-100 filter__list__btn"><i
                        class="fa-solid fa-caret-down"></i>Ngày ra mắt</button>
                <ul class="filter-option__list poa p20 rounded-8 grid-2 g30 box-shadow1" style="right: 0">
                    <li class="filter-option__item flex-column g12" style="color:#7254B7">
                        <ul>
                            <li class="p12 flex v-center g8"><input value="1w" class="filter__input--date"
                                    id="date-filter--1w" type="checkbox"><label class="fw-smb" for="date-filter--1w">1
                                    tuần trước</label></li>
                            <li class="p12 flex v-center g8"><input value="1m" class="filter__input--date"
                                    id="date-filter--1m" type="checkbox"><label class="fw-smb" for="date-filter--1m">1
                                    tháng trước</label></li>
                            <li class="p12 flex v-center g8"><input value="6m" class="filter__input--date"
                                    id="date-filter--6m" type="checkbox"><label class="fw-smb" for="date-filter--6m">6
                                    tháng trước</label></li>
                            <li class="p12 flex v-center g8"><input value="1y" class="filter__input--date"
                                    id="date-filter--1y" type="checkbox"><label class="fw-smb" for="date-filter--1y">1
                                    năm trước</label></li>
                            <div class="form__group">
                                <input type="date" class="datePicker form__input filter__input--date"
                                    id="shop__filter--day-picker">
                            </div>
                        </ul>
                    </li>
                </ul>
            </li> -->
            <!-- date filter end -->
        </ul>
    </div>
    <div class="filter-toggle__list--mobile mobile flex g20 flex-full" style="display: flex !important; margin-top: 1.2rem"></div>
    <div class="product__wrapper product__wrapper--without-carousel auto-grid g20 mt30">
        <?= $productHtml ?>
    </div>
    <ul class="pagination flex g16 mt30">
        <?= $paginationHtml ?>
        <li class="btn text-btn rounded-100"><a href="<?= $linkToNextPage ?>" class="pagination__link"><i class="fal fa-arrow-right"
                    style="margin-right: .6rem"></i>Next</a></li>
    </ul>
</main>

<!-- mobile shop filter start -->
<div class="mobile__filter box-shadow1">
    <div class="flex-between mobile__filter__top v-center">
        <span class="title-large ttu">FILTER</span>
        <button class="icon-btn mobile__filter__btn--close"><i class="fal fa-times"></i></button>
    </div>
    <ul class="mobile__filter__list pi12">
        <li class="accordion mobile__filter__item">
            <div class="mobile__filter__name ttc accordion__top flex-between p16">
                TÊN
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <ul class="mobile__filter__option-list accordion__content pi12">
                <li class="p12 option__list__item flex-between flex v-center">
                    <label class="fw-smb" for="name-ASC">Từ A - Z</label>
                    <input class="filter__input--name" id="name-ASC" value="0" type="checkbox">
                </li>
                <li class="p12 option__list__item flex-between flex v-center">
                    <label class="fw-smb" for="name-DESC">Từ Z - A</label>
                    <input class="filter__input--name" id="name-DESC" value="1" type="checkbox">
                </li>
            </ul>
        </li>
        <li class="accordion mobile__filter__item">
            <div class="mobile__filter__name ttc accordion__top flex-between p16">
                GIÁ
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class="mobile__filter__option-list accordion__content pi12">
                <form action="?mod=page&act=shop" method="post">
                    <!-- normal form group -->
                    <div class="grid-auto g20 pb12">
                        <div class="form__group">
                            <span class="form__group__title">Giá thấp nhất</span>
                            <input type="number" name="minPrice" class="form__input" placeholder="VD: 1000000">
                            <span class="form__message"></span>
                        </div>
                        <div class="form__group">
                            <span class="form__group__title">Giá cao nhất</span>
                            <input type="number" name="maxPrice" class="form__input" placeholder="VD: 1000000">
                            <span class="form__message"></span>
                        </div>
                    </div>
                    <input class="btn primary-btn rounded-8 ttu width-full form__btn" name="priceFilter" type="submit"
                        value="LỌC">
                    <div class="form__group mt30">
                        <p>
                            <label for="amount-mobile">Khoảng giá:</label>
                            <input type="text" id="amount-mobile" readonly style="border:0; ; font-weight:bold;">
                        </p>

                        <div id="slider-range--mobile"></div>
                    </div>
                </form>
            </div>
        </li>
    </ul>
</div>
<!-- mobile shop filter end -->
<!-- shop product end -->

<!-- category section start -->
<section class="section category__section">
    <div class="flex-column g12">
        <h2 class="text-68 ttu">danh mục khác</h2>
        <label for="" class="label-large-prominent">LEGOUS/</label>
    </div>
    <div class="category__wrapper mt30 auto-grid g12">
        <?= $categoryHtml ?>
    </div>
</section>
<!-- category section end -->

<!-- price filter start -->
<script>
    $(function() {
        const min = <?= $minPrice ?>;
        const max = <?= $maxPrice ?>;

        $("#slider-range").slider({
            range: true,
            min: min,
            max: max,
            values: [<?= $manualMin ?>, <?= $manualMax ?>],
            slide: function (event, ui) {
                $("#amount").val(formatCurrency(ui.values[0]) + " - " + formatCurrency(ui.values[1]));
            },
            stop: function (event, ui) {
                const minPrice = ui.values[0];
                const maxPrice = ui.values[1];
                // Redirect the user to the URL with the updated prices
                window.location.href = `?mod=page&act=shop&minPrice=${minPrice}&maxPrice=${maxPrice}`;
            }
        });
        $("#slider-range--mobile").slider({
            range: true,
            min: min,
            max: max,
            values: [<?= $manualMin ?>, <?= $manualMax ?>],
            slide: function (event, ui) {
                $("#amount-mobile").val(formatCurrency(ui.values[0]) + " - " + formatCurrency(ui.values[1]));
            },
            stop: function (event, ui) {
                const minPrice = ui.values[0];
                const maxPrice = ui.values[1];
                // Redirect the user to the URL with the updated prices
                window.location.href = `?mod=page&act=shop&minPrice=${minPrice}&maxPrice=${maxPrice}`;
            }
        });

        $("#amount-mobile").val(formatCurrency($("#slider-range").slider("values", 0)) + " - " + formatCurrency($("#slider-range").slider("values", 1)));
    });

    // Function to format the value with currency symbol and rounding for VND
    function formatCurrency(value) {
        const formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            maximumFractionDigits: 0,
        });
        return formatter.format(value);
    }
</script>
<!-- price filter end -->
