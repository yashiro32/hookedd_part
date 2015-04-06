<link rel="stylesheet" type="text/css" href="style/resets.css" />
<!-- <link rel="stylesheet" type="text/css" href="style/style.css" /> -->
<link rel="stylesheet" type="text/css" href="style/menu.css" />

<div id="header" style="background-image: url(style/headerStrip.jpg); width: 100%; height: 50px; border-bottom: #999 1px solid; text-align: center;">
<table width="1000px" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td width="16%"><a href="index.php"><img src="images/logo2.png" alt="Hookedd Social Network" width="156" height="48" border="0" /></a></td>
   <td width="34%">
     <form name="search_form" method="get" action="search.php">
       <input name="search_string" id="search_string" onclick="javascript:click_search(this.id);" onblur="javascript:onblur_search(this.id);" value="Type in your search here" style="width:300px; color: #1034BA;" />
       <input name="category" type="hidden" value="<?php echo $category; ?>" /> 
     </form>
   </td>
   <td width="50%">
     <div class="" style="margin-top: 12px;">
       
       <span style="display: inline-block;">  
         <ul>
           <li>
             <div id="note_count_square" class="square" style="display: none; height: 14px; padding-left: 2px; padding-right: 2px; border: #999 1px solid; position: absolute; margin-top: -10px; background-color: #FFFFFF; z-index: 5; text-align: center; font-weight: bold; color: #FFFFFF;"></div>
             <input type="image" id="note_image" onmouseup="javascript: show_notification('notification');" src="images/notification.png" width="25px" height="25px" style="cursor: pointer;" />
             <div id="note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: absolute; background-color: #FFFFFF; z-index: 4;"></div>
           </li>
         </ul>   
       </span>

       <span style="display: inline-block;">  
         <ul>
           <li>
             <div id="msg_count_square" class="square" style="display: none; height: 14px; padding-left: 2px; padding-right: 2px; border: #999 1px solid; position: absolute; margin-top: -10px; background-color: #FFFFFF; z-index: 5; text-align: center; font-weight: bold; color: #FFFFFF;"></div>
             <img src="images/email.png" width="25px" height="25px" onclick="javascript: show_msg_note('show_msg_notification');" style="cursor: pointer;" />
             <div id="msg_note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: absolute; background-color: #FFFFFF; z-index: 3;"></div>
           </li>
         </ul>   
       </span>

       <span style="display: inline-block;">  
         <ul>
           <li>
             <div id="frnd_req_count_square" class="square" style="display: none; height: 14px; padding-left: 2px; padding-right: 2px; border: #999 1px solid; position: absolute; margin-top: -10px; background-color: #FFFFFF; z-index: 5; text-align: center; font-weight: bold; color: #FFFFFF;"></div>
             <img src="images/friends.png" width="25px" height="25px" onclick="javascript: show_friends_note('show_frnd_notification');" style="cursor: pointer;" />
             <div id="frnd_note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: absolute; background-color: #FFFFFF; z-index: 3;"></div>
           </li>
         </ul>   
       </span>

       <span style="display: inline-block;">  
         <ul>
           <li>
             <div id="event_count_square" class="square" style="display: none; height: 14px; padding-left: 2px; padding-right: 2px; border: #999 1px solid; position: absolute; margin-top: -10px; background-color: #000000; z-index: 5; text-align: center; font-weight: bold; color: #FFFFFF;"></div>
             <img src="images/events.png" width="25px" height="25px" onclick="javascript: show_event_notification('show_event_note');" style="cursor: pointer;" />
             <div id="event_note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: absolute; background-color: #FFFFFF; z-index: 3;"></div>
           </li>
         </ul>   
       </span>

       <span style="display: inline-block;">  
         <ul>
           <li>
             <div id="conn_count_square" class="square" style="display: none; height: 14px; padding-left: 2px; padding-right: 2px; border: #999 1px solid; position: absolute; margin-top: -10px; background-color: #FFFFFF; z-index: 5; text-align: center; font-weight: bold; color: #FFFFFF;"></div>
             <img src="images/connect.png" width="25px" height="25px" onclick="javascript: show_connect_notification('show_conn_note');" style="cursor: pointer;" />
             <div id="connect_note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: absolute; background-color: #FFFFFF; z-index: 3;"></div>
           </li>
         </ul>   
       </span>

       <span style="display: inline-block;">
         <ul id="a_menu">
           <li>
             <a>Account</a>
             <ul>
               <li>
                 <a href="edit_account.php">Edit Account</a>
               </li>
               <li>
                 <a href="edit_privacy.php">Edit Privacy</a>
               </li>
               <li>
                 <a href="logout.php">Log Out</a>
               </li>
             </ul>
           </li>
         </ul>
       </span>
   
     </div>
   </td>
   <!-- <td width="28%"><div align="right" style="margin-bottom: 12px;">&nbsp;<?php echo $logOptions; ?></div></td> -->
 </tr>
</table>
</div>

<!-- <div id="note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: fixed; top: 40px; left: 52%; background-color: #FFFFFF; z-index: 4;"></div>

<div id="msg_note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: fixed; top: 40px; left: 53%; background-color: #FFFFFF; z-index: 3;"></div>

<div id="frnd_note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: fixed; top: 40px; left: 55%; background-color: #FFFFFF; z-index: 3;"></div>

<div id="event_note_window" class="mini_window" tabindex="1" style="display: none; width: 400px; height: 400px; border: #999 1px solid; position: fixed; top: 40px; left: 57%; background-color: #FFFFFF; z-index: 3;"></div> -->

<div style="background-color: #888EF4; width: 100%; text-align: center; height: 35px; border-bottom: #999 1px solid;">
<!-- <table width="100%" align="center" cellpadding="0" cellspacing="0" style="background-color: #888EF4" > -->
  <!-- <tr> -->
    <!-- <td> -->
            <ul id="nav">
              <li><a href="user_home.php">User Home</a></li>
              <li><a>Profile</a>
                <ul>
                  <li><a href="profile.php">View profile</a></li>
                  <li><a href="edit_profile.php">Edit Profile</a></li>
                </ul>
              </li>
              <li><a>Services</a>
                <ul>
                  <li><a href="ask_home.php">Ask a question</a></li>
                </ul>
              </li>
              <li><a href="#">About</a></li>
              <li><a href="#">Chat</a></li>
            </ul>
   <!-- </td> -->
  <!-- </tr> -->
<!-- </table> -->
</div>









