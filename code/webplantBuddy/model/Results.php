<?php
class Results {
	public $name = array();
	public $elo = array();
	public $wins = array();
	public $losses = array();
	public $ties = array();
	public $vel = array();
	public $state;
	public $dbconn;

	public function __construct($id) {
		$this->id = $id;
		$this->dbconn = db_connect();

	    if(!$this->dbconn) {
			return;
		}
		$query = "SELECT * FROM restaurants ORDER BY elo DESC;";
	    $result = pg_prepare($this->dbconn, "", $query);
		$result = pg_execute($this->dbconn, "", array());

		while($row = pg_fetch_row($result)) {
			array_push($this->name, $row[0]);
			array_push($this->elo, $row[1]);
			array_push($this->wins, $row[2]);
			array_push($this->losses, $row[3]);
			array_push($this->ties, $row[4]);
			array_push($this->vel, $row[5]);
		}

		$query = "SELECT COUNT(*) FROM voted WHERE username = $1;";
		$result = pg_prepare($this->dbconn, "", $query);
		$result = pg_execute($this->dbconn, "", array($this->id));

		$row = pg_fetch_row($result);

		if ($row[0] > 9) {
			$this->state = 'valid';
		} else {
			$this->state = 'invalid';
		}
   	}
   		
	public function getNames(){
		return $this->name;
	}

	public function getElo(){
		return $this->elo;
	}
		
	public function getWins(){
		return $this->wins;
	}

	public function getLosses(){
		return $this->losses;
	}

	public function getTies(){
		return $this->ties;
	}

	public function getState() {
		return $this->state;
	}

	public function getVel() {
		array_multisort($this->vel, $this->name);
		$bottom = array_reverse($this->name, false);
		$top = array($this->name[0], $this->name[1], $this->name[2], $bottom[0], $bottom[1], $bottom[2]);
		return $top;
	}	
}
?>

