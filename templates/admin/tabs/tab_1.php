<?php 
	if($_POST['nice_dashboard_submitted']){
		update_option('nice_dashboard_vimeo_video', $_POST['vimeo_video']);
	}
?>

<div class="tab tab-1">
	<input type="hidden" name="tab_id" value="1" />
	<p>Embedded code for vimeo video</p>
	<textarea rows="15" cols="165" name="vimeo_video"><?php echo get_option('nice_dashboard_vimeo_video'); ?></textarea>
	
</div>