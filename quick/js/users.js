var users = {};
$(function() { 
});
var usersForDialogCreationStats = {currentPage: 0,
                              retrievedCount: 0,
                              totalEntries: null}

var usersForDialogUpdateStats = {currentPage: 0,
                            retrievedCount: 0,
                            totalEntries: null}

function retrieveUsersForDialogCreation(callback) {
  retrieveUsers(usersForDialogCreationStats, callback);
}

function retrieveUsersForDialogUpdate(callback) {
  retrieveUsers(usersForDialogUpdateStats, callback);
}

function retrieveUsers(usersStorage, callback) {

  // we got all users
  if (usersStorage.totalEntries != null && usersStorage.retrievedCount >= usersStorage.totalEntries) {
    callback(null);
    return;
  }

  $("#load-users").show(0);
  usersStorage.currentPage = usersStorage.currentPage + 1;

  // Load users, 10 per request
  //
  QB.users.listUsers({page: usersStorage.currentPage, per_page: '10'}, function(err, result) {
    if (err) {
      console.log(err);
    } else {
      console.log(result);

      mergeUsers(result.items);

      callback(result.items);

      $("#load-users").delay(100).fadeOut(500);

      usersStorage.totalEntries = result.total_entries;
      usersStorage.retrievedCount = usersStorage.retrievedCount + result.items.length;
    }
  });
}

function updateDialogsUsersStorage(usersIds, callback){
  var params = {filter: {field: 'id', param: 'in', value: usersIds}, per_page: 100};

  QB.users.listUsers(params, function(err, result){
    if (result) {
      mergeUsers(result.items);
    }

    callback();
  });
}

function mergeUsers(usersItems){
  var newUsers = {};
  usersItems.forEach(function(item, i, arr) {
    newUsers[item.user.id] = item.user;
  });
  users = $.extend(users, newUsers);
}

function getUserLoginById(byId) {
	var userLogin;
	if (users[byId]) {
		userLogin = users[byId].login;
		return userLogin;
	}
}

function getUserLoginById1(byId) {
	var userLogin;
	if (users[byId]) {
		userLogin = users[byId].full_name;
		return userLogin;
	}
}


function getUserLoginById1(byId) {
	var userLogin;
	if (users[byId]) {
		userLogin = users[byId].full_name;
		return userLogin;
	}
}



function getUserFirstNameById(byId) {
	
var userLogin;
	if (users[byId]) {
		userLogin = users[byId].full_name;
		return userLogin;
	}
}



// Create user
  //
  function createUser(name,login,password,external_user_id){
    var params = {full_name:name,'login': login, 'password': password,external_user_id:external_user_id};
    QB.users.create(params, function(err, user){
        alert(JSON.stringify(user)); 
     
    });
}








