<?php

session_start();

$id = $_SESSION['id'];

include ("../connect/connect_to_mysql.php");

if (isset($_POST['activity']) && $_POST['activity'] == 'photo') {

  if ($_FILES['photo_field']['tmp_name'] != "") {
        $maxfilesize = 51200; // 51200 bytes equals 50kb
  
    if ($_FILES['photo_field']['size'] > $maxfilesize) {
 
          $error_msg = '<font color="#FF0000">Error: Your image file is too large, please upload another image file.</font>';
          unlink($_FILES['photo_field']['tmp_name']);

    } else if (!preg_match("/\.(gif|jpg|png)$/i", $_FILES['photo_field']['name'])) {

          $error_msg = '<font color="#FF0000">Error: Your image file was not one of the accepted formats, please upload another image file.</font>';
          unlink($_FILES['photo_field']['tmp_name']);

    } else {

          $activity = $_POST['activity'];

          $photo_status = $_POST['photo_stats'];
          $photo_status = stripslashes($photo_status);
          $photo_status = strip_tags($photo_status);
          $photo_status = mysql_real_escape_string($photo_status);

          $sql_insert_photo = mysql_query("INSERT INTO photo (owner_id, created_time, status) VALUES ('$id', now(), '$photo_status')") or die('Error: inserting details into photo table.  ' . mysql_error());
          
          $sql_photo = mysql_query("SELECT photo_id FROM photo WHERE owner_id='$id' ORDER BY created_time ASC LIMIT 1") or die('Error: selecting details from photo table.  ' . mysql_error());

           while ($row = mysql_fetch_array($sql_photo)) {
                    $photo_id = $row['id'];
           }
           
           $sql_insert_myact = mysql_query("INSERT INTO user_activities (mem_id, user_activity, activity_time, object_id) VALUES ('$id','$activity', now(), '$photo_id')") or die('Error: Inserting your activities into user_activities  ' . mysql_error());
           
           $newname = $photo_id . ".jpg";
           $address = "members/$id/photos/".$newname;
           $place_file = move_uploaded_file($_FILES['photo_field']['tmp_name'], $address);
           
           $photo_url = "photo.php?id=".$photo_id;
           
           $sql_update_photo = mysql_query("UPDATE photo SET pid='$address', photo_address='$photo_url' WHERE photo_id='$photo_id'") or die('Error: updating details from photo table.  ' . mysql_error());
           
    }

  }

}

?>

<html>
<head>
<title>Display Status Form</title>
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
<script src="js/status_form.js" type="text/javascript"></script>

<style type="text/css">

.form {
  display: none;
}

.sub_form:hover {
   background-color: #E9E8F2;
   cursor: pointer;
}

.post_links {
   cursor: pointer;
   color: #000000;
   font: 12px arial,serif;
   text-decoration: none;
}

.post_links:hover {
   text-decoration: underline;
}

</style>

<script language="javascript" type="text/javascript">

Id = '<?php echo $id; ?>';

$(document).ready(function() {
    show_status('post_status', 'status_link');
});

function show_status_form (Form, link_id) {

	$('.post_links').css({"color" : "#000000",
		                  "font" : "12px arial,serif"
		                });

	$('#'+link_id).css({"color" : "#000000",
		                "font" : "bold 13px arial,serif"
		               });
    $('.form').hide();
	$('#'+Form).show();  
  
} 

function upload_files() {

	var url = "post_files.php";

	var FORM = "upload_photo";

	// alert (FORM);

	  $.post(url, {form:FORM} ,function(data) {
		$("#status").html(data).show();  
	  }); 
} 

function hoverLink (link_id) {
    //alert(link_id);
    $('#'+link_id).css({"text-decoration" : "underline"});
}

function leaveLink (link_id) {
	// alert(link_id);
	$('#'+link_id).css({"text-decoration" : "none"});
}

</script>


</head>

<body>

<table width="500px" align="center">
  <tr>
    <td>
    <a id="status_link" class="post_links" onclick="javascript: show_status('post_status', this.id);">Status</a>
    <a id="photos_link" class="post_links" onclick="javascript: show_status('post_photos', this.id);">Photo</a>
    <a id="links_link" class="post_links" onclick="javascript: show_status('post_links', this.id);">Link</a>
    <a id="videos_link" class="post_links" onclick="javascript: show_status('post_videos', this.id);">Video</a>
    <a id="questions_link" class="post_links" onclick="javascript: show_status('post_questions', this.id);">Question</a>

    <br /><br />
    
    <div id="errors_window" style="display: none;"></div>

    <div id="form_windows">
      <div id="post_status" class="form">
        <table width="100%" style="border: none;">
          <tr>
            <td>
              <form method="post" enctype="multipart/form-data" name="post_stats">
                <input type="text" name="stats_field" id="stats_field" class="formFields" onclick="javascript: clear_input(this.id);" onblur="javascript: onblur_stats_input(this.id);" rows="1" style="width:99%;" value="Share your status">
                <input name="activity" id="stats_activity" type="hidden" value="status" />
                <strong>Share your status</strong> (220 char max) <input name="submit_status" type="button" onclick="javascript: post_status();" value="Share" />
              </form>
            </td>
          </tr>
        </table>
      </div>
                      
      <div id="post_photos" class="form">
        <table width="100%" style="border: #999 1px solid;">
          <tr>
            <td width="33%" style="border: #999 1px solid; border-top: none; border-bottom: none; border-left: none;">
              <div class="sub_form" onclick="javascript: show_status('upload_photos');" onmouseover="javascript: hoverLink('sub_link_upphoto');" onmouseout="javascript: leaveLink('sub_link_upphoto');"><a id="sub_link_upphoto">Upload a photo</a><br />from your drive</div>
            </td>
                      
            <td width="33%" style="border: #999 1px solid; border-top: none; border-bottom: none; border-left: none;">
              <div class="sub_form" onclick="javascript: show_status('take_photo');" onmouseover="javascript: hoverLink('sub_link_rephoto');" onmouseout="javascript: leaveLink('sub_link_rephoto');"><a id="sub_link_rephoto">Take a photo</a><br />with a webcam</div>
            </td>
                      
            <td width="33%">
              <div class="sub_form" onclick="javascript: show_status('create_album');" onmouseover="javascript: hoverLink('sub_link_album');" onmouseout="javascript: leaveLink('sub_link_album');"><a id="sub_link_album">Create an album</a><br />with many photos</div>
            </td>
          </tr>
        </table>
      </div>
                      
      <div id="post_links" class="form">
        <table width="100%" style="border: none;">
          <tr>
            <td>
              <input name="link" id="upload_link" type="text" onclick="javascript: clear_input(this.id);" onblur="javascript: onblur_link_input(this.id);" style="width:80%;" value="Upload a link" /><input name="submit" type="submit" style="align: right;" value="Attach" /> 
            </td>  
          </tr>
        </table>
      </div>
                   
      <div id="post_videos" class="form">
        <table width="100%" style="border: #999 1px solid;">
          <tr>
            <td width="33%" style="border: #999 1px solid; border-top: none; border-bottom: none; border-left: none;">
              <div class="sub_form" onclick="javascript: show_status('upload_videos');" onmouseover="javascript: hoverLink('sub_link_upvideo');" onmouseout="javascript: leaveLink('sub_link_upvideo');"><a id="sub_link_upvideo">Upload a video</a><br />from your drive</div>
            </td>
                      
            <td width="33%">
              <div class="sub_form" onclick="javascript: show_status('record_video');" onmouseover="javascript: hoverLink('sub_link_revideo');" onmouseout="javascript: leaveLink('sub_link_revideo');"><a id="sub_link_revideo">Record a video</a><br />with a webcam</div>
            </td>
          </tr>
        </table>
      </div>
      
      <div id="upload_photos" class="form">
        <form id="post_photo" enctype="multipart/form-data" name="post_photo">
          <strong>Select an image on your computer.</strong><br />
          <input name="photo_file" type="file" class="formFields" id="photo_file" size="20"/><br /><br />
          <input name="photo_stats" id="photo_stats" type="text" onclick="javascript: click_photo_input(this.id);" onblur="javascript: onblur_photo_input(this.id);" rows="1" style="width:99%;" value="Say something about this photo">
          <input name="photo_owner_id" type="hidden" value="<?php echo $id; ?>" />
          <input name="photo_activity" id="photo_activity" type="hidden" value="photo" />
          <input name="func" type="hidden" value="photo" />
          <input name="photo_button" type="button" onclick="javascript: submit_photo(this.form.id);" value="Share your photo" />
        </form>
      </div>
      
      <div id="upload_videos" class="form">
        <form method="post" id="post_video" enctype="multipart/form-data" name="post_video">
          <strong>Select a video on your computer.</strong><br />
          <input name="video_file" type="file" class="formFields" id="video_file" size="20"/><br /><br />
          <input name="video_stats" type="text" class="formFields" id="video_stats" onclick="javascript: click_video_input(this.id);" onblur="javascript: onblur_video_input(this.id);" rows="1" style="width:99%;" value="Say something about this video">
          <input name="video_owner_id" type="hidden" value="<?php echo $id; ?>" />
          <input name="video_activity" id="video_activity" type="hidden" value="video" />
          <input name="func" type="hidden" value="video" />
          <input name="video_button" type="button" onclick="javascript: submit_video(this.form.id);" value="Share your video" />
        </form>
      </div>
      
      <div id="post_questions" class="form">
        <form action="disp_statsform.php" method="post" enctype="multipart/form-data" name="post_question">
          <strong>Ask your friends a question:</strong> 
          <input name="question_field" class="formFields" id="question_field" type="text" onclick="javascript: click_question_input(this.id);" onblur="javascript: onblur_question_input(this.id);" rows="1" style="width:99%;" value="Ask something.." />
          <input name="activity" id="activity" type="hidden" value="question" />
          <input name="submit" type="submit" value="Ask Question" />
        </form>
      </div>
                       
    </div>
    </td>
  </tr>
</table>

</body>
</html>



