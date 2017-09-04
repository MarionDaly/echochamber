<?php
  class Page {
    private $controller_path;
    private $_db;
    public function __construct (array $config, Database $db) {
      $this->controller_path = array(
        "admin" => "Admin",
        "blog" => "Blog",
        "search" => "Search",
        "logout" => "User",
        "login" => "User",
        "home" => "Page"
      );
      $this->_db = $db;
    }
    // Take URL key, start proper controller and include proper view.
    public function init (string $url_key) {
      $key = $this->sanitizeString($url_key);
      $url = $this->explodeURL($key);

      if (empty($url[0])) {
        //$Page = new Page($url);
        return (string) "view/home.php";
      }
      elseif (array_key_exists($url[0], $this->controller_path)) {
        $obj_name = $this->controller_path[$url[0]];
        $$obj_name = new $this->controller_path[$url[0]]($url);
        return (string) "view/" . $url[0] . ".php";
      }
      else {
        $Search = new Search($url);
        return (string) "view/404.php";
      }
    }
    // Take a string and explore to an array.
    protected function explodeURL (string $key) {
      $url = explode( "/", $key);
      return (array) $url;
    }
    // Given a string, sanitize it.
    protected function sanitizeString (string $string) {
      $sanitized = htmlspecialchars(preg_replace('/[^-a-zA-Z0-9_]/', '', $string));
      $sanitized = strtolower(rtrim($sanitized, "/"));
      return (string) $sanitized;
    }
    private function getPid (array $url) {
      return (int) $pid;
    }
    public function getDescription(int $pid) {
      return (string) $description;
    }
    public function getTags(int $pid) {
      return (string) $tags;
    }
    public function getTitle(int $pid) {
      return (string) $title;
    }
    public function getCanUrl(int $pid) {
      return (string) $url;
    }
  }
?>
