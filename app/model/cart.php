<?php

namespace App\model;

class Cart
{
    public function insertCart($idUser, $id_product, $name, $price, $img, $qty, $totalCost)
    {
        $db = new database();
        $sql = "INSERT INTO cart (id_user, id_product, name, price, img, qty, total_cost) VALUES ('$idUser', '$id_product', '$name', '$price', '$img', '$qty', '$totalCost')";
        return $db->pdo_execute($sql);
    }

    public function getCartByIdBill($idBill) {
        $db = new database();
        $sql = "SELECT * FROM cart WHERE id_bill = {$idBill}";
        return $db->pdo_queryAll($sql);
    }

    public function insertCartWithIdBill($idBill, $idUser, $id_product, $name, $price, $img, $qty, $totalCost) {
        $db = new database();
        $sql = "INSERT INTO cart (id_bill, id_user, id_product, name, price, img, qty, total_cost) VALUES ('$idBill', '$idUser', '$id_product', '$name', '$price', '$img', '$qty', '$totalCost')";
        return $db->pdo_execute($sql);
    }

    public function getNew10Cart() {
        $db = new database();
        $sql = "SELECT * FROM cart ORDER BY id DESC LIMIT 10";
        return $db->pdo_queryAll($sql);
    }

    public function get_product_order($id) {
        $db = new database();
        $sql = "SELECT * FROM cart WHERE id_bill = {$id}";
        return $db->pdo_queryAll($sql);
    }

    public function check_idbillCart($Get_Id_Order) {
        $db = new database();
        $sql = "SELECT * FROM cart WHERE id_bill = {$Get_Id_Order}";
        return $db->pdo_queryAll($sql);
    }

    public function getAllCart() {
        $db = new database();
        $sql = "SELECT * FROM cart";
        return $db->pdo_queryAll($sql);
    }

    public function getAllCartByIdUser($id) {
        $db = new database();
        $sql = "SELECT * FROM cart WHERE id_user = {$id}";
        return $db->pdo_queryAll($sql);
    }

    public function delete_bill_fromCart($id_user) {
        $db = new database();
        $sql = "DELETE FROM cart WHERE id_user = {$id_user}";
        return $db->pdo_execute($sql);
    }
}

?>