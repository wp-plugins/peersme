<?php
/*
Plugin Name: Peers.me
Plugin URI: http://www.peers.me
Description: This plugin interacts with your Peers.me. Use these shortcodes on pages: [peersme], [peersme list="groups"], [peersme list="users" limit="5"]
Version: 0.3
Author: Daniël Steginga
Author URI: http://www.steginga.nl
*/

// Include necessary files
include('includes/functions.inc.php');
include('includes/model.php');
include('includes/templates.php');
include('includes/peers_me_widgets.php');
include('includes/settings.inc.php');

add_action('widgets_init', create_function('', 'return register_widget("PeersMe");'));

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
	wp_enqueue_style( 'myPeersMeStylesheet' );
	$output = '<div id="peers-me">';
	
	$address = $_GET['address'];
	$wave_id = $_GET['wave_id'];
	
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
		elseif($atts['view'] == "address") $output .= peers_me_address($atts['address'],true,true,true);
		elseif($atts['view'] == "wave") $output .= peers_me_publication($atts['wave']);
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

?>