<?php

namespace App\model;

class Shipping {
    public function getShippingMethods() {
        $db = new database();
        $sql = "SELECT * FROM shipping";
        return $db->pdo_queryAll($sql);
    }

    public function getShippingMethodByPrice($price) {
        $db = new database();
        $sql = "SELECT * FROM shipping WHERE price = {$price}";
        return $db->pdo_queryAll($sql);
    }
}
