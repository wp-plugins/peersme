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

	$peers_user_pass = $peers_me_username.":".$peers_me_password;
	$peers_me_api_address = $peers_me_address."/api/";
	if(isset($offset)) $offset = "?offset=".$offset;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $peers_me_api_address.$url);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $peers_user_pass);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$api_return = curl_exec($ch);	
	$curl_info = curl_getinfo($ch);

	
	if(curl_getinfo($ch, CURLINFO_HTTP_CODE) >= '300'){ 
		$http_codes = parse_ini_file("http-codes.txt");
		echo "The server responded: <br />";
		echo $curl_info['http_code'] . " " . $http_codes[$curl_info['http_code']]."<br><br>";
		if($curl_info['http_code'] == 401){
			echo "Please check your API settings:<br>";
			echo "* Peers.me address<br>";
			echo "* Peers.me API username<br>";
			echo "* Peers.me API password<br>";
		}
		if($curl_info['http_code'] == 404){
			echo "<strong>This content is currently unavailable</strong><br>";
			echo "The page you requested cannot be displayed right now. It may be temporarily unavailable, the link you clicked on may have expired, or you may not have permission to view this page.";
		}
		if($curl_info['http_code'] == 502){
			echo "<strong>Peers.me is currently updating or unavailable</strong><br>";
			echo "Please check our announcements on <a href=\"http://twitter.com/peersme\">twitter.com/peersme</a>";
		}

		// exit();
	}
	
	curl_close($ch);

	return $api_return;
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
	

?>