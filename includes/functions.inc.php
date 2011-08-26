<?
if(empty($peers_me_username)) $peers_me_username = get_option ( 'peers_me_username' );
if(empty($peers_me_password)) $peers_me_password = get_option ( 'peers_me_password' );

$peers_me_address = $peers_me_username.".peers.me";


function xml_value($xml_value,$value){
	$output = $xml_value->getElementsByTagName("$value")->item(0)->nodeValue;
	return $output;
}

function get_xml($url,$offset){
	global $unique_page_id, $peers_me_username, $peers_me_password, $peers_me_address;

	$peers_me_api_address = "https://".$peers_me_address."/api/".$url;

	$headers = array( 'Authorization' => 'Basic ' . base64_encode( "$peers_me_username:$peers_me_password" ) );
	
	$result = wp_remote_get( $peers_me_api_address, array( 'headers' => $headers, 'sslverify' => true ) );
	
	if( is_wp_error( $result ) ) {
		
		// SSL verify op false
		$result = wp_remote_get( $peers_me_api_address, array( 'headers' => $headers, 'sslverify' => false ) );
	}
	
	// echo $peers_me_api_address;
	
	// get response code
	$code = $result['response']['code'];
	$message = $result['response']['message'];
	
	// echo $code.$message;
	
	if($result['response']['code'] != "200"){
		
		// Oops, there's something wrong. Please check the Peers.me settings page
		echo "<p class=\"not-available\">\"<strong>".$code." - ".$message."</strong>\" - Oops... please check the Peers.me settings page.</p>";
		
	}
	
	// echo $result['body'];
	
	return $result['body'];
}

function avatar_address($address, $size) {
	global $peers_me_address;

	$avatar = "http://".$peers_me_address."/avatars/".urlencode($address)."/".$size;
	return $avatar;
}

function avatar_size($avatar_url, $size) {
	$avatar = str_replace(":style",$size,$avatar_url);
	return $avatar;
}


function array_sort($array, $on, $order='DESC')
{
  $new_array = array();
  $sortable_array = array();

  if (count($array) > 0) {
      foreach ($array as $k => $v) {
          if (is_array($v)) {
              foreach ($v as $k2 => $v2) {
                  if ($k2 == $on) {
                      $sortable_array[$k] = $v2;
                  }
              }
          } else {
              $sortable_array[$k] = $v;
          }
      }

      switch($order)
      {
          case 'ASC':   
              asort($sortable_array);
          break;
          case 'DESC':
              arsort($sortable_array);
          break;
      }

      foreach($sortable_array as $k => $v) {
          $new_array[] = $array[$k];
      }
  }
  return $new_array;
}

function xml_to_array($xml,$tagname){
	$xmldoc = new DOMDocument(); 

	if ($xmldoc->loadXML($xml)) { 
	    $items = $xmldoc->getElementsByTagName($tagname); 
	    $values = array(); 

	    foreach($items as $item) { 
			        $value = array(); 

			        if($item->childNodes->length) { 

									$tag = "";

			            foreach($item->childNodes as $i) { 

			                $value[$i->nodeName] = $i->nodeValue; 

			            }


			        } 

			        $values[] = $value; 
			
	    } 

	}
	return $values;
}

function xmlpart_to_array($xml,$tagname){
	$xmldoc = new DOMDocument(); 
	// 
	if ($xmldoc->loadXML($xml)) { 
	    $items = $xml->getElementsByTagName($tagname); 
	    $values = array(); 
	    foreach($items as $item) { 
	    			        $value = array(); 
	    
	    			        if($item->childNodes->length) { 
	    			            foreach($item->childNodes as $i) { 
	    			                $value[$i->nodeName] = $i->nodeValue; 
	    
	    			            } 
	    			        } 
	    
	    			        $values[] = $value; 
	    } 
		}
	return $values;
}

function get_root_node($xml){
	$xml = simplexml_load_string($xml);
	$output = $xml->getName();
	return $output;
}
	

// Version 0.4

function resize_image($image_url,$max_width = 500,$max_height = 500){
	//get size of image
	list($width, $height) = getimagesize($image_url); 
	$ratioh = $max_height/$height; 
	$ratiow = $max_width/$width; 
	$ratio = min($ratioh, $ratiow); 
	// New dimensions 
	$width = intval($ratio*$width); 
	$height = intval($ratio*$height);
	
	$output = "width=\"".$width."\" height=\"".$height."\" ";
	
	return $output;
}

// replace_attachments() and show_tags() moved from templates/publications/default.tpl to this file

function replace_attachments($wave_id,$publication_html,$attachments){
	$publication_xml = get_xml("publications/".urlencode($wave_id),0);
	$attachment_raw = xml_to_array($publication_xml,"attachment");
	if(!empty($attachment_raw)) { 
		foreach($attachment_raw as $attachment) { 
	
	    	$att_url = $attachment['url'];
				$att_mime = $attachment['mime_type'];
				$att_mime = substr($att_mime,0,5);
				if($att_mime == "image"){
					
					$size = resize_image($att_url,500,500);
					
					$att_tag = "<img ".$size."src=\"".$att_url."\">";
					//replace attachment with img tag
					$att_url = "<img src='".$att_url."'>";
					$publication_html = str_replace($att_url,$att_tag,$publication_html);
	
				}
				
	    }
	
	  }
	
	return $publication_html;
}

// show tags from a wave
function show_tags($wave_id, $array_only = false){
	$publication_xml = get_xml("publications/".urlencode($wave_id),0);
	$tag_raw = xml_to_array($publication_xml,"tags");
	
	$output = "";
	
	if($array_only == true){
		
		$output = $tag_raw;
		
	} else {
		
		if(!empty($tag_raw)){
		
			foreach($tag_raw as $tag) { 
					
			  $tag_name = $tag['tag'];
				$output .= " <span class=\"label\">".$tag_name."</span>";
					
			}
	
		}
		
	}
	
	return $output;
}


// Get the first attached image from a wave
// can be shown in the index

function get_attached_image($wave_id, $path_only = false,$width = 200, $height = 200){
		$publication_xml = get_xml("publications/".urlencode($wave_id),0);
		$attachment_raw = xml_to_array($publication_xml,"attachment");

		//get first attachment thats an image
		$image = false;

		if(!empty($attachment_raw)) { 

			foreach($attachment_raw as $attachment) { 

				$att_mime = $attachment['mime_type'];
				$att_mime = substr($att_mime,0,5);

				if($att_mime == "image" && $image == false){

					$image_url = $attachment['url'];
					$image = true;

				}

		  }
			

		}

		if(!empty($image_url)) { 		

			if($path_only == true){

				$output = $image_url;

			} else {

				$size = resize_image($image_url,$width,$height);
				$output = "<img ".$size."src=\"".$image_url."\" align=\"left\">";

			}
		
		}

		return $output;
}

?>