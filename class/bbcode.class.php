<?php

class bbcode {

  function __construct() {
  }

  function convert_bbcode($text) {
  
    $text = str_replace('\n' , "<br />", $text);

    $find = array(
                  "'\[b\](.*?)\[/b\]'i",
                  "'\[i\](.*?)\[/i\]'i",
                  "'\[u\](.*?)\[/u\]'i",
                  "'\[link\](.*?)\[/link\]'i",
                  "'\[link=(.*?)\](.*?)\[/link\]'i",
                  "'\[quote=(.*?)\](.*?)\[/quote\]'",
                  "'\[quote\](.*?)\[/quote\]'",
                  "'\[youtube\](.*?)\[/youtube\]'i",
                  "'\[yt\](.*?)\[/yt\]'i",
                  "'\[img\](.*?)\[/img\]'i"
                  // '/[\n]+/'
                  // '/\[youtube\]http:\/\/(?:www\.)?youtube\.com\/watch\?v=(.*?)\[\/youtube\]/i'
                  );
    $replace = array(
                     "<strong>\\1</strong>",
                     "<em>\\1</em>",
                     "<span style=\"text-decoration: underline;\">\\1</span>",
                     "<a href=\"\\1\" class=\"normal_link\" target=\"_blank\">\\1</a>",
                     "<a href=\"\\1\" class=\"normal_link\" target=\"_blank\">\\2</a>",
                     "<blockquote><div style=\"font-size: 12px;\">quote (\\1):</div><div style=\"border:1px solid #ACA899;\">\\2</div></blockquote>",
                     "<blockquote><div style=\"font-size: 12px;\">quote:</div><div style=\"border:1px solid #ACA899;\">\\1</div></blockquote>",
                     '<object width="320" height="240"><param name="movie" value="http://www.youtube.com/v/$1?fs=1&amp;hl=en_US&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/$1?fs=1&amp;hl=en_US&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="320" height="240"></embed></object><br />',
                     // '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="320" height="240" src="http://www.youtube.com/embed/$1?wmode=transparent" frameborder="0" allowFullScreen="true"></iframe><br />',
                     '<div onclick="javascript: play_youtube_video(\'$1\');" style="display: inline-block; position: relative; cursor: pointer;"><img src="http://img.youtube.com/vi/$1/1.jpg" /><img src="images/play.jpg" style="position: absolute; width: 30px; height: 30px; left: 50%; top: 50%; margin-left: -15px; margin-top: -15px;" /></div>',
                     '<img src="$1" onload="javascript: set_image_size_new(this, 300, 300);" onclick="javascript: display_bbcode_images (this.src);" style="cursor: pointer;" />'
                     // '<br />'
                     );

    $text = preg_replace($find,$replace,$text);

    return $text;

  }
  
  function modified_bbcode_for_search ($text) {
    $text = str_replace('\n' , "<br />", $text);

    $find = array(
                  "'\[b\](.*?)\[/b\]'i",
                  "'\[i\](.*?)\[/i\]'i",
                  "'\[u\](.*?)\[/u\]'i",
                  "'\[link\](.*?)\[/link\]'i",
                  "'\[link=(.*?)\](.*?)\[/link\]'i",
                  "'\[quote=(.*?)\](.*?)\[/quote\]'",
                  "'\[quote\](.*?)\[/quote\]'",
                  "'\[youtube\](.*?)\[/youtube\]'i",
                  "'\[yt\](.*?)\[/yt\]'i",
                  "'\[img\](.*?)\[/img\]'i"
                  // '/[\n]+/'
                  // '/\[youtube\]http:\/\/(?:www\.)?youtube\.com\/watch\?v=(.*?)\[\/youtube\]/i'
                  );
    $replace = array(
                     "<strong>\\1</strong>",
                     "<em>\\1</em>",
                     "<span style=\"text-decoration: underline;\">\\1</span>",
                     "<a href=\"\\1\" class=\"normal_link\" target=\"_blank\">\\1</a>",
                     "<a href=\"\\1\" class=\"normal_link\" target=\"_blank\">\\2</a>",
                     "<blockquote><div style=\"font-size: 12px;\">quote (\\1):</div><div style=\"border:1px solid #ACA899;\">\\2</div></blockquote>",
                     "<blockquote><div style=\"font-size: 12px;\">quote:</div><div style=\"border:1px solid #ACA899;\">\\1</div></blockquote>",
                     "<a href=\"\\1\" class=\"normal_link\" target=\"_blank\">\\1</a>",
                     "<a href=\"\\1\" class=\"normal_link\" target=\"_blank\">\\1</a>",
                     '<img src="$1" />'
                     // '<br />'
                     );

    $text = preg_replace($find,$replace,$text);

    return $text;
    
  }
  
  function simplified_bbcode_for_search ($text) {
    $text = str_replace('\n' , "<br />", $text);

    $find = array(
                  "'\[b\](.*?)\[/b\]'i",
                  "'\[i\](.*?)\[/i\]'i",
                  "'\[u\](.*?)\[/u\]'i",
                  "'\[link\](.*?)\[/link\]'i",
                  "'\[link=(.*?)\](.*?)\[/link\]'i",
                  "'\[quote=(.*?)\](.*?)\[/quote\]'",
                  "'\[quote\](.*?)\[/quote\]'",
                  "'\[youtube\](.*?)\[/youtube\]'i",
                  "'\[yt\](.*?)\[/yt\]'i",
                  "'\[img\](.*?)\[/img\]'i"
                  // '/[\n]+/'
                  // '/\[youtube\]http:\/\/(?:www\.)?youtube\.com\/watch\?v=(.*?)\[\/youtube\]/i'
                  );
    $replace = array(
                     "<strong>\\1</strong>",
                     "<em>\\1</em>",
                     "<span style=\"text-decoration: underline;\">\\1</span>",
                     "\\1",
                     "\\2",
                     "<blockquote><div style=\"font-size: 12px;\">quote (\\1):</div><div style=\"border:1px solid #ACA899;\">\\2</div></blockquote>",
                     "<blockquote><div style=\"font-size: 12px;\">quote:</div><div style=\"border:1px solid #ACA899;\">\\1</div></blockquote>",
                     "\\1",
                     "\\1",
                     '<img src="$1" />'
                     // '<br />'
                     );

    $text = preg_replace($find,$replace,$text);

    return $text;
    
  }

}

?>