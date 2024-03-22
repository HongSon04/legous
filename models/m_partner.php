<?php 
    function getPartner($limit = 0) {
        $sql = "SELECT * FROM partner WHERE is_appear = 1";
        if ($limit > 0) $sql .= " LIMIT $limit";
        return pdo_query($sql);
    }
?>