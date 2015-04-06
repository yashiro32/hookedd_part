<?php

session_start();

include ("check/check_user_log.php");

include_once ("connect/connect_to_mysql.php");

include ("class/activities.class.php");

$id = $_SESSION['id'];

$activities = new activities($id);

$display = $activities->getDisplayStatus();

$activity_id = $activities->getActivityId();

$numRows = $activities->getNumRows();

// echo $display;

// echo $activity_id;

// echo "FGHBDFBDFBDFBDFDFB";

// echo $id;

?>