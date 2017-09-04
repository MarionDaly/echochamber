<?php
// Load all models.
function autoload_model($className) {
  $filename = "model/" . $className . ".php";
  if (is_readable($filename)) {
    require $filename;
  }
}
// Load all controllers.
function autoload_controller($className) {
  $filename = "controller/" . $className . ".php";
  if (is_readable($filename)) {
    require $filename;
  }
}
spl_autoload_register("autoload_model");
spl_autoload_register("autoload_controller");

?>
