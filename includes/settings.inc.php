<?
function set_plugin_meta($links, $file) {
	// add a settings link to plugin overview
	$plugin = "peers-me";
	return array_merge(
		$links,
		array( sprintf( '<a href="options-general.php?page=%s">%s</a>', $plugin, __('Settings') ) )
	);
	return $links;
}

function peers_me_menu() {
	add_options_page('Peers.me Options', 'Peers.me', 'manage_options', 'peers-me', 'peers_me_options');
}

function peers_me_options() {
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to acces this page.'));
	}
	
	// variables for the field and option names
	$opt_name_username = 'peers_me_username';
	$data_field_name_username = 'peers_me_username';
	$opt_name_password = 'peers_me_password';
	$data_field_name_password = 'peers_me_password';

	$opt_name_userspath = 'peers_me_userspath';
	$data_field_name_userspath = 'peers_me_userspath';
	$opt_name_groupspath = 'peers_me_groupspath';
	$data_field_name_groupspath = 'peers_me_groupspath';
	$opt_name_publicationspath = 'peers_me_publicationspath';
	$data_field_name_publicationspath = 'peers_me_publicationspath';

	$opt_name_group_template = 'peers_me_group_template';
	$data_field_name_group_template = 'peers_me_group_template';
	$opt_name_user_template = 'peers_me_user_template';
	$data_field_name_user_template = 'peers_me_user_template';
	$opt_name_publication_template = 'peers_me_publication_template';
	$data_field_name_publication_template = 'peers_me_publication_template';
	
	$opt_name_stylesheet = 'peers_me_stylesheet';
	$data_field_name_stylesheet = 'peers_me_stylesheet';

	$hidden_field_name = 'peers_me_submit_hidden';
	
	// Read in existing option value from database
	$opt_val_address = get_option ( $opt_name_address );
	$opt_val_username = get_option ( $opt_name_username );
	$opt_val_password = get_option ( $opt_name_password );
	$opt_val_userspath = get_option ( $opt_name_userspath );
	$opt_val_groupspath = get_option ( $opt_name_groupspath );
	$opt_val_publicationspath = get_option ( $opt_name_publicationspath );
	$opt_val_group_template = get_option ( $opt_name_group_template );
	$opt_val_user_template = get_option ( $opt_name_user_template );
	$opt_val_publication_template = get_option ( $opt_name_publication_template );
	$opt_val_stylesheet = get_option ( $opt_name_stylesheet );
	
	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
		// Read their posted value
		$opt_val_address = $_POST[ $data_field_name_address ];
		$opt_val_username = $_POST[ $data_field_name_username ];
		$opt_val_password = $_POST[ $data_field_name_password ];
		$opt_val_userspath = $_POST[ $data_field_name_userspath ];
		$opt_val_groupspath = $_POST[ $data_field_name_groupspath ];
		$opt_val_publicationspath = $_POST[ $data_field_name_publicationspath ];
		$opt_val_group_template = $_POST[ $data_field_name_group_template ];
		$opt_val_user_template = $_POST[ $data_field_name_user_template ];
		$opt_val_publication_template = $_POST[ $data_field_name_publication_template ];
		$opt_val_stylesheet = $_POST[ $data_field_name_stylesheet ];
		
		
		// Save the posted value in the database
		update_option( $opt_name_address, $opt_val_address );
		update_option( $opt_name_username, $opt_val_username );
		update_option( $opt_name_password, $opt_val_password );
		update_option( $opt_name_userspath, $opt_val_userspath );
		update_option( $opt_name_groupspath, $opt_val_groupspath );
		update_option( $opt_name_publicationspath, $opt_val_publicationspath );
		update_option( $opt_name_group_template, $opt_val_group_template );
		update_option( $opt_name_user_template, $opt_val_user_template );
		update_option( $opt_name_publication_template, $opt_val_publication_template );
		update_option( $opt_name_stylesheet, $opt_val_stylesheet );
		
		// Put an settings updated message on the screen
?>
<div class="updated"><p><strong><? _e('settings saved.', 'peers-me')?></strong></p></div>
<?
	}
	
	// Now display the settings editing screen
	
	echo '<div class="wrap">';
	echo '	<h2>Peers.me</h2>';
	echo '	<p>Welcome at the Peers.me options page</p>';

	// Path for templates
	
	$includes_dir =  WP_PLUGIN_DIR."/peersme/includes/";

	// Settings form
?>
<form name="peers-me" method="post" action="">
	<input type="hidden" name="<? echo $hidden_field_name; ?>" value="Y">
	<!-- <p>
		<label width="800px">Peers.me address</label>
		<input type="text" name="<? echo $data_field_name_address; ?>" value="<? echo $opt_val_address; ?>" size="40">
	</p> -->
	<p>
		<label>Peers.me API username</label>
		<input type="text" name="<? echo $data_field_name_username; ?>" value="<? echo $opt_val_username; ?>" size="40">
		.peers.me
	</p>
	<p>
		<label>Peers.me API password</label>
		<input type="text" name="<? echo $data_field_name_password; ?>" value="<? echo $opt_val_password; ?>" size="40">
	</p>
	
	
	<p>
		<label>Path for users</label>
		<input type="text" name="<? echo $data_field_name_userspath; ?>" value="<? echo $opt_val_userspath; ?>" size="40">
	</p>
	<p>
		<label>Path for groups</label>
		<input type="text" name="<? echo $data_field_name_groupspath; ?>" value="<? echo $opt_val_groupspath; ?>" size="40">
	</p>
	<p>
		<label>Path for publications</label>
		<input type="text" name="<? echo $data_field_name_publicationspath; ?>" value="<? echo $opt_val_publicationspath; ?>" size="40">
	</p>
	
	<p>
		<label>Template for users</label>
		<select name="<? echo $data_field_name_user_template; ?>" id="<? echo $data_field_name_user_template; ?>" size="1">
<?

// check template directory: user
if ($handle = opendir($includes_dir.'templates/user')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
						if($file == $opt_val_user_template) $selected = " selected";
            echo "<option value=\"$file\"$selected>$file</option>\n";
						$selected = "";
        }
    }
    closedir($handle);
}

?>
		</select>
	</p>
	<p>
		<label>Template for groups</label>
		<select name="<? echo $data_field_name_group_template; ?>" id="<? echo $data_field_name_group_template; ?>" size="1">
<?

// check template directory: group
if ($handle = opendir($includes_dir.'templates/group')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
					if($file == $opt_val_group_template) $selected = " selected";
          echo "<option value=\"$file\"$selected>$file</option>\n";
					$selected = "";
        }
    }
    closedir($handle);
}

?>
		</select>
	</p>
	<p>
		<label>Template for publications</label>
		<select name="<? echo $data_field_name_publication_template; ?>" id="<? echo $data_field_name_publication_template; ?>" size="1">
<?

// check template directory: publication
if ($handle = opendir($includes_dir.'templates/publication')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
					if($file == $opt_val_publication_template) $selected = " selected";
          echo "<option value=\"$file\"$selected>$file</option>\n";
					$selected = "";
        }
    }
    closedir($handle);
}

?>
		</select>
	</p>

		<p>
			<label>Stylesheet for plugin</label>
			<select name="<? echo $data_field_name_stylesheet; ?>" id="<? echo $data_field_name_stylesheet; ?>" size="1">
	<?

// check stylesheet directory
if ($handle = opendir($includes_dir.'stylesheets')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
					if($file == $opt_val_stylesheet) $selected = " selected";
           echo "<option value=\"$file\"$selected>$file</option>\n";
					$selected = "";
        }
    }
    closedir($handle);
}

	?>
			</select>
		</p>

	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<? esc_attr_e('Save Changes'); ?>" />
	</p>
	
</form>
<?

	//Close wrap div
	echo '</div>';
}

?>