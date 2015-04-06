<?php

class convertToAgo {

  public function __construct() {
     // $this->registry = $registry;
  }

  public function convert_datetime($str) {
      list($date, $time) = explode(' ', $str);
      list($year, $month, $day) = explode('-', $date);
      list($hour, $minute, $second) = explode(':', $time);
      $timestamp = mktime($hour, $minute, $second, $month, $day, $year);

      /* $timezone = date_default_timezone_get();

      $userTimezone = new DateTimeZone($timezone);
      $gmtTimezone = new DateTimeZone('GMT');
      $myDateTime = new DateTime('2009-03-21 13:14', $gmtTimezone);
      $offset = $userTimezone->getOffset($myDateTime); */

      // $timestamp = $timestamp + 3600; 

      return $timestamp;
  }

  public function makeAgo($timestamp) {
            $difference = time() - $timestamp;
            $periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
            $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
            for($j=0; $difference >= $lengths[$j]; $j++)
                   $difference /= $lengths[$j];
                   $difference = round($difference);
            if($difference != 1) $periods[$j].= "s";
                   $text = "$difference $periods[$j] ago";
                   return $text;
                   // return $difference;
  }
  
}
?>