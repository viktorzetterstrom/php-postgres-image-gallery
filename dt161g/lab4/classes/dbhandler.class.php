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


  // public function getMember($userName, $password) {
  //   pg_query_params($connection, 'SELECT member.username, member.password, member.role FROM dt161g.member WHERE member.username = $1', [$userName]);
  // }


  /* Stores a post on server.
  */
  public function storePost(array $post): void {
    // Connect to db
    $dbConnection = pg_connect(Config::Instance()->getConnectString());
    if ($dbConnection) {
    $query = 'INSERT INTO dt161g.guestbook (name, message, iplog) VALUES ($1, $2, $3)';

    // Do query
    $result = pg_query_params($dbConnection, $query, array($post['name'], $post['text'], $post['ip']));

    if ($result != false) {
      // Close connection and free memory
      pg_free_result($result);
      pg_close($dbConnection);
    }
    } else {
      echo 'Error connecting to database';
    }
  }

  /* Gets posts from database
  */
  public function getPosts(): array {
    // Connect to db
    $dbConnection = pg_connect(Config::Instance()->getConnectString());
    $posts = [];
    if ($dbConnection) {
      $query = 'SELECT * FROM dt161g.guestbook';
      $result = pg_query($dbConnection, $query);
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
        pg_close($dbConnection);
      }

      return $posts;
    } else {
      echo 'Error connecting to database';
      return array();
    }
  }

}