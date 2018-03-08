<?php
class User {
	public $id;
	public $name;
	public $phone;
	public $age;
	public $gender;
	public $location;

	public function __construct($id) {
		$this->id = $id;
   	}

   	public function fetch(){
   		$this->dbconn = db_connect();

	    if(!$this->dbconn) {
			return;
		}
		$query = "SELECT * FROM appuser WHERE ID = $1;";
	    $result = pg_prepare($this->dbconn, "", $query);
		$result = pg_execute($this->dbconn, "", array($this->id));

		$row = pg_fetch_row($result);
		$this->id = $row[0];
		$this->name = $row[2];
		$this->phone = $row[5];
		$this->age = $row[3];
		$this->gender = $row[4];
		$this->location = $row[6];
   	}

   	public function update(){
   		if(empty($_REQUEST['password']) or empty($_REQUEST['name']) or empty($_REQUEST['age']) or empty($_REQUEST['sex']) or empty($_REQUEST['phone']) or empty($_REQUEST['location'])) {
			return "Please fill out every field";
		}

		$this->dbconn = db_connect();
	    if(!$this->dbconn) {
			return "database error";
		}
		
		$query = "delete from appuser where id = $1;";
		$result = pg_prepare($this->dbconn, "", $query);
		$result = pg_execute($this->dbconn, "", array($this->id));

		$query = "insert into appuser values($1, $2, $3, $4, $5, $6, $7);";
       	$result = pg_prepare($this->dbconn, "", $query);
		$result = pg_execute($this->dbconn, "", array($this->id, md5($_REQUEST['password']), $_REQUEST['name'], $_REQUEST['age'], $_REQUEST['sex'], $_REQUEST['phone'], $_REQUEST['location']));
		return "";
   	}
   		
	public function getID(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getAge(){
		return $this->age;
	}

	public function getPhone(){
		return $this->phone;
	}
	
	public function getGender() {
		return $this->gender;
	}	
	public function getLocation(){
		return $this->location;
	}

}
?>
