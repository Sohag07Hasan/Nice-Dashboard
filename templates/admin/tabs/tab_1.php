<?php 
	if($_POST['nice_dashboard_submitted']){
		update_option('nice_dashboard_vimeo_video', stripslashes($_POST['vimeo_video']));
	}
?>

<!-- Form for the whole thing  -->
<form action="" method="post">
	<input type="hidden" name="nice_dashboard_submitted" value="Y" />

	<div class="tab tab-1">
		<input type="hidden" name="tab_id" value="1" />
		<p>Embedded code for vimeo video</p>
		<textarea rows="15" cols="165" name="vimeo_video"><?php echo stripslashes(get_option('nice_dashboard_vimeo_video')); ?></textarea>
		
	</div>
	
	<input type="submit" value="Save" class="button button-primary" />
</form>