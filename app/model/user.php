<?php

namespace App\model;

class User
{
    public function editUserProfile($id, $fullname, $username, $password, $email, $image, $role, $phone) {
        $db = new database();
        $sql = "UPDATE user SET fullname = '$fullname', username = '$username', password = '$password', email = '$email', img = '$image', role = '$role', phone = '$phone' WHERE id = '$id'";
        $db->pdo_execute($sql);
    }
    public function addUserProfile($fullname, $username, $password, $email, $image, $role, $bio, $phone) {
        $db = new database();
        $sql = "INSERT INTO user (fullname, username, password, email, img, role, bio, phone) VALUES ('$fullname', '$username', '$password', '$email', '$image', '$role', '$bio', '$phone')";
        $db->pdo_execute($sql);
    }
    public function getFullNameUser() {
        $db = new database();
        $sql = "SELECT username FROM user";
        $result = $db->pdo_queryAll($sql);
        $usernames = array();
        foreach ($result as $row) {
            $usernames[] = $row['username'];
        }
        return $usernames;
    }
    public function getUser()
    {
        $db = new database();
        $sql = "SELECT * FROM user";
        return $db->pdo_queryAll($sql);
    }
    public function getUserById($id)
    {
        $db = new database();
        $sql = "SELECT * FROM user WHERE id = {$id}";
        return $db->pdo_queryOne($sql);
    }

    public function get_accountUser($id_user)
    {
        $db = new database();
        $sql = "SELECT * FROM user WHERE id = {$id_user}";
        return $db->pdo_queryAll($sql);
    }

    public function getUserInfo($id)
    {
        $db = new database();
        $sql = "SELECT * FROM user WHERE id = {$id}";
        return $db->pdo_queryAll($sql);
    }
    public function checkUser($email, $password)
    {
        $db = new database();
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        return $db->pdo_queryOne($sql);
    }
    public function checkAccount($id_user)
    {
        $db = new database();
        $sql = "SELECT * FROM user WHERE id = '$id_user'";
        return $db->pdo_queryOne($sql);
    }

    public function insertUser($username, $email, $password)
    {
        $db = new database();
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
        $db->pdo_execute($sql);
    }

    public function lastIndexOfUser()
    {
        $db = new database();
        $sql = "SELECT * FROM user ORDER BY id DESC LIMIT 1";
        return $db->pdo_queryOne($sql);
    }

    public function update_userName_email($new_username, $new_email, $id_user)
    {
        $db = new database();
        $sql = "UPDATE user SET username= {$new_username}, email= {$new_email} WHERE id =  {$id_user}";
        $db->pdo_execute($sql);
    }

    public function get_imgAvatar($id_user)
    {
        $db = new database();
        $sql = "SELECT img FROM user WHERE id = {$id_user}";
        return $db->pdo_queryOne($sql);
    }

    public function update_fullName_country_bio_avatar($new_fullname, $country, $bio, $new_avatar, $id_user)
    {
        $db = new database();
        $sql = "UPDATE user SET fullname= {$new_fullname}, country= {$country}, bio= {$bio}, img= {$new_avatar} WHERE id = {$id_user}";
        $db->pdo_execute($sql);
    }

    public function remove_avatar($new_avatar, $id_user)
    {
        $db = new database();
        $sql = "UPDATE user SET img= {$new_avatar} WHERE id = {$id_user}";
        $db->pdo_execute($sql);
    }

    public function get_password($id_user) {
        $db = new database();
        $sql = "SELECT password FROM user WHERE id = {$id_user}";
        return $db->pdo_queryOne($sql);
    }

    public function update_password($new_password, $id_user) {
        $db = new database();
        $sql = "UPDATE user SET password= {$new_password} WHERE id = {$id_user}";
        $db->pdo_execute($sql);
    }

    public function deleteUser($id) {
        $db = new database();
        $sql = "DELETE FROM user WHERE id = {$id}";
        $db->pdo_execute($sql);
    }
}
