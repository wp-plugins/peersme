<?php
/*---------------------------------------------------------------------------
Would you like to use your own template?
1.) Copy this code in a other file and save it with the .tpl prefix (e.g. myfile.tpl)
2.) Change what you want at your own risk
3.) Select your template on settings page for use

*/

function peers_me_createwave_view($address,$email,$notice){

	$output = '<div class="psme-content">';

	// If there's a notice, parse it here
	if(!empty($notice)){
		$output .= "<h2>".$notice."</h2>";
	}
	
	// Start form
	$output .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" accept-charset="utf-8">';

	// use a hidden form field for checking the POST
	$output .= '	<input type="hidden" name="wave" value="posted"> ';
	
	// use three fields, email, subject and message
	$output .= '	<label>Your email address</label><input type="text" name="email" value="'.$_POST['email'].'" id="email"><br /><br />';
	$output .= '	<label>Subject</label><input type="text" name="subject" value="'.$_POST['subject'].'" id="subject"><br /><br />';
	$output .= '	<label>Message</label><textarea name="message">'.$_POST['message'].'</textarea><br /><br /> ';
	
	// submit button
	$output .= '	<input type="submit" value="Create wave"> ';

	$output .= '</form>';
	
	$output .= '</div>';

	return $output;
	
}

function peers_me_wavecreated_view($address){
	
	$output = '<div class="psme-content">';

	$output = "<span>Thanks for contacting ".$address."!</span>";
	
	$output .= '</div>';
	
	return $output;
}

?>