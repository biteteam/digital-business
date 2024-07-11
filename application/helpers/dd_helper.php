<?php
function dd(...$data)
{
    $printedData = $data;
    if (!count($data)) $printedData = "The Program Die by application/helpers/dd_helper.php";
    if (count($data) == 1) $printedData = $data[0];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($printedData);
    die;
}
