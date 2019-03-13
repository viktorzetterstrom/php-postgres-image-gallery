<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: dbhandler.class.php
 * Desc: Class DbHandler, handles all the calls and connections to the database.
 * Used for creating, getting and deleting users and pictures.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once('util.php');

/**
 * Singleton class responsible for communicating with the database.
 */
class DbHandler {

  // Private constructor
  private function __construct() {}

  // Singleton
  public static function Instance() {
    static $inst = null;
    if ($inst === null) {
        $inst = new DbHandler();
    }
    return $inst;
  }



  // Public functions

  // Gets a user with a certain username from the database
  public function getUser($userName): User {
    // Connect to db
    $this->connect();

    if ($this->isConnected()) {
      // Get member data.
      $userQuery = 'SELECT id, username, password  FROM dt161g.project_user WHERE username = $1';
      $userResult = pg_query_params($this->dbConnection, $userQuery, [$userName]);
      $userResultArr = pg_fetch_array($userResult);

      // If no user is found, return null-user
      if ($userResultArr['username'] != $userName) {
        return new User(null, null, null, null);
      }

      $password = $userResultArr['password'];
      $userId = $userResultArr['id'];

      // Get member role data.
      $roleQuery = 'SELECT * FROM dt161g.project_user_role INNER JOIN dt161g.project_role ON project_user_role.role_id = project_role.id WHERE project_user_role.user_id = $1';
      $roleResult = pg_query_params($this->dbConnection, $roleQuery, [$userId]);
      $roleResultArr = pg_fetch_all($roleResult, PGSQL_ASSOC);

      $roles = [];
      foreach ($roleResultArr as $row) {
        array_push($roles, new Role($row['id'], $row['role']));
      }

      if ($userResult != false) {
        // Close connection and free memory
        pg_free_result($userResult);
        $this->disconnect();
      }

      return new User($userId, $userName, $password, $roles);
    } else {
      return new User(null, null, null, null);
    }
  }

  // Create a user in database
  public function createUser(string $userName, string $password, bool $isAdmin): bool {
    // Do not allow creation of users that have html-tags in their name.
    if ($userName != strip_tags($userName)) {
      return false;
    }

    // Connect
    $this->connect();

    if ($this->isConnected()) {

      // Hash password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Create query
      $userQuery = "INSERT INTO dt161g.project_user (username, password) VALUES ( $1, $2) RETURNING id";

      // Create user
      $userResult = pg_query_params($this->dbConnection, $userQuery, [$userName, $hashedPassword]);

      // if no result, return false.
      if (!$userResult) {
        $this->disconnect();
        return false;
      }

      $userResultArr = pg_fetch_assoc($userResult);
      $userId = $userResultArr['id'];

      $roleQuery = "INSERT INTO dt161g.project_user_role (user_id, role_id) VALUES($1, $2)";
      pg_query_params($this->dbConnection, $roleQuery, [$userId, 1]);
      // If admin is to be created, also insert that role.
      if ($isAdmin) pg_query_params($this->dbConnection, $roleQuery, [$userId, 2]);

      pg_free_result($userResult);
      $this->disconnect();
      return true;
    } else {
      return false;
    }
  }

  // Delete a user from database
  public function deleteUser($userName): bool {
    // It is not possible to delete current logged in user.
    session_start();
    if ($_SESSION['userLoggedIn'] == $userName) {
      return false;
    }

    // Connect to database
    $this->connect();
    if ($this->isConnected()) {

      // Run deletion query, use affected rows to see if change was made.
      $deletionQuery = "DELETE FROM dt161g.project_user WHERE username = $1";
      $deletionResult = pg_query_params($this->dbConnection, $deletionQuery, [$userName]);
      $affectedRows = pg_affected_rows($deletionResult);

      $this->disconnect();
      if ($affectedRows > 0) {
        pg_free_result($deletionResult);
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  // Private functions.

  // Returns true if DbHandler is connected to database
  private function isConnected(): bool {
    if ($this->dbConnection) {
      return true;
    } else {
      return false;
    }
  }

  // Connects to database
  private function connect(): void {
    $this->dbConnection = pg_connect(Config::Instance()->getConnectString());
  }

  // Disconnects from database
  private function disconnect(): void {
    pg_close($this->dbConnection);
  }

  // Member variables
  private $dbConnection;

}
