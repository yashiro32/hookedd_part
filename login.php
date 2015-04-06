<?php 

/* if ($_SERVER['HTTPS'] != "on") {
      $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      header("Location:$redirect");
} */

include("check/homepage_check_user_login.php");

include ("connect/connect_to_mysql.php");

// Force script errors  and warnings to show on page in case php.ini file is set to not display them
error_reporting(E_ALL);
ini_set('display_errors', '1');

$dest = "";

if (isset($_GET['dest'])) {
      $dest = $_GET['dest'];
} else {
      $dest = "";
}

// Initialize some variables
$errorMsg = '';
$email = '';
$pass = '';
$remember = '';
if (isset($_POST['email'])) {
      $email = $_POST['email'];
      $pass = $_POST['pass'];
      
      if (isset($_POST['remember'])) {
            $remember = $_POST['remember'];
      }
      
      $email = stripslashes($email);
      $pass = stripslashes($pass);
      $email = strip_tags($email);
      $pass = Strip_tags($pass);

      // error handling conditional checks goes here
      if ((!$email) || (!$pass)) {
     
             $errorMsg = 'Please fill in your username and password !'; 
      } else { // Error handling is complete and so the process the info if no errors
     
             $email = mysql_real_escape_string($email); // After we connect to the database, we secure the string before adding to query
             $pass = mysql_real_escape_string($pass); // After we connect to the database, we secure the string before adding to query
             $pass = md5($pass); // Add MD5 Hash to the password variable the user supplied after filtering it
     
             // Make the SQL query
             $sql = mysql_query("SELECT * FROM user_details WHERE email='$email' AND password='$pass'");
             $login_check = mysql_num_rows($sql);
     
             // If login check number is greater than 0 (meaning they do exist and are activated)
             if ($login_check > 0) {
                   while($row = mysql_fetch_array($sql)) {
                           // create session variables for the users raw id
                           $id = $row["owner_id"];
                           $_SESSION['id'] = $id;
               
                           // Create the idx session variable
                           $_SESSION['idx'] = base64_encode("g4p3h9xfn8sq03hs2234$id");

                           // Create session variable for the username
                           $username = $row["username"];
                           $_SESSION['username'] = $username;

                           mysql_query("UPDATE user_details SET last_log_date=now() WHERE owner_id='$id' LIMIT 1");
        
                   } // close while

                   // Remember Me Section
                   if ($remember == "yes") {
                         $encryptedID = base64_encode("g4enm2c0c4y3dn3727553$id");
                         setcookie("idCookie", $encryptedID, time()+60*60*24*30, "/"); // Cookie set to expire in about 30 days
                         setcookie("passCookie", $pass, time()+60*60*24*30, "/"); // Cookie set to expire in about 30 days
                   }

                   // All good they are logged in, send them to homepage then exit script
                   // header("location: index.php?test=$id");
                   if ($dest != "") {
                         header("location: " . $dest);
                   } else {
                         header("location: user_home.php");
                   }
                 
                   // exit();
             } else { // Run this code if login_check is equal to 0 meaning they do not exist
                   $errorMsg = "Incorrect login data, please try again";
             }
 
      } // Close else after error checks

} //Close if (isset ($_POST['uname'])){

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<!-- <link href="style/main.css" rel="stylesheet" type="text/css" /> -->
<link href="style/style.css" rel="stylesheet" type="text/css" />
<title>Log in</title>
<style type="text/css">
<!--

-->
</style>
</head>
<body style="text-align: center;">
<!-- <div align="center"><a href="index.php"><img src="images/logo1.png" alt="Home Page" width="197" height="104" border="0" /></a></div> -->
<?php include ("header.php"); ?>

<!-- <table width="400" align="center" cellpadding="6" style="background-color:#FFF; border:#666 1px solid;">
<form action="login.php" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
<tr>
 <td width="23%"><font size="+2">Log in</font></td>
 <td width="77%"><font color="#FF0000"><?php print "$errorMsg"; ?></font></td>
</tr>
<tr>
 <td><strong>Email:</strong></td>
 <td><input name="email" type="text" id="email" style="width:60%;"/></td>
</tr>
<tr>
 <td><strong>Password:</strong></td>
 <td><input name="pass" type="password" id="pass" maxlength="24" style="width:60%;"/></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td><input name="remember" type="checkbox" id="remember" value="yes" checked="checked" />
     Remember Me</td>
</tr>
<tr>
   <td>&nbsp;</td>
   <td><input name="myButton" type="submit" id="myButton" value="Sign In" /></td>
</tr>
<tr>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
</tr>
<tr>
   <td colspan="2">Forgot your password? <a href="forgot_pass.php">Click Here</a>
<br /></td>
</tr>
<tr>
   <td colspan="2">Need an Account? <a href="register.php">Click Here</a><br />      <br /></td>
</tr>
</form>
</table> -->

    <div class="log-container">
	  <h1>Log in</h1>
	  <font color="#FF0000"><?php print "$errorMsg"; ?></font>
      <div class="log">
	    <table class="log-tbl">
	      <form action="login.php?dest=<?php echo $dest; ?>" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
		    <tr>
	   	      <td>Email</td>
			  <td>:</td>
			  <td><input name="email" type="text" id="email" style="width: 220px; height: 25px; padding: 3px;" /></td>
			</tr>
			
			<tr>
			  <td>Password</td>
			  <td>:</td>
			  <td><input name="pass" type="password" id="pass" style="width: 220px; height: 25px; padding: 3px;" /></td>
			</tr>
			
			<tr>
			  <td>
			    <input name="remember" type="checkbox" id="remember" value="yes" checked="checked" />
                Remember Me
			  </td>
			</tr>
			
			<tr>
			  <td colspan="3" align="center">
			    <input name="myButton" class="log-btn" type="submit" id="myButton" value="Sign In" />
			  </td>
			</tr>
			
			<tr>
			  <td>&nbsp;</td>
		      <td></td>
		      <td> <a href="register.php">Register</a> | <a href="forgot_pass.php">Forget Your Password</a></td>
		    </tr>
		    
			<tr>
			  <td colspan="3"></td>
			</tr>
		  </form>
		</table>
	  </div><!--end of log-->
    </div><!--end of log-container-->
 
<?php include ("footer.php"); ?>

</body>
</html>

















