<?php

function sum_price_qty($cartItem)
{
    return $cartItem->qty * $cartItem->harga;
}

function sub_total($cart)
{
    $subTotal = 0;
    foreach ($cart as $cartItem) {
        $subTotal += sum_price_qty($cartItem);
    }

    return $subTotal;
}

function sum_weight($cart)
{
    $weight = 0;
    foreach ($cart as $cartItem) {
        $weight += intval($cartItem->berat);
    }

    return $weight;
}
