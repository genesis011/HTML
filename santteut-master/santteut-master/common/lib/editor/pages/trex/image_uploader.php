<?php
//1. $_FILES['upfile']로부터 5가지 배열명을 가져와서 저장한다.
$upfile = $_FILES['upload_file'];//한개파일업로드정보(5가지정보배열로들어있음)
$upfile_name= $_FILES['upload_file']['name'];//f03.jpg
$upfile_type= $_FILES['upload_file']['type'];
$upfile_tmp_name= $_FILES['upload_file']['tmp_name'];
$upfile_error= $_FILES['upload_file']['error'];
$upfile_size= $_FILES['upload_file']['size'];
$image_url = $url['root'].'files/' . $file_name;
//2. 파일명과 확장자를 구분해서 저장한다.
$file = explode(".", $upfile_name); //파일명과 확장자구분에서 배열저장
$file_name = $file[0];              //파일명
$file_extension = $file[1];         //확장자

//3.업로드될 폴더를 지정한다.
$upload_dir ="../../data/"; //업로드된파일을 저장하는장소지정
//4.파일업로드가성공되었는지 점검한다. 성공:0 실패:1
//파일명이 중복되지 않도록 임의파일명을 정한다.
if(!$upfile_error){
  $new_file_name=date("Y_m_d_H_i_s");
  $new_file_name = $new_file_name."_"."0";
  $copied_file_name= $new_file_name.".".$file_extension;
  $uploaded_file = $upload_dir.$copied_file_name;
  // $uploaded_file = "./data/2019_04_22_15_09_30_0.jpg";
}
//5 업로드된 파일사이즈(2mb)를 체크해서 넘어버리면 돌려보낸다.
if($upfile_size>2000000){
    alert_back('2. 파일사이즈가 500KB이상입니다.');
}
//6 업로드된 파일확장자를 체크한다.  "image/gif"
$file_type = $upfile_type;
//7. 임시저장소에 있는 파일을 서버에 지정한 위치로 이동한다.
if(!move_uploaded_file($upfile_tmp_name, $uploaded_file)){
  alert_back('4. 서버 전송에러!!');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>image_uploader.php</title>
<script src="../../js/popup.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="../../css/popup.css" type="text/css"  charset="utf-8"/>
<script type="text/javascript">
// <![CDATA[
    function initUploader(){
        var _opener = PopupUtil.getOpener();
        if (!_opener) {
            alert('잘못된 경로로 접근하셨습니다.');
            return;
        }
        var _attacher = getAttacher('image', _opener);
        registerAction(_attacher);

            if (typeof(execAttach) == 'undefined') { //Virtual Function
            return;
        }
        var _mockdata = {
            'imageurl': '<?php echo "http://localhost/santteut/common/lib/editor/data/".$copied_file_name;?>',
            'filename': '<?php echo $copied_file_name; ?>',
            'filesize': <?php echo $upfile_size; ?>,
            'imagealign': 'C',
            'originalurl': '<?php echo "http://localhost/santteut/common/lib/editor/data/".$copied_file_name; ?>',
            'thumburl': '<?php echo "http://localhost/santteut/common/lib/editor/data/".$copied_file_name; ?>'
        };
        execAttach(_mockdata);
        closeWindow();
    }
</script>
</head>
<body onload="initUploader();">
</body>
</html>
