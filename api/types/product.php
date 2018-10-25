<?php

class Product {
 
    // database connection and table name
    private $conn;
    private $table_name = "shop";
 
    // object properties
    public $id;
  	public $sku;
    public $name;
    public $price;
    public $type;
    public $attribute;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
	  
	  $stmt = $db->query('SELECT * FROM $table_name');
	  while ($row = $stmt->fetch())
	  {
		  echo $row['name'] . "\n";
}
    }
  
  	
}