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
		<input id="top_levl_menu_<?php echo $key; ?>" type="checkbox" name="toplevel_menus[]" value="<?php echo $cat['slug']; ?>" /> <label for="top_levl_menu_<?php echo $key; ?>" ><?php echo $cat['name']; ?></label>
		<?php 
		if(count($cat['submenus']) > 0){
			?>
			<ul class="submenus">
				<?php 
					foreach($cat['submenus'] as $k => $s){
						if(empty($s['name'])) continue;
						$value = array(
							'parent_slug' => $cat['slug'],
							'slug' => $s['slug']
						);
						?>
						<li>
						<input type="checkbox" name="submenus[]" value="<?php echo serialize($value); ?>" id="sub_menu_<?php echo $key . '_' . $k; ?>" > <label for="sub_menu_<?php echo $key . '_' . $k; ?>"><?php echo $s['name']; ?></label>
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