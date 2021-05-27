/**
 * @return {!Object} The FirebaseUI config.
 */
 var mobile = "";
function getUiConfig() {
  return {
    'callbacks': {
      // Called when the user has been successfully signed in.
      'signInSuccess': function(user, credential, redirectUrl) {
        console.log("-2-");
        handleSignedInUser(user);
        // Do not redirect.
        return false;
      }
    },
    // Opens IDP Providers sign-in flow in a popup.
    'signInFlow': 'popup',
    'signInOptions': [
      // The Provider you need for your app. We need the Phone Auth
      // firebase.auth.TwitterAuthProvider.PROVIDER_ID,
      {
        provider: firebase.auth.PhoneAuthProvider.PROVIDER_ID,
        recaptchaParameters: {
          type: 'image', // another option is 'audio'
          size: 'normal', // other options are 'normal' or 'compact'
          badge: 'bottomleft' // 'bottomright' or 'inline' applies to invisible.
        },
        defaultCountry: 'AU',
        customParameters: {
          // Forces account selection even when one account
          // is available.
          prompt: 'select_account'
        }
      }
    ],
    // Terms of service url.
    'tosUrl': 'https://www.google.com'
  };
}

function getUrlVars()
{
	console.log(window.location.href);
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function redirectToApp(mobile){
  	console.log("-5-");
	//var mobile = getUrlVars()["mobile"];
	console.log(getUrlVars());
	console.log(getUrlVars()["email"]);
	console.log(getUrlVars()["password"]);
	var email = getUrlVars()["email"];
	var password = getUrlVars()["password"];
	phoneRegister(mobile,email,password);
	//window.location.href = "..MyOnclickMethod?mobile="+mobile+"&email="+email+"&password="+password;
}

// Initialize the FirebaseUI Widget using Firebase.
var ui = new firebaseui.auth.AuthUI(firebase.auth());

/**
 * Displays the UI for a signed in user.
 * @param {!firebase.User} user
 */
var handleSignedInUser = function(user) {
  console.log("user1:");
  console.log(user);
  firebase.auth().signOut();
  deleteAccount();
  setTimeout(function() {
  	console.log("-4-");
	  redirectToApp(user.phoneNumber);
        }, 3);
  //redirectToApp();
  //document.getElementById('user-signed-in').style.display = 'block';
  // document.getElementById('user-signed-out').style.display = 'none';
  // document.getElementById('name').textContent = user.displayName;
  // document.getElementById('email').textContent = user.email;
  // document.getElementById('phone').textContent = user.phoneNumber;
  // if (user.photoURL){
  //   document.getElementById('photo').src = user.photoURL;
  //   document.getElementById('photo').style.display = 'block';
  // } else {
  //   document.getElementById('photo').style.display = 'none';
  // }
};


/**
 * Displays the UI for a signed out user.
 */
var handleSignedOutUser = function() {
  console.log("-1-");
  document.getElementById('user-signed-in').style.display = 'none';
  document.getElementById('message_div').style.display = 'none';
  document.getElementById('user-signed-out').style.display = 'block';
  ui.start('#firebaseui-container', getUiConfig());
};

// Listen to change in auth state so it displays the correct UI for when
// the user is signed in or not.
firebase.auth().onAuthStateChanged(function(user) {
  console.log("user:");
  console.log(user);
  document.getElementById('loading').style.display = 'none';
  if(user == null){
  	document.getElementById('loaded').style.display = 'block';
  }else{
  	console.log("-2-");
  	$("#user-signed-out").hide();
  	document.getElementById('user-signed-out').style.display = 'none';
  	document.getElementById('loaded').style.display = 'none';
  }
  user ? handleSignedInUser(user) : handleSignedOutUser();
});

/**
 * Deletes the user's account.
 */
var deleteAccount = function() {
  	console.log("-3-");
	document.getElementById('user-signed-out').style.display = 'none';
  firebase.auth().currentUser.delete().catch(function(error) {
  	console.log("-7-");
    if (error.code == 'auth/requires-recent-login') {
      // The user's credential is too old. She needs to sign in again.
      firebase.auth().signOut().then(function() {
	     // redirectToApp();
        // The timeout allows the message to be displayed after the UI has
        // changed to the signed out state.
        setTimeout(function() {
         // alert('Please sign in again to delete your account.');
        }, 1);
      });
    }
  });
};

/**
 * Initializes the app.
 */
var initApp = function() {
/*
	var str = location.pathname;
	var rest = str.substring(0, str.lastIndexOf("/") + 1);
	var last = str.substring(str.lastIndexOf("/") + 1, str.length);
 console.log(location.protocol + '//' + location.host + rest+'api/phoneRegister');
*/
  document.getElementById('sign-out').addEventListener('click', function() {
    firebase.auth().signOut();
  });
  document.getElementById('delete-account').addEventListener(
      'click', function() {
        deleteAccount();
      });
};

window.addEventListener('load', initApp);

var phoneRegister = function(mobile, email, password){
  	console.log("-6-");
	var str = location.pathname;
	var rest = str.substring(0, str.lastIndexOf("/") + 1);
	var last = str.substring(str.lastIndexOf("/") + 1, str.length);
	var url = location.protocol + '//' + location.host + rest;
	console.log({'email': email,'mobile': mobile});
	console.log(url+'api/phoneRegister');
	$.ajax({
        method:'post',
        url: url+'api/phoneRegister',
        data: {'email': email,'mobile': mobile},
	    success: function(result) {
		    result = JSON.parse(result);
// 		    console.log(result);
			document.getElementById('loading').style.display = 'block';
			document.getElementById('user-signed-out').style.display = 'none';
	        if(result.status==200)
	        {
				document.getElementById('loading').style.display = 'block';
				window.location.href = url+"waitPage?mobile="+mobile+"&email="+email+"&password="+password;
/*
				setTimeout(function() {
					window.location.href = url+"waitPage?mobile="+mobile+"&email="+email+"&password="+password;
			    }, 3);
*/
		    }else{
				document.getElementById('loading').style.display = 'none';
				document.getElementById('user-signed-out').style.display = 'block';
				document.getElementById('message_div').style.display = 'block';
			    $("#message").html(result.message);
		    }
			firebase.auth().signOut();
		    deleteAccount();
		}
    })
}