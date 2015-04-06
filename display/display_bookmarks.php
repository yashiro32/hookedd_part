<?php

session_start();

// include ("../check/check_user_log.php");

include ("/var/www/html/connect/connect_to_mysql.php");

include ("/var/www/html/class/bookmark.class.php");

$owner_id = $_POST['owner_id'];
$owner_id = strip_tags($owner_id);
$owner_id = mysql_real_escape_string($owner_id);

$object_type = $_POST['object_type'];
$object_type = strip_tags($object_type);
$object_type = mysql_real_escape_string($object_type);

$func = $_POST['func'];
$func = strip_tags($func);
$func = mysql_real_escape_string($func);

if ($func == "bookmarks") {
      $bookmark = new bookmark();

      $bookmark->show_bookmarks($owner_id, $object_type);

      $display = $bookmark->getDisplayStatus();
      
      $bookmark_id = $bookmark->getActivityId();
      
      $numRows = $bookmark->getNumRows();

      echo $display;

      if ($numRows == 5){
            echo '<div id="' . $bookmark_id . '" class="load_more_bms" data-object_type="' . $object_type . '">Show More Bookmarks <img src="images/arrow1.png" /></div>';
      } else {
            echo '<div id="end" class="no_more_bms">No More Bookmarks</div>';
      }
      
}

if ($func == "show_more_bookmarks") {
      $last_bookmark_id = $_POST['bookmark_id'];
      $more_bookmark = new bookmark();
      
      $more_bookmark->show_bookmarks($owner_id, $object_type, $last_bookmark_id);
      
      $display_more_bookmark = $more_bookmark->getDisplayStatus();

      $more_bookmark_id = $more_bookmark->getActivityId();

      $moreRows = $more_bookmark->getNumRows();
      
      echo $display_more_bookmark;
      
      if ($moreRows == 5){
            echo '<div id="' . $more_bookmark_id . '" class="load_more_bms" data-object_type="' . $object_type . '">Show More Bookmarks <img src="images/arrow1.png" /></div>';
      } else {
            echo '<div id="end" class="no_more_bms">No More Bookmarks</div>';
      }
}

?>
