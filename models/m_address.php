<?php
include_once 'm_pdo.php';
# address start

function getAddress()
{
    $sql = "SELECT * FROM address";
    return pdo_query_one($sql);
}
function getAllAddress()
{
    return pdo_query("SELECT * FROM address");
}
function get_address($id_user)
{
    return pdo_query("SELECT * FROM address WHERE id_user = ?", $id_user);
}
function getAllAddressByUser($id)
{
    return pdo_query("SELECT * FROM address WHERE id_user = {$id}");
}
function get_addressByid($id_address)
{
    $sql = "SELECT * FROM address WHERE id = '$id_address'";
    return pdo_query($sql);
}
function get_addressMainByIdUser($id)
{
    return pdo_query("SELECT * FROM address WHERE id_user = '$id' AND is_default = 1");
}
function get_addressByIdUser($id)
{
    return pdo_query("SELECT * FROM address WHERE id_user = $id AND is_default = 0");
}
function getDefaultAddressByIdUser($id)
{
    return pdo_query("SELECT * FROM address WHERE id_user = $id AND is_default = 1");
}
function check_addressDefault()
{
    $sql = "SELECT * FROM address WHERE is_default = '1'";
    return pdo_query($sql);
}

function add_address($name_user, $phone_user, $address_detail, $address_user, $address_default, $id_user)
{
    pdo_execute("INSERT INTO address (`id_user`,`username`,`address`,`address_detail`,`phone`,`is_default`) VALUES(?,?,?,?,?,?)", $id_user, $name_user, $address_user, $address_detail, $phone_user, $address_default);
}
function addAddressEmail($id_user, $address, $detailedAddress, $role, $phone)
{
    pdo_execute("INSERT INTO address (id_user, address, address_detail, is_default, phone) VALUES ('$id_user', '$address', '$detailedAddress', '$role', '$phone')");
}


function un_addressDefault($is_addressDefault)
{
    pdo_execute("UPDATE address SET is_default = 0 WHERE id = " . $is_addressDefault);
}

function set_defaultAddress($id_address)
{
    pdo_execute("UPDATE address SET is_default = 1 WHERE id = " . $id_address);
}

function upadate_address($name_user, $phone_user, $address_detail, $address_user, $address_default, $id_address)
{
    pdo_execute("UPDATE address SET username = ?, address=?, address_detail=?, phone = ?, is_default = ?  WHERE id = ?", $name_user, $address_user, $address_detail, $phone_user, $address_default, $id_address);
}
function update_addressmain($id_user, $text, $phone)
{
    pdo_execute("UPDATE address SET address_detail = '$text', phone = '$phone' where id_user = {$id_user} AND is_default = 1");
}
function delete_address($id_address)
{
    pdo_execute("DELETE FROM address WHERE id = ?", $id_address);
}
function delete_address_byIduser($id_user)
{
    pdo_execute("DELETE FROM address WHERE id_user = ?", $id_user);
}
function updateAddresById($id, $phone, $role, $address, $detailedAddress)
{
    pdo_execute("UPDATE address SET phone = '$phone', is_default = {$role}, address = '$address', address_detail = '$detailedAddress' WHERE id = '$id'");
}
function searchAddress($inputSearch)
{
    return pdo_query("SELECT * FROM address WHERE phone LIKE '%$inputSearch%' OR address LIKE '%$inputSearch%' OR address_detail LIKE '%$inputSearch%'");
}
?>