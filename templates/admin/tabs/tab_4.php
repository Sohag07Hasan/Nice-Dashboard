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