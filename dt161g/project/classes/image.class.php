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
                              array $exif) {
    $this->userName = $userName;
    $this->category = $category;
    $this->imageData = $imageData;
    $this->checksum = $checksum;
    $this->mime = $mime;
    $this->exif = $exif;
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
  public function getMime(): string {
    return $this->mime;
  }
  public function getExif(): array {
    return $this->exif;
  }

  // Member variables
  private $userName;
  private $category;
  private $imageData;
  private $checksum;
  private $mime;
  private $exif;
}