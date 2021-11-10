<?php 

namespace FinApp\Components;

Class Database
{
	private $connection;
	private static $_instance; //The single instance

	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	function __construct()
	{

		$this->connection = new \mysqli(
			'db', 'root', 'secret', 'transactions_db'
		);

		if (!$this->connection) {
		   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
		   exit;
		} 

	}

	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }

	// Get mysqli connection
	public function getConnection() {
		return $this->connection;
	}

}

