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
    if (!$this->verifyText($userName)) {
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
      pg_free_result($deletionResult);

      $this->disconnect();
      if ($affectedRows > 0) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }

  // Function that creates a category
  public function createCategory(string $categoryName, string $userName): bool {
    // Do not allow category names that contains unsafe chars.
    if (!$this->verifyText($categoryName)) {
      return false;
    }

    // Connect
    $this->connect();

    if ($this->isConnected()) {
      // Get user id
      $userId = $this->getUserId($userName);

      if ($userId == "") {
        $this->disconnect();
        return false;
      }

      // See if category already exists
      $checkCategoryQuery = "SELECT name FROM dt161g.project_category WHERE user_id=$1 AND name=$2";
      $checkCategoryResult = pg_query_params($this->dbConnection, $checkCategoryQuery, [$userId, $categoryName]);
      $checkCategoryResultArr = pg_fetch_array($checkCategoryResult);

      // If it exists, return false
      if ($checkCategoryResultArr) {
        pg_free_result($checkCategoryResult);
        $this->disconnect();
        return false;
      }

      $createCategoryQuery = "INSERT INTO dt161g.project_category (user_id, name) VALUES($1, $2)";
      $createCategoryResult = pg_query_params($this->dbConnection, $createCategoryQuery, [$userId, $categoryName]);

      // if no result, return false.
      if (!$createCategoryResult) {
        $this->disconnect();
        return false;
      }
      pg_free_result($createCategoryResult);

      $this->disconnect();
      return true;
    }
    return true;
  }

  // Function that returns an array with all categories connected to a specific
  // user
  public function getCategoriesForUser(string $userName): array {
    $this->connect();

    if ($this->isConnected()) {
      $userId = $this->getUserId($userName);

      if ($userId == "") {
        $this->disconnect();
        return array();
      }

      $categoryQuery = "SELECT name FROM dt161g.project_category WHERE user_id=$1";
      $categoryResult = pg_query_params($this->dbConnection, $categoryQuery, [$userId]);
      $categories = [];
      while ($categoryName = pg_fetch_array($categoryResult)) {
        array_push($categories, $categoryName['name']);
      }
      pg_free_result($categoryResult);
      $this->disconnect();

      return $categories;
    }

    return array();
  }

  // Function that gets all images within a certain category
  public function getImagesWithCategory(string $categoryName): array {

    return array();
  }

  // Function that deletes a certain category
  public function deleteCategory(string $categoryName, string $userName): bool {
    $this->connect();

    if ($this->isConnected()) {
      $userId = $this->getUserId($userName);

      if ($userId == "") {
        $this->disconnect();
        return false;
      }


      // Run deletion query, use affected rows to see if change was made.
      $deletionQuery = "DELETE FROM dt161g.project_category WHERE user_id=$1 AND name=$2";
      $deletionResult = pg_query_params($this->dbConnection, $deletionQuery, [$userId, $categoryName]);
      $affectedRows = pg_affected_rows($deletionResult);
      pg_free_result($deletionResult);
      $this->disconnect();

      if ($affectedRows > 0) {
        return true;
      } else {
        return false;
      }
    }
    return true;
  }


  // Private functions.

  // Checks that a string only contains valid chars. Used to verify names of
  // categories and users upon creation.
  private function verifyText(string $text): bool {
    if (preg_match('^\w{1,}$', $text)) {
      return true;
    } else {
      return false;
    }
  }

  // Gets a user id. Assumes connection has been made to the database.
  private function getUserId(string $userName): string {
    // Get user id
    $userQuery = "SELECT id FROM dt161g.project_user WHERE username=$1";
    $userResult = pg_query_params($this->dbConnection, $userQuery, [$userName]);
    $userResultArr = pg_fetch_array($userResult);
    pg_free_result($userResult);

    // If there is no such user, return null.
    if (!$userResultArr) {
      return "";
    } else {
      return $userResultArr['id'];
    }
  }

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
