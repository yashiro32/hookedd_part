<?php

  include ("/var/www/html/class/events.class.php");

  include ("/var/www/html/connect/connect_to_mysql.php");

  $event_id = $_POST['event_id'];

  $viewer_id = $_POST['viewer_id'];

  $func = $_POST['func']; 

  $display = "";

  $event = new events();
  
  if ($func == "show_initial_events") {
        $display = $event->show_events($viewer_id);  
  }

  if ($func == "invitees") {
        $display = $event->show_invitees($event_id, $viewer_id);
  }
  
  if ($func == "event_status") {
        // $display = $event->show_event_statuses();
        $event->show_event_statuses($viewer_id);
        $event->select_event_activities($viewer_id, $event_id);
        $display = $event->getDisplayStatus();
        $activity_id = $event->getActivityId();
        $numRows = $event->getNumRows();
        
        if ($numRows == 5){
              $display .= '<div id="' . $activity_id . '" class="load_more" >Show Older Posts <img src="images/arrow1.png" /></div>';
        } else {
              $display .= '<div id="end" class="no_more" >No More Posts</div>';
        }
  }
  
  if ($func == "load_more") {
        $lastmsg = $_POST['lastmsg'];
        $lastmsg = strip_tags($lastmsg);
        $lastmsg = mysql_real_escape_string($lastmsg);
        
        $event->show_event_statuses($viewer_id);
        $event->select_event_activities($viewer_id, $event_id, $lastmsg);
        $display = $event->getDisplayStatus();
        $activity_id = $event->getActivityId();
        $numRows = $event->getNumRows();
        
        if ($numRows == 5){
              $display .= '<div id="' . $activity_id . '" class="load_more" >Show Older Posts <img src="images/arrow1.png" /></div>';
        } else {
              $display .= '<div id="end" class="no_more" >No More Posts</div>';
        }
      
  }
  
  echo $display;

?>