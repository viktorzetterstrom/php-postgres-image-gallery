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

// Enum for role type
interface RoleType {
  const MEMBER = 0;
  const ADMIN = 1;
};

class Role {

  public function __construct($roleId, $role, $roleText) {
    $this->roleId = $roleId;
    $this->role = $role;
    $this->roleText = $roleText;
  }

  public function getRole() {
    return $this->role;
  }

  public function getRoleText() {
    return $this->roleText;
  }

  private $roleId;
  private $role;
  private $roleText;
}


