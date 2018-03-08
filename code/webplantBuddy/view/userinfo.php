<?php
	$username=!empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
	$name = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
	$age=!empty($_REQUEST['age']) ? $_REQUEST['age'] : '';
	$sex=!empty($_REQUEST['sex']) ? $_REQUEST['sex'] : '';
	$phone=!empty($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
	$location=!empty($_REQUEST['location']) ? $_REQUEST['location'] : '';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
                <link rel="stylesheet" type="text/css" href="style.css" />
                <title>Plant Buddy</title>
    </head>
    <!--
    <body  background="spag.jpeg">
    -->
        <header><h1 align="center">Plant Buddy</h1></header>
	<nav>
	            <form method="post" style="float:left">
        	        <ul>
                <li><a href="?operation=compete">Plants</a></li>
                <li><a href="?operation=result" >Results</a></li>

                <li><a href="?operation=userinfo"  style = "background-color:orange;color:yellow;font-weight:900">User Info</a></li>
                <li><a href="?operation=logout">Logout</a></li>
                </ul>
            </form>
        </nav>
	
	
		<form method="post">
			<fieldset>
				<legend>User Info</legend>
				<table>
					<!-- Trick below to re-fill the user form field -->
					<tr>
						<th>
							<label>Username</label>
						</th>
						<td>
							<input type = "text" name = "username" pattern = "^[a-zA-Z0-9]+$" maxlength="50" value = "<?php echo htmlspecialchars($_SESSION['userinfo']->getID()); ?>" disabled>
						</td>
						<td>alphanumeric</td>
					</tr>
					
					<tr>
						<th><label>Password</label></th>
						<td>
							<input type = "text" name = "password" pattern = "^[a-zA-Z0-9\s]+$" maxlength="50">
						</td>
						<td>alphanumeric</td>
					</tr>
					<tr>
						<th>
							<label>Name</label>
						</th>
						<td>
							<input type = "text" name = "name" pattern = "^[a-zA-Z\s]+$" maxlength="50" value = "<?php echo htmlspecialchars($_SESSION['userinfo']->getName()); ?>">
						</td>
						</td>
						<td>no numbers or special characters</td>
					</tr>
					<tr>
						<th>
							<label>Age</label>
						</th>
						<td>
							<select name = "age" value = "<?php echo  htmlspecialchars($_SESSION['userinfo']->getAge()); ?>">
						<?php
							for($i = 1; $i <= 100; $i += 1){
								$selected = $_SESSION['userinfo']->getAge() == $i ? 'selected = "selected"' : '';
						    	echo "<option $selected value='$i'>$i</option>";
							}
						?>
							</select>
						<input type = "radio" name = sex value = "Male" <?php if ($_SESSION['userinfo']->getGender()=="Male") echo 'checked'; ?>>
						<label>Male</label>
						<input type = "radio" name = sex value = "Female" <?php if ($_SESSION['userinfo']->getGender()=="Female") echo 'checked'; ?>>
						<label>Female</label>
						</td>
					</tr>
					
					<tr>
						<th>
							<label>Phone</label>
						</th>
						<td>
							<input type = "text" name = "phone" pattern = "\d{10}" maxlength = "10" value = "<?php echo htmlspecialchars($_SESSION['userinfo']->getPhone()); ?>">
						</td>
						<td>10 digits</td>
					</tr>		
					<tr>
						<th><label>Location</label></th>
						<td>
							<input type = "text" name = "location" pattern = "^[a-zA-Z\s]+$" maxlength="50" value = "<?php echo htmlspecialchars($_SESSION['userinfo']->getLocation()); ?>">
						</td>
						<td>no numbers or special characters</td>
					</tr>
					
					<tr>
						<th>&nbsp;</th><td><input type="submit" name="submit" value="Update" /></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td><?php echo(view_errors($errors)); ?></td>
					</tr>		
				</table>
		</form> 
    </body>

</html>
