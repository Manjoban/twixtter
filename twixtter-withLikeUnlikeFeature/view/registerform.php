<main>
        <h1>Registration Form</h1>
		<form action="twixitter.php" method="post">

			<p><?php echo $error ?></p>
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo $username ?>"><br>

                <label>Password:</label>
                <input type="text" name="password"><br>
				
				<label>Email:</label>
                <input type="text" name="email" value="<?php echo $email ?>"><br>
				
				<label>First Name:</label>
                <input type="text" name="fname" value="<?php echo $fname ?>"><br>
				
				<label>Last Name:</label>
                <input type="text" name="lname" value="<?php echo $lname ?>"><br>
				          
                <input type="submit" name = "action" value="Submit Registration"><br>
            

        </form>
		
    </main>
	</body>
	</html>