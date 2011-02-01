<?php
/*---------------------------------------------------------------------------
Would you like to use your own template?
1.) Copy this code in a other file and save it with the .tpl prefix (e.g. myfile.tpl)
2.) Change what you want at your own risk
3.) Select your template on settings page for use

Available variables: wave_id, name, created_at
Available functions: avatar_addres([address])

example xml:
<publication>
<wave_id>w+a6Bt84Wlq7Ivi</wave_id>
<publisher>daniel</publisher>
<placement>daniel</placement>
<title>1</title>
<text/>
<html/>
−
<wave_url>
http://boxes.puppetmaster.aboutpeers.com/waves/w+a6Bt84Wlq7Ivi
</wave_url>
<created_at type="datetime">2010-11-25 15:12:47 +0100</created_at>
<attachments>
  </attachments>
</publication>
*/

function peers_me_publication_view($publication){
	$output = '<p class="title">'.$publication['title'].'</p>';
	$output .= '<p class="date">'.date('F j, Y', strtotime($publication['created_at'])).'</p>';
	$output .= '<p class="text">'.$publication['html'].'</p>';
	$output .= "<hr>";
	$output .= $publication['attachments'];
	$output .= "<hr>";
	$output .= "<a href=\"".$publication['wave_url']."\">Go to Wave</a><br>";
	$output .= "<hr>";
	$output .= "Published by:<br>";
	$output .= peers_me_user_profile($publication['publisher']);
	return $output;
}

// function peers_me_index_publication_item($publication){
// 	global $publications_path;
// 	$output = '<a href="/'.$publications_path.'/?wave_id='.$publication['wave_id'].'" class="name">'.$publication['title'].'</a>';
// 	$output .= '<p class="date">'.date('F j, Y', strtotime($publication['created_at'])).'</p><hr>';
// 	return $output;
// }

function peers_me_index_publication_item($publication){
	global $publications_path, $users_path;
	$avatar_url = avatar_address($publication['publisher'],"small");
	
	$peers_me_address = get_option ('peers_me_address')."/api/";
	$output = '	<div class="content">';
	$output .= '		<div class="title"><a title="'.$publication['title'].'" href="/'.$publications_path.'/?wave_id='.$publication['wave_id'].'">'.$publication['title'].'</a></div>';
	$output .= '		<div class="publisher">';
	$output .= '			<a title="view '.$publication['publisher'].'" class="avatar-icon small" alt="'.$publication['publisher'].'" href="/'.$users_path.'/?address='.$publication['publisher'].'"><img src="'.$avatar_url.'" class="small" alt="'.$publication['publisher'].'"></a>';
	$output .= '<span class="published-on">published on	'.date('F j, Y', strtotime($publication['created_at'])).'</span>';
	$output .= '		<div class="by-author">';
	$output .= '			<span>by</span>';
	$output .= '			<span class="author"><a title="'.$publication['publisher'].'" href="/'.$users_path.'/?address='.$publication['publisher'].'">'.$publication['publisher'].'</a></span>';
	$output .= '		</div>';
	$output .= '	</div>';
	//show publication intro
	$output .= '';
	$output .= '	<div class="text">'.substr($publication['text'], 0, 600).'</div>';
	
	$output .= '<div class="read-more-line"><div class="read-more-space"><a href="/'.$publications_path.'/?wave_id='.$publication['wave_id'].'">read more</a></div></div>';
	
	//end item
	$output .= '</div>';

	return $output;
}


function peers_me_index_publication_item_widget($publication){
	global $publications_path, $users_path;
	$peers_me_address = get_option ('peers_me_address')."/api/";
	$avatar_url = avatar_address($publication['publisher'],"small");
	
	$output = '	<div class="content">';
	$output .= '<div class="title"><a title="'.$publication['title'].'" href="/'.$publications_path.'/?wave_id='.$publication['wave_id'].'">'.$publication['title'].'</a></div>';
	$output .= '		<div class="publisher">';
	$output .= '			<a title="view '.$publication['publisher'].'" class="avatar-icon small" alt="'.$publication['publisher'].'" href="/'.$users_path.'/?address='.$publication['publisher'].'"><img src="'.$avatar_url.'" class="small" alt="'.$publication['publisher'].'"></a>';
	$output .= '<span class="published-on">published on	'.date('F j, Y', strtotime($publication['created_at'])).'</span>';
	$output .= '	<div class="by-author">';
	$output .= '	<span>by</span>';
	$output .= '	<span class="author"><a title="'.$publication['publisher'].'" href="/'.$users_path.'/?address='.$publication['publisher'].'">'.$publication['publisher'].'</a></span>';
	$output .= '</div>

	</div>
	</div>
	';
	return $output;
}

?>