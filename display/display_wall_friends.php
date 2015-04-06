<?php

include ("../class/friends.class.php");
include ("../connect/connect_to_mysql.php");

$viewer_id = $_POST['id'];
$viewer_id = strip_tags($viewer_id);
$viewer_id = mysql_real_escape_string($viewer_id);

$profile_id = $_POST['profile_id'];
$profile_id = strip_tags($profile_id);
$profile_id = mysql_real_escape_string($profile_id);

$func = $_POST['func'];
$func = strip_tags($func);
$func = mysql_real_escape_string($func);

$frnds = new friends();

if ($func == 'load_friends') {
      $friends_list = $frnds->show_profile_owner_friends($viewer_id, $profile_id);
}

if ($func == 'load_more_friends') {
       $last_count = $_POST['last_count'];
       $last_count = strip_tags($last_count);
       $last_count = mysql_real_escape_string($last_count);
       
       $friends_list = $frnds->show_profile_owner_friends($viewer_id, $profile_id, $last_count);
       // $friends_list = "fgddfgdfgf";
}

if ($func == 'show_count_header') {
       $friends_list = $frnds->show_profile_frnds_count($viewer_id, $profile_id);
}

echo $friends_list;

?>
