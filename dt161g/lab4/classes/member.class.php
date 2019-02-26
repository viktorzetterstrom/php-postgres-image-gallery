<?php
/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: member.class.php
 * Desc: Class Member for laboration 3
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/


class Member {
  
  public function __construct($memberId, $userName, $password, $roles) {
    $this->memberId = $memberId;
    $this->userName = $userName;
    $this->password = $password;
    $this->roles = $roles;
  }

  public function getMemberId(): string {
    return $this->memberId;
  }

  public function getUserName(): string {
    return $this->userName;
  }

  public function getPassword(): string {
    return $this->password;
  }

  public function getRoles(): Role {
    return $this->roles;
  }

  private $memberId;
  private $userName;
  private $password;
  private $roles;
}