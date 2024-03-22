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
function formatViewsNumber($views)
{
    if ($views >= 1000000) {
        // Convert to millions
        $formattedViews = round($views / 1000000, 1) . 'm+';
    } elseif ($views >= 1000) {
        // Convert to thousands
        $formattedViews = round($views / 1000, 1) . 'k+';
    } else {
        // No conversion needed
        $formattedViews = $views . '+';
    }

    return $formattedViews;
}
function formatVND($amount) {
    $formattedAmount = number_format($amount, 0, ',', '.');
    $formattedAmount .= ' đ';
    
    return $formattedAmount;
}

// search engine
if (isset($_POST['search'])) {
    $Name = $_POST['search'];

    // connect database
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=legous_db", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
        // fetch data
        $Query = "SELECT * FROM product WHERE name LIKE '%$Name%' LIMIT 20";

        $stmt = $conn->prepare($Query);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $productList = $stmt->fetchAll();
        $conn = null;

        foreach ($productList as $item) {
            extract($item);
            $imgPath = "./public/assets/media/images/product/$img";
            $linkToDetail = "?mod=page&act=productDetail&idProduct=$id";

            $priceView = '';
            $salePriceView = '';

            if (isset($price) && $price > 0) {
                $priceView = '<div class="search__product__price title-medium">' . formatVND($price) . '</div>';
            } else {
                $priceView = '<div class="search__product__price title-medium">Đang cập nhật</div>';
            }

            if (isset($promotion) and $promotion > 0) {
                $salePrice = $price - $price * $promotion / 100;
                $salePriceView = '<div class="search__product__price title-medium">' . formatVND($salePrice) . '</div>';
                $priceView = '<del class="search__product__price title-medium">' . formatVND($price) . '</del>';
            } else {
                $salePriceView = '';
                $priceView = '<div class="search__product__price title-medium">' . formatVND($price) . '</div>';
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
            
            echo '
                    <!-- single search product start -->
                    <div class="search__product flex-between p20 rounded-8 width-full">
                        <div class="flex g12">
                            <div class="search__product__banner">
                                <img src="'. $imgPath .'" alt="">
                            </div>
                            <div class="search__product__info flex-column flex-between">
                                <a href="?mod=page&act=productDetail&idProduct='.$id.'" class="search__product__name title-large underline">'.$name.'</a>
                                '.$priceView.
                                $salePriceView.'
                            </div>
                        </div>
                        <div class="flex-between flex-column a-end">
                            <button class="icon-btn delete-search-product__btn"><i class="fal fa-times"></i></button>
                            <div class="flex g12">
                                '.$productBtn.'
                            </div>
                        </div>
                    </div>
                    <!-- single search product end -->
                ';
        }
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
}

?>