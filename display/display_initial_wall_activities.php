<?php

session_start();

// include ("../check/check_user_log.php");

include ("../connect/connect_to_mysql.php");

include ("../class/wallActivities.class.php");

$id = $_POST['id'];
$id = strip_tags($id);
$id = mysql_real_escape_string($id);

$profile_id = $_POST['profile_id'];
$profile_id = strip_tags($profile_id);
$profile_id = mysql_real_escape_string($profile_id);

$func = $_POST['func'];
$func = strip_tags($func);
$func = mysql_real_escape_string($func);

$wall_activities = new wallActivities($id);

$friend_arrays = $wall_activities->getFriendArrays();

$wall_activities->select_privacy_wall_activities ($friend_arrays, $profile_id);

$display = $wall_activities->getDisplayStatus();

$activity_id = $wall_activities->getActivityId();

$numRows = $wall_activities->getNumRows();

if ($func == "wall_activities") {
      echo $display;
}

if ($func == "load_more") {
      if ($numRows == 5){
            echo '<div id="' . $activity_id . '" class="load_more" >Show Older Posts <img src="images/arrow1.png" /></div>';
      } else {
            echo '<div id="end" class="no_more" >No More Wall Posts</div>';
      }
      // echo '<div class="load_more">' . $activity_id . '</div>';
      // echo $activity_id;
}

// echo $activity_id;

// echo "FGHBDFBDFBDFBDFDFB";

// echo $id;

?>
