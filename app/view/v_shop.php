<?php


use App\model\Category;
use App\model\Product;

?>

<script>
    // love buttons handler
    $(document).ready(function() {
        $('.love-btn').click(function() {
            var button = $(this);
            var productId = button.data('product-id');

            // Disable the love button
            button.prop('disabled', true);

            // Make an AJAX request to update the love value
            $.ajax({
                url: './views/libs/update_love.php', // Replace with the correct path to your PHP script
                method: 'POST', // HTTP method (GET, POST, etc.)
                data: {
                    product_id: productId
                }, // Data to send to the server, e.g., product ID
                success: function(response) {
                    // Handle the response from the server if needed
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    // Enable the love button if there was an error
                    button.prop('disabled', false);
                }
            });
        });
    });
</script>


<?php
/** render regular product */
$productHtml = '';

// Number of products per page
$productsPerPage = 20;

// Current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $productsPerPage;

// Fetch products from the database with LIMIT and OFFSET
$product = new product();
$products = $product->getProductWithLimitAndOffset($productsPerPage, $offset);

// Fetch total number of products from the database
$totalProducts = count($product->getProducts());

// Calculate the total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);

// pagination render 
$paginationHtml = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $linkToPage = "/product?page=$i";
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
    $linkToNextPage = "/product?page=$nextPage";
}
$product = new product();
/** filter handler */
if (isset($_POST['priceFilter']) && $_POST['priceFilter']) {
    $min = $_POST['minPrice'];
    $max = $_POST['maxPrice'];

    $products = $product->getProductsByPriceFilter($min, $max);
}
if (isset($_GET['filterCategory']) && $_GET['filterCategory']) {
    $filterIds = explode(',', $_GET['filterCategory']);
    $products = $product->getProductsByCategoryIds($filterIds);
}
if (isset($_GET['minPrice']) && isset($_GET['maxPrice'])) {
    $manualMin = $_GET['minPrice'];
    $manualMax = $_GET['maxPrice'];

    $products = $product->getProductsByPriceFilter($manualMin, $manualMax);
}
foreach ($products as $item) {
    extract($item);
    $imgPath = "/public/images/product/" . $img;
    $productLink = "/productDetail?idProduct=$id";

    $priceView = '';
    $salePriceView = '';
    $loveBtn = '<button class="icon-btn love-btn toggle-btn" data-product-id="' . $id . '"><i class="fal fa-heart"></i></button>';

    if (isset($price) && $price > 0) {
        $priceView = '<div class="product__info__price body-medium">' . formatVND($price) . '</div>';
    } else {
        $priceView = '<div class="product__info__price body-medium">Đang cập nhật</div>';
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
                    <form action="/addCart" method="post" class="flex-column g12">
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
                <a href="$productLink" class="product__banner oh banner-contain rounded-8 por"
                    style="background-image: url($imgPath)">
                    <div class="product__overlay poa flex-center">
                        $productBtn
                    </div>
                </a>
                <a href="#" class="product__info">
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
$product = new product();
$category = new category();
$categories = $category->getCategories();
foreach ($categories as $item) {

    extract($item);
    $amount = count($product->getProductsByCategoryId($id));
    $categoryHtml .=
        <<<HTML
                <!-- single category start -->
                <a href="/productCate?idCategory=$id" class="category__item flex-center g20 p20 rounded-12"
                    style="background: $bg_color; color: white">
                    <div class="banner-cover category__banner rounded-full"
                        style="background-image: url('./public/images/category/$img')">
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

/** render feature category */
$category = new category();
$product = new product();
$featureCategoriesHtml = '';
$featureCategories = $category->getFeatureCategories();
foreach ($featureCategories as $item) {
    extract($item);
    $imgPath = "/public/images/category/" . $img;
    $amount = count($product->getProductsByCategoryId($id));
    $linkToDetail = "/productCate?idCategory=$id";

    $featureCategoriesHtml .=
        <<<HTML
        <!-- single feature category start -->
        <a href="$linkToDetail" class="feature-category__item p20 flex g20 v-center" style="background: $bg_color">
            <div class="feature-category__banner oh rounded-full" style="width: 5rem; height: 5rem; flex-shrink: 0">
                <img src="$imgPath" alt="" class="img-cover">
            </div>
            <div class="feature-category__content flex-column g8">
                <h4 class="title-medium ttc">$name</h4>
                <span class="body-medium">$description</span>
                <span class="label-large">$amount sản phẩm có sẵn</span>
            </div>
        </a>
        <!-- single feature category end -->
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
<section class="section shop__title auto-grid g30 mt80">
    <div class="width-full">
        <div class="flex-column g12" style="max-width: 27rem">
            <span class="label-large">LEGOUS /</span>
            <h1 class="text-68">SHOP</h1>
            <span class="label-large">Chúng tôi hân hạnh đem đến cho bạn mô hình được lấy cảm hứng từ những nhân vật
                truyện tranh tuổi thơ với chất lượng cao</span>
        </div>
    </div>
    <div class="flex-column g12 flex-full">
        <h4 class="title-medium">DANH MỤC NỔI BẬT</h4>
        <div class="feature-category__wrapper oh flex g20 width-full">
            <?= $featureCategoriesHtml ?>
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
                    <path d="M7.5 13.5H10.5V12H7.5V13.5ZM2.25 4.5V6H15.75V4.5H2.25ZM4.5 9.75H13.5V8.25H4.5V9.75Z" fill="#6750A4" />
                </svg>
                Lọc sản phẩm
            </button>
        </div>
        <div class="filter-btn mr20">
            <button class="btn outline-btn toggle-filter-btn rounded-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M7.5 13.5H10.5V12H7.5V13.5ZM2.25 4.5V6H15.75V4.5H2.25ZM4.5 9.75H13.5V8.25H4.5V9.75Z" fill="#6750A4" />
                </svg>
                <span class="btn__text">Ẩn filter</span>
            </button>
        </div>
        <ul class="filter-toggle__list desktop flex g20 flex-full">
            <!-- filter toggle list item here -->
        </ul>
        <!-- <ul class="filter-toggle__list--mobile tablet-mobile flex g12 flex-full"></ul> -->
        <ul class="filter__list open flex g12 flex-full j-end">
            <!-- price filter start -->
            <li class="filter__list__item por">
                <button class="btn elevated-btn rounded-100 filter__list__btn"><i class="fa-solid fa-caret-down"></i>Giá</button>
                <ul class="filter-option__list poa p20 rounded-8 box-shadow1" style="right: 0">
                    <li class="filter-option__item por">
                        <form action="?mod=page&act=shop" method="post">
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
                            <input class="btn primary-btn rounded-8 ttu width-full form__btn" name="priceFilter" type="submit" value="LỌC">
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
            <li class="filter__list__item por">
                <button class="btn elevated-btn rounded-100 filter__list__btn"><i class="fa-solid fa-caret-down"></i>Danh mục</button>
                <ul class="filter-option__list poa p20 rounded-8 grid-2 g30 box-shadow1" style="right: 0">
                    <li class="filter-option__item flex-column g12" style="color:#7254B7">
                        <ul>
                            <?= $categoryFilterHtml ?>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- category filter end -->

            <!-- name filter start -->
            <li class="filter__list__item por">
                <button class="btn elevated-btn rounded-100 filter__list__btn"><i class="fa-solid fa-caret-down"></i>Tên</button>
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
        <li class="next-page-btn btn text-btn rounded-100">
            <a href="<?= $linkToNextPage ?>" class="pagination__link">
                <i class="fal fa-arrow-right" style="margin-right: .6rem"></i>
                Next</a>
        </li>
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
                DANH MỤC
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class="p10 accordion__content">
                <ul class="mobile__filter__option-list p10">
                    <?= $categoryMobileFilterHtml ?>
                </ul>
            </div>
        </li>
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
                    <input class="btn primary-btn rounded-8 ttu width-full form__btn" name="priceFilter" type="submit" value="LỌC">
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

<!-- sale banner start -->
<section class="section sale-banner grid-2">
    <div class="flex-column g16">
        <div class="fw-black text-logo">Legous</div>
        <div class="flex g6 v-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                <path d="M22.275 17.1375C24.675 17.25 25.2938 19.2938 25.3313 20.25H28.6875C28.5375 16.5375 25.8938 14.2688 22.2188 14.2688C18.075 14.2688 15 16.875 15 22.7625C15 26.4 16.7438 30.7125 22.2 30.7125C26.3625 30.7125 28.5938 27.6187 28.65 25.1813H25.2937C25.2375 26.2875 24.45 27.7687 22.2375 27.8813C19.7812 27.8062 18.75 25.8938 18.75 22.7625C18.75 17.3438 21.15 17.175 22.275 17.1375ZM22.5 3.75C12.15 3.75 3.75 12.15 3.75 22.5C3.75 32.85 12.15 41.25 22.5 41.25C32.85 41.25 41.25 32.85 41.25 22.5C41.25 12.15 32.85 3.75 22.5 3.75ZM22.5 37.5C14.2313 37.5 7.5 30.7687 7.5 22.5C7.5 14.2313 14.2313 7.5 22.5 7.5C30.7687 7.5 37.5 14.2313 37.5 22.5C37.5 30.7687 30.7687 37.5 22.5 37.5Z" fill="white" />
            </svg>/2023
        </div>
    </div>
    <div class="flex-column g16">
        <div class="text-38">GIẢM GIÁ CỰC SỐC MỪNG
            HALLOWEEN 20%</div>
        <span class="label-large">Khi nhập mã LEGOUS20</span>
    </div>
</section>
<!-- sale banner end -->

<!-- category section start -->
<section class="section category__section">
    <div class="flex-column g12">
        <h2 class="text-68 ttu">danh mục</h2>
        <label for="" class="label-large-prominent">LEGOUS/</label>
    </div>
    <div class="category__wrapper mt30 auto-grid g12">
        <?= $categoryHtml ?>
    </div>
</section>
<!-- category section end -->
<?php
$product = new product();
$maxPrice = $product->getMaxProductPrice();
$minPrice = $product->getMinProductPrice();

$manualMin = $minPrice;
$manualMax = $maxPrice;
?>

<script>
    $(function() {
        const min = <?= $minPrice ?>;
        const max = <?= $maxPrice ?>;

        $("#slider-range").slider({
            range: true,
            min: min,
            max: max,
            values: [<?= $manualMin ?>, <?= $manualMax ?>],
            slide: function(event, ui) {
                $("#amount").val(formatCurrency(ui.values[0]) + " - " + formatCurrency(ui.values[1]));
            },
            stop: function(event, ui) {
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
            slide: function(event, ui) {
                $("#amount-mobile").val(formatCurrency(ui.values[0]) + " - " + formatCurrency(ui.values[1]));
            },
            stop: function(event, ui) {
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