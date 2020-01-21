<?php
  $file_copied=$_GET['file_copied'];
  $file_name=$_GET['file_name'];

  if(!empty($file_copied)){
    $file_path = "./data/$file_copied";
    //2 서버의 Data영역에 실제 파일이 있는지 점검
    if(file_exists($file_path)){
    $fp=fopen($file_path, "rb"); //$fp 파일 핸들값
    //지정된 파일타입일경우에는 모든 브라우저 프로토콜 규약이 되어있음.
    if("text"){
      Header("Content-type: application/x-msdownload");
      Header("Content-Length: ".filesize($file_path));
      Header("Content-Disposition: attachment; filename=$file_name");
      Header("Content-Transfer-Encoding: binary");
      Header("Content-Description: File Transfer");
      Header("Expires: 0");
      //지정된 파일타입이 아닌경우
    }else{
      //타입이 알려지지 않았을때 익스플로어 프로토콜 통신방식
      if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)",$_SERVER['$HTTP_USER_AGENT'])){
        Header("Content-type: application/octet-stream");
        Header("Content-Length: ".filesize($file_path));
        Header("Content-Disposition: attachment; filename=$file_name");
        Header("Content-Transfer-Encoding: binary");
        Header("Expires: 0");
      }else{
        Header("Content-type: file/unknown");
        Header("Content-Length: ".filesize($file_path));
        Header("Content-Disposition: attachment; filename=$file_name");
        Header("Content-Description: PHP3 Generated Data");
        Header("Expires: 0");
      }
    }
    fpassthru($fp);
    fclose($fp);
  }
}

?>
