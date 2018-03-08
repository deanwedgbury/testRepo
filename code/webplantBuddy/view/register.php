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
        <header><h1 align="center"> Plant Buddy</h1></header>
		<form method="post">
			<fieldset>
				<legend>Register</legend>
				<table>
					<!-- Trick below to re-fill the user form field -->
					<tr>
						<th>
							<label>Username</label>
						</th>
						<td>
							<input type = "text" name = "username" pattern = "^[a-zA-Z0-9]+$" maxlength="50" value = "<?php echo htmlspecialchars($username); ?>">
						</td>
						<td>
							alphanumeric
						</td>
					</tr>
					<tr>
						<th>
							<label>Password</label>
						</th>
						<td>
							<input type = "text" name = "password" pattern = "^[a-zA-Z0-9\s]+$" maxlength="50">
						</td>
						<td>
							alphanumeric
						</td>
					</tr>
					
					<tr>
						<th>
							<label>Name</label>
						</th>
						<td>
							<input type = "text" name = "name" pattern = "^[a-zA-Z\s]+$" maxlength="50" value = "<?php echo htmlspecialchars($name); ?>">
						</td>
						</td>
						<td>no numbers or special characters</td>
					</tr>
					
					<tr>
						<th>
							<label>Age</label>
						</th>
					<td>
					<select name = "age" value = "<?php echo htmlspecialchars($age); ?>">
						<?php
							for($i = 1; $i <= 100; $i += 1){
								$selected = isset($_REQUEST['age']) && $_REQUEST['age'] == $i ? 'selected = "selected"' : '';
							    echo "<option $selected value='$i'>$i</option>";
							}
						?>
					</select>
					<input type = "radio" name = sex value = "Male" <?php if (isset($_REQUEST['sex']) && $_REQUEST['sex']=="Male") echo 'checked'; ?>> 
						<label>Male</label>
					<input type = "radio" name = sex value = "Female" <?php if (isset($_REQUEST['sex']) && $_REQUEST['sex']=="Female") echo 'checked'; ?>>
						<label>Female</label></td></tr>
					<tr>
						<th>
							<label>Phone</label></th><td><input type = "text" name = "phone" pattern = "\d{10}" maxlength = "10" value = "<?php echo htmlspecialchars($phone); ?>">
						</td>
						<td>10 digits</td>
					</tr>		
					<tr>
						<th>
							<label>Location</label></th><td><input type = "text" name = "location" pattern = "^[a-zA-Z\s]+$" maxlength="50" value = "<?php echo htmlspecialchars($location); ?>">
						</td>
						<td>no numbers or special characters</td></tr>
					<tr>
						<th>&nbsp;</th>
						<td><input type="submit" name="submit" value="Register" /></td>
						<td><a href="?operation=login">Login</a></td>
					</tr>
					<tr>
						<th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td>
					</tr>		
				</table>
		</form> 
    </body>

</html>
