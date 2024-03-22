<?php 
    function totalBill ($cart) {
        $total = $subTotal = 0;

        foreach ($cart as $item) {
            extract($item);
            $subTotal += $price * $qty;
        }

        $tax = $subTotal * 0.1;
        
        $total = $subTotal + $tax;
        
        return $total;
    }

    function insertBill($id_user, $id_shipping, $id_payment, $email_user, $phone_user, $address_user, $address_detail_user, $name_recipient, $phone_recipient, $address_recipient, $address_detail_recipient, $total) {
        $sql = "INSERT INTO bill (id_user, id_shipping, id_payment, email_user, phone_user, address_user, address_detail_user, name_recipient, phone_recipient, address_recipient, address_detail_recipient  , total) 
                VALUES ('$id_user', '$id_shipping', '$id_payment', '$email_user', '$phone_user', '$address_user', '$address_detail_user', '$name_recipient', '$phone_recipient', '$address_recipient', '$address_detail_recipient', '$total')";
        $billId = pdo_execute($sql);
        return $billId;
    }

    function getBillInfoById($billId)
    {
        $mySQL = "SELECT * FROM bill WHERE id = '$billId'";
        return pdo_query_one($mySQL);
    }
?>