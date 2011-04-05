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
	

	// Path for templates
	
	$includes_dir =  WP_PLUGIN_DIR."/peersme/includes/";

	// Settings form
?>
	<h2>Peers.me</h2>
<div class="rm_wrap">
	<p>Welcome at the Peers.me options page. <br>
		With this plugin, public profiles and publications can be shown on your WordPress website. If you would like to know more about Peers.me, scroll down for a short video. If you already got an API key, please provide this information down here.</p>

	<div class="rm_opts">
		<form name="peers-me" method="post" action="">
			<input type="hidden" name="<? echo $hidden_field_name; ?>" value="Y">

			<div class="rm_section_peers">  
			<div class="rm_title"><h3>Your <a href="http://www.peers.me">Peers.me</a> API credentials</h3><div class="clearfix"></div></div>
			
				<div class="rm_input rm_text"> 
					<label>Peers.me API username</label>
					<input type="text" name="<? echo $data_field_name_username; ?>" value="<? echo $opt_val_username; ?>" size="40">
					.peers.me
				</div>

				<div class="rm_input rm_text"> 
					<label>Peers.me API password</label>
					<input type="text" name="<? echo $data_field_name_password; ?>" value="<? echo $opt_val_password; ?>" size="40">
				</div>

<?

	// check if the credentials are aviablable
	//check if peers.me credentials are available
	$peers_me_username = get_option ( 'peers_me_username' );
	$peers_me_password = get_option ( 'peers_me_password' );
	if(empty($peers_me_username)||empty($peers_me_password)){
?>
		<input type="hidden" name="<? echo $data_field_name_userspath; ?>" value="<? echo $opt_val_userspath; ?>">
		<input type="hidden" name="<? echo $data_field_name_groupspath; ?>" value="<? echo $opt_val_groupspath; ?>">
		<input type="hidden" name="<? echo $data_field_name_publicationspath; ?>" value="<? echo $opt_val_publicationspath; ?>">
		<input type="hidden" name="<? echo $data_field_name_user_template; ?>" value="<? echo $opt_val_user_template; ?>">
		<input type="hidden" name="<? echo $data_field_name_group_template; ?>" value="<? echo $opt_val_group_template; ?>">
		<input type="hidden" name="<? echo $data_field_name_publication_template; ?>" value="<? echo $opt_val_publication_template; ?>">
		<input type="hidden" name="<? echo $data_field_name_stylesheet; ?>" value="<? echo $opt_val_stylesheet; ?>">
<?

	} else {

?>

			<div class="rm_title"><h3>Paths</h3><div class="clearfix"></div></div>

				<div class="rm_comment">To show users, groups and publications; create pages with the shortcode [peersme]. Please enter the paths of these pages here.</div>

				<div class="rm_input rm_text">
					<label>Path for users</label>
					<input type="text" name="<? echo $data_field_name_userspath; ?>" value="<? echo $opt_val_userspath; ?>" size="40">
					<small>don't start with /</small>
				</div>

				<div class="rm_input rm_text">
					<label>Path for groups</label>
					<input type="text" name="<? echo $data_field_name_groupspath; ?>" value="<? echo $opt_val_groupspath; ?>" size="40">
					<small>don't start with /</small>
				</div>

				<div class="rm_input rm_text">
					<label>Path for publications</label>
					<input type="text" name="<? echo $data_field_name_publicationspath; ?>" value="<? echo $opt_val_publicationspath; ?>" size="40">
					<small>don't start with /</small>
				</div>

			<div class="rm_title"><h3>Templates</h3><div class="clearfix"></div></div>

				<div class="rm_comment">You can create your own templates by duplicating and editing the files in the templates folder of the plugin.</div>

				<div class="rm_input rm_text">
					<label>Template for users</label>
					<select name="<? echo $data_field_name_user_template; ?>" id="<? echo $data_field_name_user_template; ?>" size="1">
<?

// check template directory: user
if ($handle = opendir($includes_dir.'templates/user')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
						if($file == $opt_val_user_template) $selected = " selected";
            echo "					<option value=\"$file\"$selected>$file</option>\n";
						$selected = "";
        }
    }
    closedir($handle);
}

?>
					</select>
				</div>

				<div class="rm_input rm_text">
					<label>Template for groups</label>
					<select name="<? echo $data_field_name_group_template; ?>" id="<? echo $data_field_name_group_template; ?>" size="1">
<?

// check template directory: group
if ($handle = opendir($includes_dir.'templates/group')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
					if($file == $opt_val_group_template) $selected = " selected";
          echo "						<option value=\"$file\"$selected>$file</option>\n";
					$selected = "";
        }
    }
    closedir($handle);
}

?>
					</select>
				</div>

				<div class="rm_input rm_text">
					<label>Template for publications</label>
					<select name="<? echo $data_field_name_publication_template; ?>" id="<? echo $data_field_name_publication_template; ?>" size="1">
<?

// check template directory: publication
if ($handle = opendir($includes_dir.'templates/publication')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
					if($file == $opt_val_publication_template) $selected = " selected";
          echo "						<option value=\"$file\"$selected>$file</option>\n";
					$selected = "";
        }
    }
    closedir($handle);
}

?>
					</select>
				</div>

				<div class="rm_input rm_text">
					<label>Stylesheet for plugin</label>
					<select name="<? echo $data_field_name_stylesheet; ?>" id="<? echo $data_field_name_stylesheet; ?>" size="1">
	<?

// check stylesheet directory
if ($handle = opendir($includes_dir.'stylesheets')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
					if($file == $opt_val_stylesheet) $selected = " selected";
           echo "						<option value=\"$file\"$selected>$file</option>\n";
					$selected = "";
        }
    }
    closedir($handle);
}

	?>
					</select>
				</div>
			
<?

	}

?>	
		
			<div class="rm_title"><h3>Save these settings</h3><span class="submit"><input name="save changes" type="submit" value="Save changes" />  
			</span><div class="clearfix"></div></div>
			
	
		</form>
	</div>
</div>
<br><br>
<div class="rm_wrap">
	<div class="rm_opts">
		<div class="rm_section_peers">  
			<div class="rm_title"><h3>Shortcodes</h3><div class="clearfix"></div></div>

			<div class="rm_comment">
				The Peers.me API has three different resources<br>
			<ul>
			<li>- Users</li>
			<li>- Groups</li>
			<li>- Publications</li>
			</ul>
			All of these resources can be listed and viewed through the use of shortcodes and widgets.<br><br>
			<strong>List of possible shortcodes</strong><br>
			[peersme list=”users”]<br>
			[peersme list=”groups”]<br>
			[peersme list=”publications”]<br><br>
			<strong>Limiting</strong><br>
			[peersme list=”users” limit=”5″]<br><br>
			<strong>Sorting</strong><br>
			[peersme list=”users” on=”created_at”]<br>
			[peersme list=”users” on=”created_at” sort=”DESC”]<br><br>
			<strong>Display one address</strong><br>
			[peersme view=”address” address=”daniel”]<br><br>
			<strong>Display groups with a specific label</strong><br>
			[peersme list=”groups” label=”Plugin-group”]</div>
		</div>
	</div>
</div>
<br><br>
<div class="rm_wrap">
	<div class="rm_opts">
		<div class="rm_section_peers">  
			<div class="rm_title"><h3>What is Peers.me?</h3><div class="clearfix"></div></div>

			<div class="rm_comment">Never heard of Peers.me, watch this video and claim your Peers.me address at our <a href="http://www.peers.me">website</a>.</div>

		<iframe src="http://player.vimeo.com/video/20737765?title=0&amp;byline=0&amp;portrait=0&amp;color=80ceff" width="738" height="415" frameborder="0"></iframe>
			<div class="rm_title"></div>
		</div>
	</div>
</div>
<?
}

?>