<?php

namespace App\model;

class Address {

    public function getAddress() {
        $db = new database();
        $sql = "SELECT * FROM address";
        return $db->pdo_queryAll($sql);
    }
    public function getAddressById($id) {
        $db = new database();
        $sql = "SELECT * FROM address WHERE id = $id";
        return $db->pdo_queryOne($sql);
    }

    public function get_addressByIdUser($id) {
        $db = new database();
        $sql = "SELECT * FROM address WHERE id_user = $id AND is_default = 0";
        return $db->pdo_queryAll($sql);
    }

    public function getDefaultAddressByIdUser($id) {
        $db = new database();
        $sql = "SELECT * FROM address WHERE id_user = {$id} AND is_default = 1";
        return $db->pdo_queryOne($sql);
    }

    public function get_address($id_user) {
        $db = new database();
        $sql = "SELECT * FROM address WHERE id_user = {$id_user}";
        return $db->pdo_queryAll($sql);
    }

    public function set_defaultAddress($id_address) {
        $db = new database();
        $sql = "UPDATE address SET is_default = 1 WHERE id = {$id_address}";
        $db->pdo_execute($sql);
    }
    public function delete_address_byIduser($id_user) {
        $db = new database();
        $sql = "DELETE FROM address WHERE id_user = {$id_user}";
        $db->pdo_execute($sql);
    }

    public function getAllAddress() {
        $db = new database();
        $sql = "SELECT * FROM address";
        return $db->pdo_queryAll($sql);
    }
    public function getAllAddressByUser($id) {
        $db = new database();
        $sql = "SELECT * FROM address WHERE id_user = {$id}";
        return $db->pdo_queryAll($sql);
    }

    public function check_addressDefault() {
        $db = new database();
        $sql = "SELECT * FROM address WHERE is_default = 1";
        return $db->pdo_queryAll($sql);
    }

    public function un_addressDefault($is_addressDefault) {
        $db = new database();
        $sql = "UPDATE address SET is_default = 0 WHERE is_default = {$is_addressDefault}";
        $db->pdo_execute($sql);
    }

    public function add_address($name_user, $phone_user, $address_detail, $address_user, $address_default, $id_user) {
        $db = new database();
        $sql = "INSERT INTO address (name_user, phone_user, address_detail, address_user, is_default, id_user) VALUES ('$name_user', '$phone_user', '$address_detail', '$address_user', '$address_default', '$id_user')";
        $db->pdo_execute($sql);
    }
}
