<?php 

  include_once("/var/www/html/connect/connect_to_mysql.php");
  
  include_once("/var/www/html/class/chat.class.php");
  
  $chat = new chat();
  
  $owner_id = $_POST['owner_id'];
  
  $friend_id = $_POST['friend_id'];
  
  $func = $_POST['func'];
  
  if ($func == "chats") {
       $display = $chat->show_chats($owner_id, $friend_id);
       
       echo $display; 
  }
  
  if ($func == "more_chats") {
       $last_chat_id = $_POST['last_chat_id'];
       
       $display = $chat->show_chats($owner_id, $friend_id, $last_chat_id);
       
       echo $display;
  }
  
?>
