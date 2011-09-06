<?

//check which templates are chosen

$opt_name_group_template = 'peers_me_group_template';
$opt_name_user_template = 'peers_me_user_template';
$opt_name_publication_template = 'peers_me_publication_template';
$opt_name_createwave_template = 'peers_me_createwave_template';

$opt_val_group_template = get_option ( $opt_name_group_template );
$opt_val_user_template = get_option ( $opt_name_user_template );
$opt_val_publication_template = get_option ( $opt_name_publication_template );
$opt_val_createwave_template = get_option ( $opt_name_createwave_template );

// if empty, default.tpl
if(empty($opt_val_user_template)) $opt_val_user_template = "default.tpl";
if(empty($opt_val_group_template)) $opt_val_group_template = "default.tpl";
if(empty($opt_val_publication_template)) $opt_val_publication_template = "default.tpl";
if(empty($opt_val_createwave_template)) $opt_val_createwave_template = "default.tpl";

include('templates/user/'.$opt_val_user_template);
include('templates/group/'.$opt_val_group_template);
include('templates/publication/'.$opt_val_publication_template);
include('templates/createwave/'.$opt_val_createwave_template);


?>