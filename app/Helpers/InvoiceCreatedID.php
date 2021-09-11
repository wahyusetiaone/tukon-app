<?php

if (!function_exists("invoiceCreatedID")) {
    function invoiceCreatedID($id,$created_at)
    {
        $text = 'invoice-'.$id;
        $invoiceId = $text.strtotime($created_at);

        return $invoiceId;
    }
}

