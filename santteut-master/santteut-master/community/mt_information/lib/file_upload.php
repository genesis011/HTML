<?php
// 다중 파일 업로드
if(isset($_FILES['upfile'])){
$files = $_FILES['upfile'];
$count = count($files["name"]);
$upload_dir="./data/";

for($i=0; $i<$count; $i++){
  $upfile_name[$i]=$files["name"][$i];
  $upfile_tmp_name[$i]=$files["tmp_name"][$i];
  $upfile_type[$i]=$files["type"][$i];
  $upfile_size[$i]=$files["size"][$i];
  $upfile_error[$i]=$files["error"][$i];

  $file=explode(".",$upfile_name[$i]);
  $file_name=$file[0];
  $file_extension=$file[1];

  if(!$upfile_error[$i]){
    $new_file_name = date("Y_m_d_H_i_s");
    $new_file_name = $new_file_name."_".$i;
    $copied_file_name[$i] = $new_file_name.".".$file_extension;
    $uploaded_file[$i] = $upload_dir.$copied_file_name[$i];
  }
  $type[$i] = explode("/", $upfile_type[$i]);
  if($type[$i][0]=='image'){
    alert_back('이미지 파일은 업로드 할 수 없습니다.');
  }else{
    if($upfile_size[$i]>500000) {
      alert_back('파일사이즈는 500kb 이하만 업로드 할 수 있습니다.');
    }
  }

  move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]);

  // if(!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i])){
  //   alert_back('서버 전송에러');
  // }

}//end of for
}
?>
