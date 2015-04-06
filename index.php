<?php 

/* if ($_SERVER['HTTPS'] != "on") {
      $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      header("Location:$redirect");
} 

if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
      header("Location:http://m.hookedd.com");
      // echo 'You are using a mobile device to access this website. Please go to <a href="https://m.hookedd.com"><strong>m.hookedd.com</strong></a>';
}

include ("check/homepage_check_user_login.php");

include ("view/non_member_view.php"); */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Hookedd</title>

<link href="style/main.css" rel="stylesheet" type="text/css" />
<!-- <link href="style/style.css" rel="stylesheet" type="text/css" /> -->
<link href="style/homepage.css" rel="stylesheet" type="text/css" />
<link href="style/header.css" rel="stylesheet" type="text/css" />
<link href="style/footer_home.css" rel="stylesheet" type="text/css" />
<link href="style/login.css" rel="stylesheet" type="text/css" />

<link rel="icon href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

<script src="js/jquery-1.5.js" type="text/javascript"></script>
<script src="js/jcarousellite_1.0.1.pack.js" type="text/javascript"></script>
<script src="js/vertical-slider.js" type="text/javascript"></script>
<script src="js/login.js" type="text/javascript"></script>
<script src="js/register.js" type="text/javascript"></script>
<script src="js/search.js" type="text/javascript"></script>
<script src="js/google_track.js" type="text/javascript"></script>

<style type="text/css">
<!--

-->
</style>

<script type="text/javascript">

  function close_featured_div(Div) {
    document.getElementById(Div).style.display = "none";
  }

</script>

</head>

<body style="background: url(images/main_bg.jpg) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; overflow-y: scroll;">
<?php include ("homepage_header.php"); ?>

<div id="container">
  <!-- <div id="featured" class="promotions" style="margin-top: 10px; margin-bottom: 10px;">
     <div style="font-size: 20px; font-weight: bold; text-align: center; color: blue;">
       Get rewarded with cash when you ask a question!
     </div>
     <div style="font-size: 16px; margin-top: 5px; text-align: center; color: #FFFFFF; font-weight: bold;">
       Hookedd.com is introducing a revenue sharing program when a user posts a question. The user will earn 5 - 15% of the total revenue generated from advertisements placed on his/her question page.
     </div> -->

     <!-- <a onclick="javascript: close_featured_div('featured');" title="close this box" style="position: absolute; right: 5px; top: 5px; color: #111111; cursor: pointer;"><img src="images/close.png" style="width: 15px; height: 15px;" /></a> -->
  </div>
  
  <div id="horz_ads" style="width: 1000px; position: relative; margin: 0 auto;">
    <!--  <div id="horz_ads" style="width: 500px; position: relative; margin: 0 auto;">
      <a href="http://www.ipage.com/join/index.bml?AffID=708867&LinkName=Hookedd.com Homepage"><img src="http://www.ipage.com/affiliate/banners/694" style="border: 0px;" alt="affiliate_link"></a>
    </div> -->
  </div>

  <div class="warp-container" style="margin-top: 100px;">
    <div class="map-section">
      <p class="desc_title">Welcome to Hookedd</p>
      <br />
      <p class="desc_text">Hookedd.com is a social networking platform that mainly focus on Q & A.</p> 
      <br />
      <p class="desc_text">Hookedd allows you to upload photos and videos from your own  computer or you could insert website links to photos and youtube videos when posting questions and answers.</p>
      <br />
      <p class="desc_text">Get notified with questions you are interested to view. The system will automatically find the questions that match with your interest and notify you instantly.</p>
      <br />
      <p class="desc_text">You have your own user homepage where you can view, post and share links, photos and video with your friends of your network. You also have your own personal profile page where other users can view information about you.</p>
    </div>
    <div class="join-section">
      <div id="register_error" style="background-color: #FFEBE8; border: 1px solid #DD3C10; padding: 5px; text-align: center; display: none; font-size: 12px;"></div>
      <div><p style="margin-left: 5px;">Sign up now</p></div>
	  <!-- <div class="join-top"></div> -->
	  <div class="join-mid">
	    <table cellpadding="0" cellspacing="0" class="join-table">
	      <tr><td>Username :</td></tr>
		<tr><td><input type="text" class="inp-bg" name="username" id="username" /></td></tr>
		<tr><td class="altrow"></td></tr>
		<tr><td>Email :</td></tr>
		<tr><td><input type="text" class="inp-bg" name="email1" id="email1" /></td></tr>
		<tr><td class="altrow"></td></tr>
		<tr><td>Password :</td></tr>
		<tr><td><input type="password" class="inp-bg" name="pass1" id="pass1" /></td></tr>
		<tr><td class="altrow"></td></tr>
		<tr><td>Confirm Password:</td></tr>
		<tr><td><input type="password" class="inp-bg" name="pass2" id="pass2" /></td></tr>
		<tr><td class="altrow" style="padding:1px;"></td></tr>
		<!-- <tr><td style="font-size:12px;"><input type="checkbox" name="" />&nbsp;I agree to the Terms of Service</td></tr> -->
            <tr><td style="font-size:12px;">By clicking on the button below, you agree to our Terms of Service</td></tr>
		<tr><td class="altrow"></td></tr>
		<tr><td align="center"><input id="quick_reg_btn" type="image" src="images/join-us.png" onclick="javascript: quick_register();" style="border:none;" /></td></tr>
          </table>
	  </div>
	  <!-- <div class="join-foot"></div> -->
                        
    </div>
    
    <!-- <div id="right_side_ads">
      <a href="http://www.ipage.com/join/index.bml?AffID=708867&LinkName=Hookedd.com Homepage">
        <img src="http://www.ipage.com/affiliate/banners/881" style="border:0px" alt="affiliate_link">
      </a>
    </div> -->
    
  </div>
</div>

<br /><br />

<?php include_once "footer_home.php"; ?>

</body>
</html>
