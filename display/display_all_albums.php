<?php

include ("../connect/connect_to_mysql.php");

$owner_id = $_POST['owner_id'];

$viewer_id = $_POST['viewer_id'];

$display_album = "";

$sql_album = mysql_query("SELECT * FROM album WHERE owner_id='$owner_id'");

$no_of_albums = mysql_num_rows($sql_album);

while ($row = mysql_fetch_array($sql_album)) {
         $album_id = $row['album_id'];

         $sql_first_photo = mysql_query("SELECT * FROM photo WHERE aid='$album_id' AND post_location='personal' ORDER BY photo_id DESC") or die('Error: select details from table photo.  ' . mysql_error());
         $no_of_photos = mysql_num_rows($sql_first_photo);
              
         if ($no_of_photos != 0) {
               $count_photos = 0;
               $photo_array = array();
               $photo_id_string = "";
               $photo_address = array();
               $photo_address_string = "";
               while ($pRow = mysql_fetch_array($sql_first_photo)) {
                        $photo_address[$count_photos] = $pRow['photo_address'];
                        $photo_array[$count_photos] = $pRow['photo_id'];
                        $count_photos++;
               }
               $photo_id_string = implode(",", $photo_array );
               $photo_address_string = implode(",", $photo_address);
         }

         $display_album .= '
                           <div style="border: 1px solid #D8DFEA; padding: 2px; width: 100px; height: 100px;">
                             <img src="' . $photo_address[0] . '" width="100%" height="100%" onclick="javascript: show_photos_for_album(' . $viewer_id . ', ' . $owner_id . ', ' . $album_id . ', \'' . $photo_id_string . '\', \'' . $photo_address_string . '\');" style="cursor: pointer;" />
                           </div>
                           ';

}

echo $display_album;

?>