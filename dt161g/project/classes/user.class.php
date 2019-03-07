<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: user.class.php
 * Desc: Class User, represents a user of the website. A user can an additional
 * role as an admin, which gives more privileges.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);

/**
 * Class representing a user of the webpage.
 */
class User {

  // Constructor
  public function __construct($userId, $userName, $password, $roles) {
    $this->userId = $userId;
    $this->userName = $userName;
    $this->password = $password;
    $this->roles = $roles;
  }


  // Public functions

  // Getter for userid
  public function getUserId(): string {
    return $this->userId;
  }

  // Getter for username
  public function getUserName(): string {
    return $this->userName;
  }

  // Test function for password
  public function testPassword($password): bool {
    if ($this->password != null) {
      return password_verify($password, $this->password);
    } else {
      return false;
    }
  }

  // Getter for roles
  public function getRoles(): array {
    return $this->roles;
  }

  // Checks wether it is a null-user.
  public function isNull(): bool {
    if ($this->userName == null) {
      return true;
    } else {
      return false;
    }
  }


  // Member variables
  private $userId;
  private $userName;
  private $password;
  private $roles;
}