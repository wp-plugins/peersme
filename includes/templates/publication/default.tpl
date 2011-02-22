<?php
/*---------------------------------------------------------------------------
Would you like to use your own template?
1.) Copy this code in a other file and save it with the .tpl prefix (e.g. myfile.tpl)
2.) Change what you want at your own risk
3.) Select your template on settings page for use

Available variables: wave_id, name, created_at
Available functions: avatar_addres([address])
*/

function replace_attachments($wave_id,$publication_html,$attachments){
	$publication_xml = get_xml("publications/".urlencode($wave_id),0);
	$attachment_raw = xml_to_array($publication_xml,"attachment");
	if(!empty($attachment_raw)) { 
		foreach($attachment_raw as $attachment) { 
	
	    	$att_url = $attachment['url'];
				$att_mime = $attachment['mime_type'];
				$att_mime = substr($att_mime,0,5);
				if($att_mime == "image"){
					
					//get size of image
					$max_width = 500; 
					$max_height = 500; 
					list($width, $height) = getimagesize($att_url); 
					$ratioh = $max_height/$height; 
					$ratiow = $max_width/$width; 
					$ratio = min($ratioh, $ratiow); 
					// New dimensions 
					$width = intval($ratio*$width); 
					$height = intval($ratio*$height);
					
					$att_tag = "<img width=\"".$width."\" height=\"".$height."\" src=\"".$att_url."\">";
					//replace attachment with img tag
					$att_url = "<img src='".$att_url."'>";
					$publication_html = str_replace($att_url,$att_tag,$publication_html);
	
				}
				
	    }
	
	  }
	
	return $publication_html;
}

function show_tags($wave_id){
		$publication_xml = get_xml("publications/".urlencode($wave_id),0);
		$tag_raw = xml_to_array($publication_xml,"tags");
		
		if(!empty($tag_raw)){
			foreach($tag_raw as $tag) { 
						
			    	$tag_name = $tag['tag'];
				$output .= " <span class=\"label\">".$tag_name."</span>";
						
			}
		
		}
		
		return $output;
	}



function peers_me_publication_view($publication){
	$tags = show_tags($publication['wave_id']);
	$output = '<p class="title">'.$publication['title'].$tags.'</p>';
	$output .= '<p class="date">'.date('F j, Y', strtotime($publication['created_at'])).'</p>';
	
	//replace attachments
	$publication_html = $publication['html'];
	$publication_html = replace_attachments($publication['wave_id'],$publication_html,$publication['attachments']);
	
	$output .= '<p class="text">'.$publication_html.'</p>';
	$output .= "<p><a href=\"".$publication['wave_url']."\">Go to Wave</a></p>";
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

function peers_me_index_publication_item($publication,$publication_xml){
	global $publications_path, $users_path;
	$avatar_url = avatar_size($publication['publisher_avatar_url'],"small");
	

	    foreach($publication['tags'] as $i) { 
	        // $value[$i->nodeName] = $i->nodeValue;
					$bla .= "bla";
	    } 

	
	$tags = $values;
	
	$output = '	<div class="content">';
$output .= '		<div class="title"><a title="'.$publication['title'].'" href="/'.$publications_path.'/?wave_id='.$publication['wave_id'].'">'.$publication['title'].'</a>'.show_tags($publication['wave_id']).'</div>';
	$output .= '		<div class="publisher">';
	$output .= '			<a title="view '.$publication['publisher'].'" class="avatar-icon small" alt="'.$publication['publisher'].'" href="/'.$users_path.'/?address='.$publication['publisher'].'"><img src="'.$avatar_url.'" class="small" alt="'.$publication['publisher'].'"></a>';
	$output .= '<span class="published-on">published on	'.date('F j, Y', strtotime($publication['created_at'])).'</span>';
	$output .= '		<div class="by-author">';
	$output .= '			<span>by</span>';
	$output .= '			<span class="author"><a title="'.$publication['publisher'].'" href="/'.$users_path.'/?address='.$publication['publisher'].'">'.$publication['publisher'].'</a></span>';
	$output .= '		</div>';
	$output .= '	</div>';

	$output .= '';
	$output .= '	<div class="text">'.substr($publication['text'], 0, 600).'</div>';
	
	$output .= '<div class="read-more-line"><div class="read-more-space"><a href="/'.$publications_path.'/?wave_id='.$publication['wave_id'].'">read more</a></div></div>';
	
	//end item
	$output .= '</div>';

	return $output;
}


function peers_me_index_publication_item_widget($publication){
	global $publications_path, $users_path;

	$avatar_url = avatar_address($publication['publisher'],"small");
	
	$output = '	<div class="content">';
	$output .= '<div class="title"><a title="'.$publication['title'].'" href="/'.$publications_path.'/?wave_id='.$publication['wave_id'].'">'.$publication['title'].'</a>'.show_tags($publication['wave_id']).'</div>';
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