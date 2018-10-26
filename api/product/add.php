<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../types/product.php');
include_once('../types/api.php');
include_once '../config/db.php';

$database = new Database();
$db = $database->connect();

// This is quick and basic validation, we can add type check e.t.c.
if (!isset($_GET['sku']) && !isset($_GET['name']) && !isset($_GET['price']) && !isset($_GET['type']) && (!isset($_GET['size']) || !isset($_GET['weight']) || !isset($_GET['hwl'])) ) {
	echo json_encode(array(
		'status' => API::$RESPONSE_ERROR,
		'message' => 'All parameters are mandatory!'
	));

	die();
}

$attribute = null;

// Types: 1 - DVD-disk; 2 - Book; 3 - Furniture;
switch ($_GET['type']) {
	case Product::$TYPE_DVD_DISK:
		$attribute = $_GET['size']; //TODO: super unsecured
		break;
	case Product::$TYPE_BOOK:
		$attribute = $_GET['weight']; //TODO: super unsecured
		break;
	case Product::$TYPE_FURNITURE:
		$attribute = $_GET['hwl']; //TODO: super unsecured
		break;
}

// We can additionally add escape string to secure from injections, but we have PDO
$data = [
	'sku' => isset($_GET['sku']) ? $_GET['sku'] : '',
	'name' => isset($_GET['name']) ? $_GET['name'] : '',
	'price' => isset($_GET['price']) ? $_GET['price'] : '',
	'type' => isset($_GET['type']) ? $_GET['type'] : '',
	'attribute' => isset($attribute) ? $attribute : ''
];

try {
	$sku = $db->prepare('SELECT * FROM shop WHERE sku = ?');
	$sku->execute([$data['sku']]);
	$skuExists = $sku->fetchColumn();

	if ($skuExists) {
		echo json_encode(array(
			'status' => API::$RESPONSE_ERROR,
			'message' => 'Product with SKU: ' . $data['sku'] . ' already exists!'
		));

		die();
	}

	$query = $db->prepare('INSERT INTO shop (sku, name, price, type, attribute) VALUES (:sku, :name, :price, :type, :attribute)');
	if ($query->execute($data)) {
		echo json_encode(array(
			'status' => API::$RESPONSE_SUCCESS,
			'message' => 'Item added!'
		));
	}
} catch (PDOException $e) {
	echo json_encode(array(
		'status' => API::$RESPONSE_ERROR,
		'message' => 'Error: ' . $e
	));
}
