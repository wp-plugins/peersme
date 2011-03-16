<?php
/*---------------------------------------------------------------------------
Would you like to use your own template?
1.) Copy this code in a other file and save it with the .tpl prefix (e.g. myfile.tpl)
2.) Change what you want at your own risk
3.) Select your template on settings page for use

*/

function peers_me_index_group_item($group){
	global $groups_path;
	$avatar_url = str_replace(":style","small",$group['avatar_url']);
	
	$output = '	<div class="index-item">';
	$output .= ' 	<div class="content">';
	$output .= '		<a title="view '.$group['name'].'" class="avatar-icon thumb" alt="'.$group['address'].'" href="/'.$groups_path.'/?address='.$group['address'].'"><img src="'.$avatar_url.'" class="thumb" alt="'.$group['address'].'"></a>';
	$output .= '		<div class="title">';
	$output .= '			<a title="view '.$group['name'].'" href="/'.$groups_path.'/?address='.$group['address'].'"><span>'.$group['name'].'</span>';
	$output .= '			<span class="address">('.$group['address'].')</span></a>';
	if(!empty($group['label'])){
		$output .= '			<span class="label">'.$group['label'].'</span>';
	}
	$output .= '			</div>';
	$output .= '		</div>';
	$output .= '	</div>';

	
	return $output;
	
}

function peers_me_index_group_thumb($group){
	global $groups_path;
	$avatar_url = str_replace(":style","small",$group['avatar_url']);
	
	// $output .= ' 	<div class="content">';
	$output = '		<a title="view '.$group['name'].'" class="avatar-icon thumb" alt="'.$group['address'].'" href="/'.$groups_path.'/?address='.$group['address'].'"><img src="'.$avatar_url.'" class="thumb" alt="'.$group['address'].'"></a>';
	// $output .= '		</div>';

	
	return $output;
	
}

function peers_me_group($group){
	global $groups_path;
	$avatar_url = str_replace(":style","large",$group['avatar_url']);

	if(!empty($group['label'])){
		$label .= '			<span class="label">'.$group['label'].'</span>';
	}

	$output = '
		<div id="peers-profile"> 
			<div> 
				<a href="/'.$groups_path.'/?address='.$group['address'].'" alt="'.$group['name'].'" class="avatar-icon large" title="view '.$group['name'].'"><img alt="'.$group['address'].'" class="large" src="'.$avatar_url.'" /></a>
			</div> 
			<div> 
				<h1 id="peers-profile-name">'.$group['name'].'</h1>'.$label.' 
					<div class=\'meta\'> 
						<ul id=\'meta\'> 
							<li><strong>address</strong>: '.$group['address'].'</li> 
							<li><strong>started</strong>: '.$group['created_at'].'</li> 
						</ul> 
					</div> 
				</div> 
			</div>
	';
	return $output;
}

function peers_me_group_menu($group){
	global $groups_path;
	
	//pages
	if(!empty($_GET['page']) && $_GET['page']=="publications"){ 
		$publications_current =  ' class="current"';
		$info_current =  '';
		$members_current =  '';
	} elseif(!empty($_GET['page']) && $_GET['page']=="info"){ 
		$info_current =  ' class="current"';
		$publications_current =  '';
		$members_current =  '';
	} elseif(!empty($_GET['page']) && $_GET['page']=="members"){ 
		$members_current =  ' class="current"';
		$publications_current =  '';
		$info_current =  '';
	} else { 
		$publications_current =  ' class="current"';
		$info_current =  '';
		$members_current =  '';
	}
	
	$output = '
		<div id="tabmenu">
			<div class="tabmenu-content">';
	$output .= '				<a'.$publications_current.' href="/'.$groups_path.'/?address='.$group['address'].'&page=publications">Blog</a>';
	$output .= '				<a'.$info_current.' href="/'.$groups_path.'/?address='.$group['address'].'&page=info">Info</a>';
	$output .= '				<a'.$members_current.' href="/'.$groups_path.'/?address='.$group['address'].'&page=members">Members</a>';
	$output .= '			</div>
		</div>
	
	';
	return $output;
	
}

function peers_me_group_info($group){
	
	$output = '
<fieldset><legend>Basic information</legend><div class="inside"><div class="p"><label>Description</label><div class="meta-field">'.$group['info'].'</div></div></div></fieldset>
	';
	
	return $output;
}

?>