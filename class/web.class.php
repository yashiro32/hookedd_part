<?php

class web {
  public $disp;

  public function __construct() {
    include ("display.class.php");
    $this->disp = new display();
  }

  public function get_webpage_contents($url) {
    $count = 0;
    
    $img_src = "";
    
    $domain = parse_url($url, PHP_URL_HOST);
          
    // $response = file_get_contents($url);
    
    $header = array();
    $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
    $header[] = 'Cache-Control: max-age=0';
    $header[] = 'Connection: keep-alive';
    $header[] = 'Keep-Alive: 300';
    $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
    $header[] = 'Accept-Language: en-us,en;q=0.5';
    $header[] = 'Pragma: ';
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $response = curl_exec($ch);
    curl_close ($ch);
    
    if ($response == false) {
          return null;
    }
   
    $doc = new DOMDocument();
    $doc->loadHTML($response);
    
    // libxml_use_internal_errors(TRUE);
    // $doc->loadHTMLFile($url);
    // libxml_clear_errors();
    
    $tags = array ('p', 'a', 'strong', 'span', 'div');
    $texts = array ();
  
    $imgs = $doc->getElementsByTagName('img');
    $metas = $doc->getElementsByTagName('meta');
    $titles = $doc->getElementsByTagName('title');
   
    foreach ($imgs as $tag) {
               $img_src .= $tag->getAttribute('src');
    }
     
    if ($img_src != "") {
          $webpage_contents = '<span style="display: inline-block; margin-top: 0; margin-left: 0; width: 100px; height: 100px; vertical-align: top;">';
    
          foreach($imgs as $tag) {
                    if ($tag->getAttribute('src') != "") {
                          if (parse_url($tag->getAttribute('src'), PHP_URL_HOST) == false) {
                                // $new_src = "http://" . $domain . $tag->getAttribute('src');
                                // $dimensions = $this->disp->get_resized_dimensions($new_src, 100, 100);
                                // $dim_array = explode(",", $dimensions);
                                
                                $webpage_contents .= '<img src="http://' . $domain . '/' . $tag->getAttribute('src') . '" id="' . $count . '" style="display: none;" />';
                          } else {
                                // $dimensions = $this->disp->get_resized_dimensions($tag->getAttribute('src'), 100, 100);
                                // $dim_array = explode(",", $dimensions);
                          
                                $webpage_contents .= '<img src="' . $tag->getAttribute('src') . '" id="' . $count . '" style="display: none;" />';
                          }
                          $count ++;
                    }
          }
    
          $webpage_contents .= '</span>';
          
          $webpage_contents .= '<span style="display: inline-block; margin-top: 0; margin-left: 10px; width: 300px;">';
    
    } else {
          $webpage_contents .= '<span style="display: block; width: 300px;">';
    }
    
    // $webpage_contents .= '<span style="position: absolute; width: 20%;">';
   
    foreach($titles as $title) {
              $webpage_contents .= '<strong>' . $title->nodeValue . '</strong>';
    }
    
    $webpage_contents .= '<br /><br />' . $url;
    
    $count_m_d = 0;
    
    foreach($metas as $meta) {
              if ($meta->getAttribute('name') == "description") {
                    $webpage_contents .= '<br /><br /><i contenteditable="true" style="display: block;">' . $meta->getAttribute('content') . '</i>';
                    $count_m_d++;
              }
    }
    
    if ($count_m_d == 0) {
          foreach($tags as $tag) {
                    $elementList = $doc->getElementsByTagName($tag);
                    foreach($elementList as $element) {
                              // $texts[$element->tagName][] = $element->textContent;
                              array_push($texts, $element->textContent);
                    }
          }
          
          $webpage_contents .= '<br /><br /><i contenteditable="true" style="display: block;">' . $texts[0] . '</i>';
    }
    
    $webpage_contents .= '
                                <br />
                                <button id="prev_btn" type="button" onclick="javascript: show_prev_image(this);" >
                                  <img src="images/previous.jpg" style="cursor: pointer;" />
                                </button>
                                <button id="next_btn" type="button" onclick="javascript: show_next_image(this);">
                                  <img src="images/next.jpg" style="cursor: pointer;" />
                                </button>
                                <a id="image_count" style="text-decoration: none;"></a>
                          </span>';
    
    return $webpage_contents;
    
  }
  
  public function get_youtube_contents($url, $youtube_id) {
    $domain = parse_url($url, PHP_URL_HOST);
    
    $video_content = 'http://gdata.youtube.com/feeds/api/videos/' . $youtube_id;
          
    // $response = file_get_contents($url);
    
    $header = array();
    $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
    $header[] = 'Cache-Control: max-age=0';
    $header[] = 'Connection: keep-alive';
    $header[] = 'Keep-Alive: 300';
    $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
    $header[] = 'Accept-Language: en-us,en;q=0.5';
    $header[] = 'Pragma: ';
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $video_content);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $response = curl_exec($ch);
    curl_close ($ch);
    
    if ($response == false) {
          return null;
    }
    
    $doc = new DOMDocument();
    $doc->loadXML($response);
  
    // $tags = $doc->getElementsByTagName('img');
    // $metas = $doc->getElementsByTagName('meta');
    $metas = $doc->getElementsByTagName('content');
    $titles = $doc->getElementsByTagName('title');
    
    $new_src = "http://img.youtube.com/vi/" . $youtube_id . "/1.jpg";
    $dimensions = $this->disp->get_resized_dimensions($new_src, 100, 100);
    $dim_array = explode(",", $dimensions);
          $webpage_contents .= '<span id="youtube_image" style="display: inline-block; margin-top: 0; margin-left: 0; width: 100px; height: 100px;">
                                  <img src="http://img.youtube.com/vi/' . $youtube_id . '/1.jpg" width="' . $dim_array[0] . '" height="' . $dim_array[1] . '" />
                                </span>
                                <span style="display: inline-block; position: absolute; margin-top: 0; margin-left: 10px; width: 20%;">
                               ';
   
    foreach($titles as $title) {
              $webpage_contents .= '<strong>' . $title->nodeValue . '</strong>';
    }
    
    $webpage_contents .= '<br /><br />' . $url;
    
    foreach($metas as $meta) {
              // if ($meta->getAttribute('name') == "description") {
                    // $webpage_contents .= '<br /><br /><i>' . $meta->getAttribute('content') . '</i>';
              // }
    
              $webpage_contents .= '<br /><br /><i>' . $meta->nodeValue . '</i>';
    }
    
    $webpage_contents .= '
                                <br />
                                <!-- <button id="prev_btn" type="button" onclick="javascript: show_prev_image(this);" >
                                  <img src="images/previous.jpg" style="cursor: pointer;" />
                                </button>
                                <button id="next_btn" type="button" onclick="javascript: show_next_image(this);">
                                  <img src="images/next.jpg" style="cursor: pointer;" />
                                </button> -->
                                <a id="image_count" style="text-decoration: none;"></a>
                          </span>';
    
    return $webpage_contents;
  }

}

?>