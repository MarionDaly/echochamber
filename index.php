<?php
	session_start();
	session_regenerate_id();
	// Autoload all classes.
	require_once "autoload.php";
  // Load page.
	$Page = new Page($config);
  if(isset($_GET['path'])) {
    $url = $_GET['path'];
  }
  else {
    $url = "";
  }
?>
