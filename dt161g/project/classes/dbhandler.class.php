<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: dbhandler.class.php
 * Desc: Class DbHandler for project
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
        array_push($roles, new Role($row['id'], $row['role'], $row['roletext']));
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
  public function createUser(string $username, string $password, bool $isAdmin): bool {

    return true;
  }

  // Delete a user from database
  public function deleteUser(string $userName): bool {

    return true;
  }

  // Returns true if DbHandler is connected to database
  private function isConnected(): bool {
    if ($this->dbConnection) {
      return true;
    } else {
      return false;
    }
  }



  // Private functions.

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