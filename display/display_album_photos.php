<?php

  include ("../connect/connect_to_mysql.php");
  
  include ("../class/wallActivities.class.php");

  $viewer_id = $_POST['viewer_id'];
  $owner_id = $_POST['owner_id'];
  $album_id = $_POST['album_id'];

  $wall_activities = new wallActivities($viewer_id);
  
  $show_photos = $wall_activities->show_album_photos($viewer_id, $owner_id, $album_id);
  
  echo $show_photos;
  // echo $album_id;
 
?>