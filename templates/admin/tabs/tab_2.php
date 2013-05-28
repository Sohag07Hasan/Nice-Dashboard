<style>
	ul.toplevel_menus{
		padding: 20px;
		font-size: 15px;
	}
	ul.submenus{
		margin-left: 30px;
		font-size: 13px;
		padding: 2px;
	}
</style>

<?php 

if($_POST['nice_dashboard_submitted'] == 'Y'){
	$menus_submenus = array();
	
	if(isset($_POST['toplevel_menus'])){
		$menus_submenus['toplevel_menus'] = $_POST['toplevel_menus'];
	}
	else{
		$menus_submenus['toplevel_menus'] = array();
	}
	
	if(isset($_POST['submenus'])){
		$menus_submenus['submenus'] = $_POST['submenus'];
	}
	else{
		$menus_submenus['submenus'] = array();
	}
	
	update_option('nice_dashboard_menus_submenus', $menus_submenus);
	
}

if(!$menus_submenus = get_option('nice_dashboard_menus_submenus')){
	$menus_submenus = array();
	$menus_submenus['submenus'] = array();
	$menus_submenus['toplevel_menus'] = array();
}

//var_dump($menus_submenus['submenus']);


global $menu, $submenu;

$categoried = array();

foreach($menu as $key => $m){

	$associated_submenus = array();
	if(isset($submenu[$m[2]])){
		foreach($submenu[$m[2]] as $s){
			$associated_submenus[] = array(
				'name' => preg_replace('/[^a-z A-Z]/', '', strip_tags($s[0])),
				'slug' => $s[2]
			);
		}
	}
	
	$categoried[] = array(
		'name' => preg_replace('/[^a-z A-Z]/', '', strip_tags($m[0])),
		'slug' => $m[2],
		'submenus' => $associated_submenus
	);
		
}

//var_dump($categoried);

if($categoried){
	echo '<ul class="toplevel_menus">';
	foreach($categoried as $key => $cat){
		if(empty($cat['name'])) continue;
		?>
		<li>
		<input <?php echo in_array($cat['slug'], $menus_submenus['toplevel_menus']) ? 'checked' : ''; ?> id="top_levl_menu_<?php echo $key; ?>" type="checkbox" name="toplevel_menus[]" value="<?php echo $cat['slug']; ?>" /> <label for="top_levl_menu_<?php echo $key; ?>" ><?php echo $cat['name']; ?></label>
		<?php 
		if(count($cat['submenus']) > 0){
			?>
			<ul class="submenus">
				<?php 
					foreach($cat['submenus'] as $k => $s){
						if(empty($s['name'])) continue;
						$value = array($cat['slug'], $s['slug']);
						?>
						<li>
						<input <?php echo in_array(implode(', ', $value), $menus_submenus['submenus']) ? 'checked' : ''; ?> type="checkbox" name="submenus[]" value="<?php echo implode(', ', $value); ?>" id="sub_menu_<?php echo $key . '_' . $k; ?>" > <label for="sub_menu_<?php echo $key . '_' . $k; ?>"><?php echo $s['name']; ?></label>
						</li>
						<?php 						
					}
				?>
			</ul>
			<?php 
		}
		
		echo '</li>';
	}
	echo '</ul>';
}