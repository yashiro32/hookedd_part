<?php

$domain = $_SERVER['SERVER_NAME'];

header("location: http://" . $domain . "/index.php"); // Shoot viewer back to the homepage of the site if they try to look here
// header("location: http://hookedd.com/index.php"); // Shoot viewer back to the homepage of the site if they try to look here
exit();

?>