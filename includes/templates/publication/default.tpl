<?php
/*---------------------------------------------------------------------------
Would you like to use your own template?
1.) Copy this code in a other file and save it with the .tpl prefix (e.g. myfile.tpl)
2.) Change what you want at your own risk
3.) Select your template on settings page for use

*/



function peers_me_publication_view($publication){
	$tags = show_tags($publication['wave_id']);
	
	if(!empty($publication['agenda_date'])){
		$date = " <span class=\"psme-label-blue\">".date('F j, Y', strtotime($publication['agenda_date']))."</span>";
	} else {
		$date = "";
	}
	
	$output = '<p class="psme-title">'.$publication['title'].$tags.$date.'</p>';
	$output .= '<p class="psme-date">'.date('F j, Y', strtotime($publication['created_at'])).'</p>';
	
	// HTML Version
	$publication_html = $publication['html'];
	$publication_html = replace_attachments($publication['wave_id'],$publication_html,$publication['attachments']);
	
	// Markdown Version
	// $publication_markdown = $publication['markdown'];
	// $publication_html = Markdown($publication_markdown);
	
	$output .= '<p class="psme-text">'.$publication_html.'</p>';
	$output .= "<p><a href=\"".$publication['wave_url']."\">Go to Wave</a></p>";
	$output .= "<hr>";
	$output .= "Published by:<br>";
	$output .= peers_me_user_profile($publication['publisher']);
	return $output;
}

function peers_me_index_publication_item($publication,$publication_xml){
	global $publications_path, $users_path;
	$avatar_url = avatar_size($publication['publisher_avatar_url'],"small");

	if(!empty($publication['agenda_date'])){
		$date = " <span class=\"psme-label-blue\">".date('F j, Y', strtotime($publication['agenda_date']))."</span>";
	} else {
		$date = "";
	}

	$output = '	<div class="psme-content">';
$output .= '		<div class="psme-title"><a title="'.$publication['title'].'" href="'.$publications_path.'?wave_id='.$publication['wave_id'].'">'.$publication['title'].'</a> '.$date.'</div>'; 
	$output .= '		<div class="psme-publisher">';
	$output .= '			<a title="view '.$publication['publisher'].'" class="psme-avatar-icon psme-small" alt="'.$publication['publisher'].'" href="'.$users_path.'?address='.$publication['publisher'].'"><img src="'.$avatar_url.'" class="psme-small" alt="'.$publication['publisher'].'"></a>';
	$output .= '<span class="psme-published-on">published on	'.date('F j, Y', strtotime($publication['created_at'])).'</span>';
	$output .= '		<div class="psme-by-author">';
	$output .= '			<span>by</span>';
	$output .= '			<span class="psme-author"><a title="'.$publication['publisher'].'" href="'.$users_path.'?address='.$publication['publisher'].'">'.$publication['publisher'].'</a></span>';
	$output .= '		</div>';
	$output .= '	</div>';

	$output .= '';
	$output .= '	<div class="psme-text">'.substr($publication['text'], 0, 600).'</div>';
	
	$output .= '<div class="psme-read-more-line"><div class="psme-read-more-space"><a href="'.$publications_path.'?wave_id='.$publication['wave_id'].'">read more</a></div></div>';
	
	//end item
	$output .= '</div>';

	return $output;
}


function peers_me_index_publication_item_widget($publication){
	global $publications_path, $users_path;

	$avatar_url = avatar_address($publication['publisher'],"small");
	
	$output = '	<div class="psme-content">';
	$output .= '<div class="psme-title"><a title="'.$publication['title'].'" href="'.$publications_path.'?wave_id='.$publication['wave_id'].'">'.$publication['title'].'</a></div>';
	$output .= '		<div class="psme-publisher">';
	$output .= '			<a title="view '.$publication['publisher'].'" class="psme-avatar-icon small" alt="'.$publication['publisher'].'" href="'.$users_path.'?address='.$publication['publisher'].'"><img src="'.$avatar_url.'" class="psme-small" alt="'.$publication['publisher'].'"></a>';
	$output .= '<span class="psme-published-on">published on	'.date('F j, Y', strtotime($publication['created_at'])).'</span>';
	$output .= '	<div class="psme-by-author">';
	$output .= '	<span>by</span>';
	$output .= '	<span class="psme-author"><a title="'.$publication['publisher'].'" href="'.$users_path.'?address='.$publication['publisher'].'">'.$publication['publisher'].'</a></span>';
	$output .= '</div>
	
	</div>
	</div>
	';

	return $output;
}

?>