<?php

namespace App\Utils;

class File
{
  public static function imageUpload(array $image)
  {
    $allowedFileExtensions = ["jpg", "png", "webp", "gif", "jpeg"];
    $fileExtension = pathinfo($image["name"])["extension"];

    $doesFileExtensionMatches = array_search($fileExtension, $allowedFileExtensions);

    if (is_int($doesFileExtensionMatches)) {
      $imageName = time();
      $imageName .= str_replace(" ", "-", pathinfo($image["name"])["basename"]);
      if (!file_exists(public_dir("uploads"))) {
        mkdir(public_dir("uploads"));
      }
      move_uploaded_file($image["tmp_name"], public_dir("uploads/$imageName"));
      return "/uploads/$imageName";
    } else {
      return false;
    }
  }
}
