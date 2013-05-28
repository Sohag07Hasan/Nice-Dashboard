<?php 
if ( !$widget_options = get_option( 'dashboard_widget_options' ) )
	$widget_options = array();

if ( !isset($widget_options['nice_dashboard_filtering']) ){
	?>
	<strong>Not configured! <a href="<?php echo admin_url('index.php?edit=nice_dashboard_filtering#nice_dashboard_filtering'); ?>" >configure</a></strong>
	<?php
	return; 
}

if(!isset($widget_options['nice_dashboard_filtering']['normal'])){
	$widget_options['nice_dashboard_filtering']['normal'] = array();
}

if(!isset($widget_options['nice_dashboard_filtering']['side'])){
	$widget_options['nice_dashboard_filtering']['side'] = array();
}

global $wp_meta_boxes;

//var_dump($wp_meta_boxes);

if(count($wp_meta_boxes['dashboard']['normal']['sorted']) > 0){
	$widgets = array();
	
	foreach($wp_meta_boxes['dashboard']['normal']['sorted'] as $w){
		if(in_array($w['id'], $widget_options['nice_dashboard_filtering']['normal'])){
			$widgets[] = $w['title'];
		}
	}	
	
	echo "<div style='padding: 10px;'>";
	echo "<h4 style='font-size: 15px;'>Normal Widgets</h4>";
	echo implode(', ', $widgets);
	echo "</div>";
	
}

if(count($wp_meta_boxes['dashboard']['side']['sorted']) > 0){
	$widgets = array();
	
	foreach($wp_meta_boxes['dashboard']['side']['sorted'] as $w){
		if(in_array($w['id'], $widget_options['nice_dashboard_filtering']['side'])){
			$widgets[] = $w['title'];
		}
	}	
	
	echo "<div style='padding: 10px;'>";
	echo "<h4 style='font-size: 15px;'>Side Widgets</h4>";
	echo implode(', ', $widgets);
	echo "</div>";
	
}