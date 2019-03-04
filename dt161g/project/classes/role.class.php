<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: role.class.php
 * Desc: Class Role for project
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/

class Role {
  public function __construct($roleId, $role) {
    $this->roleId = $roleId;
    $this->role = $role;
  }

  public function getId() {
    return $this->roleId;
  }

  public function getRole() {
    return $this->role;
  }

  private $roleId;
  private $role;
}