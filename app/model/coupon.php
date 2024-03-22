<?php
namespace App\model;

class Coupon
{
    public function addNewCoupon($code, $name, $discount, $expiredDate, $description, $datenow)
    {
        $db = new Database();
        $sql = "INSERT INTO coupon (coupon_code, name, discount, expired_date, description, create_date) VALUES ('$code', '$name', '$discount', '$expiredDate', '$description', '$datenow')";
        return $db->pdo_execute($sql);
    }

    public function getAllCoupon()
    {
        $db = new Database();
        $sql = "SELECT * FROM coupon";
        return $db->pdo_queryAll($sql);
    }

    public function getCouponById($id)
    {
        $db = new Database();
        $sql = "SELECT * FROM coupon WHERE id = {$id}";
        return $db->pdo_queryAll($sql);
    }

    public function editCoupon($getEditID, $namecoupon, $discountpercent, $description, $expiredDate)
    {
        $db = new Database();
        $sql = "UPDATE coupon SET name = '$namecoupon', discount = '$discountpercent', description = '$description', expired_date = '$expiredDate' WHERE id = {$getEditID}";
        return $db->pdo_execute($sql);
    }

    public function delCoupon($id)
    {
        $db = new Database();
        $sql = "DELETE FROM coupon WHERE id = {$id}";
        return $db->pdo_execute($sql);
    }

}
?>