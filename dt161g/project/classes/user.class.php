<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: user.class.php
 * Desc: Class User for Projekt
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
  public function __construct($userId, $userName, $password, $roles) {
    $this->userId = $userId;
    $this->userName = $userName;
    $this->password = $password;
    $this->roles = $roles;
  }

  public function getUserId(): string {
    return $this->userId;
  }

  public function getUserName(): string {
    return $this->userName;
  }

  public function testPassword($password): bool {
    return $this->password == $password;
  }

  public function getRoles(): array {
    return $this->roles;
  }

  public function isNull(): bool {
    if ($this->userName == null) {
      return true;
    } else {
      return false;
    }
  }

  private $userId;
  private $userName;
  private $password;
  private $roles;
}