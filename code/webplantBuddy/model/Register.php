<?php
class Register {

	public $error = "";
	public $dbconn;
	public $state;

	public function __construct(){
	}

	public function create() {
		if(empty($_REQUEST['username']) or empty($_REQUEST['password']) or empty($_REQUEST['name']) or empty($_REQUEST['age']) or empty($_REQUEST['sex']) or empty($_REQUEST['phone']) or empty($_REQUEST['location'])) {
			return "Please fill out every field";
		}

		$this->dbconn = db_connect();
	    if(!$this->dbconn) {
			return "database error"; 
		}

		$query = "select * from appuser where id = $1";
       	$result = pg_prepare($this->dbconn, "", $query);
		$result = pg_execute($this->dbconn, "", array($_REQUEST['username']));

		if(pg_num_rows($result) != 0) {
			return "Username already exists";
		}
		
		$query = "insert into appuser values($1, $2, $3, $4, $5, $6, $7);";
       	$result = pg_prepare($this->dbconn, "", $query);
		$result = pg_execute($this->dbconn, "", array($_REQUEST['username'], md5($_REQUEST['password']), $_REQUEST['name'], $_REQUEST['age'], $_REQUEST['sex'], $_REQUEST['phone'], $_REQUEST['location']));

		$this->state = "done";
		return "You can login now";
    }

    public function setError($error){
		$this->error = $error;
	}

	public function getError(){
		return $this->error;
	}

	public function getState(){
		return $this->state;
	}
}
?>
