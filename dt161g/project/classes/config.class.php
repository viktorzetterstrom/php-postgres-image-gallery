<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: config.class.php
 * Desc: Singleton class that contains the settings for the project. Specifies
 * the connection to the database and if debug mode is to be used.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);


/**
 * Singleton class responsible for keeping the configuration of the app.
 */
class Config {

  // Private constructor
  private function __construct() {}

  // Singleton
  public static function Instance() {
    static $inst = null;
    if ($inst === null) {
        $inst = new Config();
    }
    return $inst;
  }


  // Public functions

  // Getter for debug
  public function getDebug(): bool {
    return $this->debug;
  }

  // Returns string for connecting to postgres database.
  public function getConnectString() {
    return 'host=' . $this->host . ' port=' . $this->port . ' dbname=' . $this->dbname . ' user=' . $this->user .' password=' . $this->password;
  }


  // Member variables

  // Debug mode
  private $debug = true;

  // Connection values
  private $host = 'studentpsql.miun.se';
  private $port = '5432';
  private $user = 'vize1500';
  private $dbname = 'vize1500';
  private $password = 'gRd6QmzSN';

}