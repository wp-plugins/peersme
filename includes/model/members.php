<?
/*
Function for: address
Resource: users.xml
Available values in index: address, name, created_at
Available values in profile: 

Additional values: Avatar, Publications, Group memberships
*/

function peers_me_members($address,$type="user"){
	$groups_xml = get_xml("groups/".$address."/members",0);
	$groups_raw = xml_to_array($groups_xml,$type);
	$groups_sorted = array_sort($groups_raw,"name","ASC");
	$groups_limited = $groups_sorted;
	$groups_array = $groups_limited;
	$output = '';
	if(!empty($groups_array)) { 
      foreach($groups_array as $group) { 
         $output .= peers_me_index_group_item($group);
  		} 
  }
	return $output;
}

?>