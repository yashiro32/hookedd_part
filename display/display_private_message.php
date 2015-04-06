<?php

session_start();

include ("../connect/connect_to_mysql.php");

include ("../class/pm.class.php");

// $id = $_SESSION['id'];

$id = $_POST['id'];
$id = strip_tags($id);
$id = mysql_real_escape_string($id);

$func = $_POST['func'];
$func = strip_tags($func);
$func = mysql_real_escape_string($func);

$pm_id = '';

$pm = new pm();

// $display_whole_message = $pm->display_whole_message($id);

if ($func == 'show_msg_inbox') {
      $display_pm = $pm->display_receive_list($id);
}

if ($func == 'show_msg_outbox') {
      $display_pm = $pm->display_sent_list($id);
}

if ($func == 'show_search_msg') {
      $search_string = $_POST['search_string'];
      $owner_id = $_POST['owner_id'];
      $display_pm = $pm->search_pm($search_string, $owner_id);
}

if ($func == 'show_whole_message') {
      $pm_id = $_POST['pm_id'];
      $viewer_type = $_POST['viewer_type'];
      $display_pm = $pm->display_whole_message($pm_id, $id, $viewer_type);
}

if ($func == 'show_more_inbox_list') {
      $last_msg_id = $_POST['lastmsg'];
      $display_pm = $pm->display_receive_list($id, $last_msg_id);
}

if ($func == 'show_more_outbox_list') {
      $last_msg_id = $_POST['lastmsg'];
      $display_pm = $pm->display_sent_list($id, $last_msg_id);
}

if ($func == 'show_more_whole_msg') {
      $pm_id = $_POST['pm_id'];
      $viewer_type = $_POST['viewer_type'];
      $display_pm = $pm->display_whole_message($pm_id, $id, $viewer_type);
}

if ($func == 'show_more_search_msg') {
      $search_string = $_POST['search_string'];
      $owner_id = $_POST['owner_id'];
      $last_msg_id = $_POST['lastmsg'];
      $display_pm = $pm->search_pm($search_string, $owner_id, $last_msg_id);
}

echo $display_pm;

?>







