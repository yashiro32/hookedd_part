<?php

  include_once ("/var/www/html/connect/connect_to_mysql.php");
  include_once ("/var/www/html/class/bookmark.class.php");

  $viewer_id = $_POST['viewer_id'];

  $object_id = $_POST['object_id'];

  $object_type = $_POST['object_type'];

  $func = $_POST['func'];

  $bookmark = new bookmark();

  $display = "";

  if ($func == "bookmarks") {
        $display = $bookmark->show_bookmark_users($viewer_id, $object_id, $object_type);
  } 
  
  if ($func == "show_more_bookmarks") {
        $last_bm_id = $_POST['last_bm_id'];
        $display = $bookmark->show_bookmark_users($viewer_id, $object_id, $object_type, $last_bm_id);
  }
  
  echo $display;

?>