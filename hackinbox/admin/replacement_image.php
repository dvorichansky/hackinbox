<?php

$_FILES['userfile']['name'];
$_FILES['userfile']['type'];
$_FILES['userfile']['size'];
$_FILES['userfile']['tmp_name'];
$_FILES['userfile']['error'];

$uploaddir = '../img/';
$uploadfile = $uploaddir . 'hackinbox_picture' . '.png';

clearstatcache(); // clear the cache to avoid errors

// image format check
$allowed =  array('png');
$filename = $_FILES['userfile']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
if (!in_array($ext, $allowed)) {
  print "Неверный формат изображения!";
} else {
  if (is_file($uploadfile)) { // check if there is such a file
    if (@unlink($uploadfile)) { // delete if any
      if (@move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        chmod($uploadfile, 0777); // set rights
        print "Файл обновлен!";
      } else {
        print "Ошибка при копировании!";
      }
    } else { // if the file is locked
      print "Невозможно удалить файл!";
    }
  } else { // if not write
    if (@move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
      chmod($uploadfile, 0777); // set rights
      print "Файл записан!";
    } else {
      print "Ошибка при копировании!";
    }
  }
}
