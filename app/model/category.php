<?php

namespace App\model;


class Category {
    private $id = 0;
    private $name = "";
    private $img = "";
    private $description = "";

    private $bg_color = "";
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

    public function setImg($img) {
        return $this->img = $img;
    }

    public function getImg() {
        return $this->img;
    }

    public function setDescription($description) {
        return $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setBgColor($bg_color) {
        return $this->bg_color = $bg_color;
    }

    public function getBgColor() {
        return $this->bg_color;
    }

    public function setCreateDate($create_date) {
        return $this->create_date = $create_date;
    }

    public function getCreateDate() {
        return $this->create_date;
    }

    public function setUpdateDate($update_date) {
        return $this->update_date = $update_date;
    }

    public function getUpdateDate() {
        return $this->update_date;
    }

    public function getCategory($limit = 0, $data = []) {
        $db = new Database();
        $sql = "SELECT * FROM category";
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        } elseif ($data == "DESC") {
            $sql .= " ORDER BY id DESC";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getCategoryById($id) {
        $db = new Database();
        $sql = "SELECT * FROM category WHERE id = {$id}";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function getIdCategoryByIdProducts($idProduct) {
        $db = new Database();
        $sql = "SELECT id_category FROM product WHERE id = {$idProduct}";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function getFeatureCategories() {
        $db = new Database();
        $sql = "SELECT * FROM category WHERE is_special = 1";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }
    public function getCategories($start = 0, $limit = 0, $kyw = "") {
        $db = new Database();
        $sql = "SELECT * FROM category";
        if ($limit > 0) {
            $sql .= " LIMIT " . $start . "," . $limit;
        }

        if ($kyw != "") {
            $sql .= " AND LIKE '%" . $kyw . "%'";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function getproductbyCategory($id) {
        $db = new Database();
        $sql = "SELECT p.*, c.name AS category_name FROM product p LEFT JOIN category c ON p.id_category = c.id WHERE c.id = $id";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }
}
