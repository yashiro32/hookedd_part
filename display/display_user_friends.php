<?php

include ("../class/friends.class.php");
include ("../connect/connect_to_mysql.php");

$id = $_POST['id'];
$id = strip_tags($id);
$id = mysql_real_escape_string($id);

$func = $_POST['func'];
$func = strip_tags($func);
$func = mysql_real_escape_string($func);

$frnds = new friends();

if ($func == 'load_friends') {
      $friends_list = $frnds->show_user_friends($id);
}

if ($func == 'load_more_friends') {
       $last_count = $_POST['last_count'];
       $last_count = strip_tags($last_count);
       $last_count = mysql_real_escape_string($last_count);
  
       $friends_list = $frnds->show_user_friends($id, $last_count);
       // $friends_list = "fgddfgdfgf";
}

if ($func == 'show_count_header') {
      $friends_list = $frnds->show_user_frnds_count($id);
}

echo $friends_list;

?>