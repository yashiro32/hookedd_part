<?php

if ($_SERVER['HTTPS'] != "on") {
      $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      header("Location:$redirect");
}

include("check/homepage_check_user_login.php");
?>
<?php
$from = ""; // Initialize the email variable
// This code runs only if the username is posted
if (isset ($_POST['username'])) {

    $username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['username']); // filter everything but letters and numbers
    $username = strip_tags($username);
    $username = mysql_real_escape_string($username);
    
    $gender = preg_replace('#[^a-z]#i', '', $_POST['gender']); // filter everything but lowercase letters
    $gender = strip_tags($gender);
    $gender = mysql_real_escape_string($gender);
    
    $b_m = preg_replace('#[^0-9]#i', '', $_POST['birth_month']); // filter everything but numbers
    $b_d = preg_replace('#[^0-9]#i', '', $_POST['birth_day']); // filter everything but numbers 
    $b_y = preg_replace('#[^0-9]#i', '', $_POST['birth_year']); // filter everything but numbers
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    $humancheck = $_POST['humancheck'];

    $email1 = stripslashes($email1);
    $pass1 = stripslashes($pass1);
    $email2 = stripslashes($email2); 
    $pass2 = stripslashes($pass2);

    $email1 = strip_tags($email1);
    $pass1 = strip_tags($pass1);
    $email2 = strip_tags($email2);
    $pass2 = strip_tags($pass2);

    // Connect to database
    include_once "connect/connect_to_mysql.php";
    $email2 = mysql_real_escape_string($email2);
    
    $pass2 = mysql_real_escape_string($pass2);
    
    $emailChecker = mysql_real_escape_string($email1);
    $emailChecker = str_replace("`", "", $emailChecker);
     // Database duplicate username check setup for use below in the error handling if else conditionals
    $sql_username_check = mysql_query("SELECT username FROM user_details WHERE username='$username'") or die('Error: selecting details from Table user_details.  ' . mysql_error());
    $username_check = mysql_num_rows($sql_username_check);

    $sql_pname_check = mysql_query("SELECT username FROM pending_account WHERE username='$username'") or die('Error: selecting details from Table pending_account.  ' . mysql_error());
    $pname_check = mysql_num_rows($sql_pname_check);
    
     // Database duplicate e-mail check setup for use below in the error handling if else conditionals
    $sql_email_check = mysql_query("SELECT email FROM user_details WHERE email='$emailChecker'");
    $email_check = mysql_num_rows($sql_email_check);

    include("check/check_valid_email.php");
    
    // Error handling for missing data
    if ((!$username) || (!$gender) || (!$b_m) || (!$b_d) || (!$b_y) || (!$email1) || (!$email2) || (!$pass1) || (!$pass2)) {

    $errorMsg = 'ERROR: You did not submit the following required information:<br /><br />';

    if (!$username) {
         $errorMsg .= ' * User Name<br />';
    }
    if (!$gender) {
         $errorMsg .= ' * Gender: Confirm your sex.<br />';
    }
    if (!$b_m) {
         $errorMsg .= ' * Birth Month<br />';
    }
    if (!$b_d) {
         $errorMsg .= ' * Birth Day<br />';
    }
    if (!$b_y) {
         $errorMsg .= ' * Birth Year<br />';
    }
    if (!$email1) {
         $errorMsg .= ' * Email Address<br />';
    }
    if (!$email2) {
         $errorMsg .= ' * Confirm your Email Address<br />';
    }
    if (!$pass1) {
         $errorMsg .= ' * Login Password<br />';
    } 
    if (!$pass2) {
         $errorMsg .= ' * Confirm your Password<br />';
    }

    } else if (check_valid_email($email1) == false) {

              $errorMsg = "Invalid e-mail address entered! Please enter a valid e-mail address.";
        
    } else if ($email1 != $email2) {
              $errorMsg = 'ERROR: Your Email fields below do not match<br />';
    } else if ($pass1 != $pass2) {
              $errorMsg = 'ERROR: Your Password fields below do not match<br />';
    } else if ($humancheck != "") {
              $errorMsg = 'ERROR: The Human Check must be cleared to be sure you are a human<br />';
    } else if (strlen($username) < 4) {
              $errorMsg = "<u>ERROR:</u><br />Your User Name is too short. It must be between 4-20 characters long.<br />";
    } else if (strlen($username) > 20) {
              $errorMsg = "<u>ERROR:</u><br />Your User Name is too long. It must be between 4-20 characters long.<br />";
    } else if ($username_check > 0 || $pname_check > 0) {
              $errorMsg = "<u>ERROR:</u><br />Your User Name is already in use. Please try another one.<br />";
    } else if ($email_check > 0) {
              $errorMsg = "<u>ERROR:</u><br />Your Email address is already in use. Please use another one.<br />";
    } else { // Error handling has ended, process the data and add member to the database

    $email1 = mysql_real_escape_string($email1);
    $pass1 = mysql_real_escape_string($pass1);

    // Add MD5 Hash to the password variable
    $db_password = md5($pass1);

    // Convert Birthday to a Date field type format (YYYY-MM-DD) out of the month, day, and year supplied
    $full_birthday = "$b_y-$b_m-$b_d";

    // Get user IP address
    $ipaddress = getenv('REMOTE_ADDR');

    // Add user info into the database table for the main site table
    /* $sql = mysql_query("INSERT INTO user_details (username, gender, birthday, email, password, ipaddress, sign_up_date)
    VALUES ('$username', '$gender', '$full_birthday', '$email1', '$db_password', '$ipaddress', now())")
    or die('error inserting user details into database<br />' . mysql_error());  */
    
    $sql = mysql_query("INSERT INTO pending_account (username, gender, birthday, email, password, ipaddress, sign_up_date)
    VALUES ('$username', '$gender', '$full_birthday', '$email1', '$db_password', '$ipaddress', now())")
    or die('Error: inserting details into table pending_account<br />' . mysql_error()); 

    $id = mysql_insert_id();

    // Create directory folder to hold each user's files(pics, MP3s, etc.)
    // mkdir("members/$id", 0777);

   // Email user the activation link 

   $to = "$email1";
   
   $from = 'admin@hookedd.com'; // $adminEmail is established in [connect_to_mysql.php]
   $subject = 'Complete Your Hookedd.com Registration';
   // Begin HTML Email message
   $message = "Hi $username,

   Complete this step to activate your login identity at Hookedd.com 

   Click the line below to activate when ready

   http://www.hookedd.com/activation.php?id=$id&username=$username&email=$email1&sequence=$db_password
   If the URL above is not an active link, please copy and paste it into your browser address bar

   Login after successful activation using your:
   E-mail Address : $email1
   Password: $pass1

   See you on the site!";
   // end of message
     $headers = "From: $from\r\n";
     $headers .= "Content-type: text\r\n";
     
     if (!(mail($to, $subject, $message, $headers))) {
         $sql_delete_details = mysql_query("DELETE FROM pending_account WHERE username='$username' AND email='$email1'") or die('Error: deleting user details from pending account.  ' . mysql_error());
         echo "We have a problem sending email to the e-mail address you have entered. Please register your account again."; 
         exit();
     }

   // header("location: http://www.hookedd.com/email_test.php?to=$to&headers=$headers&message=$message&subject=$subject");

   // header("location: http://www.hookedd.com/email_test.php");
   
   // include_once("http://www.hookedd.com/email_test.php");
          
   $msgToUser = "<h2>One last step - Activate through Email</h2><h4>$username, there is one last step to verify your email identity:</h4><br />
   In a moment you will be sent an Activation Link to your email address.<br /><br />
   <br />
   <strong><font color=\"#990000\">VERY IMPORTANT:</font></strong>
   If you check your email with your host providers default email application, 
   there may be issues with seeing the email contents. If this happens to you 
   and you cannot read the message to activate, download the file and open using a text editor.<br /><br />";
 
   include_once 'msgToUser.php';
   exit();

   } // Close else after duplication checks

} else { // if the form is not posted with variables, place default empty variables so no warnings or errors show

        $errorMsg = "";
        $username = "";
        $gender = "";
        $b_m = "";
        $b_d = "";
        $b_y = "";
        $email1 = "";
        $email2 = "";
        $pass1 = "";
        $pass2 = "";
}

?>  
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Description" content="Register to hookedd.com" />
<meta name="Keywords" content="register, hookedd.com" />
<meta name="rating" content="General" />
<title>Register at Hookedd.com</title>
<link href="style/main.css" rel="stylesheet" type="text/css" />
<!-- <link href="style/style.css" rel="stylesheet" type="text/css" /> -->
<link href="style/register.css" rel="stylesheet" type="text/css" />
<link href="style/header_non_user.css" rel="stylesheet" type="text/css" />
<link href="style/footer.css" rel="stylesheet" type="text/css" />
<link rel="icon href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
<script src="js/search.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $("#username").blur(function() {
           $("#nameresponse").removeClass().text('Checking Username...').fadeIn(1000);
           $.post("check/check_signup_name.php",{ username:$(this).val() } ,function(data) {
                 $("#nameresponse").fadeTo(200,0.1,function() {
                    $(this).html(data).fadeTo(900,1);
                    });
           });
          });
});
function toggleSlideBox(x) {
             if ($('#'+x).is(":hidden")) {
                    $('#'+x).slideDown(300);
             } else {
                    $('#'+x).slideUp(300);
             }
}
</script>
<style type="text/css">
<!--
.style26 {color:#FF0000}
.style28 {font-size: 14px}
.brightRed {
        color: #F00;
}
.textSize_9px {
        font-size: 9px;
}
-->
</style>
</head>
<body>

<?php include_once "homepage_header2.php"; ?>

<!-- <div id="container"> -->
  <!-- <div class="warp-container"> -->
    <div class="reg-container">
	  <h1>sign up with Hookedd</h1>
	  <div class="reg">
        <table class="reg-tbl" width="100%">
          <form action="register.php" method="post" enctype="multipart/form-data">
            <tr>
              <td colspan="2"><font color="#FF0000"><?php print "$errorMsg"; ?></font></td>
            </tr>
            <tr>
              <td width="114" bgcolor="#FFFFFF">User Name:<span class="brightRed"> *</span></td>
              <td width="452" bgcolor="#FFFFFF"><input name="username" type="text" class="log-inp" id="username" value="<?php print "$username"; ?>" />
                <span id="nameresponse"><span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></span></td>
            </tr>
            
            <tr>
              <td bgcolor="#EFFFFF">Gender:<span class="brightRed"> *</span></td>
              <td bgcolor="#EFFFFF">
                <label>
                  <input type="radio" name="gender" id="gender" value="Male" />Male &nbsp;
                  <input type="radio" name="gender" id="gender" value="Female" />Female
                </label>
              </td>
            </tr>
            
            <tr>
              <td bgcolor="#FFFFFF">Date of Birth: <span class="brightRed">*</span></td>
              <td bgcolor="#FFFFFF">
                <select name="birth_month" class="formFields" id="birth_month">
                  <option value="<?php print "$b_m"; ?>"><?php print "$b_m"; ?></option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
                <select name="birth_day" class="formFields" id="birth_day">
                  <option value="<?php print "$b_d"; ?>"><?php print "$b_d"; ?></option>
                  <option value="01">1</option>
                  <option value="02">2</option>
                  <option value="03">3</option>
                  <option value="04">4</option>
                  <option value="05">5</option>
                  <option value="06">6</option>
                  <option value="07">7</option>
                  <option value="08">8</option>
                  <option value="09">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
                <select name="birth_year" class="formFields" id="birth_year">
                  <option value="<?php print "$b_y"; ?>"><?php print "$b_y"; ?></option>
                  <?php 
                    for ($x=2011; $x>=1900; $x--) {
                           echo "<option>$x";
                    }
                  ?>
                </select>
                
                <!-- <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('why');">why?</a>
                <div id="why" style="background-color:#E6F5FF; border:#9999 1px solid; padding:12px; display:none; margin-top:8px;">
                  Sometime down the road we may offer content that is only suitable for people over 18. We require this information to check your age. <br /><br />We can 
                  also use this information to alert your friends when your birthday is.
                </div> -->
              </td>
            </tr>
            
            <tr>
              <td bgcolor="#EFEFEF">Email Address: <span class="brightRed">*</span></td>
              <td bgcolor="#EFEFEF"><input name="email1" type="text" class="log-inp" id="email1" value="<?php print "$email1"; ?>" /></td>
            </tr>
            
            <tr>
              <td bgcolor="#FFFFFF">Confirm Your Email:<span class="brightRed"> *</span></td>
              <td bgcolor="#FFFFFF"><input name="email2" type="text" class="log-inp" id="email2" value="<?php print "$email2"; ?>" /></td>
            </tr>
            
            <tr>
              <td bgcolor="#EFEFEF">Create Password:<span class="brightRed"> *</span></td>
              <td bgcolor="#EFEFEF"><input name="pass1" type="password" class="log-inp" id="pass1" />
              <span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></td>
            </tr>
            
            <tr>
              <td bgcolor="#FFFFFF">Confirm Your Password:<span class="brightRed">*</span></td>
              <td bgcolor="#FFFFFF"><input name="pass2" type="password" class="log-inp" id="pass2" />
              <span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></td>
            </tr>
            
            <tr>
              <td bgcolor="#EFEFEF">Human Check: <span class="brightRed">*</span></td>
              <td bgcolor="#EFEFEF"><input name="humancheck" type="text" class="log-inp" id="humancheck" value="Please remove all of this text" /></td>
            </tr>
            
            <tr>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">
                <p><br />
                  <input type="submit" name="Submit" class="log-btn" value="Sign Up!" />
                </p>
              </td>
            </tr>
          </form>
        </table>
     
     <br />
     <br />
    <!-- <td width="160" valign="top"><?php include_once "right_AD_template.php"; ?></td> -->
   
  
      </div><!--end of log-->
    </div><!--end of reg-container-->
  <!-- </div> --><!--end of warp-container-->
<!-- </div> --><!--end of container-->	

<?php include ("/var/www/html/footer.php"); ?>		

</body>
</html>





















































    

























