<?php
	ini_set('display_errors', 'On');
	require_once "lib/lib.php";
	require_once "model/Compete.php";
	require_once "model/Results.php";
	require_once "model/Register.php";
	require_once "model/User.php";

	session_save_path("sess");
	session_start(); 

	$dbconn = db_connect();

	$errors=array();
	$view="";	

	if(isset($_REQUEST['operation'])) {
		if($_REQUEST['operation'] == 'compete') {
			$_SESSION['state'] = 'compete';
		} else if($_REQUEST['operation'] == 'result'){
			$_SESSION['state'] = 'results';
		} else if($_REQUEST['operation'] == 'userinfo') {
			$_SESSION['state'] = 'userinfo';
		} else if($_REQUEST['operation'] == 'register'){
			$_SESSION['state'] = 'register';
		} else{
			unset($_SESSION['userinfo']);
			$_SESSION['state'] = 'login';
		}
	}

	/* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	}

	switch($_SESSION['state']){
		case "unavailable":
			$view="unavailable.php";
			break;

		case "login":
			// the view we display by default
			$view="login.php";

			// check if submit or not
			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['user'])){
				$errors[]='user is required';
			}
			if(empty($_REQUEST['password'])){
				$errors[]='password is required';
			}
			if(!empty($errors))break;
	
			$_SESSION['user'] = $_REQUEST['user'];

			// perform operation, switching state and view if necessary
			if(!$dbconn) return;
			$query = "SELECT * FROM appuser WHERE id=$1 and password=$2;";
            $result = pg_prepare($dbconn, "", $query);

            $result = pg_execute($dbconn, "", array($_REQUEST['user'], md5($_REQUEST['password'])));
         	if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				//$_SESSION['user'] = $_REQUEST['user'];
	         	if(!isset($_SESSION['RestaurantMash'])){
					$_SESSION['RestaurantMash']=new Compete($_SESSION['user']);
				}
				$_SESSION['state']='compete';
				$view="vote.php";
			} else {
				$errors[]="invalid login";
			}
			break;
		case "compete":
			$view="vote.php";

			// check if submit or not
			if(isset($_REQUEST['vote'])){
				$_SESSION['previous']=!empty($_SESSION['previous']) ? $_SESSION['previous'] : '';
				if($_SESSION['previous'] != $_REQUEST['token']){

					// perform operation, switching state and view if necessary
					$_SESSION["RestaurantMash"]->pick((int)$_REQUEST['vote']);
					$_SESSION["RestaurantMash"]= new Compete($_SESSION['user']);
					$_SESSION['state']="compete";
					$_SESSION['previous']=$_REQUEST['token'];
				}
			}
			break;
		case "results":
			$_SESSION['results']=new Results($_SESSION['user']);
			$_SESSION['state']='results';
			$view="results.php";
			break;

		case "register":
			$view="register.php";
			
			if(isset($_REQUEST['submit'])){

				if(!isset($_SESSION["Register"])) {
					$_SESSION["Register"] = new Register();
				}

				$errors[] = $_SESSION["Register"]->create();
				if($_SESSION["Register"]->getState() == "done"){
					$_SESSION['state'] = 'login';
				}
			}

			break;

		case 'userinfo':
			$view="userinfo.php";
			if(!isset($_SESSION['userinfo'])) {
				$_SESSION['userinfo']=new User($_SESSION['user']);
			}
			$_SESSION['userinfo']->fetch();
			
			if(isset($_REQUEST['submit'])){
				$errors[] = $_SESSION["userinfo"]->update();
				$_SESSION['userinfo']->fetch();
			}
			break;	
	}
	require_once "view/$view";
?>
