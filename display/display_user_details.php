<?php

include ("../connect/connect_to_mysql.php");
include ("../class/activities.class.php");

$owner_id = $_POST['owner_id'];

$viewer_id = $_POST['viewer_id'];

$activities = new activities($viewer_id);

$display = $activities->show_user_details($viewer_id, $owner_id);

echo $display;

?>