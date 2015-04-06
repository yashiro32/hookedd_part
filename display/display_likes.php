<?php

  include ("/var/www/html/connect/connect_to_mysql.php");
  include ("/var/www/html/class/like.class.php");

  $viewer_id = $_POST['viewer_id'];

  $object_id = $_POST['object_id'];

  $object_type = $_POST['object_type'];

  $func = $_POST['func'];

  $like = new like();

  $display = "";

  if ($func == "likes") {
        $display = $like->show_like_users($viewer_id, $object_id, $object_type);
  } 
  
  if ($func == "show_more_likes") {
        $last_like_id = $_POST['last_like_id'];
        $display = $like->show_like_users($viewer_id, $object_id, $object_type, $last_like_id);
  }
  
  echo $display;

?>