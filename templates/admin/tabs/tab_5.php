<?php 
	
	if($_POST['progressbar_submission'] == 'Y'){
		if(isset($_POST['status_checkbox'])){
			update_option('nice_dashbaord_progress', $_POST['status_checkbox']);
		}
		
		echo '<div class="updated"><p>Saved</p></div>';
	}
	
	if(!$status_checkboxes = get_option('nice_dashbaord_progress')){
		$status_checkboxes = array();
	}
	
?>


<style>
	.progress_bar {
	    height:20px;
	    background-color: blue;
	    width: 0;
	}
	
	.progress {
	    margin-top: 10px;
	    width: 700px;
	    border:solid 1px black;
	}
	
	dt{
		font-size: 15xp;
	}
	dd{
		font-size: 13px;		
	}
	
</style>

<div class="progress">
    <div class="progress_bar"></div>
</div>

<form action="" method="post">

	<input type="hidden" name="progressbar_submission" value="Y" />
	
	<table class="form-table">
		
		<thead>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Remark ( finished? )</th>
			</tr>
		</thead>
		
		<tr>
			<td>Vimeo Video</td>
			<td>Embedded Code to show welcome video in a dashboard widget</td>
			<td> <input <?php echo in_array('1', $status_checkboxes) ? 'checked' : ''; ?> type="checkbox" name="status_checkbox[]" value="1" /> </td>
		</tr>
		
		<tr>
			<td>Hide Menus/Submenus</td>
			<td>Hide selected menus and submneus from dashboard for users with <span style="color: red">enable_nice_dashboard</span> capability</td>
			<td> <input <?php echo in_array('2', $status_checkboxes) ? 'checked' : ''; ?> type="checkbox" name="status_checkbox[]" value="2" /> </td>
		</tr>
		
		<tr>
			<td>Append .htaccess and robot.txt</td>
			<td>Admin can append some texts to the .htaccess and robot.txt. ( directory: <span style="color: red"><?php echo ABSPATH; ?></span> )</td>
			<td> <input <?php echo in_array('3', $status_checkboxes) ? 'checked' : ''; ?> type="checkbox" name="status_checkbox[]" value="3" /> </td>
		</tr>
		
		<tr>
			<td>Hide Dashboard Widgets</td>
			<td>Hide selected dashbaord widgets for users with <span style="color: red">enable_nice_dashboard</span> capability.</td>
			<td> <input <?php echo in_array('4', $status_checkboxes) ? 'checked' : ''; ?> type="checkbox" name="status_checkbox[]" value="4" /> </td>
		</tr>
		
		<tr>
			<td>Progress Bar</td>
			<td>Progress bar is to help site owner to know the progress of the site's settings</td>
			<td> <input <?php echo in_array('5', $status_checkboxes) ? 'checked' : ''; ?> type="checkbox" name="status_checkbox[]" value="5" /> </td>
		</tr>
		
	</table>
	
	<input type="submit" value="Save Progress" class="button button-primary" />
	
</form>

<script type="text/javascript">

	jQuery(function() {
	    var checkbox = jQuery(":checkbox"),
	    checkbox_length = checkbox.length;

	    //custom code to fire on load
	    var checked_length = jQuery(":checkbox:checked").length;
	    progress = checked_length / checkbox_length * 100;
	    jQuery('.progress_bar').css('width', progress + '%');
		//end custom code
	    
	    checkbox.change(function () {
	        var that = jQuery(this),
	            progress = 0,
	            checked_length = 0;
	        
	        if(that.is(':last-child')) {
	              that.siblings().attr('checked', true);
	        }
	        
	        checked_length = jQuery(":checkbox:checked").length;
	        progress = checked_length / checkbox_length * 100;
	        
	     //   jQuery('.progress_bar').css('width', progress + '%');
	        
	        // just incase you wanted it to be a little bit fancy :P
	        jQuery('.progress_bar').animate({'width' : progress + '%'}, 400); 
	    });
	}); 

</script>