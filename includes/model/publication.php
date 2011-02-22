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
	if(!isset($atts['limit']))
		$atts['limit'] = 100;
	
	$publications_array = $publications_sorted;

	if(!empty($publications_array)) { 
			//start index tpl includen //////////////////// TODO
			$i = 1;
			if($widget == true || !empty($atts['widget']) == true){
	      foreach($publications_array as $publication) { 
					
					// check if wave_id is already in output
	        if(in_array($publication['wave_id'],$arr) == false){
							
							// if limited
							if($i <= $atts['limit'])
								$output .= peers_me_index_publication_item_widget($publication);

					}

					$arr[] = $publication['wave_id'];
					$i++;
					
	      } 
			} else {
	      foreach($publications_array as $publication) { 

					// check if wave_id is already in output
					if(in_array($publication['wave_id'],$arr) == false){
					
						// if limited
						if($i <= $atts['limit'])
							$output .= peers_me_index_publication_item($publication,$publications_xml);
					
					}

					$arr[] = $publication['wave_id'];
					$i++;					
	      } 
			}
	  }
	
	return $output;
}

function peers_me_publication($wave_id){
	// echo $wave_id;
	$publication_xml = get_xml("publications/".urlencode($wave_id),0);
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