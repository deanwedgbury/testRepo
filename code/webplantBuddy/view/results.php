<?php
    $restData = array();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8" http-equiv="refresh" content="30">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Plant Buddy</title>
    </head>
        <header><h1 align="center"> Plant Buddy </h1></header>
        <nav>
            <form method="post" style="float:left">
		<ul>
                <li><a href="?operation=compete">Plants</a></li>

                <li><a href="?operation=result" style = "background-color:orange;color:yellow;font-weight:900" >Results</a></li>
	
		<li><a href="?operation=userinfo">User Info</a></li>	
	
                <li><a href="?operation=logout">Logout</a></li>
		</ul>
            </form>
        </nav>
	
	<?php
		if($_SESSION['results']->getState() == "valid") {
	?>
	
        <header><h1> Results </h1></header>
	
	<table>
	    <tr>
		<th align="left"><h3>Rank</h3></th>
		<th align="left"><h3>Restaurant</h3></th>
	   	<th align="left"><h3>Rating</h3></th>
		<th align="right"><h3>Wins</h3></th>
		<th align="right"><h3>Losses</h3></th>
	    <th align="right"><h3>Ties</h3></th>
	    </tr>
		<?php 
			$names = $_SESSION['results']->getNames();
			$elo = $_SESSION['results']->getElo();
			$wins = $_SESSION['results']->getWins();
			$losses = $_SESSION['results']->getLosses();
			$ties = $_SESSION['results']->getTies();
			$vel = $_SESSION['results']->getVel();
			for ($i = 0; $i <= sizeof($names)-1; $i++) {
				$rank = $i+1;
				echo "<tr>";
				echo "<td> $rank </td>";
				echo "<td> $names[$i] </td>";
				echo "<td> $elo[$i] </td>";
				echo "<td align=\"right\">$wins[$i] </td>";
				echo "<td align=\"right\">$losses[$i] </td>";
				echo "<td align=\"right\">$ties[$i] </td>";
				echo "</tr>";
			}
		?>
	</table>
	<table>
		<header><h1> Top 3 Changes </h1></header>
		<td><?php echo "1. $vel[3] &nbsp; 2. $vel[4] &nbsp; 3. $vel[5]" ?></td>
	</table>
	<table>
		<header><h1> Worst 3 Changes </h1></header>
		<td><?php echo "1. $vel[0] &nbsp; 2. $vel[1] &nbsp; 3. $vel[2]" ?></td>
	</table>
	<?php } else { 	?>
		<header><h1> Results </h1></header>
		<!--
		<h3>Please vote on at least 10 restaurants</h3>
		-->
	<?php } ?>
		

    </body>
</html>
