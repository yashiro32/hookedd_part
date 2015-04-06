<?php 

  include_once ("/var/www/html/class/ads.class.php");

  $func = $_POST['func'];
  
  $object_id = $_POST['object_id'];
  
  $object_type = $_POST['object_type'];
  
  $shown_ad_ids = $_POST['shown_ad_ids'];
  
  if ($func == "show_right_side_ads") {
        $ads = new ads();
        
        $show_ads = $ads->show_right_side_ads ($object_id, $object_type, $shown_ad_ids);
        
  }
  
  echo $show_ads;
  
?>