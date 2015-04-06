<?php

class display {

  public function __construct() {
    // $this->registry = $registry;
  }

  public function display_pic($pic, $user_id, $max_height, $max_width) {

    $cache_buster = rand(999999999,9999999999999);

    if (file_exists($pic)) {
          // $dimensions = $this->get_resized_dimensions($pic, $max_height, $max_width);
		  $dimensions = $max_width . "," . $max_height;
          $dimensions = explode (",", $dimensions);
		  
          // $pic = $pic . "?rand=" . $cache_buster;
          
          /* $user_pic = '
                       <ul style="list-style: none;">
                         <li>
                           <a href="/profile.php?id=' . $user_id . '">
                             <img src="' . $pic . '" width="' . $dimensions[0] . 'px" height="' . $dimensions[1] . 'px" border="1" onmouseover="javascript: show_user_details(' . $user_id . ', this);" />
                           </a>
                          
                           <div style="display: none; position: absolute; background-color: #FFFFFF; z-index: 10;">
                             <div style="border: 2px solid #666666; line-height: 1.3em; margin: 10px auto; padding: 10px; position: relative; -moz-border-radius: 10px; -webkit-border-radius: 10px; -moz-box-shadow: 0 0 5px #888888; -webkit-box-shadow: 0 0 5px #888888;">
                               <div style="border-color: transparent transparent #666666 transparent; border-style: solid; border-width: 10px; height: 0; width: 0; position: absolute; top: -22px; left: 30px;"></div>
                               <div style="border-color: transparent transparent #FFFFFF transparent; border-style: solid; border-width: 10px; height: 0; width: 0; position: absolute; top: -19px; left: 30px;"></div>
                               <span></span>
                             </div>
                           </div>
                         </li>
                       </ul>
                       '; */
          
          $user_pic = '
                       <span style="display: inline-block; position: relative;">
                         
                           <a href="/profile.php?id=' . $user_id . '">
                             <img src="' . $pic . '" width="' . $dimensions[0] . 'px" height="' . $dimensions[1] . 'px" border="1" onmouseover="javascript: show_user_details(' . $user_id . ', this);" onmouseout="javascript: hide_user_details(this);" />
                           </a>
                          
                           <div id="user_detail_div" class="user_detail_divs" style="display: none; position: absolute; background-color: #FFFFFF; z-index: 10;">
                             <div style="border: 2px solid #666666; line-height: 1.3em; margin: 10px auto; padding: 10px; position: relative; -moz-border-radius: 10px; -webkit-border-radius: 10px; -moz-box-shadow: 0 0 5px #888888; -webkit-box-shadow: 0 0 5px #888888;">
                               <div style="border-color: transparent transparent #666666 transparent; border-style: solid; border-width: 10px; height: 0; width: 0; position: absolute; top: -22px; left: 30px;"></div>
                               <div style="border-color: transparent transparent #FFFFFF transparent; border-style: solid; border-width: 10px; height: 0; width: 0; position: absolute; top: -19px; left: 30px;"></div>
                               <span></span>
                             </div>
                           </div>
                         
                       </span>
                       ';
          
    } else {
          // $dimensions = $this->get_resized_dimensions("http://www.hookedd.com/members/0/image01.jpg", $max_height, $max_width);
          $dimensions = $max_width . "," . $max_height;
		  $dimensions = explode (",", $dimensions);
    
          /* $user_pic = '
                       <ul style="list-style: none;">
                         <li>
                           <a href="/profile.php?id=' . $user_id . '">
                             <img src="members/0/image01.jpg" width="' . $dimensions[0] . 'px" height="' . $dimensions[1] . 'px" border="1" onmouseover="javascript: show_user_details(' . $user_id . ');" />
                           </a>
                           
                           <div style="display: none; position: absolute; background-color: #FFFFFF; z-index: 10;">
                             <div style="border: 2px solid #666666; line-height: 1.3em; margin: 10px auto; padding: 10px; position: relative; -moz-border-radius: 10px; -webkit-border-radius: 10px; -moz-box-shadow: 0 0 5px #888888; -webkit-box-shadow: 0 0 5px #888888;">
                               <div style="border-color: transparent transparent #666666 transparent; border-style: solid; border-width: 10px; height: 0; width: 0; position: absolute; top: -22px; left: 30px;"></div>
                               <div style="border-color: transparent transparent #FFFFFF transparent; border-style: solid; border-width: 10px; height: 0; width: 0; position: absolute; top: -19px; left: 30px;"></div>
                               <span></span>
                             </div>
                           </div>
                         </li>
                       </ul>
                      '; */
          
          $user_pic = '
                       <span style="display: inline-block; position: relative;">
                         
                           <a href="/profile.php?id=' . $user_id . '">
                             <img class="profile_pic_imgs" src="members/0/image01.jpg" width="' . $dimensions[0] . 'px" height="' . $dimensions[1] . 'px" border="1" onmouseover="javascript: show_user_details(' . $user_id . ', this);" />
                           </a>
                           
                           <div id="user_detail_div" class="user_detail_divs" style="display: none; position: absolute; z-index: 10;">
                             <!-- <div style="background-image: url(\'members/0/header_pic_02.jpg\'); border: 2px solid #666666; padding-top: 1px; line-height: 1.3em; margin: 10px auto; position: relative; -moz-border-radius: 0px; -webkit-border-radius: 0px; -moz-box-shadow: 0 0 5px #888888; -webkit-box-shadow: 0 0 5px #888888;"> -->
                             <div style="width: 300px; background-image: url(\'members/0/header_pic_02.jpg\'); background-size: auto 170px; background-repeat:no-repeat; margin: 0px auto; position: relative;"> 
                               
                               <!-- <div style="border-color: transparent transparent #666666 transparent; border-style: solid; border-width: 10px; height: 0; width: 0; position: absolute; top: -22px; left: 30px;"></div>
                               <div style="border-color: transparent transparent #FFFFFF transparent; border-style: solid; border-width: 10px; height: 0; width: 0; position: absolute; top: -19px; left: 30px;"></div> -->
                               
                               <div style="position: relative; z-index: 5;">
                               
                                 <span style="background-color: #FFFFFF; width: 20px; height: 20px; display: inline-block;"></span><span style="width: 20px; height: 20px; display: inline-block;">
                               
                                   <div style="border-top: 20px solid #FFFFFF; border-right: 10px solid transparent; width: 0; float: left;"></div>
                                   <div style="border-top: 20px solid #FFFFFF; border-left: 10px solid transparent; width: 0; float: right;"></div>
                                   
                                 </span><span style="background-color: #FFFFFF; width: 260px; height: 20px; display: inline-block;"></span>
                                 
                               </div>
                               
                               <span style="display: block; border-color: transparent #666666 #666666 #666666; border-style: solid; border-width: 1px; -moz-box-shadow: 0px 2px 5px #888888; -webkit-box-shadow: 0px 2px 5px #888888; z-index: 3; position: relative;"></span>
                               
                             </div>
                           </div>
                         
                       </span>
                      ';
    }
    
    return $user_pic;

  }

  public function display_pic_wo_details ($pic, $user_id, $max_height, $max_width) {
    $cache_buster = rand(999999999,9999999999999);

    $full_pic_addr = "/var/www/html/" . $pic;

    if (file_exists($full_pic_addr)) {
          $dimensions = $this->get_resized_dimensions($full_pic_addr, $max_height, $max_width);
          $dimensions = explode (",", $dimensions);
    
          // $pic = $pic . "?rand=" . $cache_buster;
          
          $user_pic = '
                       <a href="/profile.php?id=' . $user_id . '">
                         <img src="' . $pic . '" width="' . $dimensions[0] . 'px" height="' . $dimensions[1] . 'px" border="1" />
                       </a>
                      ';
    } else {
          $dimensions = $this->get_resized_dimensions("http://www.hookedd.com/members/0/image01.jpg", $max_height, $max_width);
          $dimensions = explode (",", $dimensions);
    
          $user_pic = '
                       <a href="/profile.php?id=' . $user_id . '">
                         <img src="http://www.hookedd.com/members/0/image01.jpg" width="' . $dimensions[0] . 'px" height="' . $dimensions[1] . 'px" />
                       </a>
                      ';
    }
    return $user_pic;

  }

  public function get_resized_dimensions($pic, $max_height, $max_width) {
    // $src = imagecreatefromjpeg($pic);
    list($pic_width, $pic_height) = getimagesize($pic);
    
    /* $ch = curl_init($pic);

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);

    $response = curl_exec($ch);
    curl_close ($ch);
  
    $src = imagecreatefromstring($response); 
  
    $pic_width = imagesx($src);
    $pic_height = imagesy($src); */

    $x_ratio = $max_width / $pic_width;
    $y_ratio = $max_height / $pic_height;
   
    if(($pic_width <= $max_width) && ($pic_height <= $max_height)) {
          $tn_width = $pic_width;
          $tn_height = $pic_height;
    } else if (($x_ratio * $pic_height) < $max_height) {
          $tn_height = ceil($x_ratio * $pic_height);
          $tn_width = $max_width;
    } else {
          $tn_width = ceil($y_ratio * $pic_width);
          $tn_height = $max_height;
    }
   
    /* $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $pic_width, $pic_height);
    imagejpeg($tmp, $pic);
    imagedestroy($src);
    imagedestroy($tmp); */

    // $img_tag = '<img src="' . $pic . '" width="' . $tn_width . '" height="' . $tn_height . '" />';
    
    $dimension = $tn_width . "," . $tn_height;

    return $dimension;
    // return $img_tag;
    
  }
  
  public function create_resized_image ($pic, $destination, $filename, $max_height, $max_width, $quality) {
    $size = getimagesize($pic);
  
    switch ($size[2]) {
      case IMAGETYPE_GIF  : $src = imagecreatefromgif($pic);  break;
      case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($pic); break;
      case IMAGETYPE_PNG  : $src = imagecreatefrompng($pic);  break;
      default : die("Unknown filetype");
    } 
    
    // $src = imagecreatefromjpeg($pic);
    
    list($pic_width, $pic_height) = getimagesize($pic);

    $x_ratio = $max_width / $pic_width;
    $y_ratio = $max_height / $pic_height;
   
    if(($pic_width <= $max_width) && ($pic_height <= $max_height)) {
          $tn_width = $pic_width;
          $tn_height = $pic_height;
    } else if (($x_ratio * $pic_height) < $max_height) {
          $tn_height = ceil($x_ratio * $pic_height);
          $tn_width = $max_width;
    } else {
          $tn_width = ceil($y_ratio * $pic_width);
          $tn_height = $max_height;
    }
   
    $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $pic_width, $pic_height);
    $destination_pic = $destination . '/' . $filename . '.jpg';
    
    /* switch ($size[2]) {
      case IMAGETYPE_GIF  : imagegif($tmp,  $destination_pic);      break;
      case IMAGETYPE_JPEG : imagejpeg($tmp, $destination_pic, $quality); break;
      case IMAGETYPE_PNG  : imagepng($tmp,  $destination_pic, 0);   break;
      default : die("Unknown filetype");
    } */
 
    imagejpeg($tmp, $destination_pic, $quality);
    
    imagedestroy($src);
    imagedestroy($tmp);

    return $destination_pic;
  }
  
  public function get_user_pic_address ($pic_addr) {
     $default_pic_addr = "http://www.hookedd.com/members/0/image01.jpg";
  
     if (file_exists($pic_addr)) {
           return $pic_addr;
     } else {
           return $default_pic_addr;
     }
  }
  
  public function cal_resized_dimensions ($height, $width, $max_height, $max_width) {
     $x_ratio = $max_width / $width;
     $y_ratio = $max_height / $height;
   
     if(($width <= $max_width) && ($height <= $max_height)) {
           $tn_width = $width;
           $tn_height = $height;
     } else if (($x_ratio * $height) < $max_height) {
           $tn_height = ceil($x_ratio * $height);
           $tn_width = $max_width;
     } else {
           $tn_width = ceil($y_ratio * $width);
           $tn_height = $max_height;
     }
     
     $dimension = $tn_width . "," . $tn_height;

     return $dimension;
  }
 
}










