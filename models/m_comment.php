<?php 
    function getAllComment() {
        return pdo_query("SELECT * FROM comment");
    }
    function getProductCommentByProductId($productId) {
        $sql = "SELECT * FROM comment WHERE id_product = $productId ORDER BY id DESC";
        return pdo_query($sql);
    }
    function insertComment($id_user, $id_product, $username, $email, $content, $now) {
        // $sql = "INSERT INTO comment (id_user, id_product, username,
        return pdo_execute("INSERT INTO comment (`id_user`,`id_product`,`username`,`email`,`content`,`create_date`) VALUES(?,?,?,?,?,?)",$id_user, $id_product, $username, $email, $content, $now);
    }

    function getComment() {
        return pdo_query("SELECT * FROM comment ORDER BY reported DESC, is_appear");
    }
    function getCommentById($id) {
        return pdo_query("SELECT * FROM comment WHERE id = {$id}");
    }
    function getCommentByIdUser($id) {
        return pdo_query("SELECT * FROM comment WHERE id_user = {$id}");
    }
    function getImgCommentById($id) {
        $sql = "SELECT * FROM comment_img WHERE id_comment = $id ORDER BY id DESC";
        return pdo_query($sql);
    }
    function editCommentById($id,$value) {
        pdo_execute("UPDATE comment SET content = '$value' WHERE id = {$id}");
    }
    function editCmtStatus($id, $value) {
        pdo_execute("UPDATE comment SET is_appear = {$value} WHERE id = {$id}");
    }
    function delCmt($id) {
        pdo_execute("DELETE FROM comment WHERE id = {$id}");
    }
    function getAllCmtImg($id) {
        return pdo_query("SELECT * FROM comment_img WHERE id_comment = {$id} ORDER BY id DESC");
    }
    function addImgCmt($id_Cmt,$value) {
        pdo_execute("INSERT INTO comment_img (`id_comment`,`src`) VALUES(?,?)",$id_Cmt,$value);
    }
    function delImgCmt($id_Cmt) {
        pdo_execute("DELETE From comment_img where id = {$id_Cmt}");
    }
   
    function delImgByIdCmt($id_Cmt) {
        pdo_execute("DELETE From comment_img where id_comment = {$id_Cmt}");
    }
    function reported($id, $value) {
        pdo_execute("UPDATE comment SET reported = {$value} WHERE id = {$id}");
    }

    function delete_blogComment_byIduser($id_user) {
        pdo_execute("DELETE From blog_comment where id_user = {$id_user}");
    }

    function delete_comments_byIduser($id_user) {
        pdo_execute("DELETE From comment where id_user = {$id_user}");
    }
?>