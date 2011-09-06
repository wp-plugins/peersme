<?php
/*
Plugin Name: Peers.me
Plugin URI: http://www.peers.me
Description: This plugin interacts with your Peers.me for Group Communication. Register your Free Peers.me account at www.peers.me to use this plugin.
Version: 0.8
Author: Daniël Steginga
Author URI: http://www.steginga.nl
*/

// Include necessary files
include('includes/functions.inc.php');
include('includes/model.php');
include('includes/templates.php');
include('includes/peers_me_widgets.php');
include('includes/settings.inc.php');

// From july-2011 Peers.me supports Markdown, so publications have a markdown version
// The markdown to html script from http://michelf.com/ is included
include('includes/markdown.php');


add_action('widgets_init', create_function('', 'return register_widget("PeersMe");'));
add_action('widgets_init', create_function('', 'return register_widget("PeersMeLogin");'));

// shortcodes... peers_me will be removed
add_shortcode('peers_me', 'peers_me');
add_shortcode('peersme', 'peers_me');

//styles
$stylesheet = get_option ( 'peers_me_stylesheet' );
if(empty($stylesheet)) $stylesheet = "default.css";

wp_register_style( 'myPeersMeStylesheet', WP_PLUGIN_URL . '/peersme/includes/stylesheets/'.$stylesheet );
wp_enqueue_style( 'myPeersMeStylesheet' );

//paths
$users_path = get_option ( 'peers_me_userspath' );
$groups_path = get_option ( 'peers_me_groupspath' );
$publications_path = get_option ( 'peers_me_publicationspath' );
if(empty($users_path)) $users_path = "users";
if(empty($groups_path)) $groups_path = "groups";
if(empty($publications_path)) $publications_path = "publications";

function peers_me($atts){
	
	//check if peers.me credentials are available
	$peers_me_username = get_option ( 'peers_me_username' );
	$peers_me_password = get_option ( 'peers_me_password' );
	if(empty($peers_me_username)||empty($peers_me_password)){
		
		$output = "Please check your API settings at the Plugin settings page:<br>";
		$output .= "* Peers.me API username<br>";
		$output .= "* Peers.me API password<br>";
		
	} else {
	
		wp_enqueue_style( 'myPeersMeStylesheet' );
		$output = '<div id="peers-me">';
	
		if(isset($_GET['address'])) $address = $_GET['address'];
		if(isset($_GET['wave_id'])) $wave_id = $_GET['wave_id'];
	
		// This function redirects the request to the right function
		//check if there are values passed by the browser
		if(!empty($address) || !empty($wave_id)){
	
			// If there's an address; start the address view (maybe check if address exists)
			if(!empty($address)){
				$output .= peers_me_address($address,true,true,true);
			}
			// If there's an wave_id; start the publication view
			if(!empty($wave_id)) {
				//show publication
				$output .= peers_me_publication($wave_id);
			}

		} else {
			if(!empty($atts['addresses'])){ 
				//Show multiple addresses
				$addresses = explode(",", $atts['addresses']);
				for($i = 0; $i < count($addresses); $i++){
					$output .= peers_me_address($addresses[$i]);
				}
			}
			elseif(isset($atts['view']) && $atts['view'] == "address") $output .= peers_me_address($atts['address'],true,true,true);
			elseif(isset($atts['view']) && $atts['view'] == "wave") $output .= peers_me_publication($atts['wave']);
			elseif(isset($atts['create']) && $atts['create'] == "wave") $output .= peers_me_createwave($atts['address'],$atts['email']);
			elseif(!empty($atts['address'])&&empty($atts['list'])) $output .= peers_me_address($atts['address'],!empty($atts['publications']),!empty($atts['groups']));
			elseif($atts['list'] == "members") $output .= peers_me_members($atts['address']); //$atts['address']
			elseif($atts['list'] == "users") $output .= peers_me_users_index($atts);
			elseif($atts['list'] == "groups") $output .= peers_me_groups_index($atts);
			elseif($atts['list'] == "publications" && !empty($atts['address'])) $output .= peers_me_publications_index($atts,$atts['address']);
			elseif($atts['list'] == "publications") $output .= peers_me_publications_index($atts);	
		}
		$output .= '</div>';
		
		
	}
	
	
	return $output;
}
// add_action('wp_print_styles', 'add_my_stylesheet');
wp_register_style( 'myPeersMeSettingsStylesheet', WP_PLUGIN_URL . '/peersme/includes/settings.css' );
wp_enqueue_style( 'myPeersMeSettingsStylesheet' );
add_action('admin_menu', 'peers_me_menu');

?>