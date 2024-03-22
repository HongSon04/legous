<?php

namespace App\model;

class Admin {
    public function productAdmin($page = 1) {
        $db = new database();
        $batdau = ($page - 1) * 9;
        $sql = "SELECT p.*, c.name AS category_name FROM product p LEFT JOIN category c ON p.id_category = c.id LIMIT $batdau,9 ";
        return $db->pdo_queryAll($sql);
    }


    public function product_CountTotal() {
        $db = new database();
        $sql = "SELECT COUNT(*) FROM product";
        return $db->pdo_query_value($sql);
    }

    public function product_getById($id) {
        $db = new database();
        $sql = "SELECT * FROM product WHERE id = $id";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function remove_product($id) {
        $db = new database();
        $sql = "DELETE FROM product WHERE id = {$id}";
        $db->pdo_execute($sql);
    }

    public function getAllImages($id) {
        $db = new database();
        $sql = "SELECT * FROM images WHERE id_product = {$id}";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function deleteImage($id) {
        $db = new database();
        $sql = "DELETE FROM images WHERE id = {$id}";
        $db->pdo_execute($sql);
    }

    public function count_Categoris() {
        $db = new database();
        $sql = "SELECT COUNT(*) AS soluong FROM category";
        return $db->pdo_queryOne($sql);
    }

    public function get_Categories($start = 0, $limit = 0, $kyw_cg = "", $sort = 0, $id = 0) {
        $db = new database();
        $sql = "SELECT * FROM category";

        if ($kyw_cg != "") {
            $sql .= " WHERE name LIKE '%$kyw_cg%'";
        }

        if ($sort > 0) {
            if ($sort == 1) {
                $sql .= " ORDER BY id DESC";
            } elseif ($sort == 2) {
                $sql .= " ORDER BY name DESC";
            } elseif ($sort == 3) {
                $sql .= " ORDER BY name ASC";
            }
        }

        if ($limit > 0) {
            $sql .= " LIMIT $start, $limit";
        }
        if ($id > 0) {
            $sql .= " WHERE id = $id";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function count_products_category($id) {
        $db = new database();
        $sql = "SELECT COUNT(product.id) AS SLSP 
            FROM category 
            LEFT JOIN product ON category.id = product.id_category 
            WHERE category.id = ? 
            GROUP BY category.id";
        return $db->pdo_queryAll($sql);
    }

    public function delete_category($id) {
        $db = new database();
        $sql = "DELETE FROM category WHERE id = {$id}";
        $db->pdo_execute($sql);
    }

    public function getidCategories($id) {
        $db = new database();
        $sql = "SELECT * FROM category WHERE id = {$id}";
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function update_Category($id_category, $name_cg, $description_cg, $img_cg, $is_appear, $is_special) {
        $db = new database();
        $sql = "UPDATE category SET name = '$name_cg', description = '$description_cg', img = '$img_cg', is_appear = '$is_appear', is_special = '$is_special' WHERE id = '$id_category'";
        $db->pdo_execute($sql);
    }

    public function shipping($id) {
        $db = new database();
        $sql = "SELECT * FROM shipping WHERE id = {$id}";
        return $db->pdo_queryAll($sql);
    }

    public function payment($id) {
        $db = new database();
        $sql = "SELECT * FROM payment WHERE id = {$id}";
        return $db->pdo_queryAll($sql);
    }

    public function get_Order_bill($filter = "", $status = 0, $id_user = 0) {
        $db = new database();
        $sql = "SELECT * FROM bill  ";
        if ($filter == "old") {
            $sql .= " ORDER BY id DESC";
        } elseif ($filter == "price") {
            $sql .= " WHERE total >=   1000000 ORDER BY total";
        }
        if ($status > 0) {
            $sql .= " WHERE status = $status ORDER BY status";
        }
        if ($id_user > 0) {
            $sql .= " WHERE id_user = {$id_user}";
        }
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function searchUser($inputSearch) {
        $db = new database();
        $sql = "SELECT * FROM user WHERE name LIKE '%$inputSearch%' OR email LIKE '%$inputSearch%' OR phone LIKE '%$inputSearch%' OR address LIKE '%$inputSearch%'";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }

    public function get_OneOrder_bill($id) {
        $db = new database();
        $sql = "SELECT * FROM bill";
        if ($id > 0) {
            $sql .= " WHERE id = $id";
        }
        $result = $db->pdo_queryOne($sql);
        return $result;
    }

    public function update_Change_status($change_status, $id) {
        $db = new database();
        $sql = "UPDATE bill SET status = '$change_status' WHERE id = '$id'";
        $db->pdo_execute($sql);
    }

    public function del_bill($id) {
        $db = new database();
        $sql = "DELETE FROM bill WHERE id = {$id}";
        $db->pdo_execute($sql);
    }

    public function getTotalBillByMonthDone($month, $year) {
        $db = new database();
        $sql = "SELECT SUM(total) AS total FROM bill WHERE status = 5 AND MONTH(create_date) = $month AND YEAR(create_date) = $year";
        return $db->pdo_queryOne($sql);
    }
}
