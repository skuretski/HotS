<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel = "stylsheet" type="text/css" href = "styles.css">
	<title>Heroes of the Storm Database</title>
</head>
<body>
	<h1>Welcome to Heroes Database!</h1>
	<nav>
		<ul>
			<li><a href = "index.php">Home</a></li>
			<li><a href = "heroes.php">Heroes</a></li>
			<li><a href = "abilities.php">Hero Abilities</a></li>
			<li><a href = "talents.php">Talent Builds</a></li>
		</ul>
	</nav>
	<h2>What is Heroes of the Storm?</h2>
	<div>Heroes of the Storm is a video game created and maintained by Blizzard Entertainment. 
		It's classified as a MOBA, or multiplayer online battle arena, and is somewhat similar to
		games such as League of Legends or Defense of the Ancients 2 (Dota2). Two teams of 
		5 players battle to destroy the opponent's core, or home base. Along their path are defenses, 
		gates, and minions to deter enemies. Heroes of the Storm has several different maps to play on, 
		each having a different side objective. Gaining this side objective will gain your team a distinct 
		advantage.   
	</div>
	<h2>What about those Heroes I play as?</h2>
	<div>There are currently 39 heroes to choose from, each having a different set of abilities, talents 
		and roles. 
		<h3>Roles</h3>
		There are 4 roles in the game: Warrior, Assassin, Support, and Specialist. 
		<ul>
			<li>Warriors are melee fighters usually taking on the role to soak damage or initiate team fights. 
				Generally, they have the most health and lesser damage output than Assassins.</li>
			<li>Assassins can be ranged or melee attackers. Their role on the team is to deal as much damage 
				as possible without succumbing to the other team since they are squishy targets.</li>
			<li>Support heroes can be ranged or melee. It's up to them to keep the team healthy and alive, and 
				they also can help secure enemy player kills with disables.</li>
			<li>Specialists are the catch-all for heroes not fitting into the other categories. Many are designed 
				to help push lanes and take down mercenary camps (strong minions you can win over to help your team). 
				They often help teams gain objectives and deal out a moderate amount of damage.</li>
		</ul>
		<h3>Abilities</h3>
		Heroes generally have 4 unique base abilities, including their special ultimate ability available at level 10, 
		and 1 special trait unique to that hero. Hero traits can be passive or activated and they can range 
		from flying to a specific map position or infusing attacks with poison. </br>
		Go <a href = "heroes.php">here</a> to see all the heroes and their abilities.
		<h3>Talents</h3>
		At levels 1, 4, 7, 10, 13, 16, and 20, heroes can access to different talents. At each tier, you can pick 
		which talent suits your objective. Each talent can either modify a basic ability, gain a new ability, or 
		give a passive trait. Players often refer to certain talent picks as a build. Veteran players frequently 
		experiment with different builds depending on certain maps, situations, or enemy team compositions.</br>
		Go <a href = "talents.php">here</a> to try out different builds. 
	</div>
	<script type="text/javascript" src="jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="javascript.js"></script>
	</body>
</html>