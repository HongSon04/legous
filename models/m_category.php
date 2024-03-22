<?php
include_once 'models/m_pdo.php';
    function  getCategories($start = 0, $limit = 0,$kyw =""){
        $sql = "SELECT * FROM category";
        if( $limit > 0){
            $sql .= " LIMIT ".$start.",".$limit;
        }
        if($kyw!=""){
            $sql .= "AND LIKE '%".$kyw."%'";
        }
        // if($asc == 1){
        //     $sql .= "ORDER BY id ASC";
        // }
        return pdo_query($sql);
    }

    function getFeatureCategories () {
        $sql = "SELECT * FROM category WHERE is_special = 1";
        return pdo_query($sql);
    }
    
    function getCategoryById ($idCategory) {
        $sql = "SELECT * FROM category WHERE id = $idCategory";
        return pdo_query_one($sql);
    }

    function getCategoriesSorted() {
        return pdo_query("SELECT * FROM category ORDER BY name ASC");
    }

    function getproductbyCategory ($id){
        return pdo_query("SELECT p.*, c.name AS category_name FROM product p LEFT JOIN category c ON p.id_category = c.id WHERE c.id = $id");
    }
    function getIdCategoryByIdProducts($idProduct) {
        $sql = "SELECT id_category FROM product WHERE id = $idProduct";
        return pdo_query_value($sql);
    }

    
?>

    