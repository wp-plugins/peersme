<?

function set_plugin_meta($links, $file) {
	// add a settings link to plugin overview
	$plugin = "peers-me";
	return array_merge(
		$links,
		array( sprintf( '<a href="options-general.php?page=%s">%s</a>', $plugin, __('Settings') ) )
	);
	return $links;
}

function peers_me_menu() {
	add_options_page('Peers.me Options', 'Peers.me', 'manage_options', 'peers-me', 'peers_me_options');
}

function peers_me_options() {
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to acces this page.'));
	}
	
	// variables for the field and option names
	$opt_name_address = 'peers_me_address';
	$data_field_name_address = 'peers_me_address';
	$opt_name_username = 'peers_me_username';
	$data_field_name_username = 'peers_me_username';
	$opt_name_password = 'peers_me_password';
	$data_field_name_password = 'peers_me_password';
	$hidden_field_name = 'peers_me_submit_hidden';
	
	// Read in existing option value from database
	$opt_val_address = get_option ( $opt_name_address );
	$opt_val_username = get_option ( $opt_name_username );
	$opt_val_password = get_option ( $opt_name_password );
	
	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
		// Read their posted value
		$opt_val_address = $_POST[ $data_field_name_address ];
		$opt_val_username = $_POST[ $data_field_name_username ];
		$opt_val_password = $_POST[ $data_field_name_password ];
		
		// Save the posted value in the database
		update_option( $opt_name_address, $opt_val_address );
		update_option( $opt_name_username, $opt_val_username );
		update_option( $opt_name_password, $opt_val_password );
		
		// Put an settings updated message on the screen
?>
<div class="updated"><p><strong><? _e('settings saved.', 'peers-me')?></strong></p></div>
<?
	}
	
	// Now display the settings editing screen
	
	echo '<div class="wrap">';
	echo '	<h2>Peers.me</h2>';
	echo '	<p>Welcome at the Peers.me options page</p>';

	// Settings form
?>
<form name="peers-me" method="post" action="">
	<input type="hidden" name="<? echo $hidden_field_name; ?>" value="Y">
	<p>
		<label width="800px">Peers.me address</label>
		<input type="text" name="<? echo $data_field_name_address; ?>" value="<? echo $opt_val_address; ?>" size="40">
	</p>
	<p>
		<label>Peers.me API username</label>
		<input type="text" name="<? echo $data_field_name_username; ?>" value="<? echo $opt_val_username; ?>" size="40">
	</p>
	<p>
		<label>Peers.me API password</label>
		<input type="password" name="<? echo $data_field_name_password; ?>" value="<? echo $opt_val_password; ?>" size="40">
	</p>
	
	
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<? esc_attr_e('Save Changes'); ?>" />
	</p>
	
</form>

	<p>Choose your templates:</p>
	<p>Default</p>
<?
	//Close wrap div
	echo '</div>';
}


function xml_value($xml_value,$value){
	$output = $xml_value->getElementsByTagName("$value")->item(0)->nodeValue;
	return $output;
}

function get_xml($url,$offset){
	$peers_user_pass = get_option ('peers_me_username').":".get_option ('peers_me_password');
	$peers_me_address = get_option ('peers_me_address')."/api/";
	//offset aanpassen, is nog niet meegegeven
	if(isset($offset)) $offset = "?offset=".$offset;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $peers_me_address.$url);
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
		exit();
	}
	
	curl_close($ch);

	return $api_return;
}

function avatar_address($address, $size) {
	$peers_me_address = get_option ( 'peers_me_address' );
	$avatar = "http://".$peers_me_address."/api/addresses/".urlencode($address)."/avatars/".$size;
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
											// Make upper for; name, company_name, 
											// if($i->nodeName == "name") $i->nodeValue = ucwords($i->nodeValue);
											// if($i->nodeName == "company_name") $i->nodeValue = ucwords($i->nodeValue);
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