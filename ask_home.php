<?php

session_start();

include_once ("connect/connect_to_mysql.php");
include_once ("class/display.class.php");
include_once("check/check_user_log.php");
include_once ("class/bbcode.class.php");

$disp = new display();
$bbcode = new bbcode();

if (isset($_SESSION['id'])) {
      $id = $_SESSION['id'];
      $form = '<form method="post" name="ask_form" id="ask_form" enctype="multipart/form-data">
                 <strong>Title:</strong>&nbsp;
                 <input type="text" name="ask_title" id="ask_title" style="width: 40%;" /><br /><br />
                 <strong>Question: </strong><br />
                 <img src="images/bold.png" id="b" onclick="javascript: replace_selected_text(ask_question.id, this.id);" />
                 <img src="images/italic.png" id="i" onclick="javascript: replace_selected_text(ask_question.id, this.id);" />
                 <img src="images/underline.png" id="u" onclick="javascript: replace_selected_text(ask_question.id, this.id);"/>
                 <img src="images/youtube.gif" id="yt" onclick="javascript: replace_selected_text(ask_question.id, this.id);" />
                 <img src="images/insertimage.gif" id="img" onclick="javascript: enter_link(ask_question.id, this.id);"/>
                 <img src="images/createlink.gif" id="link" onclick="javascript: enter_link(ask_question.id, this.id);" />
                 <br />
                 <textarea name="ask_question" id="ask_question" rows="10" cols="80" style="resize: none;"></textarea><br /><br /><br />
                 
                 <strong>Regions of Interest: </strong><br />
                 <textarea name="interest_regions" id="interest_regions" rows="4" cols="80" style="resize: none;"></textarea>
                 <div style="font-weight: bold;">
                   * Please remember to seperate keywords with commas eg. <a style="color: blue;">"region1,region2,region3"</a>
                 </div>
                 <br /><br /><br />
                 
                 <strong>Upload Pictures: </strong>
                 <!-- <span><input type="file" name="question_picture" id="question_picture" onchange="javascript: check_files(this.form.id, qns_picture_check.id, this.id); return false;" /></span><input type="button" onclick="javascript: clearFileInput(question_picture.id);" value="Clear Picture" /><span name="qns_picture_check" id="qns_picture_check"></span> -->
                 <div id="post_qn_photos" class="form">
                   <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="350" height="75" id="upload_qn_photos" align="middle">
				     <param name="movie" value="swf/upload_qn_photos.swf" />
				     <param name="quality" value="high" />
				     <param name="bgcolor" value="#ffffff" />
				     <param name="play" value="true" />
				     <param name="loop" value="true" />
				     <param name="wmode" value="transparent" />
				     <param name="scale" value="showall" />
				     <param name="menu" value="true" />
				     <param name="devicefont" value="false" />
				     <param name="salign" value="" />
				     <param name="allowScriptAccess" value="always" />
                     <!--[if !IE]>-->
                       <embed type="application/x-shockwave-flash" width="350" height="75" src="swf/upload_qn_photos.swf" allowScriptAccess="always" quality="high" id="upload_qn_photos2" bgcolor="#ffffff" play="true" loop="true" wmode="transparent" scale="showall" menu="true" devicefont="false" salign=""></embed>
                     <!--<![endif]-->
                   </object>
			          
			       <div id="progress_bars">
                     <div id="progress_outer" style="width: 100px; height: 10px; border: 1px solid red; margin-top: 10px; margin-left: 20px; display: none;">
                       <div id="progress_inner" style="position: relative; height: 10px; background-color: purple; width: 0%;"></div>
                     </div>

                     <div id="qn_images_form"></div>
                     <!-- <input type="button" onclick="javascript: post_album();" value="Post photos" /> -->
                   </div>  
                   
                 </div>

                 <br />
                 <div style="font-weight: bold;">Upload Video: </div>
                 <div id="video_input_wrapper"><input type="file" name="question_video" id="question_video" class="video_upload" title="upload a video" onchange="javascript: check_files(this.form.id, qns_video_check.id, this.id); return false;" /></div>
                 <!-- <input type="button" onclick="javascript: clearFileInput(question_video.id);" value="Clear Video" /> --><br />
                 <span name="qns_video_check" id="qns_video_check"></span><br />
                 Allow to search for of searchkeys of other users to get more answers to your question:
                 <input name="use_metakeys" id="use_metakeys" type="checkbox" value="yes" /><br />
                 <input name="question_owner_id" id="question_owner_id" type="hidden" value="' . $id . '" />
                 <input name="activity" id="activity" type="hidden" value="ask" />
                 <input name="func" id="func" type="hidden" value="question" /> 
                 <!-- <input name="questionBtn" type="button" onclick="javascript:post_question2(total_questions.id);" value="Ask" /> -->
                 <a name="questionBtn" class="question_btns" onclick="javascript: post_question2(total_questions.id);">Ask</a>
               </form>
               <div id="text_preview" style="display: none; margin-top: 10px;"></div><br />
               ';
 
} else {
        $form = 'You have not logged in. Please <a href="login.php">log in</a> or <a href="register.php">register</a> to post a question';
} 

$category = 'question';

if (isset($_GET['arranged_by'])) {
      $arranged_by = $_GET['arranged_by'];
} else {
      $arranged_by = "date";
}

$show_questions = '';

if ($arranged_by == "date") {
      $sql_question = mysql_query("SELECT * FROM open_question ORDER BY question_id DESC LIMIT 20") or die("Error: selecting details from open_question.  " . mysql_error());
} else if ($arranged_by == "popular") {
      $sql_question = mysql_query("SELECT * FROM open_question ORDER BY views DESC LIMIT 20") or die("Error: selecting details from open_question.  " . mysql_error());
}

$no_of_questions = mysql_num_rows($sql_question);

while ($row = mysql_fetch_array($sql_question)) {
         $question_id = $row['question_id'];
         $question_title = $row['title'];
         $question = $row['question'];
         $question_created_time = $row['created_time'];
         $view = $row['views'];
         $question_owner_id = $row['owner_id']; 
         
         $sql_owner_details = mysql_query("SELECT username FROM user_details WHERE owner_id='$question_owner_id'") or die("Error: selecting details from user_details.  " . mysql_error());
         
         while ($userRow = mysql_fetch_array($sql_owner_details)) {
                  $owner_username = $userRow['username'];
         }
         
         $check_pic = 'members/' . $question_owner_id . '/image01.jpg';

         $question_owner_pic = $disp->display_pic($check_pic, $question_owner_id, 50, 50);
         
         $show_questions .= '
                              <table style="background-color:#FFF; cellpadding="5" width="100%">
                                <tr>
                                  <td width="10%" valign="top">' . $question_owner_pic . '</td>
                                  <td width="90%" valign="top" style="">' . $question_created_time . ' <a href="profile.php?id=' . $question_owner_id . '">' . $owner_username . '</a> asked:<br />
                                    <a href="answers.php?question_id=' . $question_id . '" style="">' . $question_title . '</a></td>
                                </tr>
                              </table>
                              ';
  
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Open question</title>
<link href="style/main.css" rel="stylesheet" type="text/css" />
<link href="style/header_user.css" rel="stylesheet" type="text/css" />
<link href="style/footer.css" rel="stylesheet" type="text/css" />
<link href="style/load_more_btn.css" rel="stylesheet" type="text/css" />
<link href="style/buttons.css" rel="stylesheet" type="text/css" />
<link href="style/file_inputs.css" rel="stylesheet" type="text/css" />

<link rel="icon" href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

<script src="js/jquery-1.5.js" type="text/javascript"></script>

<script src="js/search.js" type="text/javascript"></script>
<script src="js/open_question.js" type="text/javascript"></script>
<script src="js/bbcode.js" type="text/javascript"></script>
<script src="js/notification.js" type="text/javascript"></script>
<script src="js/chat.js" type="text/javascript"></script>

<style type="text/css">
<!--

#popup_backgnd {
      display: none;
      background: rgba(0, 0, 0, .9);
      bottom: 0;
      left: 0;
      // overflow: hidden;
      overflow-x: auto;
      overflow-y: scroll;
      position: fixed;
      right: 0;
      top: 0;
      z-index: 6;
}

#album_ss {
      display: none;
      position: absolute;
      left: 50%;
      top: 50%;
      z-index: 7;
      
}

#next {
      display: none;
      position: absolute;
      top: 50%;
      right: 0;
      margin-top: -25px;
      margin-right: 20px;
      z-index: 7;
}

#previous {
      display: none;
      position: absolute;
      top: 50%;
      left: 0;
      margin-top: -25px;
      margin-left: 20px;
      z-index: 7;
}

-->
</style>

<script type="text/javascript">

Id = '<?php echo $id; ?>';
Arranged_by = '<?php echo $arranged_by; ?>';

$(document).ready(function () {
    show_initial_question ();
});

$(document).ready(function(){
	  $('.load_more_questions').live("click",function() {
	      var last_question_id = $(this).attr("id");
	      var Func = 'show_more_questions';

	      if(last_question_id!='end'){
	           $('.load_more_questions').append('<img src="images/facebook_style_loader.gif" />');
                   if (Arranged_by == "popular") {
                         last_question_id = $(this).attr("data-views");
                   }

	               // $.post("debug_script/test_post.php", {lastmsg:last_msg_id,user_id:id},

	               $.post("display/display_questions.php", {question_id: last_question_id, arranged_by: Arranged_by, func: Func}, function(html){
	                        $(".load_more_questions").remove();
		                    $("#show_questions").append(html);
	               }); 
	      } 

	      // return false;
	  });
	});

$('#ask_form').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});

</script>
</head>

<body>
<div id="popup_backgnd" tabindex="0">
  <div id="album_ss"></div>
  <img src="images/next.png" id="next" width="50px" height="50px" />
  <img src="images/previous.png" id="previous" width="50px" height="50px" />
</div>

<?php include_once "userhome_header2.php"; ?><br /><br />

<div style="width: 1000px; margin: 0 auto;">
  <div style="width: 70%; font-style: arial; font-size: 12px;">
    <!-- <button id="question_button" onclick="javascript: show_question_form();">Ask a question</button><br /><br /> -->
      
    <div id="error_message" style="display: none;"></div>
    <a class="open_close_form" id="click_to_ask" title="Click here to open or close question form" onclick="javascript: show_form('question_form'); show_converted_text(ask_question.id);" onmouseover="javascript: hover_qna_btn(this);" onmouseout="javascript: leave_qna_btn(this);" style="font-size: 12px; padding: 5px 10px;">Ask question</a><br /><br />
    <div id="question_form" style="text-align: left; display: none; border: 1px solid #E9E9E9; margin: 0 auto; padding: 10px;">
      <?php echo $form; ?>
    </div>
      
    <div name="total_questions" id="total_questions" style="font-weight: bold; font-size: 20px; text-decoration: underline; margin-top: 10px;">Questions(<?php  echo $no_of_questions; ?>)</div>
      
    <div id="show_questions" style="width: 100%; margin-top: 10px;">
      <?php // echo $show_questions; ?>
    </div>

    <!-- <div id="<?php echo $question_id; ?>" class="load_more_questions" onclick="javascript: load_more_questions(this.id);">Load More Questions <img src="images/arrow1.png" /></div> -->
       
  </div>
</div>

<br /><br />
<?php include_once "footer.php"; ?>

</body>
</html>
