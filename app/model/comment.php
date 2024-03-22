<?php

namespace App\model;

class Comment
{
    private $id = 0;
    private $id_user = 0;
    private $id_product = 0;
    private $email = "";
    private $content = "";
    private $reported = 0;
    private $id_appear = 0;
    private $create_date = "";
    private $update_date = "";

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIdUser($id_user)
    {
        return $this->id_user = $id_user;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdProduct($id_product)
    {
        return $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }

    public function setEmail($email)
    {
        return $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setContent($content)
    {
        return $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setReported($reported)
    {
        return $this->reported = $reported;
    }

    public function getReported()
    {
        return $this->reported;
    }

    public function setIdAppear($id_appear)
    {
        return $this->id_appear = $id_appear;
    }

    public function getIdAppear()
    {
        return $this->id_appear;
    }

    public function setCreateDate($create_date)
    {
        return $this->create_date = $create_date;
    }

    public function getCreateDate()
    {
        return $this->create_date;
    }

    public function setUpdateDate($update_date)
    {
        return $this->update_date = $update_date;
    }
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    public function getAllComment() {
        $db = new database();
        $sql = "SELECT * FROM comment";
        return $db->pdo_queryAll($sql);
    }
    public function getCommentById($id)
    {
        $db = new database();
        $sql = "SELECT * FROM comment WHERE id = {$id}";
        return $db->pdo_queryOne($sql);
    }

    public function getCommentByIdUser($id)
    {
        $db = new database();
        $sql = "SELECT * FROM comment WHERE id_user = {$id}";
        return $db->pdo_queryAll($sql);
    }

    public function getImgCommentById($id) {
        $db = new database();
        $sql = "SELECT * FROM comment_img WHERE id_comment = {$id} ORDER BY id DESC";
        return $db->pdo_queryAll($sql);
    }
    public function getProductCommentByProductId($idProduct)
    {
        $db = new database();
        $sql = "SELECT * FROM comment WHERE id_product = $idProduct ORDER BY id DESC";
       return $db->pdo_queryAll($sql);
    }

    public function insertComment($id_user, $id_product, $username, $email, $content, $now) {
        $db = new database();
        $sql = "INSERT INTO comment (id_user, id_product, username, email, content, create_date) VALUES ('$id_user', '$id_product', '$username', '$email', '$content', '$now')";
        return $db->pdo_execute($sql);
    }

    public function addImgCmt($id_Cmt,$value) {
        $db = new database();
        $sql = "INSERT INTO comment_img (`id_comment`,`src`) VALUES({$id_Cmt},'$value')";
        return $db->pdo_execute($sql);
    }


    public function delImgByIdCmt($id) {
        $db = new database();
        $sql = "DELETE FROM comment_img WHERE id_comment = {$id}";
        return $db->pdo_execute($sql);
    }

    public function editCommentById($id, $value) {
        $db = new database();
        $sql = "UPDATE comment SET content = '{$value}' WHERE id = {$id}";
        return $db->pdo_execute($sql);
    }

    public function getLastIDComment() {
        $db = new database();
        $sql = "SELECT id FROM comment ORDER BY id DESC LIMIT 1";
        return $db->pdo_queryOne($sql);
    }

    

    public function getAllCmtImgByID($id) {
        $db = new database();
        $sql = "SELECT * FROM comment_img WHERE id_comment = {$id}";
        return $db->pdo_queryAll($sql);
    }

    public function delImgCmtByID($id_Cmt) {
        $db = new database();
        $sql = "DELETE FROM comment_img WHERE id_comment = {$id_Cmt}";
        return $db->pdo_execute($sql);
    }

    public function delCmtByID($id) {
        $db = new database();
        $sql = "DELETE FROM comment WHERE id = {$id}";
        return $db->pdo_execute($sql);
    }

    public function reported($id, $value) {
        $db = new database();
        $sql = "UPDATE comment SET reported = {$value} WHERE id = {$id}";
        return $db->pdo_execute($sql);
    }

    public function editCmtStatus($id, $value) {
        $db = new database();
        $sql = "UPDATE comment SET is_appear = {$value} WHERE id = {$id}";
        return $db->pdo_execute($sql);
    }

    public function delCmt($id) {
        $db = new database();
        $sql = "DELETE FROM comment WHERE id = {$id}";
        return $db->pdo_execute($sql);
    }
}
?>