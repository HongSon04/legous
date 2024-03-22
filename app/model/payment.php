<?php

namespace App\model;

class Payment {
    public function getPaymentMethods() {
        $db = new database();
        $sql = "SELECT * FROM payment";
        return $db->pdo_queryAll($sql);
    }

    public function getPaymentMethodByPrice($price) {
        $db = new database();
        $sql = "SELECT * FROM payment WHERE price = {$price}";
        return $db->pdo_queryOne($sql);
    }

    public function getPaymentMethodById($id) {
        $db = new database();
        $sql = "SELECT * FROM payment WHERE id = {$id}";
        return $db->pdo_queryOne($sql);
    }

    public function get_namePayment($id_payment) {
        $db = new database();
        $sql = "SELECT name FROM payment WHERE id = {$id_payment}";
        return $db->pdo_query_value($sql);
    }
}
