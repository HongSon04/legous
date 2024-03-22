<?php 
    function getProducts ($limit = 0, $order = 0) {
        $sql = "SELECT * FROM product";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        if ($order != 0) {
            $sql .= " ORDER BY name DESC";
        }

        return pdo_query($sql);
    }

    function getProductByQuery($query) {
        $sql = "SELECT * FROM product WHERE name LIKE '%$query%' LIMIT 20";
        return pdo_query($sql);
    }

    function getProductById($idProduct) {
        $sql = "SELECT * FROM product WHERE id = $idProduct";
        return pdo_query_one($sql);
    }

    function getProductsByCategoryId($id_category, $order = 0, $limit = 0) {
        $sql = "SELECT * FROM product WHERE id_category = $id_category";

        if ($order != 0) {
            $sql .= " ORDER BY name DESC";
        }

        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }

        return pdo_query($sql);
    }

    function getProductsByCategoryIds($categoryIds, $order = 0, $limit = 0) {
        $categoryIds = implode(',', $categoryIds);
        $sql = "SELECT * FROM product WHERE id_category IN ($categoryIds)";

        if ($order != 0) {
            $sql .= " ORDER BY name DESC";
        }

        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }

        return pdo_query($sql);
    }
    
    function getProductsByLove ($limit = 0) {
        $sql = "SELECT * FROM product ORDER BY love DESC";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        return pdo_query($sql);
    }

    function getFeatureProduct () {
        $sql = "SELECT * FROM product WHERE is_upcomming > 0 LIMIT 1";
        return pdo_query_one($sql);
    }
    
    function getSpecialProduct() {
        $sql = "SELECT * FROM product WHERE is_special > 0 LIMIT 1";
        return pdo_query_one($sql);
    }

    function getFeatureProductOfCategory ($idCategory , $limit = 0) {
        $sql = "SELECT * FROM product WHERE id_category = $idCategory AND is_feature = 1";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        return pdo_query($sql);
    }

    function getCategoryProductsByPriceFilter($min , $max , $idCategory) {
        $sql = "SELECT * FROM product WHERE id_category = $idCategory AND price BETWEEN $min AND $max";
        return pdo_query($sql);
    }
    function getProductsByPriceFilter($min , $max) {
        $sql = "SELECT * FROM product WHERE price BETWEEN $min AND $max";
        return pdo_query($sql);
    }
    function getMaxProductPrice() {
        $sql = "SELECT MAX(price) AS max_price FROM product";
        return pdo_query_value($sql);
    }
    function getMinProductPrice() {
        $sql = "SELECT MIN(price) AS min_price FROM product";
        return pdo_query_value($sql);
    }

    function getRelatedProduct($idCategory, $limit=0) {
        $sql = "SELECT * FROM product WHERE id_category = $idCategory";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        return pdo_query($sql);
    }
    

    function updateProductViewById($id, $view) {
        $sql = "UPDATE product SET views = $view WHERE id = $id";
        pdo_execute($sql);
    }

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

    function getProductWithLimitAndOffset($limit , $offset) {
        $sql = "SELECT * FROM product LIMIT $limit OFFSET $offset";
        return pdo_query($sql);
    }
    function getCategoryProductWithLimitAndOffset($limit , $offset , $idCategory) {
        $sql = "SELECT * FROM product WHERE id_category = $idCategory LIMIT $limit OFFSET $offset";
        return pdo_query($sql);
    }
    function getSearchProductWithLimitAndOffset($limit , $offset , $query) {
        $sql = "SELECT * FROM product WHERE name LIKE '%$query%' LIMIT $limit OFFSET $offset";
        return pdo_query($sql);
    }

    function getProductQtyById ($idProduct) {
        $sql = "SELECT qty FROM product WHERE id = $idProduct";
        return pdo_query_value($sql);
    }
    function updateProductQty($idProduct, $newQty) {
        $sql = "UPDATE product SET qty = $newQty WHERE id = $idProduct";
        pdo_execute($sql);
    }
?>