$(window).load(function(){
	if(window.location.href == "https://web.engr.oregonstate.edu/~kuretsks/cs340/Final/heroes.php"){
		getHeroes();
		getWorldDropdown();
		getResourceDrop();
		getRoleDrop();
	}
	if(window.location.href == "https://web.engr.oregonstate.edu/~kuretsks/cs340/Final/abilities.php"){
		var defaultHero = "Abathur";
		getAbilities(defaultHero);
		getHeroName();
		getNewHeroName();
	}
	if(window.location.href == "https://web.engr.oregonstate.edu/~kuretsks/cs340/Final/talents.php"){
		getHeroName();
		getTalents("Abathur");
		getNewHeroName();
		getNewTalents();
	}
});

function getHeroName(){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {menu: "hero"},
		success: function(data){
			$('#hAbilSelect').html(data);
		}
	}).error(function(){
		alert("Error populating hero list.");
	});
}
function getNewHeroName(){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {menu: "newHero"},
		success: function(data){
			$('.hAbilSelect2').html(data);
		}
	}).error(function(){
		alert("Error getting new heroes.");
	});
}
function getHeroes(){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {action: "getAll"},
		success: function(data){
			$('#heroes').html(data);
		}
	}).error(function(){
		alert("Error getting hero information.");
	});
}

function getTalents(hero){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {talent: hero},
		success: function(data){
			$('#talents').html(data);
		}
	}).error(function(){
		alert("Unable to get hero talents.");
	});
}
function getNewTalents(newTalents){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {newTalent: true},
		success: function(data){
			$('#createdTal').html(data);
		}
	});
}
function getAbilities(hero){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {abil: hero},
		success: function(data){
			$('#hAbil').html(data);
		}
	}).error(function(){
		alert("Error getting ability information.");
	});
}
//Add functions
$("#addHero").submit(function(event){
	event.preventDefault();
	var hName = $('#hName').val();
	var role = $('#roleDrop :selected').val();
	var hWorld = $('#worldDrop :selected').val();
	var rType = $('#resDrop :selected').text();
	var hp = $('#hp').val();
	var res = $('#res').val();
	$.ajax({
		type: "POST",
		url: "dbFunctions.php",
		data: {add: "hero", name: hName, role: role, world: hWorld, resource: rType, hp: hp, res: res},
		success: function(data){
			$('#heroMsg').html(data);
			getHeroes();
		}
	});
});

$('#addTalent').submit(function(event){
	event.preventDefault();
	var tName = $('#talName').val();
	var tDesc = $('#talDesc').val();
	$.ajax({
		type: "POST",
		url: "dbFunctions.php",
		data: {add: "talent", tName: tName, tDesc: tDesc},
		success: function(data){
			$('#addTalMsg').html(data);
			getNewTalents();
		}
	});
});

$("#addAbil").submit(function(event){
	event.preventDefault();
	var hero = $('.hAbilSelect2 > select :selected').text();
	var hName = $('.hAbilSelect2 > select :selected').val();
	var abilName = $('#abilName').val();
	var abilDesc = $('#abilDesc').val();
	var cd = $('#abilCD').val();
	if(cd === null || cd === '' || cd === undefined)
		cd = null;
	if(abilDesc === null || abilDesc === '' || abilDesc === undefined)
		abilDesc = null;
	$.ajax({
		type: "POST",
		url: "dbFunctions.php",
		data: {add: "ability", name: hName, aName: abilName, aDesc: abilDesc, cd: cd},
		success: function(data){
			$('#addAbilMsg').html(data);
			getAbilities(hero);
		}
	});
	getHeroName();
});

$('#addRole').submit(function(event){
	event.preventDefault();
	var newRole = $('#newRole').val();
	if(newRole === '' || newRole === null){
		$('#newRoleMsg').html("You must enter a role name.");
	}
	$.ajax({
		type: "POST",
		url: "dbFunctions.php",
		data: {add: "role", role: newRole},
		success: function(data){
			$('#newRoleMsg').html(data);
			getRoleDrop();
		}
	});
});

$('#addWorld').submit(function(event){
	event.preventDefault();
	var newWorld = $('#newWorld').val();
	$.ajax({
		type: "POST",
		url: "dbFunctions.php",
		data: {add: "world", world: newWorld},
		success: function(data){
			$('#newWorldMsg').html(data);
			getWorldDropdown();
		}
	});
});

$('#hAbilSelect').on("change", '#nameDrop', function(){
	var hero = $('#nameDrop :selected').text();
	getAbilities(hero);
	getTalents(hero);
});

$('#heroes').on("click", "table tr td button", function(){
	var id = this.parentNode.parentNode.id;
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {action: "delete", id: id},
		success: function(){
			getHeroes();
		}
	});
});

$('#hAbil').on("click", ".modify", function(){
	var id = this.parentNode.parentNode.id;
	var hero = $('#nameDrop :selected').text();
	var cdTextID = "#" + "modCD" + id;
	var cd = $(cdTextID).val();
	if(cd !== '' || cd !== null){
		$.ajax({
			method: "POST",
			url: "dbFunctions.php",
			data: {modify: "true", id: id, cd: cd},
			success: function(data){
				getAbilities(hero);
			}
		});
	}

});
$('#hAbil').on("click", ".delete", function(){
	var id = this.parentNode.parentNode.id;
	var hero = $('#nameDrop :selected').text();
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {action: "deleteAbil", id: id},
		success: function(){
			getAbilities(hero);
		}
	});
});

function getWorldDropdown(){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {menu: "world"},
		success: function(data){
			$('#worldSelect').html(data);
		}
	});
}

function getResourceDrop(){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {menu: "res"},
		success: function(data){
			$('#resSelect').html(data);
		}
	});
}

function getRoleDrop(){
	$.ajax({
		method: "POST",
		url: "dbFunctions.php",
		data: {menu: "role"},
		success: function(data){
			$('#roleSelect').html(data);
		}
	});
}
