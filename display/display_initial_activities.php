<?php

  // session_start();

  // include ("../check/check_user_log.php");

  include_once ("../connect/connect_to_mysql.php");

  include_once ("../class/activities.class.php");

  $id = $_POST['id'];
  $id = strip_tags($id);
  $id = mysql_real_escape_string($id);

  $func = $_POST['func'];
  $func = strip_tags($func);
  $func = mysql_real_escape_string($func);

  // $activities = new activities($id);

  // $display = $activities->getDisplayStatus();
  // $activity_id = $activities->getActivityId();
  // $numRows = $activities->getNumRows();
  
  // $display = "";

  if ($func == "activities") {
        $activities = new activities($id);
        $display = $activities->getDisplayStatus();
        $activity_id = $activities->getActivityId();
        $latest_activity_id = $activities->getLatestActId();
        $numRows = $activities->getNumRows();

        echo $display;

        if ($numRows == 5){
              echo '<div id="' . $activity_id . '" class="load_more" >Show Older Posts <img src="images/arrow1.png" /></div>';
        } else {
              echo '<div id="end" class="no_more" >No More Posts</div>';
        }
        // echo '<div class="load_more">' . $activity_id . '</div>';
        
        echo '<div class="store_act_id" data-act_id="' . $latest_activity_id . '"></div>';

  }

  else if ($func == "load_more") {
        $lastmsg = $_POST['lastmsg'];
        $lastmsg = strip_tags($lastmsg);
        $lastmsg = mysql_real_escape_string($lastmsg);
  
        $activities = new activities($id, $lastmsg);
        $display = $activities->getDisplayStatus();
        $activity_id = $activities->getActivityId();
        $numRows = $activities->getNumRows();

        if ($numRows == 5){
              echo '<div id="' . $activity_id . '" class="load_more" >Show Older Posts <img src="images/arrow1.png" /></div>';
        } else {
              echo '<div id="end" class="no_more" >No More Posts</div>';
        }
        
        // echo '<div class="load_more">' . $activity_id . '</div>';
  }
  
  if ($func == "update") {
        $latest_act_id = $_POST['latest_act_id'];
        $latest_act_id = strip_tags($latest_act_id);
        $latest_act_id = mysql_real_escape_string($latest_act_id);
        
        $activities = new activities($id);
        $activities->update_latest_activities($id, $latest_act_id);
        
        $display = $activities->getDisplayStatus();
        
        $activity_id = $activities->getActivityId();
        $new_latest_act_id = $activities->getLatestActId ();
        $numRows = $activities->getNumRows();
        
        if  ($display != "") {
               echo $display;
        
               echo '<div class="store_act_id" data-act_id="' . $new_latest_act_id . '" data-num_rows="' . $numRows . '"></div>';
        } else { 
               echo "";
        }
        
  }

  // echo $activity_id;

  // echo $id;
  
?>