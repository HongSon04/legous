<?php

use App\model\Product;
use App\model\Category;


$product = new product();
$products = $product->getProduct(10);
$category = new category();
$categories = $category->getCategories();
$topLoveProducts = $product->getProductsByLove();

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

/** product rendering */
extract($topLoveProducts[0]);
$img_path = './public/images/product/' . $img . '';
$linkToDetail = "/productDetail?idProduct=$id";

$priceView = '';
$salePriceView = '';

if (isset($price) && $price > 0) {
    $priceView = '<div class="product__info__price title-large fw-bold primary-text">' . formatVND($price) . '</div>';
} else {
    $priceView = '<div class="product__info__price title-large fw-bold primary-text">Đang cập nhật</div>';
}

if (isset($promotion) and $promotion > 0) {
    $salePrice = $price - $price * $promotion / 100;
    $salePriceView = '<div class="product__info__sale-price title-large fw-bold primary-text">' . formatVND($salePrice) . '</div>';
    $priceView = '<del class="product__info__price title-large fw-bold primary-text">' . formatVND($price) . '</del>';
} else {
    $salePriceView = '';
    $priceView = '<div class="product__info__price title-large fw-bold primary-text">' . formatVND($price) . '</div>';
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

$views = formatViewsNumber($views);

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

$topProductHtml =
    <<<HTML
        <div class="product product__spotlight" data-id-product="$id">
            <a href="$linkToDetail" class="product__banner product__spotlight__banner banner-contain rounded-8 por"
                style="background-image: url($img_path)">
                <div class="product__overlay poa flex-center">
                    $productBtn
                </div>
            </a>
            <a href="#" class="product__info" style="z-index: 99;">
                <div class="product__info__name headline-medium fw-smb">$name</div>
                $priceView
                $salePriceView
            </a>
            <div class="product__info flex-between width-full" style="z-index: 99;">
                <div style="z-index: 99;" class="product__info__view title-large">$views views</div>
                <div class="product__info__rated flex g6 v-center body-medium">
                    $purchases lượt mua
                </div>
            </div>
        </div>
    HTML;


function renderLoveProducts($products, $productsPerWrapper) {
    $html = '';
    $wrapperIndex = 1;
    $productIndex = 0;

    $totalProducts = count($products);
    $totalWrappers = ceil($totalProducts / $productsPerWrapper);

    for ($i = 0; $i < $totalWrappers; $i++) {
        $wrapperClass = 'product-slick__wrapper__' . $wrapperIndex;

        $html .= <<<HTML
                <div class="carousel__container flex-column g12 por">
                    <div class="product__wrapper grid-auto g20 width-full {$wrapperClass}">
            HTML;

        for ($j = 0; $j < $productsPerWrapper; $j++) {
            $product = $products[$productIndex] ?? null;

            if (!$product) {
                break;
            }
            extract($product);
            $imgPath = "./public/images/product/" . $img;
            $linkToDetail = "/productDetail?idProduct=$id";


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

            $views = formatViewsNumber($views);

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


            $html .=
                <<<HTML
                <div class="product product__carousel">
                    <!-- single product start -->
                    <div class="product product__carousel">
                        <a href="$linkToDetail" class="product__banner banner-contain rounded-8 por"
                            style="background-image: url('$imgPath')">
                            <div class="product__overlay poa flex-center">
                                $productBtn
                            </div>
                        </a>
                        <a href="#" class="product__info">
                            <div class="product__info__name title-medium fw-smb">$name</div>
                            $priceView
                            $salePriceView
                        </a>
                        <div class="product__info flex-between width-full">
                            <div class="product__info__view body-medium">$views views</div>
                            <div class="product__info__rated flex g6 v-center body-medium">
                                $purchases lượt mua
                            </div>
                        </div>
                    </div>
                    <!-- single product end -->
                </div>
            HTML;
            $productIndex++;
        }

        $html .= <<<HTML
                    </div>
                </div>
            HTML;

        $wrapperIndex++;
    }

    return $html;
}

/** tabs render */
$tabsHtml = '';
$panelsHtml = '';
$category = new category();
$categories = $category->getCategories();
if (isset($categories)) {
    $i = 1;
    foreach ($categories as $item) {
        extract($item);
        $linkToCategory = "/productCate?idCategory=$item[id]";
        $collectionItemTitle = '<h2 class="text-46 ttu">' . $item['name'] . '</h2>';

        $tabsHtml .=
            <<<HTML
                <div class="tab__item" data-defaultActive="$i"  style="z-index: 99;">
                    <span class="tab__item__label label-large ttu tac">$name</span>
                </div>
            HTML;
        $i++;
        $product = new product();
        $products = $product->getProductByCategoryId($id);

        $productsHtml = '';

        if (count($products) > 0) {
            foreach ($products as $product) {
                extract($product);
                $imgPath = "./public/images/product/" . $img;
                $linkToDetail = "/productDetail?idProduct=$id";

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

                $views = formatViewsNumber($views);

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

                $productsHtml .=
                    <<<HTML
                        <!-- single product start -->
                        <div class="product product__carousel">
                            <a 
                            href="$linkToDetail" 
                            class="product__banner banner-contain display-block rounded-8 por" 
                            style="background-image: url($imgPath)">
                                <div class="product__overlay poa flex-center">
                                    <!-- overlay btn start -->
                                    $productBtn
                                    <!-- overlay btn end -->
                                </div>
                            </a>
                            <a href="#" class="product__info">
                                <div class="product__info__name title-medium fw-smb">$name</div>
                                $priceView
                                $salePriceView
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
        } else {
            $productsHtml =
                <<<HTML
                        <h2 class="fw-smb text-38 tac ttu mt30 mb30 primary-text">Danh mục hiện đang cập nhật</h2>
                    HTML;
        }

        $panelsHtml .=
            <<<HTML
                <div class="panel__item">
                    <!-- /*collection item*/ -->
                    <div class="width-full collection__item">
                        <!-- /*collection item title*/ -->
                        <div class="flex-between">
                            $collectionItemTitle 
                            <a href="$linkToCategory" class="btn rounded-100 text-btn"><i class="fal fa-arrow-right"></i>Xem nhiều hơn</a>
                        </div>
                        <div class="product__wrapper product__wrapper--normal product__wrapper--normal--slick__1 auto-grid g20">
                            $productsHtml
                        </div>
                    </div>
                </div>
            HTML;
    }
}

/** partner render  */
$partnerHtml = '';
$product = new product();
$partner = $product->getPartner(6);
if (isset($partner)) {
    foreach ($partner as $item) {
        extract($item);
        $partnerHtml .=
            <<<HTML
                <a href="$link" class="partner__item db">
                    <img src="./public/images/brands/$img" alt="$description">
                </a>
            HTML;
    }
}

/** category rendering */
$category = new category();
$categories = $category->getCategories();
$categoryHtml = '';
foreach ($categories as $item) {
    extract($item);
    $product = new product();
    $amount = count($product->getProductById($id));
    $categoryHtml .=
        <<<HTML
            <!-- single category start -->
            <a href="/productCate?idCategory=$id" class="category__item flex-center g20 p20 rounded-12"
                style="background: $bg_color; color: white">
                <div class="banner-cover category__banner rounded-full"
                    style="background-image: url('./public/images/category/$img')">
                </div>
                <div class="category__content flex-column g12">
                    <div class="title-medium ttu">$name</div>
                    <span class="body-medium">
                        $description
                    </span>
                    <label for="" class="label large">$amount sản phẩm</label>
                </div>
            </a>
            <!-- single category end -->
        HTML;
}
?>

<!-- hero banner start -->
<div class="hero-banner__wrapper">
    <div class="hero-banner__item box-shadow1 grid-2">
        <div class="left flex-column">
            <div class="flex v-center"><i class="fal fa-copyright"></i><span class="body-large">/2023</span>
            </div>
            <div class="hightlight-text">MÔ HÌNH LUFFY GEAR 5 XỊN XÒ</div>
            <span class="subtext label-medium">Khám phá những mô hình thú vị và độc đáo cùng với LEGOUS! Tại
                đây, chúng tôi cung cấp những mô hình với đa dạng nhân vật và các chủ đề khác nhau, hứa hẹn sẽ
                đáp ứng được nhu cầu mua sắm của bạn.</span>
            <div class="row g12 button-set">
                <button class="btn primary-btn rounded-100">Mua ngay</button>
                <button class="btn elevated-btn rounded-100"><i class="fal fa-arrow-right"></i>Đến cửa
                    hàng</button>
            </div>
            <div class="flex avt-wrapper">
                <div class="flex avt-group">
                    <img src="./public/images/users/user-1.svg" alt="">
                    <img src="./public/images/users/user-2.svg" alt="">
                    <img src="./public/images/users/user-3.svg" alt="">
                </div>
                <div class="flex-column flex-between">
                    <span class="label-large">1,9 nghìn</span>
                    <span class="label-large">Người đã mua</span>
                </div>
            </div>
        </div>
        <div class="right banner-contain" style="background-image: url('./public/images/banners/luffy_banner.svg'); min-width: 50%; min-height: 100%">
        </div>
    </div>
    <div class="hero-banner__item grid-2" style="background: linear-gradient(110deg, #5E007E 14.03%, #A000D8 96.4%); color: white">
        <div class="left flex-column">
            <div class="flex v-center"><i class="fal fa-copyright"></i><span class="body-large">/2023</span>
            </div>
            <div class="hightlight-text" style="color: white">SASUKE - SUSANO TOÀN CHÂN THỂ</div>
            <span class="subtext label-medium">Khám phá những mô hình thú vị và độc đáo cùng với LEGOUS! Tại
                đây, chúng tôi cung cấp những mô hình với đa dạng nhân vật và các chủ đề khác nhau, hứa hẹn sẽ
                đáp ứng được nhu cầu mua sắm của bạn.</span>
            <div class="row g12 button-set">
                <button class="btn primary-btn rounded-100">Mua ngay</button>
                <button class="btn elevated-btn rounded-100"><i class="fal fa-arrow-right"></i>Đến cửa
                    hàng</button>
            </div>
            <div class="flex avt-wrapper">
                <div class="flex avt-group">
                    <img src="./public/images/users/user-1.svg" alt="">
                    <img src="./public/images/users/user-2.svg" alt="">
                    <img src="./public/images/users/user-3.svg" alt="">
                </div>
                <div class="flex-column flex-between">
                    <span class="label-large">1,9 nghìn</span>
                    <span class="label-large">Người đã mua</span>
                </div>
            </div>
        </div>
        <div class="right banner-contain" style="
                background-image: url('./public/images/banners/sasuke-susano_banner.svg');
                ">
        </div>
    </div>
    <div class="hero-banner__item grid-2" style="background: linear-gradient(180deg, #FF3030 0%, #FF3D3D 100%); color: white">
        <div class="left flex-column">
            <div class="flex v-center"><i class="fal fa-copyright"></i><span class="body-large">/2023</span>
            </div>
            <div class="hightlight-text" style="color: white">SASUKE - SUSANO TOÀN CHÂN THỂ</div>
            <span class="subtext label-medium">Khám phá những mô hình thú vị và độc đáo cùng với LEGOUS! Tại
                đây, chúng tôi cung cấp những mô hình với đa dạng nhân vật và các chủ đề khác nhau, hứa hẹn sẽ
                đáp ứng được nhu cầu mua sắm của bạn.</span>
            <div class="row g12 button-set">
                <button class="btn primary-btn rounded-100">Mua ngay</button>
                <button class="btn elevated-btn rounded-100"><i class="fal fa-arrow-right"></i>Đến cửa
                    hàng</button>
            </div>
            <div class="flex avt-wrapper">
                <div class="flex avt-group">
                    <img src="./public/images/users/user-1.svg" alt="">
                    <img src="./public/images/users/user-2.svg" alt="">
                    <img src="./public/images/users/user-3.svg" alt="">
                </div>
                <div class="flex-column flex-between">
                    <span class="label-large">1,9 nghìn</span>
                    <span class="label-large">Người đã mua</span>
                </div>
            </div>
        </div>
        <div class="right banner-contain" style="
                background-image: url('./public/images/banners/itachi-susano_banner.svg');
                ">
        </div>
    </div>
</div>
<!-- hero banner end -->

<!-- sale banner start -->
<div class="width-full sale-banner__wrapper auto-grid">
    <div class="sale-banner__item title-medium fw-bold">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
            <path d="M12.3233 2C6.80331 2 2.33331 6.48 2.33331 12C2.33331 17.52 6.80331 22 12.3233 22C17.8533 22 22.3333 17.52 22.3333 12C22.3333 6.48 17.8533 2 12.3233 2ZM16.5633 18L12.3333 15.45L8.10331 18L9.22331 13.19L5.49331 9.96L10.4133 9.54L12.3333 5L14.2533 9.53L19.1733 9.95L15.4433 13.18L16.5633 18Z" fill="white" />
        </svg>Giảm ngay 20% cho người mới<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
            <path d="M12.3233 2C6.80331 2 2.33331 6.48 2.33331 12C2.33331 17.52 6.80331 22 12.3233 22C17.8533 22 22.3333 17.52 22.3333 12C22.3333 6.48 17.8533 2 12.3233 2ZM16.5633 18L12.3333 15.45L8.10331 18L9.22331 13.19L5.49331 9.96L10.4133 9.54L12.3333 5L14.2533 9.53L19.1733 9.95L15.4433 13.18L16.5633 18Z" fill="white" />
        </svg>
    </div>
    <div class="sale-banner__item title-medium fw-bold"><i class="fas fa-shipping-fast"></i>Free ship cho đơn
        hàng trên 2 triệu<i class="fas fa-shipping-fast"></i></div>
</div>
<!-- sale banner end -->


<!-- most love products section start -->
<section class="section most-love__section">
    <div class="flex-between v-center">
        <span class="product-amount text-68">10+</span>
        <div class="flex-column">
            <h2 class="text-68 ttu">top yêu thích</h2>
            <span class="light-devider" style="width: 30%; height: .4rem;"></span>
            <h2 class="text-68 ttu" style="color: #4A4458">sản phẩm</h2>
        </div>
    </div>
    <div class="auto-grid g20 mt30">
        <div class="product__wrapper">
            <!-- /** top love product start */ -->
            <?= $topProductHtml ?>
            <!-- /** top love product end */ -->
        </div>
        <div class="flex-column g20">
            <?= renderLoveProducts($product->getProductsByLove(12), 6) ?>
        </div>
    </div>
</section>
<!-- most love products section end -->

<!-- benefit section start -->
<section class="section benefit__section desktop row flex-between g30">
    <div class="flex-column g12" style="width: min(40rem, 100%)">
        <div class="section__title">
            <div class="text-46 ttu">
                Vô vàn ưu đãi hấp dẫn cùng
                <span class="primary-masking-text">legous</span>
            </div>
        </div>
        <span class="light-devider" style="height: .4rem; width: 20rem"></span>
        <p class="body-large" style="max-width: 70rem;">LegoUS là website chuyên cung cấp các sản phẩm Lego và
            mô hình chính hãng, uy tín và chất lượng tại Việt Nam. Với kho hàng đa dạng, phong phú, LegoUS mang
            đến cho khách hàng những trải nghiệm mua sắm tuyệt vời nhất.</p>
        <div class="flex g12">
            <button class="btn primary-btn">Khám phá ngay</button>
            <button class="btn elevated-btn rounded-100">Liên hệ</button>
        </div>
    </div>
    <div class="grid-2 benefit__wrapper g30">
        <div class="benefit__item flex-column g20 rounded-8">
            <div class="benefit__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                    <path d="M30.6 4.20001H9.00001C6.34905 4.20001 4.20001 6.34905 4.20001 9.00001V11.4M4.20001 11.4V39C4.20001 41.651 6.34905 43.8 9.00001 43.8H39C41.651 43.8 43.8 41.651 43.8 39V16.2C43.8 13.549 41.651 11.4 39 11.4H4.20001ZM37.2 27.6C37.2 29.2569 35.8569 30.6 34.2 30.6C32.5432 30.6 31.2 29.2569 31.2 27.6C31.2 25.9432 32.5432 24.6 34.2 24.6C35.8569 24.6 37.2 25.9432 37.2 27.6Z" stroke="#1D192B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="benefit__content desktop flex-column g12">
                <h4 class="benefit__title title-medium fw-bold">Thanh Toán Đa Dạng</h4>
                <span class="benefit__detail body-large">Để đảm bảo sự thuận tiện cho khách hàng, chúng tôi cung cấp
                    nhiều phương thức thanh toán an toàn và linh hoạt nhất.</span>
            </div>
        </div>
        <div class="benefit__item flex-column g20 rounded-8">
            <div class="benefit__icon">
                <svg fill="#000000" height="48px" width="48px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g id="Rocket_1_">
                            <path d="M63.9999542,8.8992481c0-2.7851996-0.7939987-4.9892998-2.3593979-6.5497999 C55.3563538-3.9113514,38.8339539,2.7459486,24.019455,17.5105476c-0.5382996,0.5366001-1.0302982,1.1086006-1.5033989,1.6948013 c-0.1553001-0.0642014-0.3339996-0.1216011-0.5394993-0.1694012c-4.2666016-0.9970989-17.960001,1.3291016-21.9463005,17.2549 c-0.1025887,0.4081993,0.0615,0.8358994,0.4101,1.0713005c0.169,0.1152,0.3643113,0.1717987,0.5596,0.1717987 c0.206,0,0.4121-0.0634003,0.5869-0.1903992c5.4105997-3.9248009,9.7511997-5.5033989,13.5403004-4.9222984 c-0.2614889,0.4740982-0.5269003,0.9365005-0.8010006,1.3783989c-0.2451992,0.3955002-0.1855993,0.9071999,0.1435118,1.235302 l1.569088,1.5639992l-2.9371996,2.9263c-0.1884995,0.1875-0.2939997,0.4422989-0.2939997,0.7080002 c0,0.2655983,0.1055002,0.5205002,0.2939997,0.7080002l9.8291121,9.7967987 c0.1952877,0.1944008,0.4500885,0.2919998,0.7059994,0.2919998c0.255888,0,0.510788-0.097599,0.706089-0.2919998 l2.9410992-2.9315987l1.5734997,1.5683975c0.1934013,0.1923027,0.4483128,0.2919998,0.7061005,0.2919998 c0.1805992,0,0.3623009-0.0489006,0.5244007-0.1484985c0.4132996-0.2549019,0.8422985-0.5024986,1.283699-0.7461014 c0.6509018,3.8078995-0.9258003,8.1761017-4.913599,13.6377029c-0.2480011,0.3398972-0.2567997,0.7987976-0.022501,1.1474991 c0.1884995,0.2812004,0.5020008,0.4423981,0.830101,0.4423981c0.0801105,0,0.1611118-0.0098,0.2411995-0.0293007 c15.9404984-3.9638977,18.2959137-17.6093979,17.3134995-21.8652992c-0.0601006-0.2597008-0.1386986-0.4641991-0.2238998-0.6455002 c0.635498-0.5021973,1.2546997-1.0267982,1.833313-1.6035004C57.1034546,29.2185478,63.9999542,17.0662479,63.9999542,8.8992481z M16.0575562,30.5486488c-3.9013996-0.8223-8.1884995,0.3213005-13.2792997,3.5625 c2.5039001-6.9482002,7.0644999-10.2305012,10.6426001-11.7763996c2.6826-1.1582012,5.1239986-1.4824009,6.6864986-1.4824009 c0.4190006,0,0.7734013,0.0233994,1.0537014,0.0596008L16.0575562,30.5486488z M23.6366673,48.6179466l-8.4121113-8.384697 l2.2304993-2.2217026l7.2674999,7.2423019l1.1445999,1.1404991L23.6366673,48.6179466z M41.5331535,50.5730476 c-1.5468979,3.5830002-4.8417969,8.1483994-11.8368988,10.6514015c3.2461014-5.0694008,4.3935013-9.3389015,3.5703011-13.2294998 l9.6737976-5.089901C43.1141548,44.2195473,42.9872551,47.203949,41.5331535,50.5730476z M34.6893539,44.8650475 c-1.7586861,0.8467026-3.4335976,1.6514015-4.970686,2.5438995L16.4364567,34.1716499 c0.7172985-1.2282028,1.3803997-2.5621014,2.052-3.9399014l4.0607986-7.6671009 c0.8499012-1.3155994,1.7915001-2.5506992,2.8822994-3.6380997C38.9843559,5.4187484,54.916954-1.5236515,60.2284546,3.7654486 c1.1758003,1.1718998,1.7714996,2.8993998,1.7714996,5.1337996c0,7.5449009-6.8251991,19.4169998-16.982399,29.5410023 C42.1884537,41.2595482,38.3759537,43.0925484,34.6893539,44.8650475z">
                            </path>
                            <path d="M42.724556,12.8533487c-1.1395988,1.1337996-1.767601,2.6426001-1.767601,4.2480001 c0,1.6064987,0.6280022,3.1152992,1.767601,4.2490997c1.1748009,1.1688995,2.7178001,1.7539005,4.2607002,1.7539005 c1.5429993,0,3.0859985-0.585001,4.2598-1.7539005c1.139698-1.1338005,1.766613-2.642601,1.766613-4.2490997 c0-1.6054001-0.626915-3.1142006-1.766613-4.2480001C48.8974533,10.5154486,45.0741539,10.5154486,42.724556,12.8533487z M49.8349533,19.9324493c-1.5722847,1.5643997-4.1279984,1.5643997-5.7001991,0 c-0.7588005-0.7559013-1.1777992-1.7608013-1.1777992-2.8311005c0-1.0692997,0.4189987-2.0742006,1.1777992-2.8301001 c0.7861023-0.7821999,1.8183022-1.1728001,2.850502-1.1728001c1.032299,0,2.0634995,0.3906002,2.8496971,1.1728001 c0.7587128,0.7558994,1.1767159,1.7608004,1.1767159,2.8301001C51.0116692,18.171648,50.5936661,19.176548,49.8349533,19.9324493z">
                            </path>
                            <path d="M16.464756,47.1472473c-0.3896008-0.3915977-1.0223999-0.3915977-1.4139996-0.0018997l-9.9950886,9.9619026 c-0.3907118,0.3895988-0.3926115,1.0223999-0.0020003,1.4139977c0.1952887,0.1963005,0.4511886,0.2940025,0.7080002,0.2940025 c0.2548885,0,0.5107884-0.097702,0.7060885-0.2920036l9.9951-9.9618988 C16.8534565,48.1716499,16.8554554,47.5388489,16.464756,47.1472473z">
                            </path>
                            <path d="M5.7245564,51.9734497c0.2549,0,0.5106997-0.097702,0.7061114-0.2919998l6.5819998-6.5605011 c0.3905888-0.3897018,0.3915882-1.0224991,0.0018883-1.4141006c-0.3895998-0.3915977-1.0223999-0.392601-1.4139996-0.0019989 l-6.5820999,6.5606003c-0.3906002,0.3895988-0.3916001,1.0224991-0.0019002,1.4141006 C5.2118564,51.8757477,5.4677563,51.9734497,5.7245564,51.9734497z">
                            </path>
                            <path d="M18.5018559,50.5837479l-6.5819998,6.5606003c-0.3906002,0.3895988-0.3915997,1.0224991-0.0018997,1.4141006 c0.1953001,0.1962013,0.4510994,0.2938995,0.7080002,0.2938995c0.2547998,0,0.5107107-0.0976982,0.7059994-0.2919998 l6.5821009-6.5605011c0.3906116-0.389698,0.3916111-1.0224991,0.0018997-1.4141006 C19.5263557,50.194149,18.8934555,50.1931496,18.5018559,50.5837479z">
                            </path>
                        </g>
                    </g>
                </svg>
            </div>
            <div class="benefit__content desktop flex-column g12">
                <h4 class="benefit__title title-medium fw-bold">Vận Chuyển Nhanh Chóng</h4>
                <span class="benefit__detail body-large">Với hệ thống vận chuyển hiện đại, bạn có thể yên tâm rằng mỗi
                    đơn hàng sẽ được giao đến địa chỉ của bạn một cách nhanh chóng.</span>
            </div>
        </div>
        <div class="benefit__item flex-column g20 rounded-8">
            <div class="benefit__icon">
                <svg width="48px" height="48px" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M15.5 9.5L11 14L9.5 12.5M12 3L20 7C20 12.1932 17.2157 19.5098 12 21C6.78428 19.5098 4 12.1932 4 7L8 5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
            </div>
            <div class="benefit__content desktop flex-column g12">
                <h4 class="benefit__title title-medium fw-bold">Uy Tín & Chất Lượng</h4>
                <span class="benefit__detail body-large">Chúng tôi cam kết cung cấp những mô hình anime chất lượng cao,
                    đáng tin cậy và đáp ứng mọi nhu cầu của bạn.</span>
            </div>
        </div>
        <div class="benefit__item flex-column g20 rounded-8">
            <div class="benefit__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                    <path d="M22.2 4.19999H8.99995C6.34898 4.19999 4.19995 6.34902 4.19995 8.99999V30.2M4.19995 30.2V39C4.19995 41.651 6.34899 43.8 8.99995 43.8H39C41.6509 43.8 43.8 41.651 43.8 39V30.6L34.8 22.2L25.8 28.2M4.19995 30.2L16.8 19.8L31.8 35.4M35.6249 17.4H30.6V12.375L40.1343 2.84069C41.5219 1.45309 43.7716 1.45309 45.1592 2.84069C46.5469 4.2283 46.5469 6.47806 45.1592 7.86567L35.6249 17.4Z" stroke="#1D192B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="benefit__content desktop flex-column g12">
                <h4 class="benefit__title title-medium fw-bold">Sản Phẩm Đa Dạng</h4>
                <span class="benefit__detail body-large">LegoUS tự hào là nơi có sự đa dạng về mô hình anime, từ những
                    nhân vật nổi tiếng đến những bộ phim hot nhất.</span>
            </div>
        </div>
    </div>
</section>
<!-- benefit section end -->

<!-- product section start -->
<section class="section product__section flex-column g30">
    <div class="product__section__title flex-center flex-column g12">
        <h2 class="text-68 tac">SẢN PHẨM</h2>
        <span class="label-large tac" style="max-width: 31.5rem">Khám phá mô hình của những bộ truyện hoặc những
            nhân vật bạn yêu thích</span>
        <div class="light-devider" style="width: 10rem; height: .4rem"></div>
    </div>
    <div class="tab__container full oh">
        <div class="tabs product-tabs flex-center width-full">
            <?= $tabsHtml ?>
        </div>
        <div class="panels">
            <?= $panelsHtml ?>
        </div>
    </div>
</section>
<!-- product section end -->

<!-- partner section start -->
<section class="section partner__section partner__slick-carousel auto-grid g100">
    <?= $partnerHtml ?>
</section>
<!-- partner section end -->

<!-- coming soon section start  -->
<section class="section comming-soon__section">
    <?php
    $product = new Product();
    $upcommingProduct = $product->getFeatureProduct();

    $upCommingImgPath = "./public/images/product/" . $upcommingProduct[0]['img'];
    $linkToDetail = "/productDetail?idProduct=$id";
    ?>
    <div class="auto-grid g30">
        <div class="banner-cover" style="background-image: url('<?= $upCommingImgPath ?>');width: 100%; aspect-ratio: 1/1.2;">
        </div>
        <div class="flex-column g30 flex-full">
            <span class="text-46 fw-normal error60">COMING SOON!</span>

            <h2 class="text-68 fw-bold" style="text-wrap: balance;">
                <?= $upcommingProduct[0]['name'] ?>
            </h2>
            <h4 class="display-small error60">Giá:
                <?= formatVND($upcommingProduct[0]['price']) ?>
            </h4>
            <span class="body-large">
                <?= $upcommingProduct[0]['description'] ?>
            </span>
            <form action="#" class="pre-order__form width-full flex-column g12" method="post">
                <div class="form__group form__group without-title width-full">
                    <input class="form__input " type="text" name="email" class="" placeholder=" ">
                    <label for="" class="label__place">Email</label>
                    <span class="form__message"></span>
                </div>
                <div class="form__group form__group without-title width-full">
                    <input class="form__input" type="number" name="qty" class="" placeholder=" ">
                    <label for="" class="label__place">Số lượng</label>
                    <span class="form__message"></span>
                </div>
                <div class="row g20">
                    <button type="submit" class="btn primary-btn">Đặt trước ngay</button>
                    <a href="<?= $linkToDetail ?>" class="btn rounded-100 elevated-btn">Xem chi tiết</a>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- coming soon section end  -->

<!-- category section start -->
<section class="section category__section">
    <div class="flex-column g12">
        <h2 class="text-68">DANH MỤC</h2>
        <label for="" class="label-large-prominent">LEGOUS/</label>
    </div>
    <div class="auto-grid parent-category__wrapper g20 mt30">
        <?= $categoryHtml ?>
    </div>
</section>
<!-- category section end -->

<!-- mobile bottom navbar start -->
<div class="navigation mobile box-shadow5">
    <ul style="width: 100%;display: flex !important; justify-content: space-between">
        <li class="list active">
            <a href="?mod=page&act=home">
                <span class="icon">
                    <ion-icon name="home-outline"></ion-icon>
                </span>
                <span class="text">Trang chủ</span>
            </a>
        </li>
        <li class="list">
            <a href="?mod=page&act=shop&page=1">
                <span class="icon">
                    <ion-icon name="bag-outline"></ion-icon>
                </span>
                <span class="text">Cửa hàng</span>
            </a>
        </li>
        <?php
        if (isset($_SESSION['userLogin']) && is_array($_SESSION['userLogin']) && !empty($_SESSION['userLogin'])) {
            $id_user = $_SESSION['userLogin']['id_user'];
            echo
            <<<HTML
                        <li class="list">
                            <a href="?mod=user&act=general&id_user=$id_user">
                                <span class="icon">
                                    <ion-icon name="person-outline"></ion-icon>
                                </span>
                                <span class="text">Tài khoản</span>
                            </a>
                        </li>
                        HTML;
        } else {
            echo
            <<<HTML
                            <li class="list" style="margin-block: auto; display: flex">
                                <a href="?mod=page&act=home">
                                    <img src="./public/assets/images/logo.png" style="width: 3rem; height: 3rem;">
                                </a>
                            </li>
                    HTML;
        }
        ?>
        <li class="list">
            <a href="#">
                <span class="icon">
                    <ion-icon name="chatbubble-outline"></ion-icon>
                </span>
                <span class="text">Tin nhắn</span>
            </a>
        </li>

        <li class="list">
            <a href="#">
                <span class="icon">
                    <ion-icon name="settings-outline"></ion-icon>
                </span>
                <span class="text">Settings</span>
            </a>
        </li>
        <!-- <div class="indicator"></div> -->
    </ul>
</div>
<!-- mobile bottom navbar end -->