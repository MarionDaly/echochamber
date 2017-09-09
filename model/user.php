<?php
/*
schema
user
uid | hash

user_info
uid | username | email | bio | sids | following | privacy

user_cookie
uid | cookie | timestamp


*/
	class UserDatabase extends Database {
		public function createUser(array $user) {
      try{
        $this->_db->beginTransaction();
        $this->_db->query('
          INSERT INTO 
            user (hash) 
          VALUES 
            (:hash)');
        $this->_db->bind(':hash', $user['hash']);
        $this->execute();
        $uid = $this->lastInsertId;
        $this->_db->query('
          INSERT INTO 
            user_info (uid, username, email) 
          VALUES 
            (:uid, :username. :email)');
        $this->_db->bind(':uid', $uid);
        $this->_db->bind(':username', $user['username']);
        $this->_db->bind(':email', $user['email']);
        $this->execute();
        $this->_db->endTransaction();
      }
      catch(PDOException $e) {
        $this->error = $e->getMessage();
        return (bool) FALSE;
      }
      return (bool) TRUE;

    }
    public function fetchHash(array $user) {
      try{
        $this->_db->beginTransaction();
        $this->_db->query('
          SELECT 
            hash 
          FROM 
            user 
          WHERE 
            uid = :uid');
        $this->_db->bind(':user', $user['uid']);
        $user_info = $this->single();
        $this->_db->endTransaction();
        $hash = $this->user_info['hash'];
      catch(PDOException $e) {
        $this->error = $e->getMessage();
      }
      return (string) $hash;
    }
    public function userExist(string $username) {
      try{
        $this->_db->beginTransaction();
        $this->_db->query('
          SELECT 
            uid 
          FROM 
            user_info 
          WHERE 
            username = :username');
        $this->_db->bind(':username', $username);
        $user_info = $this->single();
        $this->_db->endTransaction();
        $uid = $this->user_info['hash'];
      catch(PDOException $e) {
        $this->error = $e->getMessage();
      }
      return (string) $uid;
    }
    public function deleteUser(array $user) {
      try{
        $this->_db->beginTransaction();
        $this->_db->query('
          DELETE 
          FROM 
            user 
          WHERE 
            uid =  :uid');
        $this->_db->bind(':uid', $user['uid']);
        $this->execute();
        $this->_db->query('
          DELETE 
          FROM 
            user_info 
          WHERE 
            uid =  :uid');
        $this->_db->bind(':uid', $user['uid']);
        $this->execute();
        $this->_db->endTransaction();
        $this->deleteCookie($uid);
      catch(PDOException $e) {
        $this->error = $e->getMessage();
      }
    }
    public function checkCookie($cookie) {
      try{
        $this->_db->beginTransaction();
        $this->_db->query('
          SELECT 
            uid 
          FROM 
            user_cookie 
          WHERE 
            cookie = :cookie 
          AND timestamp > DATE_SUB( NOW(), INTERVAL 48 HOUR )');
        $this->_db->bind(':cookie', $cookie);
        $user_info = $this->single();
        $this->_db->endTransaction();
        $uid = $this->user_info['uid'];
      catch(PDOException $e) {
        $this->error = $e->getMessage();
      }
      return (string) $uid;
    }
    public function setCookie(array $user) {
      try{
        $this->_db->beginTransaction();
        $this->_db->query('
          INSERT INTO 
            user_cookie (uid, cookie) 
          VALUES 
            (:uid, :cookie)');
        $this->_db->bind(':uid', $user['uid']);
        $this->_db->bind(':cookie', $user['cookie']);
        $this->execute();
        $this->_db->endTransaction();      }
      catch(PDOException $e) {
        $this->error = $e->getMessage();
      }
    }
    public function deleteCookie(array $user) {
      $this->_db->beginTransaction();
      $this->_db->query('
        DELETE 
        FROM 
          user_cookie 
        WHERE 
          uid =  :uid');
      $this->_db->bind(':uid', $user['uid']);
      $this->execute();
      $this->_db->endTransaction();
    }
    public function updateUser(array $user) {
      try{
        $this->_db->beginTransaction();
        $this->_db->query('
          UPDATE user_info
          SET
            username = :username,
            bio = :bio,
            sids = :sids,
            privacy = :privacy
          WHERE
            uid = :uid');
        $this->_db->bind(':username', $user['username']);
        $this->_db->bind(':bio', $user['bio']);
        $this->_db->bind(':sids', $user['sids']);
        $this->_db->bind(':privacy', $user['privacy']);
        $this->_db->bind(':uid', $user['uid']);
        $this->execute();
        $this->_db->endTransaction();
      catch(PDOException $e) {
        $this->error = $e->getMessage();
      }
      return (string) $uid;
    }
	}
?>
