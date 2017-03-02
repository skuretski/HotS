<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel = "stylsheet" type="text/css" href = "styles.css">
	<title>Heroes</title>
</head>
<body>
	<h1>Heroes</h1>
	<nav>
		<ul>
			<li><a href = "index.php">Home</a></li>
			<li><a href = "heroes.php">Heroes</a></li>
			<li><a href = "abilities.php">Hero Abilities</a></li>
			<li><a href = "talents.php">Talent Builds</a></li>
		</ul>
	</nav>
	<div id="heroes">
	</div>
	<div><h2>New Hero?</h2>
		Is there a new hero or one in development? Feel free to add it here! 
		<form id="addHero">
			<label>Hero Name:</label> 
				<input type="text" id="hName" name="name" required><br/>
				<span id="hero_message"></span><br/>
			<label>Role: </label>
				<span id="roleSelect">
				</span>
			<label>World</label>
				<span id ="worldSelect">
				</span>
			<label>Resource Type</label>
				<span id = "resSelect">
				</span>
			<label>Base HP</label>
				<input type="number" id="hp" name="hp" min="0" max="3000" required><br/>
			<label>Base Resource</label>
				<input type="number" id="res" name="res" min="0"><br/>		 
			<input type="submit" value="Add New Hero!">
		</form>
		<span id="heroMsg"></span>
	</div>
	<div><h2>New Role or New World?</h2>
		Did Blizzard sneek in a new role or add heroes from another universe? Add it here! 
		<form id="addRole">
			<label>Add Role:</label>
			<input type="text" id="newRole" required><br/>
			<input type="submit" value="Add New Role!">
		</form><br/>
		<span id="newRoleMsg"></span><br/>
		<form id="addWorld">
			<label>Add World:</label>
			<input type="text" id="newWorld" required><br/>
			<input type="submit" value="Add New World!"></br>
		</form>
		<span id="newWorldMsg"></span><br/>
	</div>
<script type="text/javascript" src="jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="javascript.js"></script>
</body>
</html>