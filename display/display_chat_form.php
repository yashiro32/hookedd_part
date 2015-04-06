<?php

  include_once ("/var/www/html/connect/connect_to_mysql.php");
  
  $owner_id = $_POST['owner_id'];
  
  $friend_id = $_POST['friend_id'];
  
  $can_send_msg = false;
  
  $displayForm = "";
  
  $sql_friend = mysql_query("SELECT * FROM user_details WHERE owner_id='$owner_id' AND FIND_IN_SET('$friend_id', friend_array)") or die('Error: selecting details FROM Table user_details.  ' . mysql_error());
  
  if (mysql_num_rows($sql_friend) == 0) {
        $sql_connection = mysql_query("SELECT * FROM connection WHERE (requester_id='$owner_id' AND to_owner_id='$friend_id') OR (requester_id='$friend_id' AND to_owner_id='$owner_id')") or die('Error: selecting details FROM Table connection.  ' . mysql_error());
        if (mysql_num_rows($sql_connection) > 0) {
                             $can_send_msg = true;
        }
       
  } else {
        $can_send_msg = true;
  }
       
  if ($can_send_msg == true) {
        $displayForm .= '
                         <form id="full_chat_form">
                           <textarea name="full_chat_message" id="full_chat_message" title="Write a reply..." placeholder="Write a reply..." style="width: 80%; color: rgb(16, 52, 186); resize: none; overflow: hidden;"></textarea>
                           <br />
                           <div id="chat_attach_wrapper">
                             <input type="file" name="chat_attachment" id="chat_attachment" title="upload attachment">
                           </div>
                           <input name="from_owner_id" id="from_owner_id" type="hidden" value="' . $owner_id . '">
                           <input name="to_owner_id" id="to_owner_id" type="hidden" value="' . $friend_id . '">
                           <input name="send_chat_btn" type="button" onclick="javascript: send_full_chat(this.form.id);" style="background-color: #454545; color: #FFFFFF; border: none; padding: 3px 10px; border-radius: 3px; font-weight: bold; font-size: 11px; cursor: pointer;" value="Send">
                         </form>
                        ';
  }
            
  echo $displayForm;

?>
