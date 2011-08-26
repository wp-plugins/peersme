<?
/*
Function for: Group index, group profile
Resource: groups.xml
*/

function peers_me_groups_index($atts,$address = ""){
	if(!empty($address)){
		$groups_xml = get_xml("users/".$address."/groups",0);
	} else {
		$groups_xml = get_xml("groups",0);
	}

	$groups_raw = xml_to_array($groups_xml,"group");

	//sorting
	if(!empty($atts['on'])){
		$groups_sorted = array_sort($groups_raw,$atts['on'],$atts['sort']);
	} else {
		$groups_sorted = array_sort($groups_raw,"name","ASC");
	}
	//limiting
	if(!empty($atts['limit'])){
		$groups_limited = array_slice($groups_sorted, 0, $atts['limit']);
	} else {
		$groups_limited = $groups_sorted;
	}
	$groups_array = $groups_limited;

	// print_r($groups_array);

	if(!empty($groups_array)) { 

			$output = '';

 			if(!empty($atts['thumbs']) == true){

						if(!empty($atts['label'])){

							 foreach($groups_array as $group) { 

									if($group['label'] == $atts['label']) 
										$output .= peers_me_index_group_thumb($group);

					      }	

						} else {
				
							foreach($groups_array as $group) { 
								
				         $output .= peers_me_index_group_thumb($group);

				      }	
				
						}

			} else {

				if(!empty($atts['label'])){

					 foreach($groups_array as $group) { 

							if($group['label'] == $atts['label']) 
							 	$output .= peers_me_index_group_item($group);

			      }	

				} else {

	      	foreach($groups_array as $group) { 

	         	$output .= peers_me_index_group_item($group);

	      	}
 				}

			}

  }
	return $output;
}

function peers_me_group_profile($address,$menu=false,$publications=false,$groups=false){
	$groups_xml = get_xml("groups/".$address,0);
	$groups_raw = xml_to_array($groups_xml,"group");

	$profile_raw = xml_to_array($groups_xml,"profile");
	
	if(!empty($groups_raw)) { 
		$output = '';
		foreach($groups_raw as $group) { 
			$output .= peers_me_group($group);
    }
		if($menu == true){
			$output .= peers_me_group_menu($group);
		}
		if(isset($_GET['page']) && $_GET['page'] == "publications"){
			$atts['limit'] = 20;
			$output .= "<h2>Publications:</h2>";
			$output .= peers_me_publications_index($atts,$address);			
		} elseif(isset($_GET['page']) && $_GET['page'] == "info"){
			$output .= "<h2>Info:</h2>";
			foreach($profile_raw as $profile) { 
				$output .= peers_me_group_info($profile);	
	    }
		} elseif(isset($_GET['page']) && $_GET['page'] == "members"){
			$output .= "<h2>Users:</h2>";
			$output .= peers_me_members($address,"user");
			$output .= "<h2>Groups:</h2>";
			$output .= peers_me_members($address,"group");
		} else {
			if($publications == true){
				$atts['limit'] = 5;
				$publications = peers_me_publications_index($atts,$address);
				
				if(!empty($publications)){ 
					$output .= "<h2>Latest publications:</h2>";
					$output .= $publications;
				} else {
					$output .= "<h2>Group hasn't published any waves</h2>";
				}
				
			}
		}
  }
	
	return $output;
}

?>