<?php
/*---------------------------------------------------------------------------
Would you like to use your own template?
1.) Copy this code in a other file and save it with the .tpl prefix (e.g. myfile.tpl)
2.) Change what you want at your own risk
3.) Select your template on settings page for use

*/


function peers_me_index_user_item($user){
	global $users_path;

	// show small avatar on index
	$avatar_url = str_replace(":style","small",$user['avatar_url']);
	
	$output = '	<div class="psme-index-item">';
	$output .= ' 	<div class="psme-content">';
	$output .= '		<a title="view '.$user['name'].'" class="psme-avatar-icon" alt="'.$user['address'].'" href="'.$users_path.'?address='.$user['address'].'"><img src="'.$avatar_url.'" class="thumb" alt="'.$user['address'].'"></a>';
	$output .= '		<div class="psme-title">';
	$output .= '			<a title="view '.$user['name'].'" href="'.$users_path.'?address='.$user['address'].'"><span>'.$user['name'].'</span>';
	$output .= '			<span class="psme-address">('.$user['address'].')</span>';
	$output .= '			</a></div>';
	$output .= '		</div>';
	$output .= '	</div>';

	return $output;
	
}

function peers_me_index_user_thumb($user){
	global $users_path;
	$avatar_url = str_replace(":style","small",$user['avatar_url']);
	
	$output = '		<a title="view '.$user['name'].'" class="psme-avatar-icon psme-thumb" alt="'.$user['address'].'" href="'.$users_path.'?address='.$user['address'].'"><img src="'.$avatar_url.'" class="psme-thumb" alt="'.$user['address'].'"></a>';
	
	return $output;
	
}

function peers_me_user($user){
	global $users_path;
	$avatar_url = str_replace(":style","large",$user['avatar_url']);

	$output = '
		<div id="peers-profile"> 
			<div> 
				<a href="'.$users_path.'?address='.$user['address'].'" alt="'.$user['name'].'" class="psme-avatar-icon psme-large" title="view '.$user['name'].'"><img alt="'.$user['address'].'" class="psme-large" src="'.$avatar_url.'" /></a>
			</div> 
			<div> 
				<h1 id="peers-profile-name">'.$user['name'].'</h1> 
					<div class=\'meta\'> 
						<ul id=\'meta\'> 
							<li><strong>address</strong>: '.$user['address'].'</li> 
							<li><strong>started</strong>: '.$user['created_at'].'</li> 
						</ul> 
					</div> 
					<div class="icon">';
					//social networks
					if(!empty($user['twitter'])) $output .= '<a href="'.$user['twitter'].'" alt="twitter" class="psme-icon"><img src="http://company.peers.me/images/social_networks/twitter.png" /></a>';
					if(!empty($user['facebook'])) $output .= '<a href="'.$user['facebook'].'" alt="facebook" class="psme-icon"><img src="http://company.peers.me/images/social_networks/facebook.png" /></a>';
					if(!empty($user['linkedin'])) $output .= '<a href="'.$user['linkedin'].'" alt="linkedin" class="psme-icon"><img src="http://company.peers.me/images/social_networks/linkedin.png" /></a>';
					if(!empty($user['vimeo'])) $output .= '<a href="'.$user['vimeo'].'" alt="vimeo" class="psme-icon"><img src="http://company.peers.me/images/social_networks/vimeo.png" /></a>';
					if(!empty($user['youtube'])) $output .= '<a href="'.$user['youtube'].'" alt="youtube" class="psme-icon"><img src="http://company.peers.me/images/social_networks/youtube.png" /></a>';
					if(!empty($user['website'])) $output .= '<a href="'.$user['website'].'" alt="website" class="psme-icon"><img src="http://company.peers.me/images/social_networks/website.png" /></a>';
					if(!empty($user['skype'])) $output .= '<a href="skype:'.$user['skype'].'?call" class="psme-icon"><img alt="My status" height="44" src="http://mystatus.skype.com/bigclassic/'.$user['skype'].'" style="border:none;" width="182" />
					</a>
					';
					
$output .= '					</div>
				</div> 
			</div>
	';
	return $output;
}


function peers_me_user_menu($user){
	global $users_path;
	
	//pages
	if(!empty($_GET['page']) && $_GET['page']=="publications"){ 
		$publications_current =  ' class="current"';
		$info_current =  '';
		$groups_current =  '';
	} elseif(!empty($_GET['page']) && $_GET['page']=="info"){ 
		$info_current =  ' class="current"';
		$publications_current =  '';
		$groups_current =  '';
	} elseif(!empty($_GET['page']) && $_GET['page']=="groups"){ 
		$groups_current =  ' class="current"';
		$publications_current =  '';
		$info_current =  '';
	} else { 
		$publications_current =  ' class="current"';
		$info_current =  '';
		$groups_current =  '';
	}
	
	$output = '
		<div id="psme-tabmenu">
			<div class="psme-tabmenu-content">';
	$output .= '				<a'.$publications_current.' href="'.$users_path.'?address='.$user['address'].'&page=publications">Blog</a>';
	$output .= '				<a'.$info_current.' href="'.$users_path.'?address='.$user['address'].'&page=info">Info</a>';
	$output .= '				<a'.$groups_current.' href="'.$users_path.'?address='.$user['address'].'&page=groups">Groups</a>';
	$output .= '			</div>
		</div>
	
	';
	return $output;
	
}


function peers_me_user_info($user){
	
	//check for values
	if(!isset($user['info'])) $user['info'] = "";
	if(!isset($user['company_name'])) $user['company_name'] = "";
	if(!isset($user['function'])) $user['function'] = "";
	
	$output = '
<fieldset><legend>Basic information</legend><div class="psme-inside"><div class="psme-p"><label>Biography</label><div class="psme-meta-field">'.$user['info'].'</div></div></div></fieldset>
	';

	return $output;
}

?>