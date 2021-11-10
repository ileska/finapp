<?php 


namespace FinApp\Models;

use FinApp\Components\AuthManager;
use FinApp\Components\Database;

Class User
{
	private $auth;
	private $db;

	public function __construct(AuthManager $auth, Database $db){
		$this->db = $db->getConnection();
		$this->auth = $auth;
	}

	public function getBalance(){
		$query = $this->db->prepare("SELECT balance FROM users WHERE id = ? ");	
    	$query->bind_param('i', $this->auth->getId() );

    	try {
		    $query->execute();
		    $result = $query->get_result()->fetch_array(MYSQLI_ASSOC);


		    if($result){
		    	return $result['balance'];
		    } 

		    return false;

		} catch (mysqli_sql_exception $e) {
		    die($e);                                  
		}
	}	

	private function lockRows()
	{
		$query = mysqli_prepare($this->db, "SELECT * FROM users  WHERE id = ? FOR UPDATE");
	    mysqli_stmt_bind_param($query, 'i',  $this->auth->getId());
	    mysqli_stmt_execute($query);
	}	

	private function updateBalance($amount)
	{
		$query = mysqli_prepare($this->db, "UPDATE users SET balance = balance - ? WHERE id = ?");
	    mysqli_stmt_bind_param($query, "ii", $amount, $this->auth->getId());
	    mysqli_stmt_execute($query);
	}

	public function doWithdraw($amount) {

		mysqli_begin_transaction($this->db);

		try {

	    	$this->lockRows();
	    	$this->updateBalance($amount);

	    	sleep(20);
		    mysqli_commit($this->db);

		    return true;
		    
		} catch (mysqli_sql_exception $e) {
		    mysqli_rollback($this->db);
		    throw $e;
		}

	}
}
