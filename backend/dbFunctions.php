<?php
require "hiddenInfo.php";
error_reporting(E_ALL);
ini_set('display_errors', true);

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", $myUsername, $myPassword, $myUsername);
if($mysqli->connect_errno){
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")". $mysqli->connect_error;	
}

if(isset($_POST["action"])){
	if($_POST["action"] == "getAll"){
		$all = "HeroName";
		getAllHeroes();
	}
	if($_POST["action"] == "delete"){
		deleteHero($_POST["id"]);
	}
	if($_POST["action"] == "deleteAbil"){
		deleteAbil($_POST["id"]);
	}
}
if(isset($_POST["add"])){
	if($_POST["add"] == "ability")
		addAbil($_POST["name"], $_POST["aName"], $_POST["aDesc"], $_POST["cd"]);
	if($_POST["add"] == "hero")
		addHero($_POST["name"], $_POST["role"], $_POST["world"], $_POST["resource"], $_POST["hp"], $_POST["res"]);
	if($_POST["add"] == "role")
		addRole($_POST["role"]);
	if($_POST["add"] == "talent")
		addTalent($_POST["tName"], $_POST["tDesc"]);
	if($_POST["add"] == "world")
		addWorld($_POST["world"]); 
}
if(isset($_POST["modify"])){
	modAbil($_POST["id"], $_POST["cd"]);
}
if(isset($_POST["abil"])){
	$hero = $_POST["abil"];
	getHeroAbil($hero);
}
if(isset($_POST["talent"])){
	$hero = $_POST["talent"];
	getTalents($_POST["talent"]);
}
if(isset($_POST["newTalent"])){
	getNewTalents();
}
if(isset($_POST["menu"])){
	if($_POST["menu"] === "world"){
		getWorldDrop();
	}
	if($_POST["menu"] === "res"){
		getResDrop();
	}
	if($_POST["menu"] === "role"){
		getRoleDrop();
	}
	if($_POST["menu"] === "hero"){
		getHeroName();
	}
	if($_POST["menu"] === "newHero"){
		getNewHeroName();
	}
}

//Check if value is in query
function checkHeroes(&$duplicate, $hero){
	global $mysqli;
	$heroes = $mysqli->prepare("SELECT h.name AS HeroName FROM heroes h");
	$heroes->execute();
	$results = $heroes->get_result();
	while($row = $results->fetch_assoc()){
		if($row["HeroName"] === $hero)
			$duplicate = true;
	}
}

function checkRole(&$duplicate, $role){
	global $mysqli;
	$role = $mysqli->prepare("SELECT r.name AS roleName FROM role r");
	$role->execute();
	$results = $role->get_result();
	while($row = $results->fetch_assoc()){
		if($row["roleName"] === $role)
			$duplicate = true;
	}
}

function checkAbil(&$duplicate, $abil){
	global $mysqli;
	$abil = $mysqli->prepare("SELECT a.name AS abilName FROM abilities a");
	$abil->execute();
	$results = $abil->get_result();
	while($row = $results->fetch_assoc()){
		if($row["abilName"] === $abil)
			$duplicate = true;
	}
}

function checkTalent(&$duplicate, $talent){
	global $mysqli;
	$talent = $mysqli->prepare("SELECT t.name AS talentName FROM talents t");
	$talent->execute();
	$results = $talent->get_result();
	while($row = $results->fetch_assoc()){
		if($row["talentName"] === $talent)
			$duplicate = true;
	}
}

function checkWorld(&$duplicate, $world){
	global $mysqli;
	$world = $mysqli->prepare("SELECT w.name AS worldName FROM world w");
	$world->execute();
	$results = $world->get_result();
	while($row = $results->fetch_assoc()){
		if($row["worldName"] === $world)
			$duplicate = true;
	}
}
//Get Functions
function getAllHeroes(){
	global $mysqli;
	$all = $mysqli->prepare("SELECT h.hero_id as ID, h.name as HeroName, r.name as RoleName, w.name as WorldName, h.resource_type as
		ResourceType, h.base_hp as HP, h.base_resource as Resource FROM heroes h 
		INNER JOIN world w ON h.fk_world_id = w.world_id
		INNER JOIN role r ON r.role_id = h.fk_role_id ORDER BY HeroName ASC");
	$all->execute();
	$results = $all->get_result();
	showResults($results);
	$all->close();
}
//Hero Abilities Table with HTML printout
function getHeroAbil($hero){
	global $mysqli;
	$abil = $mysqli->prepare("SELECT h.hero_id as hID, a.abil_id as ID, h.name as HeroName, a.name as AbilName, a.abil_desc as Descrip, a.cooldown as CD 
		FROM heroes h INNER JOIN abilities a ON a.hero_abil = h.hero_id WHERE h.name = ? ORDER BY a.abil_id ASC");
	$abil->bind_param("s", $hero);
	$abil->execute();
	$result = $abil->get_result();
	echo "<table id='abilTable'><tr>";
	echo "<th>Hero</th><th>Ability</th><th>Description</th><th>Cooldown</th></tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr id=" . $row["ID"] . ">";
		echo "<td>" . $row["HeroName"] . "</td>";
		echo "<td>" . $row["AbilName"] . "</td>";
		echo "<td>" . $row["Descrip"] . "</td>";
		if($row["CD"] === NULL)
			echo "<td>N/A</td></tr>";
		else
			echo "<td>" . $row["CD"] . " sec</td>";
		if($row["hID"] > 39){
			echo "<td><button class ='modify'>Modify Cooldown</button><input type='number' id='modCD" . $row["ID"] . "'min='0'></td>";
			echo "<td><button class ='delete'>Delete</button></td>";
		}
		echo "</tr>";
	}
	echo "</table><br/>";
	$abil->close();
}
//Get Hero Names as Drop Down
function getHeroName(){
	global $mysqli;
	$name = $mysqli->prepare("SELECT name, hero_id FROM heroes ORDER BY name ASC");
	$name->execute();
	$result = $name->get_result();
	echo "<select name='heroName' id='nameDrop'>";
	while($row = $result->fetch_assoc()){
		echo "<option value ='" . $row["hero_id"] . "'>" . $row["name"] . "</option>";
	}
	echo "</select><br/>";
	$name->close();
}

//Get and Print Talent Table
function getTalents($hero){
	global $mysqli;
	$talents = $mysqli->prepare("SELECT h.name AS HeroName, ht.ht_id AS ID, t.name AS talent,
		ht.fk_hero_id AS hID, ht.level_avail AS level, t.talent_desc AS tDesc FROM hero_talents ht INNER JOIN heroes h ON
		ht.fk_hero_id = h.hero_id INNER JOIN talents t ON t.talent_id = ht.fk_talent_id WHERE h.name = ? ORDER BY 
		ht.level_avail ASC");
	$talents->bind_param("s", $hero);
	$talents->execute();
	$result = $talents->get_result();
	echo "<table id='talentTable'><tr>";
	echo "<th>Hero Name</th><th>Level Available</th><th>Talent Name</th><th>Talent Description</th></tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr id=" . $row["ID"] . ">";
		echo "<td>" . $row["HeroName"] . "</td>";
		echo "<td>" . $row["level"] . "</td>";
		echo "<td>" . $row["talent"] . "</td>";
		echo "<td>" . $row["tDesc"] . "</td></tr>";
	}
	echo "</table><br/>";
	$talents->close();
}

function getNewTalents(){
	global $mysqli;
	$newTal = $mysqli->prepare("SELECT talent_id, name, talent_desc FROM talents WHERE talent_id > 1951");
	$newTal->execute();
	$result = $newTal->get_result();
	echo "<table id='newTalents'><tr>";
	echo "<th>Talent Name</th><th>Talent Description</th></tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr id=" . $row["talent_id"] . ">";
		echo "<td>" . $row["name"] . "</td>";
		echo "<td>" . $row["talent_desc"] . "</td></tr>";
	}
	echo "</table><br/>";
	$newTal->close();
}

//Heroes Table Results
function showResults($result){
	echo "<table id='heroTable'><tr>";
	echo "<th>Name</th><th>Role</th><th>World</th>
		<th>Resource Type</th>
		<th>Base HP</th><th>Base Resource</th><th>Delete</th></tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr id=" . $row["ID"] . ">";
		echo "<td>" . $row["HeroName"] . "</td>";
		echo "<td>" . $row["WorldName"] . "</td>";
		echo "<td>" . $row["RoleName"] . "</td>";
		if($row["ResourceType"] === NULL)
			echo "<td>None</td>";  
		else
			echo "<td>" . $row["ResourceType"] . "</td>";
		echo "<td>" . $row["HP"] . "</td>";
		if($row["Resource"] === NULL)
			echo "<td>N/A</td>";
		else
			echo "<td>" . $row["Resource"] . "</td>";
		if($row["ID"] > 39){
			echo "<td><button class='delete'>Delete</button></td>";
		}
		echo "</tr>";
	}
	echo "</table><br/>";
}
//Adding Functions
function addHero($name, $role, $world, $rType, $hp, $res){
	$duplicate = 0;
	checkHeroes($duplicate, $name);
	if($duplicate == 0){
		global $mysqli;
		$insertHero = $mysqli->prepare("INSERT INTO heroes(name, fk_role_id, fk_world_id, resource_type, base_hp, base_resource) VALUES (?,?,?,?,?,?)");
		$insertHero->bind_param("siisii", $name, $role, $world, $rType, $hp, $res);
		$insertHero->execute();
		$insertHero->close();
		echo "Hero created successfully.<br/>";
	}
	else if($duplicate == 1){
	 	echo "Hero already exists.<br/>";
	}	
	else
	 	echo "Error creating new hero.<br/>";
}
function addAbil($hero, $name, $descrip, $cooldown){
	$duplicate = 0;
	checkAbil($duplicate, $name);
	if($duplicate == 0){
		global $mysqli;
		$addAbil = $mysqli->prepare("INSERT INTO abilities(name, hero_abil, abil_desc, cooldown) VALUES (?,?,?,?)");
		$addAbil->bind_param("sisi", $name, $hero, $descrip, $cooldown);
		$addAbil->execute();
		$addAbil->close();
		echo "Ability created successfully.<br/>";
	}
	else if($duplicate == 1)
		echo "Ability already exists.<br/>";
	else
		echo "Error creating ability.<br/>";
}

function addWorld($world){
	$duplicate = 0;
	checkWorld($duplicate, $world);
	if($duplicate == 0){
		global $mysqli;
		$addWorld = $mysqli->prepare("INSERT INTO world(name) VALUES (?)");
		$addWorld->bind_param("s", $world);
		$addWorld->execute();
		$addWorld->close();
		echo "Universe created successfully.<br/>";
	}
	else if($duplicate == 1)
		echo "Universe already exists.<br/>";
	else 
		echo "Error creating universe.<br/>";
}
function addRole($role){
	$duplicate = 0;
	checkRole($duplicate, $role);
	if($duplicate == 0){
		global $mysqli;
		$addRole = $mysqli->prepare("INSERT INTO role(name) VALUES (?)");
		$addRole->bind_param("s", $role);
		$addRole->execute();
		$addRole->close();
		echo "Role created successfully.<br/>";
	}
	else if($duplicate == 1)
		echo "Role already exists.<br/>";
	else 
		echo "Error creating role.<br/>";
}

function addTalent($name, $desc){
	global $mysqli;
	$addTal = $mysqli->prepare("INSERT INTO talents(name, talent_desc) VALUES (?,?)");
	$addTal->bind_param("ss", $name, $desc);
	$addTal->execute();
	$addTal->close();
	echo "Talent created successfully.<br/>";

}
//Delete and Modify Functions
function modAbil($abil, $cooldown){
	global $mysqli;
	$modCD = $mysqli->prepare("UPDATE abilities SET cooldown = ? WHERE abil_id = ? ");
	$modCD->bind_param("ii", $cooldown, $abil);
	$modCD->execute();
	$modCD->close();
}

function deleteAbil($id){
	global $mysqli;
	$deleteAbil = $mysqli->prepare("DELETE FROM abilities WHERE abil_id = ?");
	$deleteAbil->bind_param("i", $id);
	$deleteAbil->execute();
	$deleteAbil->close();
}
function deleteHero($id){
	global $mysqli;
	$delete = $mysqli->prepare("DELETE FROM heroes WHERE hero_id = ?");
	$delete->bind_param("i", $id);
	$delete->execute();
	$delete->close();
}


//Functions for Drop Down Menus--populates based on what values are in the tables
function getWorldDrop(){
	global $mysqli;
	$worldDrop = $mysqli->prepare("SELECT name, world_id FROM world GROUP BY name, world_id");
	$worldDrop->execute();
	$result = $worldDrop->get_result();
	echo "<select name='world' id='worldDrop'>";
	while($row = $result->fetch_assoc()){
		echo "<option value='". $row["world_id"] . "'>" . $row["name"] ."</option>";
	}
	echo "</select><br/>";
	$worldDrop->close();
}

function getResDrop(){
	global $mysqli;
	$resDrop = $mysqli->prepare("SELECT DISTINCT resource_type FROM heroes");
	$resDrop->execute();
	$result = $resDrop->get_result();
	echo "<select name='resType' id='resDrop'>";
	while($row = $result->fetch_assoc()){
		if($row["resource_type"] === NULL)
			echo "<option value='none'>None</option>";
		else
			echo "<option value ='" . $row["resource_type"] . "'>" . $row["resource_type"] . "</option>"; 
	}
	echo "</select><br/>";
	$resDrop->close();
}

function getAbilDrop($id){
	global $mysqli;
	$abilDrop = $mysqli->prepare("SELECT name FROM abilities WHERE hero_abil = ?");
	$abilDrop->bind_param("i", $id);
	$abilDrop->execute();
	$result = $abilDrop->get_result();
	echo "<select name='abil' id='abilName'>";
	while($row = $result->fetch_assoc()){
		echo "<option value ='" . $row["name"] . "'>" . $row["name"] . "</option>";
	}
	echo "</select><br>";
}
function getRoleDrop(){
	global $mysqli;
	$roleDrop = $mysqli->prepare("SELECT DISTINCT name, role_id FROM role");
	$roleDrop->execute();
	$result = $roleDrop->get_result();
	echo "<select name='roleType' id='roleDrop'>";
	while($row = $result->fetch_assoc()){
		echo "<option value ='" . $row["role_id"] . "'>" . $row["name"] . "</option>";
	}
	echo "</select><br/>";
	$roleDrop->close();
}
//Makes drop down for newly created heroes (aka NOT 1-39)
function getNewHeroName(){
	global $mysqli;
	$newName = $mysqli->prepare("SELECT name, hero_id FROM heroes WHERE hero_id > 39 ORDER BY name ASC");
	$newName->execute();
	$result = $newName->get_result();
	if($result->num_rows === 0){
		echo "No new heroes in database.<br/>";
	}
	else{
		echo "<select name='heroName' id='nameDrop'>";
		while($row = $result->fetch_assoc()){
			echo "<option value ='" . $row["hero_id"] . "'>" . $row["name"] . "</option>";
		}
		echo "</select><br/>";
	}
	$newName->close();
}


