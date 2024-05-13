<?php
function dd($data)
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    die;
}
