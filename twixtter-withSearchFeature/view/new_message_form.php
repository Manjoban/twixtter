			<main>
				<h1>Make a New Post</h1>
				<form action="twixitter.php" method="post">
				<?php echo $error; ?>
					<fieldset>
						<legend>Enter Your Message</legend>
						
				
				<textarea maxlength="255" name="message" id="message">
				</textarea><br>
			
				<input type="submit" name = "action" value="Submit Post" >
				</fieldset>
			</form>
			
		</main>
	</body>
	</html>