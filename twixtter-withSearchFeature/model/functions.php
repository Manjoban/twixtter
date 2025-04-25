<?php
	//Connection information for finding and connecting to the MySQL server
	$dsn = 'mysql:host=localhost;dbname=newapp';
	$dbuser = 'root';
	$dbpass = '';

	$db = new PDO($dsn, $dbuser, $dbpass);
		
	function notEmptyAccount($username, $password, $email, $fname, $lname)
	{
		//Not every function deals with DB connections
		//This function checks for empty variables and is used for form validation
		//returns true if non of the variables (parameters) are empty or returns false if one or more of them are empty
		if(empty($username) OR empty($password) OR empty($email) OR empty($fname) OR empty($lname))
			return false;
		
		return true;
	}
	
	function addAccount($username, $password, $email, $fname, $lname)
	{
		//Inserts a new account in the accounts table
		global $db; //Make $db accessible inside the function block
		
		$query = 'INSERT INTO accounts (username, password, email, fname, lname)
				  VALUES (:username, :password, :email, :fname, :lname )';
		$statement = $db->prepare($query);
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $password);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':fname', $fname);
		$statement->bindValue(':lname', $lname);
		$statement->execute();
		$statement->closeCursor();	
	}
	function getAccount($id)
	{
		//Finds and returns a single account based on the 'id' column 
		global $db;
		$query = 'SELECT * FROM accounts WHERE id = :id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$account = $statement->fetch();
		$statement->closeCursor();	
		//return the account - $account is a 1-dimensional associative array
		return $account;
	}
	function checkUsername($username)
	{
		//Checks if a username submitted for registration is available
		//Usernames must be unique
		//Function returns true if the username is available and false if it is not
		global $db;
		$queryUser = 'SELECT id FROM accounts
					  WHERE username = :username' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':username', $username);
		
		$statement1->execute();
		$userAccount = $statement1->fetch();
		$statement1->closeCursor();
		if($userAccount == NULL)
			return true;
		else
			return false;
		
	}
	function processLogin($username, $password)
	{
		//This function receives the username and password entered by the user in the Login form
		//It queries the accounts table using the username to see if a match was found
		//Since the username field is set as unique in the DB, only a single record will match
		//Or no records will match if the username does not exist in the table
		//If a record is found, then the supplied password will be compared to the password stored in the database and returned with the query results
		//The function will return the matching account if the login is correct
		//It will return NULL if the login was incorrect
		global $db;
		$queryUser = 'SELECT * FROM accounts
					  WHERE username = :username' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':username', $username);
			
		$statement1->execute();
		$userAccount = $statement1->fetch();
		$statement1->closeCursor();
		//At this point, $userAccount either contains the matching record 
		//or is NULL if no match was found
		if($userAccount != NULL)
		{
			//username was found in the DB, now verify the password
			if($password == $userAccount['password'])
				return $userAccount; //Login successful
			else
				return NULL; //incorrect pass	
		}
		else
			return NULL; //incorrect username
	}
function addPost($message, $account_id) 
{
 
	//This function inserts a new record in the table
	  global $db; //Make $db accessible inside the function block 
	 
	//The SQL - this is to add a new record in the table 
	//Note the 'placeholders' :col_one, :col_two, :col_three
	$query = 'INSERT INTO posts(account_id, message) VALUES (:account_id, :message)'; 
	//Call the prepare method from the $db object  
	//to setup a prepared (secure) interaction with the database 
	$statement = $db->prepare($query);  
	//'bind' each variable to the placeholders specified in the SQL query  
	$statement->bindValue(':account_id', $account_id); 
	$statement->bindValue(':message', $message); 
	//Execute the SQL command 
	$statement->execute();  

	//Our interaction with the DB is done, close the connection to the server  
	$statement->closeCursor();  
	//There is nothing to return from this function
}
function getPosts()
{
	global $db; 
	 
	//Setup the SQL statement - no placeholders needed
	//We need a JOIN statement to get the username from the accounts table
	$query = 'SELECT p.*, a.username FROM posts p 
				JOIN accounts a 
				ON p.account_id = a.id
				ORDER by p.posted_date DESC';
	$statement = $db->prepare($query);
	$statement->execute();

	//We use the fetchAll() function because we expect
	//that there could be multiple results
	//After this statement, $records contains all the data for the found records
	// stored as a 2-dimensional associative array

	$posts = $statement->fetchAll();
	$statement->closeCursor();

	//return the $records found
	return $posts;
}

function getPost($id)
{
	//This function finds a single record based on the id (primary key) 
	global $db; //Make the $db visible within the function
	//Since we are using a variable $id as part of the SQL statement 
	//we need to use a placeholder  ':id' 
	$query = 'SELECT * FROM posts WHERE id = :id';  
	$statement = $db->prepare($query);  
	//'bind' the variable to the placeholder 
	$statement->bindValue(':id', $id); 
	$statement->execute();  
	//This query will find at most 1 matching record,  
	//so we use the fetch() function here instead of fetchAll()
	$post = $statement->fetch(); 
	$statement->closeCursor();   
	//return the record- $comment is a 1-dimensional associative array 
	return $post;
	
}
function updatePost($id, $message)
{
	global $db; //Make $db accessible inside the function block  
	//The SQL - this is to update an existing entry in the table 
	//Note the 'placeholders' :col_one, :col_two, :col_three, :id 
	$query = 'UPDATE posts SET  message= :message WHERE id = :id';    
	//Call the prepare method from the $db object  
	//to setup a prepared (secure) interaction with the database 
	$statement = $db->prepare($query);  
	//'bind' each variable to the placeholders specified in the SQL query 
	$statement->bindValue(':message', $message);  
	$statement->bindValue(':id', $id); 
	//Execute the SQL command 
	$statement->execute();  
	//Our interaction with the DB is done, close the connection to the server  
	$statement->closeCursor();  
	//There is nothing to return from this function 
}
function deletePost($id)
{
	//This function deletes an single record from the table based on the id 
	global $db; 
	//setup the query - id comes from the client, so use a placeholder, :id 
	$query = 'DELETE FROM posts WHERE id = :id'; 
	$statement = $db->prepare($query);  
	$statement->bindValue(':id', $id); 
	$statement->execute();  
	$statement->closeCursor();   
	//There is nothing to return from this function
}
function createPostsList($posts, $account_id)
{
	if($posts != NULL){
		$postsList = "";
		foreach($posts as $row){
			
			$message = $row['message'];
			$id = $row['id'];
			$username = $row['username'];
			$posted_date = $row['posted_date'];
			$post_account_id = $row['account_id'];
			$postsList .= "<p>$message</p><p><b>Posted by</b> $username on $posted_date</p>";
			//Check if the current user created this post
			//If yes, include the 'edit' and 'delete' links
			if($account_id == $post_account_id)
				$postsList .="<p> <a href = 'twixitter.php?action=edit&id=$id'>edit</a> | <a href = 'twixitter.php?action=delete&id=$id'>delete</a></p>";
			
			$postsList .="<hr>";
		}	
	}
	else
		$postsList = "<h2> No one has posted anything!</h2>";
	return $postsList;
		
}
function searchPosts($search) {
    global $db;
    $search = "%$search%";
    $query = 'SELECT p.*, a.username FROM posts p
              JOIN accounts a ON p.account_id = a.id
              WHERE p.message LIKE :search
              ORDER BY p.posted_date DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(':search', $search);
    $statement->execute();
    return $statement->fetchAll();
}

function searchUsers($search) {
    global $db;
    $search = "%$search%";
    $query = 'SELECT * FROM accounts WHERE username LIKE :search';
    $statement = $db->prepare($query);
    $statement->bindValue(':search', $search);
    $statement->execute();
    return $statement->fetchAll();
}



function saveSearchHistory($account_id, $term, $type) {
    global $db;
    $query = 'INSERT INTO search_history (account_id, search_term, search_type) VALUES (:account_id, :term, :type)';
    $statement = $db->prepare($query);
    $statement->bindValue(':account_id', $account_id);
    $statement->bindValue(':term', $term);
    $statement->bindValue(':type', $type);
    $statement->execute();
    $statement->closeCursor();
}

function getSearchHistory($account_id) {
    global $db;
    $query = 'SELECT * FROM search_history WHERE account_id = :account_id ORDER BY searched_at DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(':account_id', $account_id);
    $statement->execute();
    return $statement->fetchAll();
}
function showResults($pagetitle, $results, $posts, $users) {
    $output = "";

    if (empty($results) && empty($posts) && empty($users)) {
        $output .= "<p>No results found.</p>";
    } elseif ($pagetitle === "Search Post Results") {
        foreach ($results as $post) {
            $output .= "<div><p>" . htmlspecialchars($post['message']) . "</p>";
            $output .= "<p><b>Posted by:</b> " . htmlspecialchars($post['username']) . " on " . $post['posted_date'] . "</p><hr></div>";
        }
    } elseif ($pagetitle === "Search User Results") {
        foreach ($results as $user) {
            $output .= "<div><p><b>Username:</b> " . htmlspecialchars($user['username']) . "</p>";
            $output .= "<p>Name: " . htmlspecialchars($user['fname'] . ' ' . $user['lname']) . "</p>";
            $output .= "<p>Email: " . htmlspecialchars($user['email']) . "</p><hr></div>";
        }
    } elseif ($pagetitle === "Search Results") {
        $output .= "<h2>Posts</h2>";
        foreach ($posts as $post) {
            $output .= "<div><p>" . htmlspecialchars($post['message']) . "</p>";
            $output .= "<p><b>Posted by:</b> " . htmlspecialchars($post['username']) . " on " . $post['posted_date'] . "</p><hr></div>";
        }

        $output .= "<h2>Users</h2>";
        foreach ($users as $user) {
            $output .= "<div><p><b>Username:</b> " . htmlspecialchars($user['username']) . "</p>";
            $output .= "<p>Name: " . htmlspecialchars($user['fname'] . ' ' . $user['lname']) . "</p>";
            $output .= "<p>Email: " . htmlspecialchars($user['email']) . "</p><hr></div>";
        }
    }

    echo $output;
}

?>