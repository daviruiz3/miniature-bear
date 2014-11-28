/*
David Ewald & David N. Ruiz
INFO 343 A\B
Final Project
*/

'use strict';
var SEARCHED =false;
var results = 0; 
$(document).ready(function(){
	//ajaxEverything('http://api.comicvine.com/characters/', injectStuff);
	$('#querySubmit').click(allAjax);
	$('#topBanner').click(function(){
		window.location.pathname = '/ewadav/DDComics/final/DD.html';});
		$('#query').bind('keyup', function(event) {
		if (event.keyCode == 13) {
			allAjax();
		}
	});
	$("#characters").hide();
	$("#volumes").hide();
	$("#teams").hide();

	$('#loading').hide();
	
	$('#heroesTitle').hide();
    $('#volumesTitle').hide();
    $('#teamsTitle').hide();
});
	
function allAjax()	{
	if(SEARCHED)	{
		results = 0;
		$('.titles').show();

		$('#characters').empty();
		$('#volumes').empty();
		$('#teams').empty();
		
		$('#heroesTitle').show();
		$('#volumesTitle').show();
		$('#teamsTitle').show();
		
		$('#charDetails .col').empty();
		$('#volDetails .col').empty();
		$('#teamsDetails .col').empty();
	}

	search('team');
	search('character');
	search('volume');
	$('#charDetails .col').empty();
	SEARCHED = true;

	$('#heroesTitle').show();
    $('#volumesTitle').show();
    $('#teamsTitle').show();

}

// This function accepts the data (JSON format) paramter
// and builds a character based on the data passed

function injectCharacters(data)	{
	var hero = data;
	results++;
	var insertion = $('<div>').addClass('insertion').click(function(){characterDetails(hero);}).appendTo('#characters');
	if(hero.image !=null)	{
		var $heroImage = $('<img>' , {'src': hero.image.thumb_url , 'alt': hero.name ,}).appendTo(insertion);
	}else	{
		var $heroImage = $('<img>' , {'src': 'no-photo.jpg' , 'alt': "No picture" , 'height': '110px', 'width':'110px'}).appendTo(insertion);
	}
	var $heroName = $('<h3>').text(hero.name).appendTo(insertion);
	if(hero.first_appeared_in_issue != null && hero.first_appeared_in_issue.name != '')	{
		var $comicBook = $('<p>').text("First appeared in \"" + hero.first_appeared_in_issue.name + "\"").appendTo(insertion);
	}
	if(hero.deck != '')	{
		var $heroDeck = $('<p>').text(hero.deck).appendTo(insertion);
	}
} 

// This function accepts a data (JSON format) parameter
// and builds a list of volumes 

function injectVolumes(data) {
	var volume = data;
	results++;
	var insertion = $('<div>').addClass('insertion').click(function(){volumeDetails(volume)}).appendTo('#volumes');
	if(volume.image !=null)	{
		var $volumeImage = $('<img>' , {'src': volume.image.thumb_url , 'alt': volume.name ,}).appendTo(insertion);
	}else	{
		var $volumeImage = $('<img>' , {'src': 'no-photo.jpg' , 'alt': "No picture" , 'height': '110px', 'width':'110px'}).appendTo(insertion);
	}
	var $heroName = $('<h3>').text(volume.name).appendTo(insertion);
	if(volume.count_of_issues != null)	{
		var $comicBook = $('<a>').text("Total issues: " + volume.count_of_issues ).appendTo(insertion);
	}
	if(volume.start_year != null)	{
		var $startYear = $('<p>').text("Start year: " + volume.start_year).appendTo(insertion);
	}
} 

// This function accepts a data (JSON format) parameter
// and builds a list of the teams associated with a hero
function injectTeams(data)	{
	var team = data;
	results++;
	var insertion = $('<div>').addClass('insertion').click(function(){teamDetails(team)}).appendTo('#teams');
	if(team.image !=null)	{
		var $teamImage = $('<img>' , {'src': team.image.thumb_url , 'alt': team.name ,}).appendTo(insertion);
	}else{
		var $teamImage = $('<img>' , {'src': 'no-photo.jpg' , 'alt': "No picture" , 'height': '110px', 'width':'110px'}).appendTo(insertion);
	}
	var $heroName = $('<h3>').text(team.name).appendTo(insertion);
	if(team.first_appeared_in_issue != null)	{
		var $firstAppeared = $('<a>').text("First appeared in \"" + team.first_appeared_in_issue.name + "\"").appendTo(insertion);
	}
	if(team.deck != '')	{
		var $teamDeck = $('<p>').text(team.deck).appendTo(insertion);
	}
	$("#teams").fadeIn("slow");
} 
 
// These function executes an ajax request for Hero Details 

function ajaxHeroDetails(url)	{
	$.ajax({
		url: url ,
		data:{
			api_key: "b0a8872b1ca70c95a8b28568face4a1fda82785c", 
			format: 'jsonp',
			json_callback: 'injectHeroDetails'
			} ,
		dataType: 'jsonp' ,
		success: injectHeroDetails 
	});
}

function ajaxVolumeDetails(url)	{
	$.ajax({
		url: url ,
		data:{
			api_key: "b0a8872b1ca70c95a8b28568face4a1fda82785c", 
			format: 'jsonp',
			json_callback: 'injectVolumeDetails'
			} ,
		dataType: 'jsonp' ,
		success: injectVolumeDetails 
	});
}

function ajaxTeamDetails(url) {
		$.ajax({
		url: url ,
		data:{
			api_key: "b0a8872b1ca70c95a8b28568face4a1fda82785c", 
			format: 'jsonp',
			json_callback: 'injectTeamDetails'
			} ,
		dataType: 'jsonp' ,
		success: injectTeamDetails 
	});
}

//###############################################//

// This function handles the ajax request and input search functionality
function search(resource) {
	var query = $('#query').val();
	var url = 'http://api.comicvine.com/search/';
	
	$.ajax({
		url: url ,
		data:{
			api_key: "b0a8872b1ca70c95a8b28568face4a1fda82785c", 
			format: 'jsonp',
			json_callback: 'filterResources',
			query: query ,
			resources: resource
			} ,
		dataType: 'jsonp' ,
		success: filterResources 
	});
}

function filterResources(data)	{
	$.each(data.results, function(i){
		var resource = data.results[i];
		if(resource.resource_type =='character')	{
			injectCharacters(resource);
		}else if (resource.resource_type =='volume')	{
			injectVolumes(resource);
		}else if (resource.resource_type =='team'){
			injectTeams(resource);
		}
	});
	
	$("#characters").fadeIn("slow");
	$("#volumes").fadeIn("slow");
	$("#teams").fadeIn("slow");
	$('#results').text(results + " Results");
}

	
// These functions all accept a data (JSON format) parameter
// and make a call to the correct ajax Request	
function characterDetails(data)	{
	var url = data.api_detail_url;
	emptyShow();
	ajaxHeroDetails(url);
}

function volumeDetails(data) {
	var url = data.api_detail_url;
	emptyShow();
	ajaxVolumeDetails(url);
}

function teamDetails(data) {
	var url = data.api_detail_url;
	emptyShow();
	ajaxTeamDetails(url);
}

// This function accepts a query parameter and makes an ajax request
// Reddit Api  
function ajaxRedditFeeds(qu) {

	$.ajax('http://www.reddit.com/search.json', {
		dataType: 'jsonp',
		jsonp: 'jsonp',
		data:{ q : qu },
		success: injectRedditFeeds
	});
}

// This function accepts a data (JSON format) parameter
// The purpose is to gather random unrelated topics that match the query string
function injectRedditFeeds(data){
    $('#redditFeed').empty();
        
        var reddit = $('<div id="redditFeed">');
        
        $.each(data.data.children, function(index, child){
			var list = $('<li>');
			var thum;
			var reddi;
			var titl = $('<span class="title">').text(child.data.title);
			var alink = $('<a>', {'href' : "http://www.reddit.com" + child.data.permalink , 'alt': 'Reddit Post'}); 
        
            if (child.data.thumbnail !== null && child.data.thumbnail !== 'self' && child.data.thumbnail !== '') {
				if(child.data.thumbnail == 'nsfw')	{
					thum = $('<img>', {'src': 'over18.png' , 'alt' : child.data.title , 'width':'70px' , 'height': '70px'}); 			
				}else{
					thum = $('<img>', {'src': child.data.thumbnail , 'alt' : child.data.title}); 
				}			
				alink.append(thum);
			}
                
                if (child.data.selftext != null && child.data.selftext != ""){
                        var string = child.data.selftext.split(' ');
                        
                        string = string.slice(0, 20);
                        string[19] = string[19] +"...";
                        
                        string = string.join(" ");
                        
                        alink.append(string);
                }
                
                if(child.data.author){
                        var auth = $("<span class='author'>").html(child.data.author);
                        alink.append(auth);
                }
                
                if(child.data.ups){
                        var likes = child.data.ups;
                        alink.append(likes);
                }
                
                list.append(alink);
                
                reddit.append(list);
        });
        
        $('#charDetails .col').append(reddit);
        $('#volDetails .col').append(reddit);
        $('#teamsDetails .col').append(reddit);
}

//This function injects the herodetails into the page if a hero was selected.

function injectHeroDetails(data)	{
	var hero = data.results;
	if(hero.image !=null)	{
		var $heroImage = $('<img>' , {'src': hero.image.super_url , 'alt': hero.name}).appendTo('#charDetails .col');
	}else	{
		var $heroImage = $('<img>' , {'src': 'no-photo.jpg' , 'alt': "No picture" , 'height': '110px', 'width':'110px'}).appendTo('#charDetails .col');
	}
	var $heroName = $('<h1>').appendTo('#charDetails .col');
	var insertion = $('<div>').addClass('basicInfo').appendTo('#charDetails .col');
	$('<a>').text(hero.name).attr('href', hero.site_detail_url).appendTo($heroName);
	var $descriptionDiv = $('<div>').addClass('description').appendTo('#charDetails .col');
	
	if(hero.publisher != null)	{
		$('<p>').text("Publisher: " + hero.publisher.name).appendTo(insertion);
	}
	if(hero.origin !=null)	{	
		$('<p>').text("Origin: " + hero.origin.name).appendTo(insertion);
	}
	if(hero.first_appeared_in_issue != null && hero.first_appeared_in_issue.name !='')	{
		var $comicBook = $('<p>').text("First appeared in \"" + hero.first_appeared_in_issue.name + "\"").appendTo(insertion);
	}
	if(hero.aliases !=null)	{
		var $heroAliases = $('<p>').text('Aliases: ' + hero.aliases).appendTo(insertion);
	}
	
	if(hero.description !=null)	{
		var $heroDescription = $('<p>').html(hero.description).appendTo(insertion);
	}else{
		if(hero.deck != '')	{
			var $heroDeck = $('<p>').text(hero.deck).appendTo(insertion);
		}
	}
	
	if(hero.count_of_issue_appearances != null && hero.issue_credits !=null)	{
		var $issueDiv = $('<div>').attr('id','charIssues').appendTo('#volDetails .col');
		$('<p>').text("Number of issue appearances: " + hero.count_of_issue_appearances).appendTo($issueDiv);
		var $issueList = $('<ul>').appendTo($issueDiv);
		for (var i = 0; i<hero.issue_credits.length; i++)	{
			if(hero.issue_credits[i].name !='' && hero.issue_credits[i].name!= ' ')	{
				if(i < 200){
					var $listItem = $('<li>').appendTo($issueList);
					$('<a>').text(hero.issue_credits[i].name).attr('href', hero.issue_credits[i].site_detail_url).appendTo($listItem);
				}
			}
		}
	}
	if(hero.volume_credits !=null)	{
		var $volumeDiv = $('<div>').attr('id','charVolumes').appendTo('#volDetails .col');
		$('<p>').text("Volumes:").appendTo($volumeDiv);
		var $volumeList = $('<ul>').appendTo($volumeDiv);
		for( var i = 0; i<hero.volume_credits.length; i++)	{
			if(i < 200){
				var $volumeItem = $('<li>').appendTo($volumeList);
				$('<a>').text(hero.volume_credits[i].name).attr('href', hero.volume_credits[i].site_detail_url).appendTo($volumeItem);
			}
		}
	}
	if(hero.character_friends !=null && hero.character_friends !='')	{
		var $friendDiv = $('<div>').attr('id','friends').appendTo('#teamsDetails .col');
		$('<p>').text("Friends:").appendTo($friendDiv);
		var $friendList = $('<ul>').appendTo($friendDiv);
		for( var i = 0; i<hero.character_friends.length; i++)	{
			var $friendItem = $('<li>').appendTo($friendList);
			$('<a>').text(hero.character_friends[i].name).click(function(){ajaxHeroDetails(hero.character_friends[i].api_detail_url)}).appendTo($friendItem);
		}
	}
	if(hero.character_enemies !=null && hero.character_enemies !='')	{
		var $enemyDiv = $('<div>').attr('id','enemies').appendTo('#teamsDetails .col');
		$('<p>').text("Enemies:").appendTo($enemyDiv);
		var $enemyList = $('<ul>').appendTo($enemyDiv);
		for( var i = 0; i<hero.character_enemies.length; i++)	{
			var $enemyItem = $('<li>').appendTo($enemyList);
			$('<a>').text(hero.character_enemies[i].name).click(function(){ajaxHeroDetails(hero.character_enemies[i].api_detail_url)}).appendTo($enemyItem);
		}
	}
	if(hero.powers !=null)	{
		var $powersDiv = $('<div>').attr('id','powers').appendTo('#teamsDetails .col');
		$('<p>').text("Powers:").appendTo($powersDiv);
		var $powersList = $('<ul>').appendTo($powersDiv);
		for( var i = 0; i<hero.powers.length; i++)	{
			var $powersItem = $('<li>').appendTo($powersList);
			$('<a>').text(hero.powers[i].name).attr('href', hero.powers[i].site_detail_url).appendTo($powersItem);
		}
	}
	var heroName = hero.name.split(' ').join('+');
	var heroName2 = hero.name.split(' ').join('_');
	var $amawikiDiv = $('<div>').addClass('wikiAmaz').appendTo('#volDetails .col');
	var qStringAmazon = 'http://www.amazon.com/s/ref=nb_sb_noss_1?url=search-alias%3Daps&field-keywords=' + heroName;
	var amazonLink = $('<a>').attr('href' , qStringAmazon).appendTo($amawikiDiv);
	$('<img>' , {'src': 'amazon.jpg' , 'alt' : qStringAmazon}).appendTo(amazonLink);
	var qStringWiki = 'http://en.wikipedia.org/wiki/' + heroName2;
	var wikiLink = $('<a>').attr('href' , qStringWiki).appendTo($amawikiDiv);
	$('<img>' , {'src': 'Wikipedia.png' , 'alt' : qStringWiki}).appendTo(wikiLink);
	
	$('#loading').hide();
	$('#charDetails .col').show();
	ajaxRedditFeeds(hero.name);
}

//This function injects all the information for a volume if clicked

function injectVolumeDetails(data) {
	var volume = data.results;
	var $mainDiv = $('#charDetails .col');

	// Add the image
	if (volume.image != null)	{
		var $volumeImage = $('<img>' , {'src': volume.image.super_url , 'alt': volume.name}).appendTo($mainDiv);

	} else	{
		var $volumeImage = $('<img>' , {'src': 'no-photo.jpg' , 'alt': "No picture" , 'height': '110px', 'width':'110px'}).appendTo($mainDiv);
	}
	
	// Add the name
	var $volumeName = $('<h1>').appendTo($mainDiv);
	$('<a>').text(volume.name).attr('href', volume.site_detail_url).appendTo($volumeName);
	
	var insertion = $('<div>').attr('id','basicInfo').appendTo($mainDiv);

	// Add the description or the deck if no description
	var $descriptionDiv = $('<div>').addClass('description').appendTo($mainDiv);
	if (volume.description != null)	{
		var $volumeDescription = $('<p>').html(volume.description).appendTo($descriptionDiv);
	} else if (volume.deck != '') {
		var $volumeDescription = $('<p>').text(volume.deck).appendTo($descriptionDiv);
	}

	// Add the publisher, if they exist
	if (volume.publisher != null)	{
		$('<p>').text("Publisher: " + volume.publisher.name).appendTo(insertion);
	}

	// Add the number of issues
	if (volume.count_of_issues != null) {
		$('<p>').text("Number of Issues: " + volume.count_of_issues).appendTo(insertion);
	}

	// Add the start year
	if (volume.count_of_issues != null) {
		$('<p>').text("Start Year: " + volume.start_year).appendTo(insertion);
	}

	// First and Last issue name and publish year
	var firstLastIssue = '';
	if (volume.first_issue != null) {
		firstLastIssue = 'First Issue: ' + volume.first_issue.name + ' ' + volume.first_issue.publish_year;
	}

	if (volume.last_issue != null) {
		firstLastIssue += ', Last Issue:' + volume.last_issue.name + ' ' + volume.last_issue.publish_year;
	}
	$('<p>').text(firstLastIssue).appendTo(insertion);

	
	// Add all of the characters
	listMaker(volume.character_credits, $('#volDetails .col'), "Characters in Volume: ");

	// Add all of the writers/artists
	listMaker(volume.persons_credits, $('#volDetails .col') , "Writers and Artists: ");
	
	// Wikipedia and amazon stuff
	addWikiZon(volume, $('#volDetails .col'));

	// Hide loading and show the volDetails
	$('#loading').hide();
	$mainDiv.show();
	ajaxRedditFeeds(volume.name);
}

//This function injects all the details of the team if selected

function injectTeamDetails(data) {
	var team = data.results;
	var $mainDiv = $('#charDetails .col')
	console.log(team);
	// Add the image
	if (team.image != null)	{
		var $teamImage = $('<img>' , {'src': team.image.super_url , 'alt': team.name}).appendTo($mainDiv);

	} else	{
		var $teamImage = $('<img>' , {'src': 'no-photo.jpg' , 'alt': "No picture" , 'height': '110px', 'width':'110px'}).appendTo($mainDiv);
	}
	
	// Add the name
	var $teamName = $('<h1>').appendTo($mainDiv);
	$('<a>').text(team.name).attr('href', team.site_detail_url).appendTo($teamName);
	
	var insertion = $('<div>').attr('id','basicInfo').appendTo($mainDiv);

	// Add the description or the deck if no description
	var $descriptionDiv = $('<div>').addClass('description').appendTo($mainDiv);
	if (team.description != null)	{
		var $teamDescription = $('<p>').html(team.description).appendTo($descriptionDiv);
	} else if (team.deck != '') {
		var $teamDescription = $('<p>').text(team.deck).appendTo($descriptionDiv);
	}

	// Add the publisher, if they exist
	if (team.publisher != null)	{
		$('<p>').text("Publisher: " + team.publisher.name).appendTo(insertion);
	}

	// Add the number of issues appeared in
	if (team.count_of_issue_appearances != null) {
		$('<p>').text("Number of Issues appeared in: " + team.count_of_issue_appearances).appendTo(insertion);
	}

	// Add the number of team members
	if (team.count_of_team_members != null) {
		$('<p>').text("Number of Members: " + team.count_of_team_members).appendTo(insertion);
	}

	// First issue appeared in
	if (team.first_appeared_in_issue != null) {
		var issueAppearedIn = 'First Issue appeared: ' + team.first_appeared_in_issue.name;
		$('<p>').text(issueAppearedIn).appendTo(insertion);
	}


	// Issues Disbanded in
	var disbanded = 'Issues disbanded in:';
	if (team.disbanded_in_issues != null && team.disbanded_in_issues.length != 0) {
		$.each(team.disbanded_in_issues, function(i) {
			disbanded += team.disbanded_in_issues[i].name + ',';
		});
		disbanded = disbanded.substr(0, disbanded.length - 1);
		$('<p>').text(disbanded).appendTo(insertion);
	}
	
	// Team Enemies
	listMaker(team.team_enemies, $('#volDetails .col'), "Team Enemies: ");

	// Team Friends
	listMaker(team.team_friends, $('#volDetails .col'), "Team Friends: ");

	// Character Enemies
	listMaker(team.character_enemies, $('#volDetails .col'), "Character Enemies: ");

	// Character Friends
	listMaker(team.character_friends, $('#volDetails .col') , "Character Friends: ");

	
	// Add all of the characters
	listMaker(team.charDetails, $('#volDetails .col') , "Team Members: ")


	// Add all of the writers/artists
	listMaker(team.person_credits, $('#volDetails .col'), "Writers and Artists: ");
	
	// Wikipedia and amazon stuff
	addWikiZon(team, $('#volDetails .col'));


	// Hide loading and show the character details
	$('#loading').hide();
	$mainDiv.show();
	ajaxRedditFeeds(team.name);
}

// Adds the Amazon and Wikipedia buttons to the given div
// Takes an object to get the name from(team, volume, hero)
function addWikiZon(mainObj, $mainDiv) {
	var heroName = mainObj.name.split(' ').join('+');
	var heroName2 = mainObj.name.split(' ').join('_');
	var $amawikiDiv = $('<div>').addClass('wikiAmaz').appendTo($mainDiv);
	var qStringAmazon = 'http://www.amazon.com/s/ref=nb_sb_noss_1?url=search-alias%3Daps&field-keywords=' + heroName;
	var amazonLink = $('<a>').attr('href' , qStringAmazon).appendTo($amawikiDiv);
	$('<img>' , {'src': 'amazon.jpg' , 'alt' : qStringAmazon}).appendTo(amazonLink);
	var qStringWiki = 'http://en.wikipedia.org/wiki/' + heroName2;
	var wikiLink = $('<a>').attr('href' , qStringWiki).appendTo($amawikiDiv);
	$('<img>' , {'src': 'Wikipedia.png' , 'alt' : qStringWiki}).appendTo(wikiLink);
}


// Makes the lists of issues, enemeis,volumes, etc       /           /            ////////////////////
function listMaker(list, mainDiv , string) {
	if (list != null && list.length != 0) {
		var $characterListContainer = $('<div>').addClass('person-list').appendTo(mainDiv);
		$('<p>').text(string).appendTo($characterListContainer);
		var $characterList = $('<ul>').appendTo($characterListContainer);
		$.each(list, function(i) {
			var $listItem = $('<li>').appendTo($characterList);
			var $link = $('<a>').attr("href", list[i].site_detail_url).text(list[i].name).appendTo($listItem);
			
		}); 
	}
}

//This function empties divs when we re-search something
function emptyShow() {
	$('#teams').empty();
	$('#characters').empty();
	$('#volumes').empty();
	$('.titles').hide();
	$('#results').empty();
	$('#loading').show();
}	