<?php
// Start session, check if user is logged in or not, and connect to the database all in one included file
include_once("check/check_user_log.php");

// include ("class/activities.class.php");

include_once "connect/connect_to_mysql.php";

?>

<?php

$sk = $_GET['sk'];
$sk = strip_tags($sk);
$sk = mysql_real_escape_string($sk);

$pm_id = $_GET['pm_id'];
$pm_id = strip_tags($pm_id);
$pm_id = mysql_real_escape_string($pm_id);

$sub_link = $_GET['sub_link'];
$sub_link = strip_tags($sub_link);
$sub_link = mysql_real_escape_string($sub_link);

$viewer_type = $_GET['viewer_type']; 
$viewer_type = strip_tags($viewer_type);
$viewer_type = mysql_real_escape_string($viewer_type);

$chat_user_id = $_GET['chat_user_id']; 
$chat_user_id = strip_tags($chat_user_id);
$chat_user_id = mysql_real_escape_string($chat_user_id);

include ("class/display.class.php");
$display = new display();

include("class/friends.class.php");
$frnds = new friends();

// ------- INITIALIZE SOME VARIABLES ---------
// they must be initialized in some server environments or else errors will get thrown
$id = "";
$username = "";
$firstname = "";
$lastname = "";
$mainNameLine = "";
$country = "";
$state = "";
$city = "";
$zip = "";
$bio_body = "";
$website = "";
$youtube = "";
$facebook = "";
$twitter = "";
$twitterWidget = "";
$location = "";
$user_pic = "";
$blabberDisplayList = "";
$interactionBox = "";
$cacheBuster = rand(999999999,9999999999999); // Put on an image URL will help always show new when changed
// --------------- END INITIALIZE SOME VARIABLES ----------------

// ------- ESTABLISH THE PAGE ID ACCORDING TO CONDITIONS -------
if (isset($_SESSION['idx'])) {
        $id = $logOptions_id;
} else {
    // header("location: /home/content/59/7816259/html/index.php");
    exit();
}
// ------- END ESTABLISH THE PAGE ID ACCORDING TO CONDITIONS -------

// ------- FILTER THE ID AND QUERY THE DATABASE -------
$id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers on the ID just in case
$sql = mysql_query("SELECT * FROM user_details WHERE owner_id='$id' LIMIT 1"); // query the member
// ------- END FILTER THE ID AND QUERY THE DATABASE ------

// ------- MAKE SURE PERSON EXISTS IN DATABASE --------
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
    // header("location: index.php?msg=user_does_not_exist");
    exit();
}
// ------- END MAKE SURE THE PERSON EXISTS IN DATABASE -------

// ------- WHILE LOOP FOR GETTING THE MEMBER DATA ------
while($row = mysql_fetch_array($sql)) {
	$username = $row["username"];
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $country = $row["country"];
    $state = $row["state"];
    $city = $row["city"];
    $sign_up_date = $row["sign_up_date"];
  $sign_up_date = strftime("%b %d %Y", strtotime($sign_up_date));
    $last_log_date = $row["last_log_date"];
  $last_log_date = strftime("%b %d %Y", strtotime($last_log_date));
    $bio_body = $row["bio_body"];
    $bio_body = str_replace("&#39;", "'", $bio_body);
    $bio_body = stripslashes($bio_body);
    $website = $row["website"];
    $youtube = $row["youtube"];
    $facebook = $row["facebook"];
    $twitter = $row["twitter"];
    $friend_array = $row["friend_array"];
    /////// Mechanism to Display Pic. See if the user have uploaded a pic or not /////////////////////
    $check_pic = "members/$id/image01.jpg";
    $default_pic = "members/0/image01.jpg";
    
    if (file_exists($check_pic)) {
          $user_pic_addr = $check_pic;
    } else {
          $user_pic_addr = $default_pic;
    }
	
    $user_pic = $display->display_pic($check_pic, $id, 50, 50); 
	
    /////// MECHANISM TO DISPLAY REAL NAME NEXT TO USERNAME - REAL NAME(USERNAME) ///////////////////
    if ($firstname != "") {
         $mainNameLine = "$firstname $lastname ($username)";
             $username = $firstname;
    } else {
         $mainNameLine = $username;
    }
    ////// MECHANISM TO DISPLAY LOCATION INFO OR NOT ////////////////////
    if ($country == "" && $state == "" && $city == "") {
      $locationInfo = "";
    } else {
      $locationInfo = "$city &middot; $state<br />$country ".'<a href="#" onclick="return false" onmousedown="javascript:toggleViewMap(\'google_map\');">view map</a>';
    }
} // close while loop
// ------- END WHILE LOOP FOR GETTING THE MEMBER DATA --------

$display = "";

include ("display/display_activities.php");
include ("class/pm.class.php");

$pm = new pm();

$display_inbox_list = $pm->display_receive_list($id);

$display_outbox_list = $pm->display_sent_list($id);

// $activities = new activities($id);
// $display = $activities->getDisplayStatus();
// $activity_id = $activities->getActivityId();
    
// ------- ESTABLISH THE PROFILE INTERACTION TOKEN --------
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum); // Will always overwrite itself each time this script runs
// ------- END ESTABLISH THE PROFILE INTERACTION TOKEN --------

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Description" content="Profile for <?php echo "$username"; ?>" />
<meta name="Keywords" content="<?php echo "$username, $city, $state, $country"; ?>" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title>HomePage of <?php echo $username; ?></title>
<link href="style/main.css" rel="stylesheet" type="text/css" />
<link href="style/private_messages.css" rel="stylesheet" type="text/css" />
<link href="style/status_form.css" rel="stylesheet" type="text/css" />
<link href="style/friends.css" rel="stylesheet" type="text/css" />
<link href="style/load_more_btn.css" rel="stylesheet" type="text/css" />
<link href="style/chat.css" rel="stylesheet" type="text/css" />
<link href="style/header_user.css" rel="stylesheet" type="text/css" />
<link href="style/footer.css" rel="stylesheet" type="text/css" />
<link href="style/buttons.css" rel="stylesheet" type="text/css" />
<link href="style/scrollbar.css" rel="stylesheet" type="text/css" />
<link href="style/post_menu.css" rel="stylesheet" type="text/css" />
<link href="style/file_inputs.css" rel="stylesheet" type="text/css" />
<link href="style/search.css" rel="stylesheet" type="text/css" />
<link href="style/selects.css" rel="stylesheet" type="text/css" />
<link href="style/notifications.css" rel="stylesheet" type="text/css" />

<link rel="icon" href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
<!-- <script src="js/jquery-2.0.3.js" type="text/javascript"></script> -->
<script src="js/jquery.elastic.source.js" type="text/javascript"></script>

<script src="js/notification.js" type="text/javascript"></script>
<script src="js/picture.js" type="text/javascript"></script>
<script src="js/private_message.js" type="text/javascript"></script>
<script src="js/show_status.js" type="text/javascript"></script>
<script src="js/video.js" type="text/javascript"></script>
<script src="js/status_form.js" type="text/javascript"></script>
<script src="js/friends.js" type="text/javascript"></script>
<script src="js/status.js" type="text/javascript"></script>
<script src="js/search.js" type="text/javascript"></script>
<script src="jwplayer/jwplayer.js" type="text/javascript"></script>
<script src="js/chat.js" type="text/javascript"></script>
<script src="js/online.js" type="text/javascript"></script>
<script src="js/browser_events.js" type="text/javascript"></script>
<script src="js/feedback.js" type="text/javascript"></script>
<script src="js/comment.js" type="text/javascript"></script>
<script src="js/report_post.js" type="text/javascript"></script>
<script src="js/invite_friend.js" type="text/javascript"></script>
<script src="js/bookmark.js" type="text/javascript"></script>
<script src="js/non_open_question_page.js" type="text/javascript"></script>

<style type="text/css">
<!--

.infoHeader {
      background-color: #BDF;
      font-size: 11px;
      font-weight: bold;
      padding: 0px;
      border: #999 1px solid;
      border-bottom: none;
      width: 180px;
}
.infoBody {
      background-color: #FFF;
      font-size: 11px;
      padding: 0px;
      border: #999 1px solid;
      border-bottom: none;
      width: 180px;
}
/* -------- Interaction Links Class -------- */
.interactionLinksDiv a {
      border: #B9B9B9 1px solid;
      padding: 5px; 
      color: #060;
      font-size: 11px;
      background-image: url(style/headerBtnsBG.jpg);
      text-decoration: none;
}
.interactionLinksDiv a:hover {
      border: #090 1px solid;
      padding: 5px;
      color: #060;
      font-size: 11px;
      background-image: url(style/headerBtnsBGover.jpg);
}
/* -------- Interaction Containers Class --------- */
.interactContainers {
	padding:8px;
	background-color:#BDF;
	border:#999 1px solid;
	display:none;
}
#add_friend_loader {
      display: none;
}
#remove_friend_loader {
      display: none;
}
#interactionResults {
      display: none;
      font-size: 16px;
      padding: 8px;
}
#friendTable td {
      font-size: 9px;
}
#friendTable td a {
      color: #03C;
      text-decoration: none;
}
#view_all_friends {
      background-image: url(style/opaqueDark.png);
      width: 270px;
      padding: 20px;
      position: fixed;
      top: 150px;
      display: none;
      z-index: 100;
      margin-left: 50px;
}

.load_more {
      border: 1px solid #D8DFEA;
      padding: 10px 15px;
      background-color: #EDEFF4;
      cursor: pointer;
}

.load_more:hover {
      background-color: #3B5998;
}

.no_more {
      border: 1px solid #D8DFEA;
      padding: 10px 15px;
      background-color: #EDEFF4;
}

.no_more:hover {
      background-color: #3B5998;
      // cursor: pointer;
      // text-decoration: none;
      // font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
      // font-size: 11px;
      // text-align: left;
}

.sm {
      cursor: pointer;
      padding: 5px;
}

.sm_a {
      width: 100%;
}

.msg_sub_sm {
      cursor: pointer;
      margin-top: 5px;
}

#whole_bkgnd_opaque {
      /* display: none;
      position: fixed;
      _position: absolute; /* hack for internet explorer 6*/
      /* height: 100%;
      width: 100%;
      top: 0;
      left: 0;
      background: rgba(0, 0, 0, .7);
      border: 1px solid #cecece;
      z-index: 6; */
      
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
      // width: 100%;
      // margin: 0 auto;
      
}

#popupContactClose {
      // display: none;
      font-size: 20px;
      line-height: 14px;
      // position: fixed;
      // top: 10%;
      // left: 61%;
      position: absolute;
      right: 5px;
      top: 5px;
      color: #6fa5fd;
      font-weight: 700;
      z-index: 8;
      cursor: pointer;
}

#popup_content {
      display: none;
      position: absolute;
      // width: 100%;
      // left: 0;
      left: 50%;
      top: 50%;
      z-index: 7;
      // margin: 0 auto;
      
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
<script language="javascript" type="text/javascript">

quest = '<?php echo $sk; ?>';

Id = '<?php echo $id; ?>';
User_pic_addr = '<?php echo $user_pic_addr; ?>';

pm_id = '<?php echo $pm_id; ?>';
sub_link = '<?php echo $sub_link; ?>';
Viewer_Type = '<?php echo $viewer_type; ?>';

Chat_user_Id = '<?php echo $chat_user_id; ?>';

Latest_act_id = 0;
update_act = "";

$(document).ready(function() {
	
if (quest == 'news_link') {

   clickDiv('activity_windows', 'news_link', 'nl_loader', 'show_newsFeed');
}

else if (quest == "message_link") {

   clickDiv('message_windows', 'message_link', 'msg_loader', 'show_msgWindows');
   $('.msg_sub_sm').show();

   $('.message_sub_window').hide();
   var Func = "";

   if (sub_link != '') {
	   if (sub_link == 'msg_inbox_link') {
		     clickDiv('message_windows', 'msg_inbox_link', 'msg_inbox_loader', 'show_msg_inbox'); 
		     // Func = 'show_msg_inbox';
             $.post("display/display_private_message.php", {id: Id, func: 'show_msg_inbox'}, function(data) {
            	 $('#inbox_list').html(data).show();
             });
	   }

	   if (sub_link == 'msg_outbox_link') {
		     clickDiv('message_windows', 'msg_outbox_link', 'msg_outbox_loader', 'show_msg_outbox'); 
		     $.post("display/display_private_message.php", {id: Id, func: 'show_msg_outbox'}, function(data) {
            	 $('#outbox_list').html(data).show();
             });
	   }

	   if (sub_link == 'new_msg_link') {
		     clickDiv('message_windows', 'new_msg_link', 'new_msg_loader', 'show_new_msg'); 
		     $('#pm_form_window').show();
	   }
   } 

   else if (pm_id == '' && sub_link == '') {
	   clickDiv('message_windows', 'msg_inbox_link', 'msg_inbox_loader', 'show_msg_inbox'); 
	     // Func = 'show_msg_inbox';
       $.post("display/display_private_message.php", {id: Id, func: 'show_msg_inbox'}, function(data) {
      	 $('#inbox_list').html(data).show();
       });
   }
   
   if (pm_id != '') {
		// $('#inbox_list').hide();
		// $('#outbox_list').hide();
	    $('#whole_message').show();
	}
}

else if (quest == "events_link") {

   clickDiv('events_windows', 'events_link', 'ev_loader', 'show_evWindows');
}

else if (quest == "friends_link") {

   clickDiv('friends_windows', 'friends_link', 'frnd_loader', 'show_frndWindows');
}

else if (quest == "apps_link") {

   clickDiv('apps_windows', 'apps_link', 'apps_loader', 'show_appsWindows');
}

else if (quest == "bookmarks_link") {

   clickDiv('bookmarks_windows', 'bookmarks_link', 'bookmarks_loader', 'show_bmWindows');
} 

else if (quest == "my_questions_link") {

	   clickDiv('my_questions_windows', 'my_questions_link', 'my_questions_loader', 'show_myQnWindows');
} 

else if (quest == "my_answers_link") {

	   clickDiv('my_answers_windows', 'my_answers_link', 'my_answers_loader', 'show_myAnsWindows');
} 

else if (quest == "chats_link") {
   if (Chat_user_Id != "") {
	     $('#chats_windows').show();
	     show_initial_chat_details(Chat_user_Id);
   } else {
         clickDiv('chats_windows', 'chats_link', 'chats_loader', 'show_chatUsers');
   }
}

else {
  
   clickDiv('activity_windows', 'news_link', 'nl_loader', 'show_newsFeed');
}

});

function clickDiv(content,link,image,Func) {
    // alert ("fdgrgrreg");

	var ID = '<?php echo $id; ?>';
	var RandNum = '<?php echo $thisRandNum; ?>';

    $('#'+image).show();
	$('.sm').css({"background-color":"#FFF",
                      "font":"12px arial,serif",
                      "color":"#000000"
	             });
	
	$('#'+link).css({"background-color":"#B4BBCD",
                     "font":"bold 13px arial,serif",
                     "color":"#DD4B39",
                     "min-width":"180px"
                   });
	
	// $.post("display/display_editprofile.php", {id:ID, func:Func, randnum:RandNum},
			// function(html) {
		       $('.window').hide();
		       if (Func == 'show_frndWindows') {
		    	     var Window = 'friends_lists';
			         var count_window = 'friends_count_header';
			         $('#'+content).show();
		    	     show_initial_friends(Id, Window, count_window);
		       } 

		       else if (Func == 'show_newsFeed') {
			         // alert ("Hello");
			         $('#'+content).show();
		    	     display_initial_activities(Id);
			   }

		       else if (Func == 'show_msg_inbox') {
		    	     $('#'+content).show();
			   } 

			   else if (Func == 'show_bmWindows') {
				     $('#'+content).show();
				     show_all_initial_bms();
			   } 

			   else if (Func == 'show_myQnWindows') {
				     $('#'+content).show();
				     show_all_initial_my_qns();
			   } 

			   else if (Func == 'show_myAnsWindows') {
				     $('#'+content).show();
				     show_all_initial_my_ans();
			   } 

			   else if (Func == 'show_chatUsers') {
				     $('#'+content).show();
				     show_initial_chat_users();
			   }
		       
		       else {
		             // $('#'+content).html(html);
		             $('#'+content).show();
		       }
	// }); 
	
   $('#'+image).hide();

}

function hoverDiv(link) {

	var color = document.getElementById(link).style.backgroundColor;

    if (color == "rgb(180, 187, 205)"){
    	// $('#'+x).css("background-color","red");
    }
    else {
    	$('#'+link).css({"background-color":"#F7F7F7",
    	    	      "width":"180px"});
    }
}

function leaveDiv(link) {

	var color = document.getElementById(link).style.backgroundColor;

	if (color == "rgb(180, 187, 205)"){
    	// $('#'+x).css("background-color","red");
    }
    else {
    	$('#'+link).css("background-color","#FFF");
    }
}

function redirect(link, sub_link) {
	if (sub_link != null) {
		window.location = 'user_home.php?sk='+link+'&sub_link='+sub_link;
	} else {
		window.location = 'user_home.php?sk='+link;
	}
}

function redirect_sub_link(link, sub_link) {
	
}

function toggleViewStatus(x) {

	if ($('#'+x).is(":hidden")) {
        $('#'+x).slideDown(200);
    } else {
        $('#'+x).slideUp(200);
    }
	
}

// Start Private Messaging stuff
$('#pmForm').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});
function sendPM ( ) {
      var pmSubject = $("#pmSubject");
        var pmTextArea = $("#pmTextArea");
        var sendername = $("#pm_sender_name");
        var senderid = $("#pm_sender_id");
        var recName = $("#pm_rec_name");
        var pmType = $("#pm_type");
        // var recID = $("#pm_rec_id");
        // var pm_wipit = $("#pmWipit");
        var url = "scripts_for_profile/private_msg_parse.php";
      if (pmSubject.val() == "") {
           $("#errors_window").html('<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; Please type a subject.').show().fadeOut(6000);
      } else if (pmTextArea.val() == "") {
           $("#errors_window").html('<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; Please type in your message.').show().fadeOut(6000);
      } else if (recName.val() == "") {
    	   $("#errors_window").html('<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; Please type in the username of the person you want to send your message to.').show().fadeOut(6000);
      } else {
           $("#pmFormProcessGif").show();
           $.post(url,{ subject: pmSubject.val(), message: pmTextArea.val(), senderName: sendername.val(), senderID: senderid.val(), rcpntName: recName.val(), type: pmType.val() } , function(data) {
                 $('#private_message').slideUp("fast");
                 $("#errors_window").html(data).show().fadeOut(10000);
                 document.pmForm.pmTextArea.value='';
                 document.pmForm.pmSubject.value='';
                 document.pmForm.recName.value='';
                 $("#pmFormProcessGif").hide();
           });
      }
}
// End Private Messaging stuff

// $(function() {
	
$(document).ready(function(){
  $('.load_more').live("click",function() {
      var last_msg_id = $(this).attr("id");
      var id = "<?php echo $id; ?>";

      if(last_msg_id!='end'){
    
           /*  $.ajax({
                       type: "POST",
                       url: "show_activities.php",
                       data: "lastmsg="+ last_msg_id&"user_id="+ id, 
                       beforeSend:  function() {
                            $('a.load_more').append('<img src="images/facebook_style_loader.gif" />');
               },
               success: function(html){
                 $(".facebook_style").remove();
                 $("#updates").append(html);
               }
               }); */

               $('.load_more').append('<img src="images/facebook_style_loader.gif" />');

               // $.post("debug_script/test_post.php", {lastmsg:last_msg_id,user_id:id},

               $.post("show/show_activities.php", {lastmsg:last_msg_id,user_id:id}, function(html){
                        $(".load_more").remove();
	                    $("#updates").append(html);
               }); 
      } 

      // return false;
  });
});

//--- Get contents of newsfeed the webpage starts loading ---// 
/* $(document).ready(function () {
	// alert (window.location.pathname);
    var url = "display/display_initial_activities.php";
    var Func = "activities";
    
    $.post(url, {id:Id, func:Func}, function(data) {
             $("#updates").append(data);
    });

    Func = "load_more";
    $.post(url, {id:Id, func:Func}, function(data) {
             $("#updates").after(data);
    });
}); */

//--- function to call to automatically load the latest status after the user have submitted a post ---//
function display_initial_activities(ID) {
  // alert ("Hello!!!");
  var url = "display/display_initial_activities.php";
  var Func = "activities";

  $("#updates").html("");
  $(".load_more").remove();
  $(".no_more").remove();
  
  $.post(url, {id:ID, func:Func}, function(data) {
	       // $("#updates").html("");
	       // $(".load_more").remove();
           $("#updates").append(data);
           if ($(".store_act_id:first").length != 0) {
                 Latest_act_id = $(".store_act_id:first").attr("data-act_id");
           }

           clearInterval (update_act);
           update_act = setInterval("update_activities()", 5000);
           
  });

  /* Func = "load_more";
  $.post(url, {id:ID, func:Func}, function(data) {
           $("#updates").after(data);
  }); */
}

function update_activities() {
  $.post("display/display_initial_activities.php", {id: Id, latest_act_id: Latest_act_id, func: 'update'}, function(data) {
	       if (data.replace(/\s/g, "") != "") {
                 $(".store_act_id").remove();
		         $("#updates").prepend(data);	
		         if ($(".store_act_id:first").length != 0) {
		               Latest_act_id = $(".store_act_id:first").attr("data-act_id");	
		         }
		         
	       }

           // alert (data.replace(/\s/g, ""));
  });
       
}

</script>
</head>
<body>
<div id="whole_bkgnd_opaque" tabindex="0">
  <div id="popup_content"></div>
  <img src="images/next.png" id="next" width="50px" height="50px" />
  <img src="images/previous.png" id="previous" width="50px" height="50px" />
</div>
<!-- <div id="popupContactClose">x</div> -->

<div id="white_bkgnd" style="position: fixed; display: none; width: 100%; height: 100%; background-color: #FFFFFF; z-index: 10; top: 0; left: 0;"></div>

<audio id="alert_sound" style="display: none;">
  <source src="http://www.hookedd.com/sound/alert.mp3" type="audio/mpeg" />
</audio>

<?php include ("show_bookmarks_box.php"); ?>

<?php include ("show_likes_box.php"); ?>

<?php include ("block_user_box.php"); ?>

<?php include ("share_post_box.php"); ?>

<?php include ("report_post_box.php"); ?>

<?php include ("delete_post_box.php"); ?>

<?php include ("invite_friend_box.php"); ?>

<?php include ("chat_box.php"); ?>

<?php include_once "userhome_header2.php"; ?>

<div style="width: 1000px; margin: 0 auto; font-size: 12px;">
<table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="738" valign="top"><br />
     <table width="100%" border="0" align="center" cellpadding="6">
     <tr>
       <td width="26%" valign="top">
         
         <div style="position: relative; vertical-align: middle;">
           <?php echo $user_pic; ?>
           <span style="display: inline-block; vertical-align: middle; height: 50px;">
             <a href="profile.php?id=<?php echo $id; ?>" style="display: inline-block; color: blue; font-weight: bold; margin-left: 10px;" class="normal_link"><?php echo $username;?></a>
           </span>
         </div>
         
         <?php include_once ("side_menu.php"); ?>
         <br /><br />
         
         <div><?php include_once("ad_200_square.php"); ?></div>
          </td>
         <td width="74%" valign="top">
           <span style="font-size:16px; font-weight:800;"><?php echo $mainNameLine; ?></span>
                <br />
                <?php // include("debug_script/test_script2.php"); 
                      // echo $interactionBox; ?>

              <div id="errors_window" class="window" style="display: none;"></div>
              
              <div id="activity_windows" class="window" style="display: none;">
                <div id="stats_form" style="margin-top: 10px;"> 
                  <span class="status_menu"><a id="status_link" class="post_links" onclick="javascript: show_status_form('post_status', this.id);" onmouseover="javascript: hover_status_form(this.id);" onmouseout="javascript: leave_status_form(this.id);">Status</a></span>
                  
                  <span class="status_menu">
                    <a id="photos_link" class="post_links" onclick="javascript: show_status_form('post_photos', this.id);" onmouseover="javascript: hover_status_form(this.id);" onmouseout="javascript: leave_status_form(this.id);">Photo</a>
                    <div id="post_photos" class="stats_sub_menu">
                      <span class="sub_form" onclick="javascript: show_status_form('upload_photos');" onmouseover="javascript: hoverLink('sub_link_upphoto');" onmouseout="javascript: leaveLink('sub_link_upphoto');"><a id="sub_link_upphoto">Upload a photo</a></span>
                      <span class="sub_form" onclick="javascript: show_status_form('take_photo');" onmouseover="javascript: hoverLink('sub_link_rephoto');" onmouseout="javascript: leaveLink('sub_link_rephoto');"><a id="sub_link_rephoto">Take a photo</a></span>
                      <span class="sub_form" onclick="javascript: show_status_form('create_album');" onmouseover="javascript: hoverLink('sub_link_album');" onmouseout="javascript: leaveLink('sub_link_album');"><a id="sub_link_album">Create an album</a></span>
                    </div>
                  </span>
                  
                  <span class="status_menu"><a id="links_link" class="post_links" onclick="javascript: show_status_form('post_links', this.id);" onmouseover="javascript: hover_status_form(this.id);" onmouseout="javascript: leave_status_form(this.id);">Link</a></span>
                  
                  <span class="status_menu">
                    <a id="videos_link" class="post_links" onclick="javascript: show_status_form('post_videos', this.id);" onmouseover="javascript: hover_status_form(this.id);" onmouseout="javascript: leave_status_form(this.id);">Video</a>
                    <div id="post_videos" class="stats_sub_menu">
                      <span class="sub_form" onclick="javascript: show_status_form('upload_videos');" onmouseover="javascript: hoverLink('sub_link_upvideo');" onmouseout="javascript: leaveLink('sub_link_upvideo');"><a id="sub_link_upvideo">Upload a video</a></span>
                      <span class="sub_form" onclick="javascript: show_status_form('record_video_form');" onmouseover="javascript: hoverLink('sub_link_revideo');" onmouseout="javascript: leaveLink('sub_link_revideo');"><a id="sub_link_revideo">Record a video</a></span>
                    </div>
                  </span>
                  
                  <span class="status_menu"><a id="questions_link" class="post_links" onclick="javascript: show_hide_question_form('post_open_question', this.id);" onmouseover="javascript: hover_status_form(this.id);" onmouseout="javascript: leave_status_form(this.id);">Question</a></span>
                  
                  <!-- <span class="status_menu"><a id="open_questions_link" class="post_links" onclick="javascript: show_status_form('post_open_question', this.id);" onmouseover="javascript: hover_status_form(this.id);" onmouseout="javascript: leave_status_form(this.id);">Question</a></span> -->
                </div>
                  <br /><br />
   
                  <div id="post_status" class="form">
                    <table width="100%" style="border: none;">
                      <tr>
                        <td>
                          <form method="post" enctype="multipart/form-data" name="post_stats">
                            <div>
                              <textarea name="stats_field" id="stats_field" class="formFields" onclick="javascript: clear_input(this.id);" onblur="javascript: onblur_stats_input(this.id);" rows="5" style="width:80%; color:#1034BA; resize: none;" placeholder="Share your status">Share your status</textarea>
                            </div>
                            <input name="activity" id="stats_activity" type="hidden" value="status" />
                            <br /><br />
                            <strong>Share your status </strong>
                            <!-- <input name="submit_status" type="button" onclick="javascript: post_status();" value="Share" /> -->
                            <a name="submit_status" class="share_btns" onclick="javascript: post_status();">Share</a> 
                          </form>
                        </td>
                      </tr>
                    </table>
                  </div>
                      
                  <div id="" class="form">
                    <table style="border: #999 1px solid;" width="90%">
                      <tr>
                        <td width="33%" style="border: #999 1px solid; border-top: none; border-bottom: none; border-left: none;">
                          <div class="sub_form" onclick="javascript: show_status_form('upload_photos');" onmouseover="javascript: hoverLink('sub_link_upphoto');" onmouseout="javascript: leaveLink('sub_link_upphoto');"><a id="sub_link_upphoto">Upload a photo</a><br />from your drive</div>
                        </td>
                       <td width="33%" style="border: #999 1px solid; border-top: none; border-bottom: none; border-left: none;">
                         <div class="sub_form" onclick="javascript: show_status_form('take_photo');" onmouseover="javascript: hoverLink('sub_link_rephoto');" onmouseout="javascript: leaveLink('sub_link_rephoto');"><a id="sub_link_rephoto">Take a photo</a><br />with a webcam</div>
                       </td>
                      
                       <td width="33%">
                         <div class="sub_form" onclick="javascript: show_status_form('create_album');" onmouseover="javascript: hoverLink('sub_link_album');" onmouseout="javascript: leaveLink('sub_link_album');"><a id="sub_link_album">Create an album</a><br />with many photos</div>
                       </td>
                     </tr>
                   </table>
                 </div>
                      
                 <div id="post_links" class="form">
                   <table width="100%" style="border: none;">
                     <tr>
                       <td>
                         <form id="post_link" method="post" enctype="multipart/form-data" name="post_link">
                           <strong>Upload your link: </strong><br />
                           <input name="upload_link" id="upload_link" class="formFields" type="text" onclick="javascript: click_link_input(this.id, 'link_details');" onblur="javascript: onblur_link_input(this.id);" style="width:80%; color:#1034BA;" placeholder="Type in your link" value="Type in your link" /><br />
                           <br /><strong>Talk about your link: </strong><br />
                           <input name="link_status" id="link_status" class="formFields" type="text" style="width:80%;" />
                           <input name="link_owner_id" type="hidden" value="<?php echo $id; ?>" />
                           <input name="link_activity" id="link_activity" type="hidden" value="link" />
                           <input name="func" type="hidden" value="link" /><br />
                           
                           <div id="link_details" sytle="display: none; position: relative; width: 100%;"></div>
                           <br />
                           <!-- <input name="submit" type="button" onclick="javascript: submit_link('link_details');" value="Attach" /> -->
                           <a name="submit" class="share_btns" onclick="javascript: submit_link('link_details');">Attach</a>
                         </form>
                       </td>  
                     </tr>
                   </table>
                 </div>
                   
                 <div id="" class="form">
                   <table width="90%" style="border: #999 1px solid;">
                     <tr>
                       <td width="33%" style="border: #999 1px solid; border-top: none; border-bottom: none; border-left: none;">
                         <div class="sub_form" onclick="javascript: show_status_form('upload_videos');" onmouseover="javascript: hoverLink('sub_link_upvideo');" onmouseout="javascript: leaveLink('sub_link_upvideo');"><a id="sub_link_upvideo">Upload a video</a><br />from your drive</div>
                       </td>
                      
                       <td width="33%">
                         <div class="sub_form" onclick="javascript: show_status_form('record_video_form');" onmouseover="javascript: hoverLink('sub_link_revideo');" onmouseout="javascript: leaveLink('sub_link_revideo');"><a id="sub_link_revideo">Record a video</a><br />with a webcam</div>
                       </td>
                     </tr>
                   </table>
                 </div>
                 
                 <div id="upload_photos" class="form">
                   <form id="post_photo" enctype="multipart/form-data" name="post_photo">
                     <strong>Select an image on your computer.</strong><br />
                     <div id="photo_input_wrapper">
                       <!-- <input name="photo_file" type="file" id="photo_file" title="upload a photo" onchange="javascript: check_status_photo(this.form.id, 'errors_window', this.id);" /> -->
                       <input name="photo_file" type="file" id="photo_file" title="upload a photo" />
                     </div>
                     <a class="clear_btns" onclick="javascript: clearFileInput(photo_file.id);">Clear File</a>
                     <br /><br />
                     <input name="photo_stats" id="photo_stats" class="formFields" type="text" onclick="javascript: click_photo_input(this.id);" onblur="javascript: onblur_photo_input(this.id);" rows="1" style="width:80%; color:#1034BA;" placeholder="Say something about this photo" value="Say something about this photo">
                     <input name="photo_owner_id" type="hidden" value="<?php echo $id; ?>" />
                     <input name="photo_activity" id="photo_activity" type="hidden" value="photo" />
                     <input name="func" type="hidden" value="photo" />
                     <br /><br />
                     <!-- <input name="photo_button" type="button" onclick="javascript: submit_photo(this.form.id, 'errors_window', photo_file.id, photo_stats.id);" value="Share your photo" /> -->
                     <a name="photo_button" class="share_btns" onclick="javascript: submit_photo('post_photo', 'errors_window', 'photo_file', 'photo_stats');">Share your photo</a>
                   </form>
                 </div>
      
                 <div id="upload_videos" class="form">
                   <form method="post" id="post_video" enctype="multipart/form-data" name="post_video">
                     <strong>Select a video on your computer.</strong><br />
                     <div id="video_input_wrapper">
                       <!-- <input name="video_file" type="file" id="video_file" title="upload a video" onchange="javascript: check_status_video(this.form.id, 'errors_window', this.id);" /> -->
                       <input name="video_file" type="file" id="video_file" title="upload a video" />
                     </div>
                     <a class="clear_btns" onclick="javascript: clearFileInput(video_file.id);">Clear File</a>
                     <br /><br />
                     <input name="video_stats" type="text" class="formFields" id="video_stats" onclick="javascript: click_video_input(this.id);" onblur="javascript: onblur_video_input(this.id);" rows="1" style="width:80%; color:#1034BA;" placeholder="Say something about this video" value="Say something about this video">
                     <input name="video_owner_id" type="hidden" value="<?php echo $id; ?>" />
                     <input name="video_activity" id="video_activity" type="hidden" value="video" />
                     <input name="func" type="hidden" value="video" />
                     <br /><br />
                     <!-- <input name="video_button" type="button" onclick="javascript: submit_video(this.form.id, 'errors_window', video_file.id, video_stats.id);" value="Share your video" /> -->
                     <a name="video_button" class="share_btns" onclick="javascript: submit_video('post_video', 'errors_window', 'video_file', 'video_stats');">Share your video</a>
                   </form>
                 </div>
      
                 <div id="post_questions" class="form">
                   <form method="post" enctype="multipart/form-data" name="post_question">
                     <strong>Ask your friends a question:</strong> 
                     <input name="question_field" class="formFields" id="question_field" type="text" onclick="javascript: click_question_input(this.id);" onblur="javascript: onblur_question_input(this.id);" rows="1" style="width:99%; color:#1034BA;" value="Ask something..." />
                     <input name="activity" id="activity" type="hidden" value="question" />
                     <br /><br />
                     <!-- <input name="submit" type="submit" value="Ask Question" /> -->
                     <a name="submit" class="share_btns">Ask Question</a>
                   </form>
                 </div>
                 
                 <!-- <div id="post_open_question" class="form">
                   <form method="post" name="ask_form" id="ask_form" enctype="multipart/form-data">
                     <strong>Title:</strong>&nbsp;
                     <input type="text" name="ask_title" id="ask_title" style="width: 40%;" /><br /><br />
                     <strong>Question:</strong><br />
                     <img src="images/bold.png" id="b" onclick="javascript: replace_selected_text(ask_question.id, this.id);" />
                     <img src="images/italic.png" id="i" onclick="javascript: replace_selected_text(ask_question.id, this.id);" />
                     <img src="images/underline.png" id="u" onclick="javascript: replace_selected_text(ask_question.id, this.id);"/>
                     <img src="images/youtube.gif" id="yt" onclick="javascript: replace_selected_text(ask_question.id, this.id);" />
                     <img src="images/insertimage.gif" id="img" onclick="javascript: enter_link(ask_question.id, this.id);"/>
                     <img src="images/createlink.gif" id="link" onclick="javascript: enter_link(ask_question.id, this.id);" />
                     <br />
                     <textarea name="ask_question" id="ask_question" rows="30" cols="60" style="resize: none;"></textarea><br /><br />
                     <strong>Upload Pictures: </strong>
                     <div id="post_qn_photos" class="">
                       <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="350" height="75" id="upload_qn_photos" align="middle">
				         <param name="movie" value="swf/upload_qn_photos.swf" />
				         <param name="quality" value="high" />
				         <param name="bgcolor" value="#ffffff" />
				         <param name="play" value="true" />
			             <param name="loop" value="true" />
			             <param name="wmode" value="window" />
				         <param name="scale" value="showall" />
				         <param name="menu" value="true" />
				         <param name="devicefont" value="false" />
				         <param name="salign" value="" />
				         <param name="allowScriptAccess" value="always" />
                          
                           <embed type="application/x-shockwave-flash" width="350" height="75" src="swf/upload_qn_photos.swf" allowScriptAccess="always" quality="high" id="upload_qn_photos2" bgcolor="#ffffff" play="true" loop="true" wmode="window" scale="showall" menu="true" devicefont="false" salign=""></embed>
                          
                       </object>
			           
			           <div id="progress_bars">
                         <div id="progress_outer" style="width: 100px; height: 10px; border: 1px solid red; margin-top: 10px; margin-left: 20px; display: none;">
                         <div id="progress_inner" style="position: relative; height: 10px; background-color: purple; width: 0%;"></div>
                       </div>

                       <div id="qn_images_form"></div>
                          
                       </div>  
                     </div>
                     <br />
                     <div style="font-weight: bold;">Upload Video: </div>
                     <div id="video_input_wrapper"><input type="file" name="question_video" id="question_video" class="video_upload" title="upload a video" onchange="javascript: check_files(this.form.id, qns_video_check.id, this.id); return false;" /></div>
                     <br />
                     <span name="qns_video_check" id="qns_video_check"></span><br />
                     Allow to search for of searchkeys of other users to get more answers to your question:
                     <input name="use_metakeys" id="use_metakeys" type="checkbox" value="yes" /><br />
                     <input name="question_owner_id" id="question_owner_id" type="hidden" value="' . $id . '" />
                     <input name="activity" id="activity" type="hidden" value="ask" />
                     <input name="func" id="func" type="hidden" value="question" /> 
                     <a name="questionBtn" class="question_btns" onclick="javascript: post_question2(total_questions.id);">Ask</a>
                   </form>
                   <div id="text_preview" style="display: none; margin-top: 10px;"></div><br />
                 </div> -->
                 
                 <div id="create_album" class="form">
                   <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="350" height="75" id="upload_mul_photos" align="middle">
				     <param name="movie" value="swf/upload_mul_photos.swf" />
				     <param name="quality" value="high" />
				     <param name="bgcolor" value="#ffffff" />
				     <param name="play" value="true" />
				     <param name="loop" value="true" />
				     <param name="wmode" value="window" />
				     <param name="scale" value="showall" />
				     <param name="menu" value="true" />
				     <param name="devicefont" value="false" />
				     <param name="salign" value="" />
				     <param name="allowScriptAccess" value="sameDomain" />
                     <!--[if !IE]>-->
                       <embed type="application/x-shockwave-flash" width="350" height="75" src="swf/upload_mul_photos.swf" allowScriptAccess="sameDomain" quality="high" id="upload_mul_photos2" bgcolor="#ffffff" play="true" loop="true" wmode="window" scale="showall" menu="true" devicefont="false" salign=""></embed>
                     <!--<![endif]-->
                   </object>
			          
			       <div id="progress_bars" style="display: none;">
                     <div id="progress_outer" style="width: 100px; height: 10px; border: 1px solid red; margin-top: 10px; margin-left: 20px; display: none;">
                       <div id="progress_inner" style="position: relative; height: 10px; background-color: purple; width: 0%;"></div>
                     </div>
                     
                     <br />
                     <strong>Album Name: </strong><input type="text" name="album_name_inp" id="album_name_inp" /><br />
                     <strong style="margin-left: 7px;">Description: </strong><input type="text" name="album_desc_inp" id="album_desc_inp" />
                     <input type="hidden" name="album_id_inp" id="album_id_inp" />
                     <br /><br />
                     <form id="album_form"></form>
                     <!-- <input type="button" onclick="javascript: post_album();" value="Post photos" /> -->
                     <a class="share_btns" onclick="javascript: post_album();">Post photos</a>
                   </div>  
                   
                 </div>
                 
                 <div id="record_video_form" class="form">
                   <span style="font-weight: bold;">Talk about this video: </span>
                   <input type="text" name="record_video_status" id="record_video_status" class="formFields" style="width: 50%;" />
                   <input type="hidden" name="record_video_id" id="record_video_id" />
                   <input type="hidden" name="rec_vid_owner_id" id="rec_vid_owner_id" />
                   <br />
                   <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="550" height="400" id="record_video" align="middle">
				     <param name="movie" value="swf/record_video.swf" />
				     <param name="quality" value="high" />
				     <param name="bgcolor" value="#ffffff" />
				     <param name="play" value="true" />
				     <param name="loop" value="true" />
				     <param name="wmode" value="window" />
				     <param name="scale" value="showall" />
				     <param name="menu" value="true" />
				     <param name="devicefont" value="false" />
				     <param name="salign" value="" />
				     <param name="allowScriptAccess" value="sameDomain" />
				     <!--[if !IE]>-->
				       <embed type="application/x-shockwave-flash" width="550" height="400" src="swf/record_video.swf" allowScriptAccess="sameDomain" quality="high" id="record_video2" bgcolor="#ffffff" play="true" loop="true" wmode="window" scale="showall" menu="true" devicefont="false" salign=""></embed>
				     <!--<![endif]-->
			       </object>
			       
			       <br /><br />
			       <!-- <input type="button" onclick="javascript: post_record_video();" value="Post Video" /> -->
			       <a class="share_btns" onclick="javascript: post_record_video();">Post Video</a>
                   
                 </div>
                  
               <br /><br />
               <div class="seperator" style="border-bottom: 1px dashed #C3C3C3; width: 90%;"></div>
               <br /><br />
                  
               <div id="fb_container" style="width:530px; overflow-x:hidden;">
                 <div id="updates"><?php // echo $display; ?></div>
               </div>
               
             </div>
              
             <div id="message_windows" class="window" style="display: none;">
              
             <div id="msg_errors_window" class="message_sub_window" style="display: none;"></div>
              
               <div id="pm_form_window" class="message_sub_window" style="display: none;">
                 <br />
                 <font size="+1">Send New Message to other users</font><br /><br />
                 
                 <div style="border: #D8D8D8 1px solid; padding: 10px;">
                    <form name="pmForm" id="pmForm" method="post">
                      <strong style="margin-left: 28px;">To:</strong>
                      <input name="rcpntName" id="pm_rec_name" type="text" style="width: 50%; border: #CCC 1px solid; height: 25px;" onblur="javascript: check_valid_recipient(this, 'nameresponse');" />
                      <span id="nameresponse"><span class="textSize_9px"><span class="greyColor">Username only</span></span></span>
                      <br /><br />
                      <strong>Subject:</strong>
                      <input name="subject" id="pmSubject" type="text" style="width: 50%; border: #CCC 1px solid; height: 25px;" /><br /><br />
                      <strong>Message:</strong><br />
                      <textarea name="message" id="pmTextArea" style="width:90%; height: 150px; resize: none; border: #CCC 1px solid; margin-top: 5px;"></textarea>
                      <br />
                      <div id="attach_input_wrapper">
                        <!-- <input type="file" name="attachment" id="pm_attachment" onchange="javascript: jvs_chk_attachment(this.id);" /> -->
                        <input type="file" name="attachment" id="pm_attachment" title="upload attachment" onchange="javascript: check_attachment(this.form.id, 'msg_errors_window', this.id);" />
                      </div>
                      <input name="senderID" id="pm_sender_id" type="hidden" value="<?php echo $id; ?>" />
                      <input name="senderName" id="pm_sender_name" type="hidden" value="<?php echo $_SESSION['username']; ?>" />
                      <input name="type" id="pm_type" type="hidden" value="new" />
                      <!-- <input name="pm_rec_id" id="pm_rec_id" type="hidden" value="<?php echo $id; ?>" /> -->
                      <!-- <input name="pmWipit" id="pmWipit" type="hidden" value="<?php echo $thisRandNum; ?>" /> -->
                      <span id="PMStatus" style="color:#F00;"></span>
                      <input name="pmSubmit" type="button" onclick="javascript: send_reply(this.form.id, 'msg_errors_window');" style="background-color: #454545; color: #FFFFFF; border: none; padding: 3px 10px; border-radius: 3px; font-weight: bold; font-size: 11px; cursor: pointer;" value="Send" />
                      <span id="pmFormProcessGif" style="display:none;"><img src="images/loading.gif" width="28" height="10" alt="Loading" /></span>
                    </form>
                  </div>
                  
                </div>
                
                 <div id="inbox_list" class="message_sub_window" style="display: none;">
                   <?php // echo $display_inbox_list; ?>
                 </div>

                 <div id="outbox_list" class="message_sub_window" style="display: block;">
                   <?php // echo $display_outbox_list; ?>
                 </div>

                 <div id="whole_message" class="message_sub_window" style="display: none;">
                   <?php 
      
                     // $pm_id = $_GET['pm_id'];
                     // $viewer_type = $_GET['viewer_type'];
                     $display_whole_message = $pm->display_whole_message($pm_id, $id, $viewer_type); 
                     echo $display_whole_message;
                   ?>
                 </div>

              </div>
              
              <div id="events_windows" class="window" style="display: none;">
                 <strong>Test displaying events windows</strong>
              </div>
              
              <div id="friends_windows" class="window" style="display: none;">
                 <?php 
                   // $friends_list = $frnds->show_user_friends($id);
                   // echo $friends_list;
                 ?>
                 <div id="friends_count_header"></div>
                 <div id="friends_lists"></div>
              </div>
              
              <div id="bookmarks_windows" class="window" style="display: none; margin-top: 10px;">
               
                <div style="margin-top: 30px; margin-bottom: 20px; font-size: 15px; font-weight: bold;">SELECT A BOOKMARK TYPE</div>
               
                <div id="select_bm_type" style="margin-top: 10px;">
                  <div class="type_select_wrapper">
                    <select name="bookmark_type" id="bookmark_type" class="type_select" onchange="javascript: select_bookmark_type(this);">
		              <option id="all" value="all">All</option>
		              <option id="status" value="status">status</option>
		              <option id="photo" value="photo">photo</option>
		              <option id="video" value="video">video</option>
		              <option id="link" value="link">link</option>
		              <option id="album" value="album">album</option>
		              <option id="question" value="question">question</option>
		              <option id="answer" value="answer">answer</option>
		          </select>
		          </div>
		        </div>
		        
		        <div style="margin-top: 30px; margin-bottom: 20px; font-size: 15px; font-weight: bold;">OR SEARCH FOR BOOKMARKS</div>
		        
		        <div id="search_bookmarks" style="margin-top: 10px;">
		          
		          <form id="bookmark_form" name="bookmark_form" method="post" action="javascript: return false;" onsubmit="javascript: display_initial_bms('bm_search_input', 'bm_search_type');">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; font-weight: normal;">Search Here:</p>
               
                    <div style="display: inline-block;">
                      <span>
                        <input type="text" name="bm_search_input" id="bm_search_input" class="search_input" autocomplete="off" onkeyup="javascript: autocomplete();" />
                        <div style="width: 300px; height: 100px; border: 1px solid #000000; background-color: #FFFFFF; position: absolute; display: none;"></div>
                      </span>
                    </div>
                    
                    <select name="bm_search_type" id="bm_search_type" class="formFields" style="margin-left: 5px;">
		              <option id="all" value="all">All</option>
		              <option id="status" value="status">Status</option>
		              <option id="photo" value="photo">Photo</option>
		              <option id="video" value="video">Video</option>
		              <option id="link" value="link">Link</option>
		              <option id="album" value="album">Album</option>
		              <option id="question" value="question">Question</option>
		              <option id="answer" value="answer">Answer</option>
		            </select>
                    <br />
                    
                    <input name="bookmark_btn" id="bookmark_btn" type="submit" class="search_btn" value="Search" />
            
                  </form>
		          
		        </div>
		        
		        <br /><br />
		        <div class="seperator" style="border-bottom: 1px dashed #C3C3C3; width: 90%;"></div>
		        <br /><br />
		        
                <div id="bookmarks_div" style="margin-top: 10px;"></div>
              </div>
              
              <div id="my_questions_windows" class="window" style="display: none;"></div>
              
              <div id="my_answers_windows" class="window" style="display: none;"></div>
              
              <!-- <div id="edit_question_window" class="window" style="display: none;"></div>
              
              <div id="edit_question_window" class="window" style="display: none;"></div> -->
              
              <div id="chats_windows" class="window" style="display: none; position: relative;">
                <div id="chat_users"></div>
                
                <div id="chat_details" style="display: none; overflow: hidden;"></div>
                <div id="full_chat_form_box" style="display: none;"></div>
              </div>
             
            </td>
          </tr>
          <tr>
            <td colspan="2" valign="top">
            </td>
          </tr>
        </table>
       <p><br />
         <br />
  </p></td>
      <td width="160" valign="top" style="padding: 5px;">
        <div><a href="create_ad.php" class="normal_link" style="font-weight: bold; color: blue;">Create an ad</a></div>
        <?php include_once("right_AD_template2.php"); ?><br /><br />
        <?php include_once("right_AD_template.php"); ?>
      </td>
    </tr>
</table>
</div>

<div id="rqst_frnd_bkgndPopup">
  <div id="confirm_rqst_frnd">
    <div style="background-color: #4D90FE; text-align: center; padding: 10px;">
      <span id="rqst_header"></span>
    </div>
  
    <div style="width: 400px; padding: 10px;">
      <span id="owner_pic" style="width: 30%;"></span>
      <span id="rqst_msg" style="display: inline-block; width: 70%; color: #000000; font-size: 12px; font-weight: normal; vertical-align: top;"></span>
    </div>
    
    <div style="background-color: #E7E7E7; padding: 10px; vertical-align: middle;">
      <span style="margin-left: 10px;"><a id="frnd_yes_button" class="yes_btns" style="">Yes</a></span>
      <span style="margin-left: 16px;"><a id="frnd_cancel_button" class="cancel_btns" style="">Cancel</a></span>
    </div>
  </div>
</div>

<div id="post_open_question" class="form" style="position: absolute; width: 750px; display: none; background-color: #FFFFFF; z-index: 10; border: 1px solid #DDDDDD;">
  <div style="margin-left: 10px; margin-top: 10px;">
    <span class="stats_btns" onclick="javascript: show_hide_question_form('post_open_question');" style="display: inline-block; padding: 1px 20px;"><img src="images/arrow_left.png" style="width: 22px; height: 22px;" /></span>
  </div>
  <iframe id="post_question_link" style="width: 740px; min-height: 700px;"></iframe>
</div>

<div id="edit_question_form" class="form" style="position: absolute; width: 1030px; display: none; background-color: #FFFFFF; z-index: 10; border: 1px solid #DDDDDD;">
  <div style="margin-left: 10px; margin-top: 10px;">
    <span class="stats_btns" onclick="javascript: close_edit_qn_form();" style="display: inline-block; padding: 1px 20px;"><img src="images/arrow_left.png" style="width: 22px; height: 22px;" /></span>
  </div>
  <iframe id="edit_question_link" style="width: 1020px; min-height: 700px;"></iframe>
</div>

<div id="edit_answer_form" class="form" style="position: absolute; width: 1030px; display: none; background-color: #FFFFFF; z-index: 10; border: 1px solid #DDDDDD;">
  <div style="margin-left: 10px; margin-top: 10px;">
    <span class="stats_btns" onclick="javascript: close_edit_ans_form();" style="display: inline-block; padding: 1px 20px;"><img src="images/arrow_left.png" style="width: 22px; height: 22px;" /></span>
  </div>
  <iframe id="edit_answer_link" style="width: 1020px; min-height: 700px;"></iframe>
</div>

<?php include_once "footer.php"; ?>
</body>
</html> 
 



























































  