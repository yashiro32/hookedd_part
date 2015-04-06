<?php

session_start();

include_once ("connect/connect_to_mysql.php");
include_once ("class/display.class.php");
// include_once("check/check_user_log.php");
include_once ("class/bbcode.class.php");
include_once ("/var/www/html/class/ask.class.php");
include_once ("class/ads.class.php");

$disp = new display();

$bbcode = new bbcode();

$ask = new ask();

$ads = new ads();

if ($_GET['question_id'] != "") {
      $question_id = $_GET['question_id'];
      $question_id = strip_tags($question_id);
      $question_id = mysql_real_escape_string($question_id);
} else {
      header("location: ask_home.php");
      exit();
}

$this_script = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// echo $_SERVER['REQUEST_URI'];

include_once ("view/question_views.php");

if (isset($_SESSION['id'])) {
      $id = $_SESSION['id'];
      
      $check_pic = "members/$id/image01.jpg";
      $default_pic = "members/0/image01.jpg";
    
      if (file_exists($check_pic)) {
            $user_pic_addr = $check_pic;
      } else {
            $user_pic_addr = $default_pic;
      }
      
      $answer_form = '<form method="post" name="ans_form" id="ans_form" enctype="multipart/form-data">
                        <strong>Your Answer:</strong><br /><br />
                        <img src="images/bold.png" id="b" onclick="javascript: replace_selected_text(answer_question.id, this.id);" />
                        <img src="images/italic.png" id="i" onclick="javascript: replace_selected_text(answer_question.id, this.id);" />
                        <img src="images/underline.png" id="u" onclick="javascript: replace_selected_text(answer_question.id, this.id);"/>
                        <img src="images/youtube.gif" id="yt" onclick="javascript: replace_selected_text(answer_question.id, this.id);" />
                        <img src="images/insertimage.gif" id="img" onclick="javascript: enter_link(answer_question.id, this.id);"/>
                        <img src="images/createlink.gif" id="link" onclick="javascript: enter_link(answer_question.id, this.id);" />
                        <br /><textarea name="answer_question" id="answer_question" class="formFields" onclick="javascript: show_converted_text(this.id);" rows="10" cols="80" style="resize: none;"></textarea><br /><br />
                        <strong>Upload Pictures: </strong>
                        <!-- <input type="file" name="answer_picture" id="answer_picture" onchange="javascript: check_files(this.form.id, ans_picture_check.id); return false;" /><span name="ans_picture_check" id="ans_picture_check"></span> -->
                        <div id="post_ans_photos" class="form">
                          <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="350" height="75" id="upload_ans_photos" align="middle">
				            <param name="movie" value="swf/upload_ans_photos.swf" />
				            <param name="quality" value="high" />
				            <param name="bgcolor" value="#ffffff" />
				            <param name="play" value="true" />
				            <param name="loop" value="true" />
				            <param name="wmode" value="transparent" />
				            <param name="scale" value="showall" />
				            <param name="menu" value="true" />
				            <param name="devicefont" value="false" />
				            <param name="salign" value="" />
				            <param name="allowScriptAccess" value="sameDomain" />
                            <!--[if !IE]>-->
                              <embed type="application/x-shockwave-flash" width="350" height="75" src="swf/upload_ans_photos.swf" allowScriptAccess="sameDomain" quality="high" id="upload_ans_photos2" bgcolor="#ffffff" play="true" loop="true" wmode="transparent" scale="showall" menu="true" devicefont="false" salign=""></embed>
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
                        <div id="video_input_wrapper"><input type="file" name="answer_video" id="answer_video" class="video_upload" title="upload a video" onchange="javascript: check_files(this.form.id, ans_video_check.id); return false;" /></div>
                        <span name="qns_video_check" id="qns_video_check"></span><br />
                        <!-- <input type="button" onclick="javascript: preview_textarea(answer_question.id);" value="Preview" /> --><br />
                        <input name="question_id" id="question_id" type="hidden" value=' . $question_id . ' />
                        <input name="ans_owner_id" id="ans_owner_id" type="hidden" value=' . $id . ' />
                        <input name="func" id="func" type="hidden" value="answer" />
                        <input name="activity" id="activity" type="hidden" value="answer" />
                        <!-- <input name="answerBtn" type="button" onclick="javascript:post_answer2(' . $question_id . ', total_answers.id)" value="Answer" /> -->
                        <a name="answerBtn" class="question_btns" onclick="javascript:post_answer2(' . $question_id . ', total_answers.id)">Answer</a> 
                      </form><br />
                      <div id="text_preview" style="display: none;"></div>
                      <br />
                      ';
      
} else {
        $answer_form = 'You have not logged in. Please <a class="normal_link" href="login.php" style="font-weight: bold;">log in here</a> or <a class="normal_link" href="register.php" style="font-weight: bold;">register here</a> to post a question or answer a question';
        $id = 0;
        $user_pic_addr = '';
} 

$show_question = '';
$sql_question = mysql_query("SELECT * FROM open_question WHERE question_id='$question_id'") or die("Error: selecting details from open_question.  " . mysql_error());

$no_of_question = mysql_num_rows($sql_question);

if ($no_of_question == 0) {
      header("location: ask_home.php");
      exit();
}

while ($row = mysql_fetch_array($sql_question)) {
         // $question_id = $row['question_id'];
         $question_title = $row['title'];
         
         $question = $row['question'];
         
         $meta_desc = stripslashes($question);
         // $meta_desc = str_replace('"', "", $meta_desc);
         // $meta_desc = str_replace("'", "", $meta_desc);
         
         
         $question = $bbcode->convert_bbcode($question);
         $question = nl2br($question);
         
         $interest_regions = $row['interest_regions'];
         
         $question_created_time = $row['created_time'];
         $question_created_time = $ask->ago->convert_datetime($question_created_time);
         $question_created_time = $ask->ago->makeAgo($question_created_time);
         
         $view = $row['view'];
         $question_owner_id = $row['owner_id']; 
         
         if ($row['picture_address'] != NULL) {
               $question_pic_address = '<img src="' . $row['picture_address'] . '" /><br />';
         }
         
         if ($row['video_address'] != NULL) {
               $question_video_address = '<video width="200" height="200" onplay="javascript: adjust_video_size(this);" controls="controls"><source src="' . $row['video_address'] . '" type="video/ogg" /></video>';
         }
        
         $sql_search_for_images = mysql_query("SELECT * FROM photo WHERE aid='$question_id' AND post_location='question' ORDER BY photo_id");
         
         $no_of_images = mysql_num_rows($sql_search_for_images);
         if ($no_of_images != 0) {
               $count_images = 0;
               $image_array = array();
               $image_string = "";
               while($raw = mysql_fetch_array($sql_search_for_images)) {
                       $image_address = $raw['photo_address'];
                       $image_array[$count_images] = $raw['photo_id'];
                       $count_images++;
               }
               $image_string = implode(",", $image_array );
               $question_pic_address = '
                                        <div style="border: 1px solid #D8DFEA; padding: 2px; width: 100px; height: 100px; margin-top: 10px;">
                                          <img src="' . $image_address . '" title="Click on this image to display the whole album" width="100" height="100" onclick="javascript: display_qn_images_album(\'' . $image_string . '\');" style="cursor: pointer;" />
                                        </div>
                                        <br />
                                        ';
         } else {
               $question_pic_address = "";
         }
         
         $sql_search_for_videos = mysql_query("SELECT * FROM video WHERE aid='$question_id' AND post_location='question' ORDER BY video_id");
         
         $no_of_videos = mysql_num_rows($sql_search_for_videos);
         if ($no_of_videos != 0) {
               // $count_videos = 0;
               // $video_array = array();
               // $video_string = "";
               while($raw = mysql_fetch_array($sql_search_for_videos)) {
                       $video_address = $raw['video_address'];
                       $video_status = $raw['status'];
                       // $video_array[$count_videos] = $raw['photo_id'];
                       // $count_videos++;
               }
               // $image_string = implode(",", $image_array );
               $question_video_address = '
                                          <div style="margin-top: 10px;">
                                            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="320" height="240" id="">
				                              <param name="movie" value="swf/player.swf" />
				                              <param name="flashvars" value="file=/' . $video_address . '" />
				                              <param name="wmode" value="transparent" />
				                              <param name="allowfullscreen" value="true" />
				                              <param name="allowScriptAccess" value="never" />
                                              <embed flashvars="file=/'  . $video_address . '" allowfullscreen="true" allowscriptaccess="never" src="swf/player.swf" width="320" height="240" wmode="transparent" />
                                              <div style="margin-top: 5px;">' . $video_status . '</div>
                                            </object>
                                          </div>
                                          ';
         } else {
              $question_video_address = "";
         }
         
         if ($id != 0) {
               $sql_reply = mysql_query("SELECT * FROM reply WHERE object_id='$question_id' && object_type='question'") or die('Error: selecting details from Table reply.  ' . mysql_error());
         
               $no_of_replies = mysql_num_rows($sql_reply);
               
               $reply = '
                         <div style="background-color: #EEEEEE; width: 100%; padding-top: 5px; padding-bottom: 5px; margin-top: 2px; font-weight: bold; color: #333333;">
                           ' . $no_of_replies . ' replies
                         </div>
                         <div id="reply_box" style="margin-top: 2px;">
                           <div id="replies" style="background-color: #EEEEEE;">
                        ';
               
               while ($rw = mysql_fetch_array($sql_reply)) {
                        $reply_owner_id = $rw['owner_id'];
                        
                        $sql_reply_owner = mysql_query("SELECT * FROM user_details WHERE owner_id='$reply_owner_id'") or die('Error: selecting details from Table user_details.  ' . mysql_error()); 
                        
                        while ($ru = mysql_fetch_array($sql_reply_owner)) {
                                 $reply_owner_username = $ru['username'];
                        }
                         
                        $check_reply_owner_pic = 'members/' . $reply_owner_id . '/image01.jpg';
                        
                        $reply_owner_pic = $disp->display_pic($check_reply_owner_pic, $reply_owner_id, 30, 30);
               
                        $reply .= '
                                   <div id="reply">
                                     <table style="width: 50%;">
                                       <tr>
                                         <td style="width: 10%; valign: top;">' . $reply_owner_pic . '</td>
                                         <td style="width: 90%; valign: top;">
                                           <span class="greenColor textsize10">' . $rw['created_time'] . ' <a href="profile.php?id=' . $reply_owner_id . '">' . $reply_owner_username . '</a> commented:</span>' . $reply_menu . '<br />
                                             ' . $rw['reply'] . '
                                         </td>
                                       </tr>
                                     </table>
                                   </div>
                                  ';
               }
               
               $reply .= '
                            </div>
                            <div style="padding: 5px; background-color: #EEEEEE; margin-top: 2px;">
                              <input type="text" data-owner_id="' . $id . '" data-object_id="' . $question_id . '" data-object_type="question" placeholder="reply..." 
                              onkeyup="javascript: key_in_reply(event, this);" onclick="javascript: show_reply_pic(this);" onblur="javascript: hide_reply_pic(this);" style="width: 100%;" />
                            </div>   
                          </div>
                         ';
         }
         
         $sql_ques_owner_details = mysql_query("SELECT * FROM user_details WHERE owner_id='$question_owner_id'") or die("Error: selecting details from user_details.  " . mysql_error());
         
         while ($userRow = mysql_fetch_array($sql_ques_owner_details)) {
                  $owner_username = $userRow['username'];
                  $q_points = $userRow['q_points'];
                  $a_points = $userRow['a_points'];
         }
         
         $check_pic = 'members/' . $question_owner_id . '/image01.jpg';
         
         /* $cache_buster = rand(999999999,9999999999999);

         if (file_exists($check_pic)) {
          $check_pic = $check_pic . "?" . $cache_buster;
          $question_owner_pic = '<a href="profile.php?id=' . $question_owner_id . '"><img src="' . $check_pic . '" width="50px" height="50px" border="1"/></a>';
         } else {
          $question_owner_pic = '<a href="profile.php?id=' . $question_owner_id . '"><img src="members/0/image01.jpg" width="50px" height="50px" border="1"/></a> &nbsp;';
         } */
         
               $num_of_likes = $ask->count_likes($question_id, 'question');
             
               if ($id > 0 && $num_of_likes > 0) {
                     $like_text = '<a class="click_link" onclick="javascript: show_likes_box(' . $question_id . ', \'' . question . '\');" style="color: blue;">' . $num_of_likes . ' people</a> like this'; 
               } else if ($id == 0 && $num_of_likes > 0) {
                     $like_text = "$num_of_likes people like this"; 
               } else {
                     $like_text = "";
               }
       
               $num_of_shares = $ask->count_shares($question_id, 'question');
       
               if ($num_of_shares == 0) {
                     $share_text = "";
               } else {
                     $share_text = "$num_of_shares people share this"; 
               }

               $num_of_bookmarks = $ask->count_bookmarks($question_id, 'question');
       
               if ($id > 0 && $num_of_bookmarks > 0) {
                     $bookmark_text = '<a class="click_link" onclick="javascript: show_bookmarks_box(' . $question_id . ', \'' . question . '\');" style="color: blue;">' . $num_of_bookmarks . ' people</a> bookmark this'; 
               } else if ($id == 0 && $num_of_bookmarks > 0) {
                     $bookmark_text = "$num_of_bookmarks people bookmark this"; 
               } else {
                     $bookmark_text = "";
               }
         
               
               $like = $ask->check_like ($id, $question_owner_id, $question_id, 'question');
         
               $bookmark = $ask->check_bookmark ($id, $question_owner_id, $question_id, 'question');
               
               $promote_question = "";
               
         if ($id != $question_owner_id) {
               $post_menu = '
                             <span class="post_menu">
                               <img src="images/arrow_down.png" style="width: 15px; height: 15px;" onclick="javascript: show_post_menu(this);" />
                               <div>
                                 <span class="sub_menu" title="Report this question" onclick="javascript: show_report_post_box(' . $question_id . ', \'' . question . '\');">Report Question</span>
                               </div>
                             </span>
                            ';
               
         } else {
               $post_menu = '
                             <span class="post_menu">
                               <img src="images/arrow_down.png" style="width: 15px; height: 15px;" onclick="javascript: show_post_menu(this);" />
                               <div>
                                 <span class="sub_menu" title="Delete this question" onclick="javascript: show_delete_box(' . $question_id . ', \'' . question . '\');">Delete Question</span>
                               </div>
                             </span>
                            ';
               
               $promote_question = '<a href="pay_promote_post.php?post_owner_id=' . $question_owner_id . '&object_type=question&object_id=' . $question_id . '" class="promote_btns" style="margin-left: 10px;">Promote Question</a>';
         }
         
         $question_owner_pic = $disp->display_pic($check_pic, $question_owner_id, 50, 50);
         
         if ($interest_regions != "") {
               $interest_array = explode(",", $interest_regions);
               
               for ($i = 0; $i < count($interest_array); $i++) {
                      $interest_array_string .= '<a style="font-weight: bold;">.</a> ' . $interest_array[$i];
               }
         
               $interest_string = '
                                    <div id="interest_regions_list">
                                      <div style="font-weight: bold;">Regions of interest: </div>
                                      ' . $interest_array_string . '
                                    </div>
                                   ';
         }
         
         if ($id > 0) {
         $show_question .= '
                              <table style="background-color:#FFF; cellpadding="5" width="100%">
                                <tr>
                                  <td width="20%" valign="top">
                                    ' . $question_owner_pic . '<br />
                                    <a href="profile.php?id=' . $question_owner_id . '" class="normal_link" style="font-weight: bold;">' . $owner_username . '</a>
                                    <br /><br />
                                    <span style="font-weight: bold;">Q points : </span>' . $q_points . '<br />
                                    <span style="font-weight: bold;">A points : </span>' . $a_points . '
                                  </td>
                                  <td width="80%" valign="top" style="position: relative;"><span class="greenColor">' . $question_created_time . ' <a href="profile.php?id=' . $question_owner_id . '" class="normal_link" style="font-weight: bold;">' . $owner_username . '</a> asked:</span>' . $post_menu . '<br />
                                    <div id="question_title" style="font-size: 20px; margin-top: 10px; text-decoration: underline;">' . $question_title . '</div>
                                    ' . $question_pic_address . '
                                    ' . $question_video_address . '
                                    <div id="question_html" style="margin-top: 20px; font-size: 14px; font-family: Arial,Liberation Sans,DejaVu Sans,sans-serif; word-wrap: break-word; clear: both;">' . $question . '</div>
                                    <div style="margin-top: 20px;">
                                      <a class="click_link" style="color: blue;" onclick="javascript: share_post(' . $question_id .', \'' . question . '\', this);">share</a> ' . $like . ' ' . $bookmark . '
                                    </div>
                                    <div style="display: inline-block; background-color: #EEEEEE; width: auto; margin-top: 10px; padding: 5px;">
                                      <!-- <a id="likes_count"> ' . $like_text . '</a> -->' . $like_text . '
                                      <a id="shares_count"> ' . $share_text . '</a>
                                      <!-- <a id="bookmarks_count"> ' . $bookmark_text . '</a> -->' . $bookmark_text . '
                                    </div>
                                    ' . $reply . '
                                  </td>
                                </tr>
                              </table>
                              ';
         } else {
              $show_question .= '
                                 <table style="background-color:#FFF; cellpadding="5" width="100%">
                                   <tr>
                                     <td width="20%" valign="top">
                                       ' . $question_owner_pic . '<br />
                                       <a href="profile.php?id=' . $question_owner_id . '" class="normal_link" style="font-weight: bold;">' . $owner_username . '</a>
                                       <br /><br />
                                       <span style="font-weight: bold;">Q points : </span>' . $q_points . '<br />
                                       <span style="font-weight: bold;">A points : </span>' . $a_points . '
                                     </td>
                                     <td width="80%" valign="top" style="position: relative;"><span class="greenColor">' . $question_created_time . ' <a href="profile.php?id=' . $question_owner_id . '" class="normal_link" style="font-weight: bold;">' . $owner_username . '</a> asked:</span><br />
                                       <div id="question_title" style="font-size: 20px; margin-top: 10px; text-decoration: underline;">' . $question_title . '</div>
                                         ' . $question_pic_address . '
                                         ' . $question_video_address . '
                                       <div id="question_html" style="margin-top: 20px; font-size: 14px; font-family: Arial,Liberation Sans,DejaVu Sans,sans-serif; word-wrap: break-word; clear: both;">' . $question . '</div>
                                       <div style="display: inline-block; background-color: #EEEEEE; width: auto; margin-top: 10px; padding: 5px;">
                                         <a id="likes_count"> ' . $like_text . '</a>
                                         <a id="shares_count"> ' . $share_text . '</a>
                                         <a id="bookmarks_count"> ' . $bookmark_text . '</a>
                                       </div>
                                     </td>
                                   </tr>
                                 </table>
                                 ';
         }
  
}

$sql_answers = mysql_query("SELECT * FROM open_answer WHERE question_id='$question_id' ORDER BY answer_id DESC");

$no_of_answers = mysql_num_rows($sql_answers);

$show_right_side_ads = $ads->show_right_side_ads ($question_id, 'question');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title><?php echo $question_title; ?></title>

<meta name="description" content="<?php echo $meta_desc; ?>" />

<link href="style/main.css" rel="stylesheet" type="text/css" />

<?php 

  if ($id > 0) {
        echo '<link href="style/header_user.css" rel="stylesheet" type="text/css" />';
  } else {
        echo '<link href="style/header_non_user.css" rel="stylesheet" type="text/css" />';
  }
  
?>


<link href="style/footer.css" rel="stylesheet" type="text/css" />
<link href="style/load_more_btn.css" rel="stylesheet" type="text/css" />
<link href="style/buttons.css" rel="stylesheet" type="text/css" />
<link href="style/post_menu.css" rel="stylesheet" type="text/css" />
<link href="style/file_inputs.css" rel="stylesheet" type="text/css" />
<link href="style/login.css" rel="stylesheet" type="text/css" />

<link rel="icon" href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

<script src="js/jquery-1.5.js" type="text/javascript"></script>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script src="js/search.js" type="text/javascript"></script>
<script src="js/open_question.js" type="text/javascript"></script>
<script src="js/bbcode.js" type="text/javascript"></script>
<script src="js/video.js" type="text/javascript"></script>
<script src="js/notification.js" type="text/javascript"></script>
<script src="js/chat.js" type="text/javascript"></script>
<script src="js/picture.js" type="text/javascript"></script>
<script src="js/report_post.js" type="text/javascript"></script>
<script src="js/google_track.js" type="text/javascript"></script>
<script src="js/ad.js" type="text/javascript"></script>
<script src="js/reply.js" type="text/javascript"></script>

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

Question_id = '<?php echo $question_id?>';

User_pic_addr = '<?php echo $user_pic_addr; ?>';

// window.setInterval("show_converted_text(answer_question.id)", 500);

/* $(document).ready(function () {
	
// document.observe("dom:loaded", function(Event) {

  var ttarea = document.getElementById("answer_question");
  
  Event.observe('answer_question', 'click', show_converted_text);
  
}); */

$(document).ready(function () {
	show_initial_answers (Question_id);
});

$(document).ready(function(){
	  $('.load_more_answers').live("click",function() {
	      var last_answer_id = $(this).attr("id");
	      var Func = 'show_more_answers';
	      
	      if(last_answer_id!='end'){
	           $('.load_more_answers').append('<img src="images/facebook_style_loader.gif" />');

	               // $.post("debug_script/test_post.php", {lastmsg:last_msg_id,user_id:id},

	               $.post("display/display_answers.php", {question_id: Question_id, answer_id: last_answer_id, func: Func}, function(html){
	                        $(".load_more_answers").remove();
		                    $("#show_answers").append(html);
	               }); 
	      } 

	      // return false;
	  });
	});


/* $('#ans_form').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});
function post_answer() {
           
	      var Answer = $("#answer_question");
	      var Activity = $("#activity");
	      var url = "post_question.php";
          var Func = "answer";
	      
	      if (Answer.val() == "") {
	           $("#error_message").html('<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; Please type in your answer.').show().fadeOut(6000);
	      } else {
	           $.post(url,{answer: Answer.val(), id: Id, activity: Activity.val(), func: Func} , function(data) {
	                 $("#error_message").html(data).show();
	                 document.ans_form.answer_question.value='';
	           });
	      }
} */

function fontEdit(x,y)
{
   textEditor.document.execCommand(x,"",y);
   textEditor.focus();
}

function frame_focus(frame_id) {
	// alert (frame_id);
	// document.getElementById(frame_id).focus();
	// document.getElementById(frame_id).contentDocument.write('What the fuck is this shit ?!!');
	
	var text_Editor = document.getElementById(frame_id);
	
	text_Editor.contentDocument.designMode="on";
	text_Editor.contentDocument.open();
	text_Editor.contentDocument.write('<head><style type="text/css">body{ font-family:arial; font-size:13px; }</style> </head>');
	text_Editor.contentDocument.close();

}

function open_close_charts_div () {
	if ($("#charts_div").is(":visible")) {
          $("#charts_div").hide();
    } else {
    	  $("#charts_div").show();
    	  drawRegionsMap();
    	  drawLineChart();
    }
}

function close_charts_div () {
	if ($("#charts_div").is(":visible")) {
          $("#charts_div").hide();
    }
}

google.load('visualization', '1', {'packages': ['geochart']});
// google.setOnLoadCallback(drawRegionsMap);

function drawRegionsMap() {
   // var stats_table = '<table style="font-size: 16px;"><tr><td><a style="font-weight: bold;">Country</a></td><td><a style="font-weight: bold;">Visitors</a></td></tr>';
   var stats_table = '';
   var countries_count = <?php echo json_encode($countries_count); ?>;
   var countries_stats = <?php echo json_encode($countries_stats); ?>;
   /* var data = new google.visualization.DataTable();
   
   /* data.addColumn('string', 'Country');
   data.addColumn('number', 'Popularity'); */

   $.each(countries_count, function(i, val) {
   	        // stats_table += '<tr><td>' + i + '</td><td>' + val + '</td></tr>';
	        stats_table += '<span style="display: inline-block; width: 50%; font-size: 14px; margin-top: 5px;"><a style="font-weight: bold;"> .' + i + '</a> ' + val + '</span>';
   });

   stats_table += "</table>";

   var data = new google.visualization.DataTable(countries_stats);
   
   var options = {};

   var chart = new google.visualization.GeoChart(document.getElementById('geo_chart'));
   chart.draw(data, options);
   $("#geo_data").html(stats_table);
}

google.load("visualization", "1", {packages:["corechart"]});
// google.setOnLoadCallback(drawLineChart);
function drawLineChart() {
  var views_stats = <?php echo json_encode($views_stats); ?>;
  /* var data = google.visualization.arrayToDataTable([
    ['Year', 'Sales', 'Expenses'],
    ['2004',  1000,      400],
    ['2005',  1170,      460],
    ['2006',  660,       1120],
    ['2007',  1030,      540]
  ]); */

  var data = new google.visualization.DataTable(views_stats);

  var options = {
    title: 'Views per Day'
  };

  var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
  chart.draw(data, options);
}

</script>
</head>

<body>
<div id="popup_backgnd" tabindex="0">
  <div id="album_ss"></div>
  <img src="images/next.png" id="next" width="50px" height="50px" />
  <img src="images/previous.png" id="previous" width="50px" height="50px" />
</div>

<div id="report_post_box" style="width: 420px; height: 320px; background: rgba(82, 82, 82, 0.7)!important; position: fixed; left: 50%; top: 50%; margin-left: -210px; margin-top: -160px; z-index: 10; border-radius: 8px; padding: 10px; display: none;">
  
  <div style="background-color: #FFFFFF; text-align: center; border: #999 1px solid;">
    <div style="font-size: 12px; font-weight: bold; color: #FFFFFF; background-color: #3B5998; padding: 5px;">
      Report post <img src="images/cross2.png" title="close" style="width: 12px; height: 12px; position: absolute; right: 0%; margin-right: 20px; cursor: pointer;" onclick="javascript: close_rp_box();" />
    </div>
    <div style="width: 100%; margin-top: 10px;">
      <textarea id="report_post_text" style="width: 90%; height: 240px; max-height: 240px; resize: none;"></textarea>
      <input type="hidden" name="rp_object_id" id="rp_object_id" value="" />
      <input type="hidden" name="rp_object_type" id="rp_object_type" value="" />
    </div>
    <div style="padding: 10px; margin-top: 5px; margin-bottom: 3px;">
      <a style="cursor: pointer; color: #FFFFFF; background-color: #343434; border-color: #C8C8C8; padding: 5px; font-size: 11px; font-weight: bold; border-radius: 4px; 
      -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; margin-top: 10px; margin-bottom: 3px;"
      onclick="javascript: send_report_post();">Report</a>
    </div>
  </div>

</div>

<?php include ("delete_post_box.php"); ?>
<?php include ("share_post_box.php"); ?>

<?php include ("show_bookmarks_box.php"); ?>
<?php include ("show_likes_box.php"); ?>

<?php 
  if ($id > 0) {
        include ("userhome_header2.php"); 
  } else {
        include ("non_user_header.php");
  }
?><br /><br />

<div style="position: relative; width: 1000px; margin: 0 auto;">
  <div style="width: 70%; font-style: arial; font-size: 12px;">
    <div style="position: relative;">
      <a id="click_to_answer" class="open_close_form" title="Click here to open or close answer form" onclick="javascript: show_form('answer_form'); show_converted_text(answer_question.id);" onmouseover="javascript: hover_qna_btn(this);" onmouseout="javascript: leave_qna_btn(this);" style="font-size: 12px; padding: 5px 10px;">Answer question</a>
      <?php echo $promote_question; ?>
      <strong title="click here to view statistics" onclick="javascript: open_close_charts_div();" style="position: absolute; right: 10px; top: 15px; color: #333; font: arial,sans-serif; font-size: 16px; border: 1px solid #EEEEEE; padding: 5px; background-color: #DDDDDD; cursor: pointer;">
        <?php echo $no_of_views; ?> views
      </strong>
    </div>
    
    <div style="position: relative; height: 30px;"><a class="stats_btns" title="click here to view statistics" onclick="javascript: open_close_charts_div();" style="position: absolute; right: 10px; top: 5px;">stats</a></div>
    
    <div id="charts_div" style="position: relative; padding: 20px; display: none;">
      <div style="width: 100%; height: 30px; position: relative;">
        <span onclick="javascript: close_charts_div();" title="close" style="position: absolute; top: 5px; right: 10px; display: inline-block; cursor: pointer;"><img src="images/close.png" style="width: 20px; height: 20px;" /></span>
      </div>
      <div id="geo_chart" style="width: 700px; height: 400px;"></div>
      <div id="geo_data"></div>
      <div id="line_chart" style="width: 700px; height: 400px;"></div>
    </div>
    
    <br /><br />
    

    <div id="answer_form" style="text-align: left; display: none; border: 1px solid #E9E9E9; padding: 10px;">
      <?php echo $answer_form; ?>
    </div>
         
    <div id="error_message">
      
    </div>
      
    <br /><br />
    
    <?php echo $interest_string; ?>
    
    <div id="show_question" style="display: block; margin-top: 10px;">
      <?php echo $show_question; ?>
    </div>
      
    <br /><font name="total_answers" id="total_answers" size="3"><strong>Answers(<?php  echo $no_of_answers; ?>)</strong></font><br />
      
    <div id="show_answers" style="display: block;">
      <?php // echo $show_answers; ?>
    </div>

    <!-- <div id="<?php echo $answer_id; ?>" class="load_more" onclick="javascript: load_more_answers(this.id);">Load More Answers <img src="images/arrow1.png" /></div> -->
      
  </div>
  
  <div id="right_side_ads" style="position: absolute; width: 26%; top: 0; right: 0; margin-left: 20px;">
    <?php echo $show_right_side_ads; ?>
  </div>
  
</div>

<br /><br />
<?php include_once "footer.php"; ?>

</body>
</html>





