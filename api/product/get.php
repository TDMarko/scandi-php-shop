<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../types/product.php');
include_once('../types/api.php');
include_once '../config/db.php';
 
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
			'attribute' => getAttributeByType($item['type'], $item['attribute'])
		);

		array_push($response, $products);
	}

	echo json_encode(array(
		'status' => API::$RESPONSE_SUCCESS,
		'message' => $response
	));
} else {
	echo json_encode(array(
		'status' => API::$RESPONSE_ERROR,
		'message' => 'No data found!'
	));
}

/*
 * Helpers
 */
function getAttributeByType($type, $attribute) {
	$output = '';

	switch ($type) {
		case Product::$TYPE_DVD_DISK:
			$output = 'Size: ' . $attribute;
			break;
		case Product::$TYPE_BOOK:
			$output = 'Weight: ' . $attribute;
			break;
		case Product::$TYPE_FURNITURE:
			$output = 'Dimension: ' . $attribute;
			break;
	}

	return $output;
}