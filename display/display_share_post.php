<?php

  include ("/var/www/html/connect/connect_to_mysql.php");
  include ("/var/www/html/class/share.class.php");

  $viewer_id = $_POST['viewer_id'];

  $object_id = $_POST['object_id'];

  $object_type = $_POST['object_type'];

  $share = new share();

  $display = "";

  if ($object_type == "status") {
        $display = $share->show_status_for_share($object_id, $object_type);

  } else if ($object_type == "photo") {
        $display = $share->show_photo_for_share($object_id, $object_type);

  } else if ($object_type == "video") { 
        $display = $share->show_video_for_share($object_id, $object_type);

  } else if ($object_type == "link") {
        $display = $share->show_link_for_share($object_id, $object_type);

  } else if ($object_type == "album") {
        $display = $share->show_album_for_share($object_id, $object_type);

  } else if ($object_type == "answer") {
        $display = $share->show_answer_for_share($object_id, $object_type);

  } else if ($object_type == "question") {
        $display = $share->show_question_for_share($object_id, $object_type);

  }

  echo $display;

?>