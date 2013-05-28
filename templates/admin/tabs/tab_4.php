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