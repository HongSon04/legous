<?php

namespace App\model;

class Bill
{
    public function getBill()
    {
        $db = new Database();
        $sql = "SELECT * FROM bill";
        return $db->pdo_queryAll($sql);
    }

    public function getAllBillByIdUser($id) {
        $db = new Database();
        $sql = "SELECT * FROM bill WHERE id_user = {$id}";
        return $db->pdo_queryAll($sql);
    }
    public function getBillInfoById($billId)
    {
        $db = new Database();
        $sql = "SELECT * FROM bill WHERE id_bill = '$billId'";
        return $db->pdo_queryOne($sql);
    }

    public function insertBill($id_user, $id_shipping, $id_payment, $email_user, $phone_user, $address_user, $address_detail_user, $name_recipient, $phone_recipient, $address_recipient, $address_detail_recipient, $total)
    {
        $db = new Database();
        $sql = "INSERT INTO bill (id_user, id_shipping, id_payment, email_user, phone_user, address_user, address_detail_user, name_recipient, phone_recipient, address_recipient, address_detail_recipient, total) VALUES ('$id_user', '$id_shipping', '$id_payment', '$email_user', '$phone_user', '$address_user', '$address_detail_user', '$name_recipient', '$phone_recipient', '$address_recipient', '$address_detail_recipient', '$total')";
        return $db->pdo_execute($sql);
    }

    public function totalBill($cart)
    {
        $total = $subTotal = 0;

        foreach ($cart as $item) {
            extract($item);
            $subTotal += $price * $qty;
        }

        $tax = $subTotal * 0.1;

        $total = $subTotal + $tax;

        return $total;
    }

    public function getBillByID($id)
    {
        $db = new Database();
        $sql = "SELECT * FROM bill WHERE id = {$id}";
        return $db->pdo_queryOne($sql);
    }
    public function get_allBill($id_user)
    {
        $db = new Database();
        $sql = "SELECT * FROM bill WHERE id_user = {$id_user}";
        return $db->pdo_queryAll($sql);
    }

    public function get_total_orders($id_user)
    {
        $db = new Database();
        $sql = "SELECT COUNT(*) FROM bill WHERE id_user = {$id_user}";
        return $db->pdo_query_value($sql);
    }

    public function get_orderHistory($id_user, $current_page, $itemsPage)
    {
        $db = new Database();
        $sql = "SELECT * FROM bill WHERE id_user = {$id_user} ORDER BY id DESC LIMIT {$current_page}, {$itemsPage}";
        return $db->pdo_queryAll($sql);
    }

    public function getLastBill()
    {
        $db = new Database();
        $sql = "SELECT * FROM bill ORDER BY id DESC LIMIT 1";
        return $db->pdo_queryOne($sql);
    }

    public function delete_bill($id_user) {
        $db = new Database();
        $sql = "DELETE FROM bill WHERE id_user = {$id_user}";
        return $db->pdo_execute($sql);
    }
}

?>