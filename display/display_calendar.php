<?php

include ("../class/time.class.php");
include ("../class/events.class.php");

$event = new event();

$month = $_POST['month'];
$year = $_POST['year'];

$show_calendar = $event->show_calendar($month, $year);

echo $show_calendar;


?>