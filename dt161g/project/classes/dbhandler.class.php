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
        return new User("", "", "", []);
      }

      $password = $userResultArr['password'];
      $userId = $userResultArr['id'];

      // Get member role data.
      $roleQuery = 'SELECT * FROM dt161g.project_user_role INNER JOIN dt161g.project_role ON project_user_role.role_id = project_role.id WHERE project_user_role.user_id = $1';
      $roleResult = pg_query_params($this->dbConnection, $roleQuery, [$userId]);
      $roleResultArr = pg_fetch_all($roleResult, PGSQL_ASSOC);
      pg_free_result($userResult);
      pg_free_result($roleResult);

      $roles = [];
      foreach ($roleResultArr as $row) {
        array_push($roles, new Role($row['id'], $row['role']));
      }

      if ($userResult != false) {
        // Close connection
        $this->disconnect();
      }

      return new User($userId, $userName, $password, $roles);
    } else {
      return new User("", "", "", []);
    }
  }

  // Gets all the usernames in an array.
  public function getUsersAndCategories(): array {
    $this->connect();

    if ($this->isConnected()) {
      $usersAndCategories = [];

      // Get all user names
      $usersQuery = "SELECT username FROM dt161g.project_user";
      $usersResult = pg_query($this->dbConnection, $usersQuery);

      $userNames = [];
      while ($userName = pg_fetch_array($usersResult)) {
        array_push($userNames, $userName[0]);
      }

      // For each user name
      foreach ($userNames as $userName) {
        // Get all categories for that user
        $userCategories = $this->getCategoriesForUser($userName);

        // Append to return array
        $userAndCategories = [$userName, $userCategories];
        array_push($usersAndCategories, $userAndCategories);
      }

      return $usersAndCategories;
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
      pg_free_result($userResult);
      $userId = $userResultArr['id'];

      $roleQuery = "INSERT INTO dt161g.project_user_role (user_id, role_id) VALUES($1, $2)";
      pg_query_params($this->dbConnection, $roleQuery, [$userId, 1]);
      // If admin is to be created, also insert that role.
      if ($isAdmin) pg_query_params($this->dbConnection, $roleQuery, [$userId, 2]);

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

      return $categories;
    }

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


  // Adds provided image to the database, returns true if successful.
  public function addImage(Image $image): bool {
    $this->connect();

    if ($this->isConnected()) {
      $userName = $image->getUserName();

      // Get user id and category id.
      $userId = $this->getUserId($userName);
      $category = $image->getCategory();
      $categoryId = $this->getCategoryId($userId, $category);
      if ($userId == "" || $categoryId == "") {
        $this->disconnect();
        return false;
      }
      $imageData = $image->getImageData();
      $checksum = $image->getCheckSum();
      $mime = $image->getMime();
      $date = $image->getDate();

      // See if image with same checksum already exists
      $checkImageQuery = "SELECT checksum FROM dt161g.project_image WHERE checksum=$1 AND user_id=$2";
      $checkImageResult = pg_query_params($this->dbConnection, $checkImageQuery, [$checksum, $userId]);
      $checkImageResultArr = pg_fetch_array($checkImageResult);
      pg_free_result($checkImageResult);
      // If it exists, return false
      if ($checkImageResultArr) {

        $this->disconnect();
        return false;
      }

      // Add image to database.
      $imageQuery = "INSERT INTO dt161g.project_image
                    (image_data, checksum, mime, date, category_id, user_id)
                    VALUES($1, $2, $3, $4, $5, $6)";

      $byteaImageData = pg_escape_bytea($imageData);
      $imageResult = pg_query_params($this->dbConnection, $imageQuery,
                     [$byteaImageData, $checksum, $mime, $date, $categoryId, $userId]);

      $this->disconnect();
      if ($imageResult) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }


  // Function that retrieves images from the database.
  public function getImages(string $userName, string $category = ""): array {
    $this->connect();

    if ($this->isConnected()) {
      // Get user id, return false if not found
      $userId = $this->getUserId($userName);
      if ($userId == "") {
        $this->disconnect();
        return [];
      }

      // If provided, get category id
      if ($category != "") {
        $categoryId = $this->getCategoryId($userId, $category);
        // If empty string is returned, category does not exist. Then flag id
        // as invalid.
        if ($categoryId == "") $categoryId = 'invalid';
      } else {
        $categoryId = "";
      }

      // Fetch all images
      $imageResults = false;
      if ($categoryId != "invalid") {
        if ($category != "") {
          $imageQuery = "SELECT * FROM dt161g.project_image WHERE user_id=$1 AND category_id=$2";
          $imageResults = pg_query_params($this->dbConnection, $imageQuery, [$userId, $categoryId]);
        } else {
          $imageQuery = "SELECT * FROM dt161g.project_image WHERE user_id=$1";
          $imageResults = pg_query_params($this->dbConnection, $imageQuery, [$userId]);
        }
      }

      // Add images to array
      $imageArray = [];
      if ($imageResults) {
        while ($dbImage = pg_fetch_assoc($imageResults)) {
          $dbCategory = $this->getCategoryName($dbImage['category_id']);
          $imageData = pg_unescape_bytea($dbImage['image_data']);
          $checksum = $dbImage['checksum'];
          $mime = $dbImage['mime'];
          $date = $dbImage['date'];
          $newImage = new Image($userName, $dbCategory, $imageData, $checksum, $mime, $date);

          array_push($imageArray, $newImage);
        }
        pg_free_result($imageResults);
      }

      // Disconnect
      $this->disconnect();

      // Return images
      return $imageArray;
    }
    return [];
  }




  // Private functions.

  // Checks that a string only contains valid chars. Used to verify names of
  // categories and users upon creation.
  private function verifyText(string $text): bool {
    if (preg_match('/^\w{1,}$/', $text)) {
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

  // Gets the id for a category with a given name. Assumes connection to database
  // is established.
  private function getCategoryId(string $userId, string $categoryName): string {
    // get id
    $categoryQuery = "SELECT id FROM dt161g.project_category WHERE name=$1 AND user_id=$2";
    $categoryResult = pg_query_params($this->dbConnection, $categoryQuery, [$categoryName, $userId]);
    $categoryResultArr = pg_fetch_array($categoryResult);
    pg_free_result($categoryResult);

    // If category does not exist, return null
    if (!$categoryResultArr) {
      return "";
    } else {
      return $categoryResultArr['id'];
    }
  }

  // Fetches a category name based on given id, assumes connections is established
  private function getCategoryName(string $categoryId): string {
    // get id
    $categoryQuery = "SELECT name FROM dt161g.project_category WHERE id=$1";
    $categoryResult = pg_query_params($this->dbConnection, $categoryQuery, [$categoryId]);
    $categoryResultArr = pg_fetch_array($categoryResult);
    pg_free_result($categoryResult);

    // If category does not exist, return null
    if (!$categoryResultArr) {
      return "";
    } else {
      return $categoryResultArr['name'];
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
