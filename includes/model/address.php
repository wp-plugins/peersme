<?
/*
Function for: address
Resource: users.xml
Available values in index: address, name, created_at
Available values in profile: 

Additional values: Avatar, Publications, Group memberships
*/

function peers_me_address($address,$menu=false,$publications=false,$groups=false){
	$address_xml = get_xml("addresses/".$address,0);
	//check if address is user or group
	$address_type = get_root_node($address_xml);
	if($address_type == "group"){
		$output = peers_me_group_profile($address,$menu,$publications,$groups);
	}elseif($address_type == "user"){
		$output = peers_me_user_profile($address,$menu,$publications,$groups);
	}else {
		$output = "Address could not be found";
	}
	return $output;
}

function peers_me_old_address(){
	//get address from url
	$output = "hello, this is the address";
	// $address_xml = get_xml("addresses/".$address,0);
	//check if address is user or group
	// $address_type = get_root_node($address_xml);
	if($address_type == "group"){
		$output = peers_me_group_profile($address,$menu,$publications,$groups);
	}elseif($address_type == "user"){
		$output = peers_me_user_profile($address,$menu,$publications,$groups);
	}else {
		$output = "Address could not be found";
	}
	return $output;
}

?>