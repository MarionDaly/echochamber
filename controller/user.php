<?php
	class User extends Core {
		private $_db;
		private $salt;
		private $hash;
		private $username;
		private $password;
	  	public function __construct (Database $_db) {
			$this->_db = $_db;
	  	}
		public function login(string $username, string $password, string $url) {
			if ($this -> check_username($username, $password) === true){

   				header("location:" . $url . "");
			}
			else{
				
			}
		}
		public function logout(string $url) {
			$_SESSION = array();
			if (ini_get("session.use_cookies")) {
			    $params = session_get_cookie_params();
			    setcookie(session_name(), '', time() - 42000,
			        $params["path"], $params["domain"],
			        $params["secure"], $params["httponly"]
			    );
			}
			session_destroy();
			header("location:" . $url . "");
		}
		public function register(string $password, string $email, string $url) {
			// error codes:
			// 0 - success
			// 1 - bad email
			// 2 - email not unique, alreqdy exists
			// 3 - password not complex enough
			// 4 - Misc issue
            $this->check_exist($email); 
            $this->check_email($email);
            $this->check_password($password);
            if ( $this->create_user($email, $password)) {
            	$this->setSession();
            	return (int) 0;
            }
            else {

            }  
		}
		private function createUsername(string $username, string $password, string $email) {	 
			$this->_db->createUser();
			$this->hash($password);
			return (bool) TRUE;
		}
		private function checkUsername(string $username, string $password ) {
			$uid = $this->_db->userExist($username);
			$user = array (
				'uid' => $uid,
			);
			$hash = $this->_db->fetchHash($user);
			$password = $this->password_hash($password);
			if (password_verify($password, $hash)) {
				$this->setSession();
				return (bool) TRUE;
			}
			else {
				return (bool) FALSE;
			}
		}
		private function checkEmail(string $email) {
			$filter = filter_var($email, FILTER_VALIDATE_EMAIL)
			return (bool) $filter;
		}
		private function passwordHash(string $password) {
			$options = [
		        'salt' => custom_function_for_salt(),
		        'cost' => 20,
		      ];
     		 $hash = password_hash($password, PASSWORD_DEFAULT, $options);
			return (string) $hash;
		}
		private function setCookie() {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      		$charactersLength = strlen($characters);
      		$randomString = '';
      		for ($i = 0; $i < 64; $i++) {
      			$randomString .= $characters[rand(0, $charactersLength - 1)];
      		}
      		return (string) $randomString;
		}
		private function setSession() {
			$_SESSION['username'] == $this->login_info['username'];
			$this->setCookie;
			$_SESSION['logged_in'] == TRUE;
		}
	}
?>
