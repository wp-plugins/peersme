<?php
/*
Plugin Name: Peers.me
Plugin URI: http://www.peers.me
Description: This plugin interacts with your Peers.me. Use these shortcodes on pages: [peers_me], [peers_me list="groups"], [peers_me list="users" limit="5"] 
Version: 0.2
Author: Daniël Steginga
Author URI: http://www.steginga.nl
*/

// Include necessary files
include('functions.inc.php');
include('templates.php');
include('model/user.php');
include('model/publication.php');
include('model/group.php');
include('model/address.php');
include('model/members.php');
include('peers_me_widgets.php');

add_action('widgets_init', create_function('', 'return register_widget("PeersMeUsers");'));
add_action('widgets_init', create_function('', 'return register_widget("PeersMePublications");'));
add_shortcode('peers_me', 'peers_me');

//styles
wp_register_style( 'myPeersMeStylesheet', WP_PLUGIN_URL . '/peers_me/stylesheet.css' );
wp_enqueue_style( 'myPeersMeStylesheet' );

//paths
$users_path = "users";
$groups_path = "groups";
$publications_path = "publications";

function peers_me($atts){
	wp_enqueue_style( 'myPeersMeStylesheet' );
	$output = '<div id="peers-me">';
	// This function redirects the request to the right function
	//check if there are values passed by the browser
	if(!empty($_GET['address']) || !empty($_GET['wave_id'])){
	
		// If there's an address; start the address view (maybe check if address exists)
		if(!empty($_GET['address'])){
			$output .= peers_me_address($_GET['address'],true,true,true);
		}
		// If there's an wave_id; start the publication view
		if(!empty($_GET['wave_id'])) {
			//show publication
			$output .= peers_me_publication($_GET['wave_id']);
		}

	} else {
		if(!empty($atts['addresses'])){ 
			//Show multiple addresses
			$addresses = explode(",", $atts['addresses']);
			for($i = 0; $i < count($addresses); $i++){
				$output .= peers_me_address($addresses[$i]);
			}
		}
		elseif(!empty($atts['address'])&&empty($atts['list'])) $output .= peers_me_address($atts['address'],!empty($atts['publications']),!empty($atts['groups']));
		elseif($atts['list'] == "members") $output .= peers_me_members($atts['address']); //$atts['address']
		elseif($atts['list'] == "users") $output .= peers_me_users_index($atts);
		elseif($atts['list'] == "groups") $output .= peers_me_groups_index($atts);
		elseif($atts['list'] == "publications") $output .= peers_me_publications_index($atts);
		
	
	}
	$output .= '</div>';
	return $output;
}

add_action('admin_menu', 'peers_me_menu');
// add_filter( 'plugin_row_meta', 'set_plugin_meta', 10, 2 );

?>