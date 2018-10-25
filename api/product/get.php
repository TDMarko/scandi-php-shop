<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/db.php';
include_once '../types/product.php'; //TODO: add type check
 
$database = new Database();
$db = $database->connect();

$items = $db->query('SELECT * FROM shop');
$itemsCount = $items->rowCount();

if ($itemsCount > 0) {
    $products = $response = [];

    while ($item = $items->fetch()) {
        $products = array(
            'id' => $item['id'],
            'sku' => $item['sku'],
            'name' => $item['name'],
            'price' => $item['price'],
            'type' => $item['type'],
            'attribute' => $item['attribute']
        );

        array_push($response, $products);
    }

    echo json_encode(array(
        'status' => 'success', //TODO: add const
        'message' => $response
    ));
} else {
    echo json_encode(array(
        'status' => 'error', //TODO: add const
        'message' => 'No data found!'
    ));
}
