<?
/*
Function for: Publication index, publication
Resource: publications.xml
Available values in index: 
Available values in publication: 
*/

function peers_me_publications_index($atts,$address = "",$widget=false){
	if(!empty($address)){
		$publications_xml = get_xml("publications?placements=".$address,0);
		// $atts['limit'] = 5;
	} else {
		$publications_xml = get_xml("publications.xml",0);
	}
	$publications_raw = xml_to_array($publications_xml,"publication");
	//sorting
	if(isset($atts['on'])){
		$publications_sorted = array_sort($publications_raw,$atts['on'],$atts['sort']);
	} else {
		$publications_sorted = array_sort($publications_raw,"created_at","DESC");
	}
	//limiting
	if(isset($atts['limit'])){
		$publications_limited = array_slice($publications_sorted, 0, $atts['limit']);
	} else {
		$publications_limited = $publications_sorted;
	}
	$publications_array = $publications_limited;
	$output = '';
	if(!empty($publications_array)) { 
			//start index tpl includen //////////////////// TODO
			if($widget == true || !empty($atts['widget']) == true){
	      foreach($publications_array as $publication) { 
	         $output .= peers_me_index_publication_item_widget($publication);
	      } 
			} else {
	      foreach($publications_array as $publication) { 
	         $output .= peers_me_index_publication_item($publication);
	      } 
			}
			//end index tpl includen //////////////////// TODO
  }
	// $output = $publications_xml;
	return $output;
}

function peers_me_publication($wave_id){
	$publication_xml = get_xml("publications/".urlencode($_GET['wave_id']),0);
	$publication_raw = xml_to_array($publication_xml,"publication");
	if(!empty($publication_raw)) { 
		$output = '';
		foreach($publication_raw as $publication) { 
	    	$output .= peers_me_publication_view($publication);
	    }
	  }
	return $output;
}

function peers_me_publications($atts){
	//address checken???
	if(!empty($_GET['wave_id'])){
		$output = peers_me_publication($_GET['wave_id']);
	} else {
		//show index
		$output = peers_me_publication_index($atts);
	}
	return $output;
}

?>