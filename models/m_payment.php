<?php 
    function getPaymentMethods() {
        $sql = "SELECT * FROM payment";
        return pdo_query($sql);
    }

    function getPaymentMethodById($payment)
    {
        $mySQL = "SELECT * FROM payment WHERE id=$payment";
        return pdo_query_one($mySQL);
    }
?>