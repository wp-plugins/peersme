<?

### Include wp-config.php
$wp_root = '../../..';
if (file_exists($wp_root.'/wp-load.php')) {
	require_once($wp_root.'/wp-load.php');
} else {
	require_once($wp_root.'/wp-config.php');
}

$q = $_GET["q"];
$place = $_GET["place"];
$address = $_GET["address"];

if($q == "users")
	{
		
		if($place == "sidebar"){ 
			$atts['limit'] = 5;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
			$atts['thumbs'] = false;			
		}elseif($place == "page"){
			$atts['limit'] = 1000;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
			$atts['thumbs'] = false;
		} else {
			$atts['limit'] = 15;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
			$atts['thumbs'] = true;	
		}
		
		$output = peers_me_users_index($atts);

	} 
else
if($q == "groups")
	{

		if($place == "sidebar"){ 
			$atts['limit'] = 5;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
			$atts['thumbs'] = false;			
		}elseif($place == "page"){
			$atts['limit'] = 1000;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
			$atts['thumbs'] = false;			
		} else {
			$atts['limit'] = 15;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
			$atts['thumbs'] = true;	
		}
		
		$output = peers_me_groups_index($atts);
		
	}
else
if($q == "publications")
	{

		if(isset($address)){
		
			if($address == "public")
				$atts['limit'] = 5;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
			
			$output .= peers_me_publications_index($atts,$address);
		
		}
		else
		if($place == "page"){
			
			$atts['limit'] = 20;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
		
			$output .= peers_me_publications_index($atts,"");
		
		} else {

			$atts['limit'] = 5;
			$atts['on'] = "created_at";
			$atts['sort'] = "DESC";
			$output .= peers_me_publications_index($atts,"",true);

		}

	}

echo $output;

?>