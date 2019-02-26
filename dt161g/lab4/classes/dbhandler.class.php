<?php
/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: dbhandler.class.php
 * Desc: Class DbHandler for laboration 4
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
require_once('config.class.php');

class DbHandler {

  private $dbConnection;

  // Make constructor private
  private function __construct() {}

  // Singleton
  public static function Instance() {
      static $inst = null;
      if ($inst === null) {
          $inst = new DbHandler();
      }
      return $inst;
  }


  public function getMember($userName): Member {
    // Connect to db
    $this->connect();

    if ($this->isConnected()) {
      // Get member data.
      $userQuery = 'SELECT member.id, member.username, member.password  FROM dt161g.member WHERE member.username = $1';
      $userResult = pg_query_params($this->dbConnection, $userQuery, [$userName]);
      $userResultArr = pg_fetch_array($userResult);

      // If no user is found, return null-user
      if ($userResultArr['username'] != $userName) {
        return new Member(null, null, null, null);
      }

      $password = $userResultArr['password'];
      $memberId = $userResultArr['id'];

      // Get member role data.
      $roleQuery = 'SELECT * FROM dt161g.member_role INNER JOIN dt161g.role ON member_role.role_id = role.id WHERE member_role.member_id = $1';
      $roleResult = pg_query_params($this->dbConnection, $roleQuery, [$memberId]);
      $roleResultArr = pg_fetch_all($roleResult, PGSQL_ASSOC);
      
      $roles = [];
      foreach ($roleResultArr as $row) {
        array_push($roles, new Role($row['id'], $row['role'], $row['roletext']));
      }

      if ($userResult != false) {
        // Close connection and free memory
        pg_free_result($userResult);
        $this->disconnect();
      }

      return new Member($memberId, $userName, $password, $roles);
    } else {
      return new Member(null, null, null, null);
    }
  }


  /* Stores a post on server.
  */
  public function storePost(array $post): void {
    // Connect to db
    $this->connect();
    if ($this->isConnected()) {
    $query = 'INSERT INTO dt161g.guestbook (name, message, iplog) VALUES ($1, $2, $3)';

    // Do query
    $result = pg_query_params($this->dbConnection, $query, array($post['name'], $post['text'], $post['ip']));

    if ($result != false) {
      // Close connection and free memory
      pg_free_result($result);
      $this->disconnect();
    }
    } else {
      echo 'Error connecting to database';
    }
  }

  /* Gets posts from database
  */
  public function getPosts(): array {
    // Connect to db
    $this->connect();
    $posts = [];
    if ($this->isConnected()) {
      $query = 'SELECT * FROM dt161g.guestbook';
      $result = pg_query($this->dbConnection, $query);
      $dbPosts =  (pg_fetch_all($result, PGSQL_ASSOC));
    
      foreach ($dbPosts as $dbPost) {
        $newPost = array('name' => $dbPost['name'],
                        'text' => $dbPost['message'],
                        'ip' => $dbPost['iplog'],
                        'date' => $dbPost['timelog']);

        array_push($posts, $newPost);
      }

      if ($result != false) {
        // Close connection and free memory
        pg_free_result($result);
        $this->disconnect();
      }

      return $posts;
    } else {
      echo 'Error connecting to database';
      return array();
    }
  }

  private function isConnected() {
    if ($this->dbConnection) {
      return true;
    } else {
      return false;
    }
  }

  private function connect() {
    $this->dbConnection = pg_connect(Config::Instance()->getConnectString());
  }

  private function disconnect() {
    pg_close($this->dbConnection);
  }
}