<?php

session_start();

include ("check/check_user_log.php");

include ("connect/connect_to_mysql.php");

include ("class/wallActivities.class.php");

$id = $_SESSION['id'];

$wall_activities = new wallActivities($id);

$friend_arrays = $wall_activities->getFriendArrays();

// $wall_activities->select_wall_activities ($friend_arrays, $profile_id);

$wall_activities->select_privacy_wall_activities ($friend_arrays, $profile_id);

$wall_display = $wall_activities->getDisplayStatus();

$wall_activity_id = $wall_activities->getActivityId();

$numRows = $wall_activities->getNumRows();

// echo $display;

// echo $activity_id;

// echo "FGHBDFBDFBDFBDFDFB";

// echo $id;

?>