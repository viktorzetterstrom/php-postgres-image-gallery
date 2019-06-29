<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: image.class.php
 * Desc: Represents an image uploaded to the page.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/

/**
 * Class representing images to be used on the webpage and uploaded to the
 * database.
 */
class Image {

  // Constructor
  public function __construct(string $userName,
                              string $category,
                              string $imageData,
                              string $checksum,
                              string $mime,
                              string $date) {
    $this->userName = $userName;
    $this->category = $category;
    $this->imageData = $imageData;
    $this->checksum = $checksum;
    $this->mime = $mime;
    $this->date = $date;
  }

  // Getters for member variables
  public function getUserName(): string {
    return $this->userName;
  }
  public function getCategory(): string {
    return $this->category;
  }
  public function getImageData(): string {
    return $this->imageData;
  }
  public function getCheckSum(): string {
    return $this->checksum;
  }
  public function getMime(): string {
    return $this->mime;
  }
  public function getDate(): string {
    return $this->date;
  }

  // Generates an image-tag for display .
  public function generateTag(string $classString = "", string $idString = ""): string {
    $src = 'data: '.$this->mime.';base64,'.$this->imageData;
    $tag = '<img src="' . $src . '" class="' . $classString .'" id="' . $idString . '">';
    return $tag;
  }

  // Member variables
  private $userName;
  private $category;
  private $imageData;
  private $checksum;
  private $mime;
  private $date;
}