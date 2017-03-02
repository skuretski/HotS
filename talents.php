<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel = "stylsheet" type="text/css" href = "styles.css">
	<title>Talent Builds</title>
</head>
<body>
	<h1>Talent Builds</h1>
	<nav>
		<ul>
			<li><a href = "index.php">Home</a></li>
			<li><a href = "heroes.php">Heroes</a></li>
			<li><a href = "abilities.php">Hero Abilities</a></li>
			<li><a href = "talents.php">Talent Builds</a></li>
		</ul>
	</nav>
	<h2>See what talents are available to heroes</h2>
	Remember, you can only pick one talent per level tier.<br/> 
	<span id="hAbilSelect">
	</span>
	<div id="talents">
	</div>
	<h2>See Your Created Talents</h2>
	<div id="createdTal">
	</div>
	<div>
		<h2>Add Talents</h2>
		<form id ="addTalent">
			<label>Talent Name</label>
			<input type="text" id="talName" required><br/>
			<span id='talNameMsg'></span><br/>
			<label>Talent Description</label>
			<textarea id="talDesc"></textarea><br/>
			<input type="submit" value="Add Talent"><br/> 
		</form>
		<span id='addTalMsg'></span><br/>
	</div>

<script type="text/javascript" src="jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="javascript.js"></script>
</body>
</html>