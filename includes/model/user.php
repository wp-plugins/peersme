<?
/*
Function for: User index, user profile
Resource: users.xml
Available values in index: address, name, created_at
Available values in profile: 

Additional values: Avatar, Publications, Group memberships
*/

function peers_me_users_index($atts,$address = ""){
	$output = "";
	if(!empty($address)){
		$users_xml = get_xml("groups/".$address."/members",0);
	} else {
		$users_xml = get_xml("users",0);
	}
	$users_raw = xml_to_array($users_xml,"user");
	//sorting
	if(!empty($atts['on'])){
		$users_sorted = array_sort($users_raw,$atts['on'],$atts['sort']);
	} else {
		$users_sorted = array_sort($users_raw,"name","ASC");
	}
	//limiting
	if(!empty($atts['limit'])){
		$users_limited = array_slice($users_sorted, 0, $atts['limit']);
	} else {
		$users_limited = $users_sorted;
	}
	$users_array = $users_limited;
	if(!empty($users_array)) { 
			//start index tpl includen //////////////////// TODO
			$output = '';
			if(!empty($atts['thumbs']) == true){
				 foreach($users_array as $user) { 
		         $output .= peers_me_index_user_thumb($user);
		      }	
			} else {
	      foreach($users_array as $user) { 
	         $output .= peers_me_index_user_item($user);
	      } 
			}
			//end index tpl includen //////////////////// TODO
  }
	return $output;
}

function peers_me_user_profile($address,$menu=false,$publications=false,$groups=false){
	$users_xml = get_xml("users/".$address,0);
	$users_raw = xml_to_array($users_xml,"user");

	$profile_raw = xml_to_array($users_xml,"profile");
	if(!empty($users_raw)) { 
		$output = '';
		foreach($users_raw as $user) { 
			$output .= peers_me_user($user);
    }
		if($menu == true){
			$output .= peers_me_user_menu($user);
		}
		if(isset($_GET['page']) && $_GET['page'] == "publications"){
			$atts['limit'] = 20;
			$atts['offset'] = 0;
			$output .= "<h2>Publications:</h2>";
			$output .= peers_me_publications_index($atts,$address);			
		} elseif(isset($_GET['page']) && $_GET['page'] == "info"){
			$output .= "<h2>Info:</h2>";
			foreach($profile_raw as $profile) { 
				$output .= peers_me_user_info($profile);	
	    }
		} elseif(isset($_GET['page']) && $_GET['page'] == "groups"){
			$output .= "<h2>Groups:</h2>";
			$atts = "";
			$output .= peers_me_groups_index($atts,$address);
		} elseif(isset($_GET['page']) && $_GET['page'] == "twitter"){
			$output .= "<h2>Twitter:</h2>";
			$atts = "";
			$output .= peers_me_user_twitter($user);
		} else {
			if($publications == true){
				$atts['limit'] = 5;
				$publications = peers_me_publications_index($atts,$address);
				
				// $output .= "<h2>Publications:</h2>";
				// $output .= peers_me_publications_index($atts,$address);
				
				if(!empty($publications)){ 
					$output .= "<h2>Latest publications:</h2>";
					$output .= $publications;
				} else {
					$output .= "<h2>User hasn't published any waves</h2>";
				}
			}
		}
  }
	return $output;
}


?>