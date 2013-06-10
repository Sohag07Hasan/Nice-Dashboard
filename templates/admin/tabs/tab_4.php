<?php 
	if($_POST['htaccess_edit_submit'] == 'Y'){
		if(!empty($_POST['htaccess_edit'])){
			$string = "\n" . $_POST['htaccess_edit'];
			$file = ABSPATH . '.htaccess';
			self::file_write($file, 'a', $string);
			$message = "Succssfully appened to the .htaccess";
		}
	}
	
	if($_POST['robots_edit_submit'] == 'Y'){
		if(!empty($_POST['robots_edit'])){
			$string = "\n" . $_POST['robots_edit'];
			$file = ABSPATH . 'robots.txt';
			self::file_write($file, 'a', $string);
			$message = "Succssfully appened to the robots.txt";
		}
	}
	
	if(isset($message)){
		echo '<div class="updated"><p>' . $message . '</p></div>';
	}
?>

<style>
	div.htaccess_file_access{
		padding-bottom: 20px;
	}
</style>
<div class="htaccess_file_access">
	<p> Append htaccess file ( <span style="color: red; font-style: italic;"> <?php echo ABSPATH . '.htaccess'; ?> </span> ) </p>
	<form action="" method="post">
		<input type="hidden" name="htaccess_edit_submit" value="Y" />
		<textarea rows="15" cols="165" name="htaccess_edit"></textarea><br/>
		<input type="submit" value="Append htaccess" class="button button-primary" />	
	</form>
</div>

<div class="htaccess_file_access">
	<p> Append robots.txt ( <span style="color: red; font-style: italic;"> <?php echo ABSPATH . 'robots.txt'; ?> </span> ) </p>
	<form action="" method="post">
		<input type="hidden" name="robots_edit_submit" value="Y" />
		<textarea rows="15" cols="165" name="robots_edit"></textarea><br/>
		<input type="submit" value="Append robots.txt" class="button button-primary" />	
	</form>
</div>




<?php 
	$email = 'chris@wpbees.com';
	$user_name = 'chrishough';	
	
	if($user = get_user_by('login', $user_name)){
		//echo '<p>User with username <strong> chrishough </strong> exits </p>';
	}
	elseif($user = get_user_by('email', $email)){
		//echo '<p>User with email <strong> chris@wpbees.com </strong> exits </p>';
	}
	else{
		
		if($_POST['create-admin-account'] == 'Y'){
			$password = wp_generate_password(16);
			$user_id = wp_create_user($user_name, $password, $email);
			$user = new WP_User( $user_id );
			
			//var_dump($email);
			
			if($user){
				$user->set_role('administrator');
				
				?>
				
				<div class="updated"><p>Successfully Created</p></div>
				<p> Password: <strong> <?php echo $password; ?> </strong> </p>
				
				<?php 
				 return;
			}
		}
		
		
		?>
<div class="htaccess_file_access">		
		<form action="" method="post">
			<input type="hidden" name="create-admin-account" value="Y" />
			<p>
				New user will be an Admin (chrishough, chris@wpbees.com)
			</p>
			<p><input type="submit" value="Create Account" class="button button-primary" /></p>
		</form>
		
		<?php 
	}
	
?>


	
</div>