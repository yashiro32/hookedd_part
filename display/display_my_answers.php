<?php

session_start();

// include_once ("../check/check_user_log.php");

include_once ("/var/www/html/connect/connect_to_mysql.php");

include_once ("/var/www/html/class/ask.class.php");

$owner_id = $_POST['owner_id'];
$owner_id = strip_tags($owner_id);
$owner_id = mysql_real_escape_string($owner_id);

$arranged_by = $_POST['arranged_by'];
$arranged_by = strip_tags($arranged_by);
$arranged_by = mysql_real_escape_string($arranged_by);

$func = $_POST['func'];
$func = strip_tags($func);
$func = mysql_real_escape_string($func);

if ($func == "initial_my_answers") {
      $ask = new ask();

      $display = $ask->show_my_answers($owner_id, $arranged_by);

      echo $display;
      
}

if ($func == "show_more_my_answers") {
      $last_ans_id = $_POST['last_ans_id'];
      $more_ans = new ask();
      
      $display_more_answers = $more_ans->show_my_answers($owner_id, $arranged_by, $last_ans_id);
           
      echo $display_more_answers;
      
}

?>


