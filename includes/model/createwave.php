<?
/*
Function: Create Wave
Description: Create a Wave by posting a form at WordPress page. The email is temporary untill the API accepts wave addresses.
Shortcode: [peersme create="wave" address="(address of user/group)" email="(email of user)"]
Date: August 6, 2011
By: Daniël Steginga
*/

function peers_me_createwave($address,$email){
	global $peers_me_username, $peers_me_password, $peers_me_address;
	
	// check if form is posted
	if($_POST['wave'] == "posted"){

		// is posted, so check fields
		$notice = "";

		if(!$_POST['email']) $notice .= "No email address provided.<br />";
		if(!$_POST['subject']) $notice .= "No subject provided.<br />";
		if(!$_POST['message']) $notice .= "No message provided.<br />";
		
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_POST['email'])) {
			$notice .= "Email address isn't correct. Please check it.<br />";
		}
		
		// check if $notice has any messages
		if($notice != ""){

			// display form with notice(s)
			$output .= peers_me_createwave_view($address,$email,$notice);			

		} else {

			// set data array
			// use $email for now, in the future this will be changed to the wave address
			$data = array(	'email' => $_POST['email'].",".$email, //add $email after comma
							'title' => $_POST['subject'],
							'text' => $_POST['message']
			);
			
			// build URL
			$peers_me_api_address = "https://".$peers_me_address."/api/waves";

			// Get credentials and put them in header
			$headers = array( 'Authorization' => 'Basic ' . base64_encode( "$peers_me_username:$peers_me_password" ) );
			
			// Use WordPress remote post to post the data to the url
			$response = wp_remote_post($peers_me_api_address, array( 	'method' => 'POST', 
															'timeout' => 45,
															'redirection' => 5,
															'httpversion' => '1.0',
															'blocking' => true,
															'headers' => $headers, 
															'body' => $data,
															'sslverify' => false ));
			
			if( is_wp_error( $response ) ) {

				// Oops, something went wrong
				$notice = 'Something went wrong!';
				$output = peers_me_createwave_view($address,$email,$notice);
				print_r( $response );

			} else {
				
				// Display a nice message to the user
				$output = peers_me_wavecreated_view($address);
				
			}
			
		}
		



	} else {
		// isn't posted, so display form

		$output = peers_me_createwave_view($address,$email,$notice);
		
	}

	return $output;
		
}

?>