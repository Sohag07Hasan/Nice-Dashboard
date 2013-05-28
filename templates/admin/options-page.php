<?php 
	$page_url = admin_url('options-general.php?page=wpnicerdashboard');
	$class = $_GET['tab'];
	
	$tabs = array(
		
		1 => array(
			'class' => 'nav-tab',
			'name' => 'Vimeo Video'
		),
		
		2 => array(
			'class' => 'nav-tab',
			'name' => 'Menus/Submenus'
		),
		
		3 => array(
			'class' => 'nav-tab',
			'name' => 'Dashboard'
		),
		
		4 => array(
			'class' => 'nav-tab',
			'name' => 'Htaccess/Robots/Admin Creator'
		),
		
		5 => array(
			'class' => 'nav-tab',
			'name' => 'Progress bar'
		),
		
	);
	
?>

<div class="wrap">
	<?php screen_icon(); ?>
	<h2 class="nav-tab-wrapper">
		
		<?php 
		
			foreach($tabs as $key => $tab){
				if(isset($_GET['tab'])){
					$class = $_GET['tab'] == $key ? $tab['class'] . ' nav-tab-active' : $tab['class'];
				}
				else{
					if($key == 1){
						$class = $tab['class'] . ' nav-tab-active';
					}
					else{
						$class = $tab['class'];
					}
				}		
			
				?>
				<a href="<?php echo self::get_tab_url($key); ?>" class="<?php echo $class; ?>"><?php echo $tab['name']; ?></a>
				<?php 				
			}
			
		?>
			
	</h2>
	
	<?php 
		if($_POST['nice_dashboard_submitted'] == 'Y'){
			echo '<div class="updated"><p>saved</p></div>';
		}
	?>
	
	
	<?php include self::get_appropriate_tab(); ?>
	

</div>