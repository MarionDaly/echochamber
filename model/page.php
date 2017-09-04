<?php
  class PageModel extends Database {
    public function searchURL($url_key, $x){
      $this->query('SELECT pid, type, title, description, meta_kw, meta_title, meta_desc, content, tags, page_url, comments FROM page WHERE page_url LIKE :url OR title LIKE :title OR tags LIKE :tags ORDER BY created DESC LIMIT :x');
      $this->bind(':url', $url_key);
      $this->bind(':title', $url_key);
      $this->bind(':tags', $url_key);
      $this->bind(':x', $x);
      return (array) $this->resultset();
    }
    public function loadPage(int $pid) {
      $this->query('SELECT pid, type, title, description, meta_kw, meta_title, meta_desc, content, tags, page_url, comments FROM page WHERE page_url = :url');
      $this->bind(':url', $url_key);
      return (array) $this->single();
    }
  }
?>
