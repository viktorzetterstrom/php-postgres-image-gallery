<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: role.class.php
 * Desc: Represents the different roles a user can have.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/

class Role {
  // Constructor
  public function __construct($roleId, $role) {
    $this->roleId = $roleId;
    $this->role = $role;
  }


  // Public functions

  // Getter for role id
  public function getId() {
    return $this->roleId;
  }

  // Getter for role name
  public function getRole() {
    return $this->role;
  }


  // Member variables
  private $roleId;
  private $role;
}