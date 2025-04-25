<?php
//Start or re-start the session 
session_start(); 

//Check if this client is authenticated (logged in)
if(isset($_SESSION['loggedin']))
{
	$loggedin = $_SESSION['loggedin'];
	$account_id = $_SESSION['account_id'];
	$userDisplay = $_SESSION['userDisplay'];
	$username = $_SESSION['username'];
	$email = $_SESSION['email'];
	//Set the menu options for authenticated users
	$menu = "<a href='twixitter.php?action=addpost'>Make a New Post</a> | <a href='twixitter.php?action=account'>My Account</a> | <a href='twixitter.php?action=liked'>Liked Posts</a> | <a href='twixitter.php?action=logout'>Logout</a>";

}
else
{//User is not authenticated (not logged in)
	$loggedin = FALSE;
	//set the account_id to 0 for functions that have account_id as a paremeter
	$account_id = 0;
	//Set the menu options for non-authenticated users
	$menu = "<a href='twixitter.php?action=loginform'>Login</a> | <a href='twixitter.php?action=register'>Register</a>";
}
include("model/functions.php");
//Get the user 'action'
//Check the POST array for a value with the name 'action' (form submission)
$action = filter_input(INPUT_POST, 'action');
//If NULL - nothing found in POST array - check the GET array (URL submission)
if($action == NULL)
	$action = filter_input(INPUT_GET, 'action');

if($action == "register")
{//user has clicked the 'register' link
	//No data to capture
	//No processing to be done
	//set the variables for the 'view' file
	$pagetitle="Registration Form";
	$error="";
	$username = "";
	$email="";
	$fname = "";
	$lname="";
	//include the view files
	include("view/header.php");
	include("view/registerform.php");		
}
elseif($action == "Submit Registration")
{//User has submitted the registration form
	//capture data from registration form
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');
	$email= filter_input(INPUT_POST, 'email');
	$fname =  filter_input(INPUT_POST, 'fname');
	$lname= filter_input(INPUT_POST, 'lname');
	
	//Check for empty fields by calling a the function
	if(notEmptyAccount($username, $password, $email, $fname, $lname))
	{//function returned true, so all fields are completed
		
		//check if username is available by calling the function
		if(checkUsername($username))
		{//function returned true, so the username is available
			//enter new account by calling the function
			addAccount($username, $password, $email, $fname, $lname);
			$pagetitle="Registration Complete";
			include("view/header.php");
			include("view/registrationdone.php");
		}
		else
		{
			//username is taken, show form again
			$error = "<p>Username is not available. Please select another.</p>";
			$pagetitle="Registration Form";
			include("view/header.php");
			include("view/registerform.php");
		}
	}
	else
	{//Some fields were left empty
		$pagetitle="Registration Form";
		$error="<p>Please complete all fields</p>";
		include("view/header.php");
		include("view/registerform.php");		
	}
	
}
elseif($action == "loginform")
{//User clicked the 'login' link
	//No data to capture
	//No processing to be done
	//set the variables for the 'view' file
	$pagetitle="Login Form";
	$username = "";
	$error="";
	//include the view files
	include("view/header.php");
	include("view/loginform.php");		
}	
elseif($action == "Login")
{//User has submitted the login form
	//Capture the submitted data
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');
	
	//Call the processLogin function, send the username and password as parameters
	$account = processLogin($username, $password);
	//The function will return the matching account if the login is correct
	//It will return NULL if the login was incorrect
	if($account != NULL)
	{//Login was successful, user account was returned
		//Set the $_SESSION array values
		//This is the only time when values are assigned to the $_SESSION array
		$_SESSION['loggedin'] = True;
		$_SESSION['username'] = $account['username'];
		$_SESSION['account_id']= $account['id'];
		$_SESSION['email'] = $account['email'];
		$_SESSION['userDisplay'] = $account['fname']." ".$account['lname'];
		//login is done, redirect to default view
		header("Location:twixitter.php");			
	}
	else
	{//Login was not successful
		//set the variables for the 'view' file
		$error = "<p>Incorrect login, try again</p>";
		$pagetitle="Login Form";
		//include the 'view' files, showing the login form again
		include("view/header.php");
		include("view/loginform.php");	
	}	
}
elseif($action == "logout" && $loggedin)
{//This 'action' is only available if logged in
	$_SESSION = array();  //clear the $_SESSION array
	session_destroy();	
	header("Location:twixitter.php");
}
elseif($action == "account" && $loggedin)
{//This 'action' is only available if logged in
	//user want to view their account details
	//Write the controller file code require
	//as well as any new view file(s) or functions needed
	$pagetitle = "My Account";
	include("view/header.php");
	include("view/account.php");
}
elseif($action == "addpost" && $loggedin)
{
	$pagetitle = "Make a New Post";
	$error = "";
	include("view/header.php");
	include("view/new_message_form.php");
}
elseif($action == "Submit Post" && $loggedin)
{
    // Capture the data from the form
    
    $message= trim(filter_input(INPUT_POST, 'message'));
	if(empty($message))
	{
		$error = "<p>Please enter a message</p>";
		include("view/header.php");
		include("view/new_message_form.php");
	}
	else
	{
		addPost($message, $account_id);
		header("Location:twixitter.php");
	}
}
elseif($action == 'edit' && $loggedin)
{
	//User is trying to edit and update a specific comment.
	//This request is sent via the 'GET' method when the user clicks the 'edit' link
	//first capture the 'id' value of the record to be updated
	$id = filter_input(INPUT_GET, 'id');
	
	//Next call the 'getComment' function to get the data for that record
	$post = getPost($id);
	//Assign the values from the database results to individual variables
	
	$message = $post['message'];
	
	if($account_id != $post['account_id'])
		header("Location:twixitter.php");
	//Finally show the 'edit' form populated with the data from the record
	//Note that we use a 'hidden' input element to include the record id in the form
	$error = "";
	$pagetitle = "Edit Post";
	include("view/header.php");
	include("view/edit_form.php");
}
elseif($action == 'Update Post' && $loggedin)
{
	// Capture the data from the form
    
    $message= trim(filter_input(INPUT_POST, 'message'));
	$id = filter_input(INPUT_POST, 'id');
	
	if(empty($message))
	{
		$error = "<p>Please complete all fields</p>";
		include("view/header.php");
		include("view/edit_form.php");
	}
	else
	{
		//Verify that the user has the right to edit the post
		//Start by getting the post by the submitted id
		$post = getPost($id);
		//Only update the post if the account_id's match
		if($account_id == $post['account_id'])
			updatePost($id, $message);
		//Redirect the user back to the default view
		header("Location:twixitter.php");
	}
}
elseif($action == 'delete' && $loggedin)
{
	//User is trying to delete a secific comment.
	//This request is sent via the 'GET' method when the user clicks the 'delete' link
	//first capture the 'id' value of the record to be deleted
	$id = filter_input(INPUT_GET, 'id');
	//Verify that the user has the right to edit the post
	//Start by getting the post by the submitted id
	$post = getPost($id);
	//Only delete the post if the account_id's match
	if($account_id == $post['account_id'])
		deletePost($id);
		//Redirect the user back to the default view
	header("Location:twixitter.php");
}
elseif($action == 'like' && $loggedin)
{
	$post_id = filter_input(INPUT_GET, 'id');
	if ($post_id) {
		likePost($account_id, $post_id);
	}
	header("Location:twixitter.php");
}

elseif($action == 'unlike' && $loggedin)
{
	$post_id = filter_input(INPUT_GET, 'id');
	if ($post_id) {
		unlikePost($account_id, $post_id);
	}
	header("Location:twixitter.php");
}

elseif($action == 'liked' && $loggedin)
{
	$pagetitle = "Liked Posts";
	$posts = getLikedPosts($account_id);
	$postsList = createPostsList($posts, $account_id);
	include("view/header.php");
	include("view/liked_posts.php");
}

else
{ 
	//No data was sent with the request for twixitter.php
	$pagetitle = "Twixitter: A completly original social media site";
	$posts = getPosts();
	$postsList = createPostsList($posts, $account_id);
	include("view/header.php");  //header view file
	include("view/home_view.php");  
}
?>







