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

  // Debug mode
  private static $debug = true;

  // Connection values
  private static $host = 'studentpsql.miun.se';
  private static $port = '5432';
  private static $user = 'vize1500';
  private static $dbname = 'vize1500';
  private static $password = 'gRd6QmzSN';

  static public function getDebug() {
    return self::$debug;
  }

  static public function getConnectString(): string {
    return 'host=' . self::$host . ' port=' . self::$port . ' dbname=' . self::$dbname . ' user=' . self::$user .' password=' . self::$password;
  }

  static public function getDbDns(){
      $dns = "";
      return $dns;
  }



}