<?php

class Database {
	private $host = 'localhost';
	private $db_name = 'shop';
	private $username = 'root';
	private $password = '';
	public $db;

	public function connect() {
		$this->db = null;
 
		try {
			$this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->exec('set names utf8');
		} catch (PDOException $e) {
			echo 'Connection error: ' . $e->getMessage();
		}

		return $this->db;
	}
}
