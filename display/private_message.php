<?php

session_start();

include ("../connect/connect_to_mysql.php");

include ("../class/pm.class.php");

// $id = $_SESSION['id'];

$pm_id = '';

$pm = new pm();

$display_whole_message = $pm->display_whole_message($id);

?>






