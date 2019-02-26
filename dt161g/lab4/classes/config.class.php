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
  static public function getDebug() {
    return self::$debug;
  }

  // Returns string for connecting to pg
  static public function getConnectString(): string {
    return 'host=' . self::$host . ' port=' . self::$port . ' dbname=' . self::$dbname . ' user=' . self::$user .' password=' . self::$password;
  }

  static public function getMemberLinks(): array {
    return self::$member_link_array;
  }

  static public function getAdminLinks(): array {
    return self::$admin_link_array;
  }

  // Debug mode
  private static $debug = true;

  // Connection values
  private static $host = 'studentpsql.miun.se';
  private static $port = '5432';
  private static $user = 'vize1500';
  private static $dbname = 'vize1500';
  private static $password = 'gRd6QmzSN';


  // This array holds the links to be displayed when a member has logged in
  private static $member_link_array = [
    "Gästbok" => "guestbook.php",
    "Meddlemssida" => "members.php"
  ];

  // This array holds the links to be displayed when a admin has logged in
  private static $admin_link_array = [
    "Adminsida" => "admin.php"
  ];
}