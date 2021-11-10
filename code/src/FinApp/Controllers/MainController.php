<?php 

namespace FinApp\Controllers;

use FinApp\Models\User;
use FinApp\Components\AuthManager;
use FinApp\Components\View;

Class MainController
{
	private $user; 

	public function __construct(User $user, AuthManager $auth)
	{
		$this->auth = $auth;
		$this->user = $user;
	}

	public function index()
	{	

		if($this->auth->is_auth()){

			return View::render('home', [
				'name' => $this->auth->getLogin(),
				'balance' => $this->user->getBalance(),
			]);

		} else {
			$this->redirect('login');
		}
	}

	public function getLogin()
	{
		return View::render('login');
	}

	public function postLogin()
	{	
		if( $this->auth->login($_POST) ){
			$this->redirect('index');
		} else {
			echo 'Wrong credentials';
			die();
		};
	}

	public function logout()
	{	
		if($this->auth->logout()){
			$this->redirect('login');
		}
	}

	public function doWithdraw()
	{		

		if($data['amount'] > $this->user->getBalance() )
		{
			echo 'Withdraw amount is greater than user balance';
			die();
		}

		session_write_close();

		if($this->user->doWithdraw(intval($_POST['amount']) ))
		{
			$this->redirect('index');
		}
	}

	private function redirect($location)
	{
		header("Location: /".$location);
		die();
	}

}