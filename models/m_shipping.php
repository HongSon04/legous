<?php 

    function getShippingMethods () {
        $sql = "SELECT * FROM shipping";
        return pdo_query($sql);
    }

    function getShippingMethodByPrice($price) {
        $sql = "SELECT * FROM shipping WHERE price = $price";
        return pdo_query_one($sql);
    }
?>