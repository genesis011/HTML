<?php
$file = $_FILES['file'];
if($_FILES['file']['name']){
  if (!$_FILES['file']['error']){
    $name = date("Y_m_d_H_i_s");
    $ext = explode('.', $_FILES['file']['name']);
    $filename = $name . '.' . $ext[1];
    $destination = './img/' .$filename; //change this directory
    $location = $_FILES["file"]["tmp_name"];
    move_uploaded_file($location, $destination);
    echo 'http://localhost/santteut/community/official_review/img/'.$filename; //change this URL
  }
  else
  {
    echo $message = 'Ooops! Your upload triggered the following error: '.$_FILES['file']['error'];
  }
}
?>
