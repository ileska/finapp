<?php 

namespace FinApp\Components;

Class AuthManager
{
	private $db;

	public function __construct(Database $db){
		$this->db = $db->getConnection();
	}

	public function is_auth()
	{
		if( $_SESSION['is_auth'] == 1){
			return true;
		}
		return false;
	}

	public function login($data)
	{

		$query = $this->db->prepare("SELECT id, login, balance FROM users WHERE email = ? AND password = ?;");	
    	$query->bind_param('ss', $data['email'], md5(md5($data['password'])) );

    	try {
		    $query->execute();
		    $result = $query->get_result()->fetch_array(MYSQLI_ASSOC);

		    $query->close();
		    $this->db->close();

		    if($result){
		    	$_SESSION['is_auth'] = 1;
		    	$_SESSION['login'] = $result['login'];
		    	$_SESSION['user_id'] = $result['id'];

		    	return true;
		    } 

		    return false;

		} catch (mysqli_sql_exception $e) {
		    die($e);                                  
		}

	}

	public function logout(){
		unset($_SESSION['user']);
		$_SESSION['is_auth'] = 0;
		return true;
	}

	public function getLogin()
	{
		if($_SESSION['login']){
			return $_SESSION['login'];
		}
	}	

	public function getId()
	{
		if($_SESSION['user_id']){
			return $_SESSION['user_id'];
		}
	}
}