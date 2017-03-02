<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel = "stylsheet" type="text/css" href = "styles.css">
	<title>Hero Abilities</title>
</head>
<body>
	<h1>Hero Abilities</h1>
	<nav>
		<ul>
			<li><a href = "index.php">Home</a></li>
			<li><a href = "heroes.php">Heroes</a></li>
			<li><a href = "abilities.php">Hero Abilities</a></li>
			<li><a href = "talents.php">Talent Builds</a></li>
		</ul>
	</nav>
	<h2>See each hero's unique set of abilities!</h2>
	You can also modify cooldowns of newly created heroes.<br>
	<span id="hAbilSelect">
	</span>
	<div id="hAbil">
	</div>
	<div><h2>Add Abilities to New Heroes</h2>
		<form id="addAbil">
			<label>Hero</label>
			<span class="hAbilSelect2">
			</span>
			<label>Ability Name</label>
			<input type="text" id="abilName" required><br/>
			<label>Ability Description</label><br/>
			<textarea id="abilDesc"></textarea><br/>
			<label>Cooldown</label>
			<input type="number" id="abilCD" min="0"><br/>
			<input type="submit" value="Submit">
		</form>
		<span id="addAbilMsg"></span><br/><br/>
	</div>
	<hr>
<script type="text/javascript" src="jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="javascript.js"></script>
</body>
</html>