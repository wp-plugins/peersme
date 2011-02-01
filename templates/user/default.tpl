<?php
/*---------------------------------------------------------------------------
Would you like to use your own template?
1.) Copy this code in a other file and save it with the .tpl prefix (e.g. myfile.tpl)
2.) Change what you want at your own risk
3.) Select your template on settings page for use

Available variables: address, name, created_at
Available functions: avatar_addres([address])
*/


function peers_me_index_user_item($user){
	global $users_path;
	$avatar_url = avatar_address($user['address'],"small");
	
	$output = '	<div class="index-item">';
	$output .= ' 	<div class="content">';
	$output .= '		<a title="view '.$user['name'].'" class="avatar-icon thumb" alt="'.$user['address'].'" href="/'.$users_path.'/?address='.$user['address'].'"><img src="'.$avatar_url.'" class="thumb" alt="'.$user['address'].'"></a>';
	$output .= '		<div class="title">';
	$output .= '			<a title="view '.$user['name'].'" href="/'.$users_path.'/?address='.$user['address'].'"><span>'.$user['name'].'</span>';
	$output .= '			<span class="address">('.$user['address'].')</span>';
	$output .= '			</a></div>';
	// info field not yet available
	// $output .= '		<div class="description">'.$user['info'].'</div>';
	$output .= '		</div>';
	$output .= '	</div>';

	
	return $output;
	
}

function peers_me_index_user_thumb($user){
	global $users_path;
	$avatar_url = avatar_address($user['address'],"small");
	
	// $output .= ' 	<div class="content">';
	$output = '		<a title="view '.$user['name'].'" class="avatar-icon thumb" alt="'.$user['address'].'" href="/'.$users_path.'/?address='.$user['address'].'"><img src="'.$avatar_url.'" class="thumb" alt="'.$user['address'].'"></a>';
	// $output .= '		</div>';

	
	return $output;
	
}

function peers_me_user($user){
	global $users_path;
	$avatar_url = avatar_address($user['address'],"large");

	$output = '
		<div id="peers-profile"> 
			<div> 
				<a href="/'.$users_path.'/?address='.$user['address'].'" alt="'.$user['name'].'" class="avatar-icon large" title="view '.$user['name'].'"><img alt="'.$user['address'].'" class="large" src="'.$avatar_url.'" /></a>
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
					if(!empty($user['twitter'])) $output .= '<a href="'.$user['twitter'].'" alt="twitter" class="icon"><img src="http://company.peers.me/images/social_networks/twitter.png" /></a>';
					if(!empty($user['facebook'])) $output .= '<a href="'.$user['facebook'].'" alt="facebook" class="icon"><img src="http://company.peers.me/images/social_networks/facebook.png" /></a>';
					if(!empty($user['linkedin'])) $output .= '<a href="'.$user['linkedin'].'" alt="linkedin" class="icon"><img src="http://company.peers.me/images/social_networks/linkedin.png" /></a>';
					if(!empty($user['vimeo'])) $output .= '<a href="'.$user['vimeo'].'" alt="vimeo" class="icon"><img src="http://company.peers.me/images/social_networks/vimeo.png" /></a>';
					if(!empty($user['youtube'])) $output .= '<a href="'.$user['youtube'].'" alt="youtube" class="icon"><img src="http://company.peers.me/images/social_networks/youtube.png" /></a>';
					if(!empty($user['website'])) $output .= '<a href="'.$user['website'].'" alt="website" class="icon"><img src="http://company.peers.me/images/social_networks/website.png" /></a>';
					if(!empty($user['skype'])) $output .= '<a href="skype:'.$user['skype'].'?call" class="icon"><img alt="My status" height="44" src="http://mystatus.skype.com/bigclassic/'.$user['skype'].'" style="border:none;" width="182" />
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
		<div id="tabmenu">
			<div class="tabmenu-content">';
	$output .= '				<a'.$publications_current.' href="/'.$users_path.'/?address='.$user['address'].'&page=publications">Blog</a>';
	$output .= '				<a'.$info_current.' href="/'.$users_path.'/?address='.$user['address'].'&page=info">Info</a>';
	$output .= '				<a'.$groups_current.' href="/'.$users_path.'/?address='.$user['address'].'&page=groups">Groups</a>';
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
<fieldset><legend>Basic information</legend><div class="inside"><div class="p"><label>Biography</label><div class="meta-field">'.$user['info'].'</div></div></div></fieldset>
	';
	
	$output .= '
<fieldset><legend>Basic information</legend><div class="inside"><div class="p"><label>Company</label><div class="meta-field">'.$user['company_name'].'</div></div></div><div class="inside"><div class="p"><label>Function</label><div class="meta-field">'.$user['function'].'</div></div></div></fieldset>
	';	

	return $output;
}

function peers_me_user_twitter($user){

	$twitter = str_replace("http://www.twiter.com/", "", $user['twitter']);
	$twitter = str_replace("http://www.twitter.com/", "", $user['twitter']);	
	$twitter = str_replace("http://twiter.com/", "", $user['twitter']);
	$twitter = str_replace("http://twitter.com/", "", $user['twitter']);



	$output = '
		<script src="http://widgets.twimg.com/j/2/widget.js"></script>
		<script>
		new TWTR.Widget({
		  version: 2,
		  type: \'profile\',
		  rpp: 4,
		  interval: 6000,
		  width: 300,
		  height: 300,
		  theme: {
		    shell: {
		      background: \'#cccccc\',
		      color: \'#292929\'
		    },
		    tweets: {
		      background: \'#ffffff\',
		      color: \'#333333\',
		      links: \'#ed2939\'
		    }
		  },
		  features: {
		    scrollbar: true,
		    loop: false,
		    live: false,
		    hashtags: true,
		    timestamp: true,
		    avatars: false,
		    behavior: \'all\'
		  }
		}).render().setUser(\''.$twitter.'\').start();
		</script>
	
	';
	
	return $output;
}

?>