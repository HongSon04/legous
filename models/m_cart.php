<?php
include_once 'm_pdo.php';
function getAllCart()
{
  return pdo_query("SELECT * FROM cart");
}
function check_idbillCart($Get_Id_Order) {
  return pdo_query("SELECT * FROM cart WHERE id_bill = $Get_Id_Order");
}
function getNew10Cart() {
  return pdo_query("SELECT * FROM cart ORDER BY id DESC LIMIT 10");
}

function insertCart($idUser, $id_product, $name, $price, $img, $qty, $totalCost)
{
  $sql = "INSERT INTO 
              cart (id_user, id_product, name, price, img, qty, total_cost) 
            VALUES 
              ('$idUser', '$id_product', '$name', '$price', '$img', '$qty', '$totalCost') ";
  pdo_execute($sql);
}
function getAllCartByIdUser($id)
{
  return pdo_query("SELECT * FROM cart WHERE id_user = {$id}");
}

function removeCartProduct($idUser, $idProduct)
{
  $sql = "DELETE FROM cart WHERE id_user = $idUser AND id_product = $idProduct";
  pdo_execute($sql);
}

function getCartByUserId($idUser)
{
  $sql = "SELECT * FROM cart WHERE id_user = $idUser";
  return pdo_query($sql);
}
function insertCartWithIdBill($idBill, $idUser, $id_product, $name, $price, $img, $qty, $totalCost)
{
  $sql = "INSERT INTO 
              cart (id_bill, id_user, id_product, name, price, img, qty, total_cost) 
            VALUES 
              ('$idBill', '$idUser', '$id_product', '$name', '$price', '$img', '$qty', '$totalCost') ";
  pdo_execute($sql);
}
function getCartByIdBill($idBill)
{
  $sql = "SELECT * FROM cart WHERE id_bill = $idBill";
  return pdo_query($sql);
}

function getProductFromDatabaseCart($user_id, $id_product)
{
  $sql = "SELECT * FROM cart WHERE id_product = $id_product AND id_user = $user_id";
  return pdo_query($sql);
}

function updateProductInDatabaseCart($user_id, $id, $newQty, $newTotalCost)
{
  $sql = "UPDATE cart
            SET qty='$newQty', total_cost=$newTotalCost
            WHERE id_user=$user_id AND id_product=id";
  pdo_execute($sql);
}

function get_order($id_order)
{
  return pdo_query("SELECT * FROM bill WHERE id = ? ", $id_order);
}

function get_product_order($id_order)
{
  return pdo_query("SELECT * FROM cart WHERE id_bill = ?", $id_order);
}
function get_orderHistory($id_user, $current_page, $itemsPage)
{
  $startItem = ($current_page - 1) * $itemsPage;
  $query = "SELECT * FROM bill WHERE id_user = $id_user ORDER BY id DESC LIMIT $startItem, $itemsPage";
  return pdo_query($query);
}

function get_total_orders($id_user)
{
  return pdo_query_value("SELECT COUNT(*) FROM bill WHERE id_user = ?", $id_user);
}
function get_allBill($id_user)
{
  return pdo_query("SELECT * FROM bill WHERE id_user = ?", $id_user);
}
function get_id_bill_cart($id_bill)
{
  return pdo_query("SELECT id FROM cart WHERE id_bill = ?", $id_bill);
}
function getAllBillByIdUser($id)
{
  return pdo_query("SELECT * FROM bill WHERE id_user = ?", $id);

}
function getBill()
{
  return pdo_query("SELECT * FROM bill");
}
function getBillByID($id)
{
  return pdo_query("SELECT * FROM bill WHERE id = {$id}");
}
function get_id_bill($id_user)
{
  return pdo_query("SELECT id FROM bill WHERE id_user = ?", $id_user);
}
function delete_bill_fromCart($id_user)
{
  pdo_execute("DELETE FROM cart WHERE id_user = {$id_user}");
}
function delete_bill($id_user)
{
  pdo_execute("DELETE FROM bill WHERE id_user = {$id_user}");
}
function updateIdBillInCart($id_user, $id_bill)
{
  $sql = "UPDATE cart
            SET id_bill = $id_bill 
            WHERE id_user = $id_user";
}
?>