<?php 

//save widet options
if ( !$widget_options = get_option( 'dashboard_widget_options' ) )
	$widget_options = array();

if ( !isset($widget_options['nice_dashboard_filtering']) ){
	$widget_options['nice_dashboard_filtering'] = array();	
}

if(!isset($widget_options['nice_dashboard_filtering']['normal'])){
	$widget_options['nice_dashboard_filtering']['normal'] = array();
}

if(!isset($widget_options['nice_dashboard_filtering']['side'])){
	$widget_options['nice_dashboard_filtering']['side'] = array();
}

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['nice_dashboard_filtering'])){
	$widget_options['nice_dashboard_filtering'] = $_POST['nice_dashboard_filtering'];
	update_option( 'dashboard_widget_options', $widget_options );
}


//configuring
global $wp_meta_boxes;
if(count($wp_meta_boxes['dashboard']['normal']['sorted']) > 0){
	?>
		
		<h4>Normal Widgets</h4>
		<ul class="normal-widgets">
			<?php 
				$counter = 0;
				foreach($wp_meta_boxes['dashboard']['normal']['sorted'] as $box){
				?>
					
					<input <?php echo (in_array($box['id'], $widget_options['nice_dashboard_filtering']['normal'])) ? 'checked' : ''; ?> id="normal_widget_<?php echo $counter; ?>" type="checkbox" name="nice_dashboard_filtering[normal][]" value="<?php echo $box['id']; ?>" /> <label for="normal_widget_<?php echo $counter; ?>" ><?php echo $box['title'] ?></label>
					
					<?php 
					$counter ++;
				}
			?>
		</ul>
	
	<?php 
}

if(count($wp_meta_boxes['dashboard']['side']['sorted']) > 0){
	?>
		
		<h4>Side Widgets</h4>
		<ul class="normal-widgets">
			<?php 
				$counter = 0;
				foreach($wp_meta_boxes['dashboard']['side']['sorted'] as $box){
				?>
					
					<input <?php echo (in_array($box['id'], $widget_options['nice_dashboard_filtering']['side'])) ? 'checked' : ''; ?> id="side_widget_<?php echo $counter; ?>" type="checkbox" name="nice_dashboard_filtering[side][]" value="<?php echo $box['id']; ?>" /> <label for="side_widget_<?php echo $counter; ?>" ><?php echo $box['title'] ?></label>
					
					<?php 
					$counter ++;
				}
			?>
		</ul>
	
	<?php 
}