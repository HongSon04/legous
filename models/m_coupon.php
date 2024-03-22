<?php
include_once 'models/m_pdo.php';

function addNewCoupon($code, $name, $discount, $expiredDate, $description, $datenow)
{
    pdo_execute("INSERT INTO coupon (`coupon_code`, `name`, `discount`, `expired_date`, `description`,`create_date`) VALUES(?,?,?,?,?,?)", $code, $name, $discount, $expiredDate, $description, $datenow);
}

function getAllCoupon()
{
    return pdo_query("SELECT * FROM coupon ORDER BY id DESC");
}

function getCouponById($id)
{
    return pdo_query("SELECT * FROM coupon where id = {$id}");
}

function editCoupon($getEditID, $namecoupon, $discountpercent, $description, $expiredDate)
{
    pdo_execute("UPDATE coupon SET name = '$namecoupon', discount = '$discountpercent', description = '$description', expired_date = '$expiredDate' WHERE id = {$getEditID}");
}

function delCoupon($id)
{
    pdo_execute("DELETE From coupon where id = {$id}");
}
?>