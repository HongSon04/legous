<?php
include_once 'models/m_pdo.php';

# Lấy account đã đnăg xuất
function get_accountUser($value)
{
    return pdo_query("SELECT * FROM user WHERE id = ?", $value);
}

# general - edit profile
function checkAccount($id_user)
{
    return pdo_query_one("SELECT * FROM user WHERE id = ?", $id_user);
}
function checkAccounts($id_account)
{
    return pdo_query_one("SELECT * FROM user WHERE id = ?", $id_account);
}

function get_userBy_email_password($email_user, $password_user)
{
    return pdo_query("SELECT * FROM user WHERE email = ? AND password = ?", $email_user, $password_user);
}

function getUserById($idUser)
{
    $sql = "SELECT * FROM user WHERE id = $idUser";
    return pdo_query($sql);
}
function getUserByEmail($email)
{
    return pdo_query_one("SELECT * FROM user where email = '$email'");
}
// chỉnh sửa thông tin người dùng từ mã tài khoản
function update_userName_email($new_username, $new_email, $id_user)
{
    pdo_execute("UPDATE user SET username=?, email=? WHERE id = ?", $new_username, $new_email, $id_user);
}

function update_fullName_country_bio_avatar($new_fullname, $country, $bio, $new_avatar, $id_user)
{
    pdo_execute("UPDATE user SET img = ?, fullname=?, country=?, bio = ?  WHERE id = ?", $new_avatar, $new_fullname, $country, $bio, $id_user);
}

function remove_avatar($new_avatar, $id_user)
{
    pdo_execute("UPDATE user SET img = ? WHERE id = ?", $new_avatar, $id_user);
}

function get_imgAvatar($id_user)
{
    return pdo_query_one("SELECT img FROM user WHERE id = ?", $id_user);
}
# edit profile end




function insertUser($username, $email, $password)
{
    $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)"; // Use parameterized query
    $userId = pdo_execute($sql, $username, $email, $password);
    return $userId; // Return the last inserted ID
}

function checkUser($email, $password)
{
    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    return pdo_query_one($sql);
}

function getUserByInfo($email, $password)
{
    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    return pdo_query_one($sql);
}

function generateRandomUsername($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $username = '';

    $charactersLength = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $username .= $characters[rand(0, $charactersLength - 1)];
    }

    return $username;
}

function generateRandomPassword($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
    $password = '';

    $charactersLength = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }

    return $password;
}


function getUser()
{
    return pdo_query("SELECT * FROM user ORDER BY id");
}
function getFullNameUser()
{
    $result = pdo_query("SELECT username FROM user");
    $usernames = array();
    foreach ($result as $row) {
        $usernames[] = $row['username'];
    }
    return $usernames;
}
function getUserInfo($id)
{
    return pdo_query("SELECT * FROM user WHERE id = {$id}");
}
function searchUser($inputSearch)
{
    return pdo_query("SELECT * FROM user WHERE fullname LIKE '%$inputSearch%' OR username LIKE '%$inputSearch%' OR email LIKE '%$inputSearch%' or phone LIKE '%$inputSearch%'");
}

# password
function get_password($id_user)
{
    return pdo_query_value("SELECT password FROM user WHERE id = ?", $id_user);
}
function update_password($new_password, $id_user)
{
    pdo_execute("UPDATE user SET password = ? WHERE id = ?", $new_password, $id_user);
}

#order

function get_namePayment($id_payment)
{
    return pdo_query_value("SELECT name FROM payment WHERE id = ?", $id_payment);
}
function get_nameShipping($id_shipping)
{
    return pdo_query_value("SELECT name FROM shipping WHERE price = ?", $id_shipping);
}
function get_fullname($id_user)
{
    return pdo_query_value("SELECT fullname FROM user WHERE id = ?", $id_user);
}


function get_priceShipping($id_shipping)
{
    return pdo_query_value("SELECT price FROM shipping WHERE price = ?", $id_shipping);
}
function get_priceCoupon($id_coupon)
{
    return pdo_query_value("SELECT price FROM coupon WHERE id = ?", $id_coupon);
}

# delete account
function get_id_comments($id_user)
{
    return pdo_query("SELECT id FROM comment WHERE id_user = ?", $id_user);
}



function editUserProfile($id, $fullname, $username, $password, $email, $image, $role, $bio, $phone)
{
    pdo_execute("UPDATE user SET fullname = '$fullname', username = '$username', email = '$email', password = '$password', img = '$image', role = '$role', bio = '$bio', phone = '$phone' WHERE id = " . $id);
}
function addUserProfile($fullname, $username, $password, $email, $image, $role, $bio, $phone)
{
    pdo_execute("INSERT INTO user (fullname, username, email, password, img, role, bio, phone) VALUES ('$fullname', '$username', '$email', '$password', '$image', '$role', '$bio', '$phone') ");
}

function deleteUser($id)
{
    pdo_execute("DELETE FROM user WHERE id = {$id}");
}
function delete_acccount($id_user)
{
    pdo_execute("DELETE FROM user WHERE id = {$id_user}");
}


#Sort User
function sortOldUser()
{
    return pdo_query("SELECT * FROM user ORDER BY id DESC");
}

function sortAToZUser()
{
    return pdo_query("SELECT * FROM user ORDER BY fullname");
}
function sortZToAUser()
{
    return pdo_query("SELECT * FROM user ORDER BY fullname DESC");
}