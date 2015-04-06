<?php

session_start();

// include ("../check/check_user_log.php");

include ("../connect/connect_to_mysql.php");

include ("../class/ask.class.php");

// $id = $_POST['id'];
// $id = strip_tags($id);
// $id = mysql_real_escape_string($id);

$viewer_id = $_POST['viewer_id'];

$func = $_POST['func'];
// $func = strip_tags($func);
$func = mysql_real_escape_string($func);

$question_id = $_POST['question_id'];

$answer = new ask();

$display_answer = $answer->show_answers($viewer_id, $question_id);

$answer_id = $answer->getAnswerId();

$numRows = $answer->getAnswerRows();

if ($func == "show_initial_answers") {
      echo $display_answer;
}

if ($func == "load_more_answers") {
      if ($numRows == 5){
            echo '<div id="' . $answer_id . '" class="load_more_answers" >Show More Answers <img src="images/arrow1.png" /></div>';
      } else {
            echo '<div id="end" class="no_more_answers" >No More Answers</div>';
      }
      // echo '<div class="load_more">' . $question_id . '</div>';
}

if ($func == "show_more_answers") {
      $last_answer_id = $_POST['answer_id'];
      $more_answer = new ask();
      
      $display_more_answer = $more_answer->show_answers($viewer_id, $question_id, $last_answer_id);

      $more_answer_id = $more_answer->getAnswerId();

      $moreRows = $more_answer->getAnswerRows();
      
      echo $display_more_answer;
      
      if ($moreRows == 5){
            echo '<div id="' . $more_answer_id . '" class="load_more_answers" >Show More Answers <img src="images/arrow1.png" /></div>';
      } else {
            echo '<div id="end" class="no_more_answers" >No More Answers</div>';
      }
}

?>