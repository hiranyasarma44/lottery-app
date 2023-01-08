<?php

use CodeIgniter\Files\File;

if (!function_exists('file_upload')) {
  function file_upload($file, $fileUploadDir = '/public/uploads/', $multiple = false)
  {
    if ($multiple) {
      // TODO: need testing
      return false;
      foreach ($file['images'] as $img) {
        if ($img->isValid() && !$img->hasMoved()) {
          $folderName = rtrim($folderName ?? date('Ymd'), '/') . '/';
          $fileName ??= $file->getRandomName();
          $img->move(ROOTPATH . $fileUploadDir . $folderName, $fileName);

          $fileLocation = ROOTPATH . $fileUploadDir . $folderName . $fileName;
          $uploadedFileInfo = new File(ROOTPATH . $fileLocation);
          $data[] = ['uploaded_flleinfo' => $uploadedFileInfo, 'file_path' => substr($uploadedFileInfo, -46)];
        }
      }
    }
    if (!$file->hasMoved()) {

      // Move the uploaded file to a new location.
      $folderName = rtrim($folderName ?? date('Ymd'), '/') . '/';
      $fileName ??= $file->getRandomName();
      $file->move(ROOTPATH . $fileUploadDir . $folderName, $fileName);
      $fileLocation = ROOTPATH . $fileUploadDir . $folderName . $fileName;
      $uploadedFileInfo = new File(ROOTPATH . $fileLocation);
      $data = ['uploaded_flleinfo' => $uploadedFileInfo, 'file_path' => substr($uploadedFileInfo, -46)];
      return $data;
    }
    return false;
  }
}
