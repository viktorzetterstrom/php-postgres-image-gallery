<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: config.class.php
 * Desc: Class Config for Projekt
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

  public function getDebug(): bool {
    return $this->debug;
  }


  // Member variables
  private $debug = true;

}