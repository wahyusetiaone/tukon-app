<?php

if (!function_exists("jsonTypeForItem")) {
    function jsonTypeForItem($name,$qty,$price)
    {
        $text = array([
            'name' => $name,
            'qty' => $qty,
            'price' => $price
        ]);

        return json_encode($text);
    }
}

if (!function_exists("jsonTypeForAvailableBank")) {
    function jsonTypeForAvailableBank($array)
    {
        return json_encode($array);
    }
}

if (!function_exists("jsonTypeForAvailableRetail")) {
    function jsonTypeForAvailableRetail($array)
    {
        return json_encode($array);
    }
}

if (!function_exists("jsonTypeForAvailableewallet")) {
    function jsonTypeForAvailableewallet($array)
    {
        return json_encode($array);
    }
}

