<?php 

  include_once("/var/www/html/connect/connect_to_mysql.php");
  
  include_once("/var/www/html/class/display.class.php");
  
  include_once("/var/www/html/class/agoTimeFormat.php");
  
  $disp = new display();
  
  $time = new convertToAgo();
  
  $owner_id = $_POST['owner_id'];
  
  $chat_users_array = array();
  
  $sql_chat = mysql_query("SELECT * FROM chat WHERE to_owner_id='$owner_id' || from_owner_id='$owner_id'") or die('Error: selecting details fo Table chat.  ' . mysql_error());
  
  while ($row = mysql_fetch_array($sql_chat)) {
           $to_owner_id = $row['to_owner_id'];
  
           if ($to_owner_id != $owner_id) {
                 if (!in_array($to_owner_id, $chat_users_array)) {
                       array_push($chat_users_array, $to_owner_id);
                 }
           } else {
                 $from_owner_id = $row['from_owner_id'];
                 if (!in_array($from_owner_id, $chat_users_array)) {
                       array_push($chat_users_array, $from_owner_id);
                 }
           }
  }
  
  for ($i = 0; $i < count($chat_users_array); $i++) {
         $sql_user_details = mysql_query("SELECT * FROM user_details WHERE owner_id='$chat_users_array[$i]'") or die('Error: selecting details from Table user_details.  ' . mysql_error());
         
         while ($raw = mysql_fetch_array($sql_user_details)) {
                  $username = $raw['username'];
         }
         
         $check_pic = '../members/' . $chat_users_array[$i] . '/image01.jpg';

         $user_pic = $disp->display_pic($check_pic, $chat_users_array[$i], 50, 50);
         
         $sql_last_chat_msg = mysql_query("SELECT * FROM chat WHERE (from_owner_id='$chat_users_array[$i]' AND to_owner_id='$owner_id') || (from_owner_id='$owner_id' AND to_owner_id='$chat_users_array[$i]') ORDER BY chat_id DESC LIMIT 1") or die('Error: selecting details fo Table chat.  ' . mysql_error());
    
         while ($chatRow = mysql_fetch_array($sql_last_chat_msg)) {
                  $msg = $chatRow['message'];
                  
                  $time_sent = $chatRow['time_sent']; 
                  $time_sent = $time->convert_datetime($time_sent);
                  $time_sent = $time->makeAgo($time_sent);
         }
         
         $display .= '
                      <div class="chatted_with_user" onclick="javascript: redirect_to_chat_details(' . $chat_users_array[$i] . ');" style="margin-top: 5px; border-top: 1px solid #E9E9E9; padding: 5px; cursor: pointer; height: 50px;">
                        <span style="display: inline-block; vertical-align: middle;">' . $user_pic . '</span>
                        <span style="display: inline-block; vertical-align: middle;">
                          <a class="normal_link" href="profile.php?id=' . $chat_users_array[$i] . '">' . $username . '</a>
                          <br />
                          ' . $msg . '
                        </span>
                        
                        <div style="float: right; padding: 10px;">
                          ' . $time_sent . '
                        </div>
                      </div>
                     ';
  }
  
  echo $display; 

?>