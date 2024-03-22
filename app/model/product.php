<?php

namespace app\model;


class Product {
    private $id = 0;
    private $name = "";
    private $price = 0;
    private $promotion = "";
    private $img = "";
    private $qty = 0;
    private $views = 0;
    private $love = 0;
    private $purchases = 0;
    private $short_detail = "";
    private $description = "";
    private $is_special = 0;
    private $is_trending = 0;
    private $is_feature = 0;
    private $is_upcoming = 0;
    private $create_date = "";
    private $update_date = "";


    public function setId($id) {
        return $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        return $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setPrice($price) {
        return $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPromotion($promotion) {
        return $this->promotion = $promotion;
    }

    public function getPromotion() {
        return $this->promotion;
    }

    public function setImg($img) {
        return $this->img = $img;
    }

    public function getImg() {
        return $this->img;
    }

    public function setQty($qty) {
        return $this->qty = $qty;
    }

    public function getQty() {
        return $this->qty;
    }

    public function setViews($views) {
        return $this->views = $views;
    }

    public function getViews() {
        return $this->views;
    }

    public function setLove($love) {
        return $this->love = $love;
    }

    public function getLove() {
        return $this->love;
    }

    public function setPurchases($purchases) {
        return $this->purchases = $purchases;
    }

    public function getPurchases() {
        return $this->purchases;
    }

    public function setShort_detail($short_detail) {
        return $this->short_detail = $short_detail;
    }

    public function getShort_detail() {
        return $this->short_detail;
    }

    public function setDescription($description) {
        return $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setIs_special($is_special) {
        return $this->is_special = $is_special;
    }

    public function getIs_special() {
        return $this->is_special;
    }

    public function setIs_trending($is_trending) {
        return $this->is_trending = $is_trending;
    }

    public function getIs_trending() {
        return $this->is_trending;
    }

    public function setIs_feature($is_feature) {
        return $this->is_feature = $is_feature;
    }

    public function getIs_feature() {
        return $this->is_feature;
    }

    public function setIs_upcoming($is_upcoming) {
        return $this->is_upcoming = $is_upcoming;
    }

    public function getIs_upcoming() {
        return $this->is_upcoming;
    }

    public function setCreate_date($create_date) {
        return $this->create_date = $create_date;
    }

    public function getCreate_date() {
        return $this->create_date;
    }

    public function setUpdate_date($update_date) {
        return $this->update_date = $update_date;
    }

    public function getUpdate_date() {
        return $this->update_date;
    }

    public function getProduct($limit = 0, $data = []) {
        $db = new database();
        $sql = "SELECT * FROM product";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        } elseif ($data == "DESC") {
            $sql .= " ORDER BY id DESC";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getProductById($id) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE id = $id";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }
    public function getProducts($limit = 0, $order = 0) {
        $db = new database();
        $sql = "SELECT * FROM product";
        if ($order == 1) {
            $sql .= " ORDER BY id DESC";
        }

        if($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }
    public function getProductsByLove($limit = 0, $data = []) {
        $db = new database();
        $sql = "SELECT * FROM product ORDER BY love DESC";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }elseif ($data == "DESC") {
            $sql .= " ORDER BY id DESC";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getProductByCategoryId($id, $data = [], $limit = 0) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE id_category = $id";
        if ($data == "DESC") {
            $sql .= " ORDER BY id DESC";
        }
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getFeatureProduct() {
        $db = new database();
        $sql = "SELECT * FROM product WHERE is_feature = 1";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getPartner($limit = 0) {
        $db = new database();
        $sql = "SELECT * FROM partner";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function updateProductViewById($id, $view) {
        $db = new database();
        $sql = "UPDATE product SET views = $view WHERE id = $id";
        $db->pdo_execute($sql);
    }

    public function getRelatedProduct($idCategory, $limit = 0) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE id_category = {$idCategory}";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }
    public function getProductWithLimitAndOffset($limit, $offset) {
        $db = new database();
        $sql = "SELECT * FROM product LIMIT {$limit} OFFSET {$offset}";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getProductsByPriceFilter($min, $max) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE price BETWEEN {$min} AND {$max}";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }
    public function getProductsByCategoryId($id_category, $order = 0, $limit = 0) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE id_category = {$id_category}";

        if ($order != 0) {
            $sql .= " ORDER BY name DESC";
        }

        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }
        return $result = $db->pdo_queryAll($sql);
    }

    public function getProductsByCategoryIds($categoryIds, $order = 0, $limit = 0)
    {
        $db = new database();
        $sql = "SELECT * FROM product WHERE id_category IN '$categoryIds'";
        if ($order == 1) {
            $sql .= " ORDER BY id DESC";
        }
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getMaxProductPrice() {
        $db = new database();
        $sql = "SELECT MAX(price) AS max_price FROM product";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function getMinProductPrice() {
        $db = new database();
        $sql = "SELECT MIN(price) AS min_price FROM product";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function getSpecialProduct() {
        $db = new database();
        $sql = "SELECT * FROM product WHERE is_special > 0 LIMIT 1";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function getProductQtyById ($idProduct) {
        $db = new database();
        $sql = "SELECT qty FROM product WHERE id = {$idProduct}";
        $result = $db->pdo_query_value($sql);
        return $result;
    }

    public function updateProductQty($idProduct, $newQty) {
        $db = new database();
        $sql = "UPDATE product SET qty = {$newQty} WHERE id = {$idProduct}";
        $db->pdo_execute($sql);
    }

    public function updateProductPurchases($idProduct, $purchases) {
        $db = new database();
        $sql = "UPDATE product SET purchases = {$purchases} WHERE id = {$idProduct}";
        $db->pdo_execute($sql);
    }

    public function getFeatureProductOfCategory ($idCategory , $limit = 0) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE id_category = {$idCategory} AND is_feature = 1";
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getCategoryProductsByPriceFilter($min , $max , $idCategory) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE price BETWEEN {$min} AND {$max} AND id_category = {$idCategory}";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getCategoryProductWithLimitAndOffset($limit , $offset , $idCategory) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE id_category = {$idCategory} LIMIT {$limit} OFFSET {$offset}";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function product_checkName($name) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE name = '$name'";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function product_add($name,$id_category,$description,$price, $img, $qty) {
        $db = new database();
        $sql = "INSERT INTO product(name,id_category,description,price,img,qty) VALUES ('$name','$id_category','$description','$price','$img','$qty')";
        $db->pdo_execute($sql);
    }


    public function product_edit($id,$name,$id_category,$description,$price, $img, $qty) {
        $db = new database();
        $sql = "UPDATE product SET name = '$name', id_category = '$id_category', description = '$description', price = '$price', img = '$img', qty = '$qty' WHERE id = {$id}";
        $db->pdo_execute($sql);
    }
}
