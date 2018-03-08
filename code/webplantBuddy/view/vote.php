<?php
?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Plant Buddy</title>
    </head>
    <!--
    <body  background="spag.jpeg">
    -->
        <header><h1 align="center">Plant Buddy </h1></header>
        <nav>
            <form method="post" style="float:left">
		<ul>
                <li><a href="?operation=compete"style = "background-color:orange;color:yellow;font-weight:900">Plants</a></li>

                <li><a href="?operation=result">Results</a></li>

		<li><a href="?operation=userinfo">User Info</a></li>

                <li><a href="?operation=logout">Logout</a></li>
		</ul>
            </form>
        </nav>
	
        <header><h1> Plants </h1></header>
	<!--		
		<?php if($_SESSION["RestaurantMash"]->getState()!="out"){ ?>
			<form method="post">
				<input type="hidden" name="token" value="<?php echo rand(); ?>">
				<button type="submit" name = "vote" value="1"> <?php echo($_SESSION["RestaurantMash"]->getFirstRestaurant()); ?> </button>
				<button type="submit" name = "vote" value="2"> <?php echo($_SESSION["RestaurantMash"]->getSecondRestaurant()); ?> </button>
				<button type="submit" name = "vote" value="3"> <?php echo("Neither"); ?> </button>
			</form> 
		<?php } ?>
		<?php if($_SESSION["RestaurantMash"]->getState()=="out") {?>
			<h1> no more restaurants to vote on </h1>
		<?php } ?>
	-->
    </body>
</html>
