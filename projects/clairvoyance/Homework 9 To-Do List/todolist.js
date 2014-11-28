//Augustus Yuan 1027965
//CSE 190MX Tanner
//HW9 Remember the Cow: In this assignment we are required to interact with a webservice using
//ajax and create a to-do's list. The to-do list should use scriptaculous to create some effects.
//Furthermore the list should also be able to move around and the code should update itself accordingly.
"use strict";
document.observe("dom:loaded", function() {
	//get old list if there is one, else don't do anything
	new Ajax.Request("webservice.php",  {
		method: "get",
		onSuccess: updateList 
	});
	$("add").observe("click", add);
	$("delete").observe("click", remove);
});

//function that takes in an event and adds the next item to the to-do list inputted by the user
//all list items should be sortable and should be updated into the user's list
function add(event) {
	var item =  $("itemtext").value;
	var li = document.createElement("li");
	li.innerHTML = item;
	li.hide();
	$("todolist").appendChild(li);
	li.appear();
	Sortable.create("todolist", {
		onChange: listChange
	});
	updateSession();
}

//function that takes in an event and removes the next item to the to-do list inputted by the user
//all list items should be sortable and should be updated into the user's list
function remove(event) {
	if ($$("#todolist li").length > 0) {
		new Effect.Fade($("todolist").firstChild, {
			afterFinish: function() {
				$("todolist").firstChild.remove();
				updateSession();
			}
		});
	}
}

//function that takes in a list and highlights. Called when user moves an item. This will
//also make sure the saved list is updated
function listChange(list) {
	list.highlight();
	updateSession();
}

//function that helps updates the user's list so that when she leaves and returns, it will be saved.
//code is in JSON format
function updateSession() {
	var arr = $$("#todolist li");
	var list = {};
	list.items = [];
	for (var i = 0; i < arr.length; i++) {
		arr[i].id = "list_" + i;
		list.items.push(arr[i].innerHTML);
	}
	list = JSON.stringify(list);
	new Ajax.Request("webservice.php",  {
		method: "post",
		parameters: {"todolist" : list}
	});
}

//function that takes in ajax and updates the current to-do list assuming there is a to-do list
//made by the user.
function updateList(ajax) {
	var list = JSON.parse(ajax.responseText);
	var array = list.items;
	for (var i = 0; i < array.length; i++) {
		var li = document.createElement("li");
		li.innerHTML = array[i];
		li.id = "list_" + i;
		$("todolist").appendChild(li);
		li.hide();
		li.appear();
	}
	Sortable.create("todolist", {
		onChange: listChange
	});
}