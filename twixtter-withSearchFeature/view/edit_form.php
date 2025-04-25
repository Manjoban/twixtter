			<main>
				<h1>Update Post Form</h1>
				<form action="twixitter.php" method="post">
				<?php echo $error; ?>
					<fieldset>
						<legend>Update Your Message</legend>
						
				
				<textarea maxlength="255" name="message" id="message"><?php echo $message ?></textarea><br>
				<input type = "hidden" name="id" value = "<?php echo $id ?>">
				<input type="submit" name = "action" value="Update Post" >
				</fieldset>
			
		</main>
	</body>
	</html>