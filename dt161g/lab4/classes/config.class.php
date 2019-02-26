<?php
/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: config.class.php
 * Desc: Class Config for laboration 3
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/

class Config {

  // Make constructor private
  private function __construct() {}

  // Singleton
  public static function Instance() {
      static $inst = null;
      if ($inst === null) {
          $inst = new Config();
      }
      return $inst;
  }

  // Returns debug status
 public function getDebug() {
    return $this->debug;
  }

  // Returns string for connecting to pg
  public function getConnectString() {
    return 'host=' . $this->host . ' port=' . $this->port . ' dbname=' . $this->dbname . ' user=' . $this->user .' password=' . $this->password;
  }

  public function getMemberLinks() {
    return $this->member_link_array;
  }

  public function getAdminLinks() {
    return $this->admin_link_array;
  }

  // Debug mode
  private $debug = true;

  // Connection values
  private $host = 'studentpsql.miun.se';
  private $port = '5432';
  private $user = 'vize1500';
  private $dbname = 'vize1500';
  private $password = 'gRd6QmzSN';


  // This array holds the links to be displayed when a member has logged in
  private $member_link_array = [
    "Gästbok" => "guestbook.php",
    "Meddlemssida" => "members.php"
  ];

  // This array holds the links to be displayed when a admin has logged in
  private $admin_link_array = [
    "Adminsida" => "admin.php"
  ];
}