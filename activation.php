<?php

// If the GET variable is not empty, we run this script. If the variable is empty we give the message at the bottom
// Force script errors and warnings to show on page in case php.ini file is set not to display them
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include_once("geo/geoiploc.php");
include_once("class/time.class.php");

$time = new time();

if ($_GET['id'] != "" && $_GET['email'] != null && $_GET['username'] != null) {
      // Connect to the database 
      include_once("connect/connect_to_mysql.php");

      $id = $_GET['id'];
      $id = strip_tags($id);
      
      $hashpass = $_GET['sequence'];
      $hashpass = strip_tags($hashpass);

      
      $username = $_GET['username'];
      $username = strip_tags($username);
      $username = mysql_real_escape_string($username);
      
      $email = $_GET['email'];
      $email = strip_tags($email);
      $email = mysql_real_escape_string($email);

      $id = mysql_real_escape_string($id);
      $id = eregi_replace("`", "", $id);

      $hashpass = mysql_real_escape_string($hashpass);
      $hashpass = eregi_replace("`", "", $hashpass);

      // check to see if the account have already been activated
      $sql_check_account = mysql_query("SELECT * FROM user_details WHERE email='$email' AND password='$hashpass'");
      if (mysql_num_rows($sql_check_account) > 0) {
            echo "Your account has already been activated. Please log in to use the account.";
            exit();
      }

      // $sql = mysql_query("UPDATE user_details SET email_activated='1' WHERE owner_id='$id' AND password='$hashpass'"); 
      $sql_get_details = mysql_query("SELECT username, gender, birthday, email, password, ipaddress, sign_up_date FROM pending_account WHERE owner_id='$id' AND password='$hashpass'")
      or die('Error: getting details from pending_account table.  ' . mysql_error());
      
      if (mysql_num_rows($sql_get_details) == 0) {
            echo 'Your account does not exists in our database. Please register again.';
            exit();
      }
      
      while ($raw = mysql_fetch_array($sql_get_details)) {
               $my_uname = $raw['username'];
               $gender = $raw['gender'];
               $birthday = $raw['birthday'];
               $my_email = $raw['email'];
               $my_pass = $raw['password'];
               $ipaddress = $raw['ipaddress'];
               $sign_up_date = $raw['sign_up_date'];
      }
      
      $country = getCountryFromIP($ipaddress, " NamE ");
      
      $timezones = $time->get_gmt_timezones_array();
      
      $timezone = "";
      
      foreach ($timezones as $tz => $value) {
                 if (strpos($tz, $country) !== false) {
                       $timezone = $value;
                       break;
                 }
      }
      
      if ($timezone == "") {
            $timezone = "America/Denver";
      }
      
      $sql_copy_details = mysql_query("INSERT INTO user_details (username, gender, birthday, email, password, ipaddress, sign_up_date, country, timezone) 
      VALUES ('$my_uname', '$gender', '$birthday', '$my_email', '$my_pass', '$ipaddress', '$sign_up_date', '$country', '$timezone')") or die('Error: copying details into user_details table.  ' . mysql_error());

      $sql_doublecheck = mysql_query("SELECT * FROM user_details WHERE email='$email' AND password='$hashpass'");
      $doublecheck = mysql_num_rows($sql_doublecheck);

      if ($doublecheck == 0) {
            $msgToUser = "<br /><br /><h3><strong><font color=red>Your account could not be activated!</font></strong></h3><br />
            <br />
            Please email site administrator and request manual activation.
            ";
            include("msgToUser.php");
            exit();
      } else if ($doublecheck > 0) {
                  while ($row = mysql_fetch_array($sql_doublecheck)) {
                           $new_id = $row['owner_id'];
                           $friends = $row['friend_array'];
                  } 
       
                  $sql_insert_metas = mysql_query("INSERT INTO metas (owner_id, en_metasearch, en_metaask) VALUES ('$new_id', '0', '0')") or die("Error: inserting details into TABLE metas.  " . mysql_error());
    
                  $sql_privacy = mysql_query("INSERT INTO privacy (object_id, description, value, owner_id, friends) 
                  VALUES ('status', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('comment', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('bio', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('website', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('birthday', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('post_comment', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('photo', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('video', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('address', 'all_friends', 'friends', '$new_id', '$friends'),
                         ('e-mail', 'all_friends', 'friends', '$new_id', '$friends')") or die('Error: inserting datas into table privacy.  ' . mysql_error());
                  
                  mkdir("members/$new_id", 0777);
                  
                  $sql_del_pend_acc = mysql_query("DELETE FROM pending_account WHERE owner_id='$id' AND password='$hashpass'");
                  
                  
                  $msgToUser = "<br /><br /><h3><font color=\"#0066CC\"><strong>Your account has been activated! <br /><br />
                                Log In anytime <a href=\"http://www.hookedd.com/login.php\">Here</a>.</strong></font></h3>";

                  include("msgToUser.php");
                  exit();
       } 

}// close first if

print "Essential data from the activation URL is missing! Close your browser, go back to your email inbox, and please use the full URL supplied in the activation link we sent you.<br />
<br />
admin@hookedd.com
";
?>












