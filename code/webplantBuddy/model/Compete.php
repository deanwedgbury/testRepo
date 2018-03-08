<?php
require_once "lib/Rating.php";
class Compete {

	public $id;
	public $name = array();
	public $elo = array();
	public $oldelo1;
	public $oldelo2;
	public $state = "";
	public $dbconn;

	public function __construct($id) {
		$this->state = "";
		$this->id = $id;
		$this->dbconn = db_connect();
	    if(!$this->dbconn) {
			return; 
		}
		reset($this->name);
		reset($this->elo);
		
		$query = "SELECT * 
		FROM
		(
		SELECT t1.name1, t1.name2, elo1, elo2
		FROM (select r1.name name1, r2.name name2, r1.elo elo1, r2.elo elo2
		      from restaurants r1, restaurants r2
		      where r1.name != r2.name and r1.name < r2.name) t1
		LEFT JOIN (select v.rest1 name1, v.rest2 name2
		           from voted v
		           where v.username = $1) t2 
		ON (t1.name1 = t2.name1 AND t1.name2 = t2.name2)
		WHERE t2.name1 is NULL
		)as ta
		WHERE ABS(elo1 - elo2) < 48 AND name1 != name2 
		ORDER BY RANDOM();";
		$result = pg_prepare($this->dbconn, "", $query);
		$result = pg_execute($this->dbconn, "", array($this->id));
					
		if(pg_num_rows($result) == 0) {
			$this->state = 'out';	
		}
		else {
			if($row = pg_fetch_row($result)) {
				array_push($this->name, $row[0]);
				array_push($this->name, $row[1]);
				array_push($this->elo, $row[2]);
				array_push($this->elo, $row[3]);
			}

				$this->oldelo1 = $this->elo[0];
				$this->oldelo2 = $this->elo[1];
		}
    }

    public function pick($choice) {
	
		$this->dbconn = db_connect();

    	if(!$this->dbconn) {
			return; 
		}
		
		// Rating is from: https://github.com/Chovanec/elo-rating, uses Rating.php, in /lib/

    	if ($choice == 1) {
			$query = "UPDATE restaurants SET wins = wins + 1 WHERE name = $1;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->name[0]));
			$query = "UPDATE restaurants SET losses = losses + 1 WHERE name = $1;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->name[1]));

			$rating = new Rating($this->elo[0], $this->elo[1], Rating::WIN, Rating::LOST);
			$results = $rating->getNewRatings();

    	}
    	else if ($choice == 2){
			$query = "UPDATE restaurants SET losses = losses + 1 WHERE name = $1;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->name[0]));
			$query = "UPDATE restaurants SET wins = wins + 1 WHERE name = $1;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->name[1]));

			$rating = new Rating($this->elo[0], $this->elo[1], Rating::LOST, Rating::WIN);
			$results = $rating->getNewRatings();

    	}
		else{
			$query = "UPDATE restaurants SET ties = ties + 1 WHERE name = $1;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->name[0]));
			$query = "UPDATE restaurants SET ties = ties + 1 WHERE name = $1;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->name[1]));
		
			$rating = new Rating($this->elo[0], $this->elo[1], Rating::DRAW, Rating::DRAW);
			$results = $rating->getNewRatings();

    	}
	

		if ($choice == 1 or $choice == 2 or $choice == 3) {
	    	$this->elo[0] = $results['a'];
	    	$this->elo[1] = $results['b'];

			$query = "UPDATE restaurants SET elo = $1 WHERE name = $2;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->elo[0], $this->name[0]));

			$query = "UPDATE restaurants SET elo = $1 WHERE name = $2;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->elo[1], $this->name[1]));   

			$query = "INSERT INTO voted VALUES ($1, $2, $3);";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->id, $this->name[0], $this->name[1]));


			$query = "SELECT vel FROM restaurants WHERE name = $1;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->name[0]));		

			$row = pg_fetch_row($result);
			$oldvel = $row[0];

			$newvel = ($oldvel + $this->elo[0] - $this->oldelo1	)/2;
			$query = "UPDATE restaurants SET vel = $1 WHERE name = $2;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($newvel, $this->name[0]));

			$query = "SELECT vel FROM restaurants WHERE name = $1;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($this->name[1]));		

			$row = pg_fetch_row($result);
			$oldvel = $row[0];

			$newvel = ($oldvel + $this->elo[1]-$this->oldelo2)/2;
			$query = "UPDATE restaurants SET vel = $1 WHERE name = $2;";
	       	$result = pg_prepare($this->dbconn, "", $query);
			$result = pg_execute($this->dbconn, "", array($newvel, $this->name[1]));

	    }		
	}

    public function getState(){
		return $this->state;
	}

	public function getFirstRestaurant(){
		return $this->name[0];
	}

	public function getSecondRestaurant(){
		return $this->name[1];
	}	
}
?>
