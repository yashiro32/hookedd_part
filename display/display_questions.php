<?php

session_start();

// include ("../check/check_user_log.php");

include ("../connect/connect_to_mysql.php");

include ("../class/ask.class.php");

// $id = $_POST['id'];
// $id = strip_tags($id);
// $id = mysql_real_escape_string($id);

$func = $_POST['func'];
// $func = strip_tags($func);
$func = mysql_real_escape_string($func);

$arranged_by = $_POST['arranged_by'];
// $func = strip_tags($func);
$arranged_by = mysql_real_escape_string($arranged_by);

$question = new ask();

if ($func == "show_initial_questions") {
      $display_question = $question->show_questions($arranged_by);
      
      $question_id = $question->getQuestionId();

      $numRows = $question->getQuestionRows();
      
      echo $display_question;
}

if ($func == "load_more_questions") {
      $display_question = $question->show_questions($arranged_by);
      
      $question_id = $question->getQuestionId();

      $numRows = $question->getQuestionRows();
      
      if ($numRows == 5){
            echo '<div id="' . $question_id . '" class="load_more_questions" >Show More Questions <img src="images/arrow1.png" /></div>';
      } else {
            echo '<div id="end" class="no_more_questions" >No More Questions</div>';
      }
      // echo '<div class="load_more">' . $question_id . '</div>';
}

if ($func == "show_more_questions") {
      $last_question_id = $_POST['question_id'];
      $more_question = new ask();
      
      $display_more_question = $more_question->show_questions($arranged_by, $last_question_id);

      $more_question_id = $more_question->getQuestionId();

      $moreRows = $more_question->getQuestionRows();
      
      echo $display_more_question;
      
      /* if ($moreRows == 5){
            echo '<div id="' . $more_question_id . '" class="load_more_questions" >Show More Questions <img src="images/arrow1.png" /></div>';
      } else {
            echo '<div id="end" class="no_more_questions" >No More Questions</div>';
      } */
}

?>