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
  
  public function __construct($memberId, $userName, $passWord, $role) {
    $this->memberId = $memberId;
    $this->userName = $userName;
    $this->password = $passWord;
    $this->role = $role;
  }

  public function getMemberId(): string {
    return $this->memberId;
  }

  public function getUserName(): string {
    return $this->userName;
  }

  public function getRole(): Role {
    return $this->role;
  }

  private $memberId;
  private $userName;
  private $password;
  private $role;
}