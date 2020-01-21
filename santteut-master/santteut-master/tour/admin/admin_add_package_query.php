<?php
include '../../common/lib/db_connector.php';

// echo "<script>alert($_POST['p_code']);history.go(-1);</script>";
//--------------------------------------
if(!empty($_POST['p_place'])){
    $p_place = $_POST['p_place'];
}else{
    $p_place = "";
    echo "<script>alert('종류를 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_code'])){
    $code = $_POST['p_code'];
}else{
    $code = "";
    echo "<script>alert('코드를 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_name'])){
    $name = $_POST['p_name'];
}else{
    $name = "";
    echo "<script>alert('제목을 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_period'])){
    $period = $_POST['p_period'];
}else{
    $period = "";
    echo "<script>alert('기간을 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_dp_date'])){
    $dp_date = $_POST['p_dp_date'];
    $yoil = array("0","1","2","3","4","5","6");
    $day = $yoil[date('w', strtotime($dp_date))];
    $dp_day=$day;
    // alert($dp_day);
}else{
    $dp_date = "";
    echo "<script>alert('출발일을 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_dp_time'])){
    $dp_time = $_POST['p_dp_time'];
}else{
    $dp_time = "";
    echo "<script>alert('출발시간을 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_arr_time'])){
    $arr_time = $_POST['p_arr_time'];
}else{
    $arr_time = "";
    echo "<script>alert('도착시간을 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_pay'])){
    $pay = $_POST['p_pay'];
}else{
    $pay = "";
    echo "<script>alert('요금을 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_add_pay'])){
    $add_pay = $_POST['p_add_pay'];
}else{
    $add_pay = "";
    echo "<script>alert('추가요금여부를 선택하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_free_time'])){
    $free_time = $_POST['p_free_time'];
}else{
    $free_time = "";
    echo "<script>alert('자유일정여부를 선택하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_dp_city'])){
    $dp_city = $_POST['p_dp_city'];
}else{
    $dp_city = "";
    echo "<script>alert('출발도시를 선택하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['p_arr_mt'])){
    $arr_mt = $_POST['p_arr_mt'];
}else{
    $arr_mt = "";
    echo "<script>alert('도착산을 선택하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_POST['content'])){
    $detail_content = $_POST['content'];
}else{
    $detail_content = "";
    echo "<script>alert('내용을 입력하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_FILES['p_main_img1'])){
    $main_img1 = $_FILES['p_main_img_copy1'];
}else{
    $main_img1 = "";
    echo "<script>alert('메인 이미지1을 선택하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_FILES['p_main_img2'])){
    $main_img2 = $_FILES['p_main_img_copy2'];
}else{
    $main_img2 = "";
    echo "<script>alert('메인 이미지2을 선택하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_FILES['p_main_img3'])){
    $main_img3 = $_FILES['p_main_img_copy3'];
}else{
    $main_img3 = "";
    echo "<script>alert('메인 이미지3을 선택하세요');history.go(-1);</script>";
    return false;
}
if(!empty($_FILES['p_main_img1'])){

    //1. $_FILES['upfile']로부터 5가지 배열명을 가져와서 저장한다.
    $main_img_copy1 = $_FILES['p_main_img1'];//한개파일업로드정보(5가지정보배열로들어있음)
    $main_img_copy_name1= $_FILES['p_main_img1']['name'];//f03.jpg
    $main_img_copy_type1= $_FILES['p_main_img1']['type'];//image/gif  file/txt
    $main_img_copy_tmp_name1= $_FILES['p_main_img1']['tmp_name'];
    $main_img_copy_error1= $_FILES['p_main_img1']['error'];
    $main_img_copy_size1= $_FILES['p_main_img1']['size'];
    // echo "<script>alert('$upfile_tmp_name');history.go(-1);</script>";
    //2. 파일명과 확장자를 구분해서 저장한다.
    $file1 = explode(".", $main_img_copy_name1); //파일명과 확장자구분에서 배열저장
    $file_name1 = $file1[0];              //파일명
    $file_extension1 = $file1[1];         //확장자

    //3.업로드될 폴더를 지정한다.
    $upload_dir ="../../common/lib/editor/data/"; //업로드된파일을 저장하는장소지정

    //4.파일업로드가성공되었는지 점검한다. 성공:0 실패:1
    //파일명이 중복되지 않도록 임의파일명을 정한다.
    if(!$main_img_copy_error1){
      $new_file_name1=date("Y_m_d_H_i_s");
      $new_file_name1 = $new_file_name1."_"."0";
      $copied_file_name1= $new_file_name1.".".$file_extension1;
      $uploaded_file1 = $upload_dir.$copied_file_name1;
      // $uploaded_file = "./data/2019_04_22_15_09_30_0.jpg";
    }

    //5 업로드된 파일확장자를 체크한다.  "image/gif"
    $type=explode("/", $main_img_copy_type1);

    if($type[0]=='image'){
      switch ($type[1]) {
        case 'gif': case 'jpg': case 'png': case 'jpeg':
          case 'pjpeg': break;
          default:alert_back('3. gif jpg png 확장자가아닙니다.');
        }
        //6 업로드된 파일사이즈(2mb)를 체크해서 넘어버리면 돌려보낸다.
        if($main_img_copy_size1>10000000){
          alert_back('2. 이미지파일사이즈가 2MB이상입니다.');
        }
    }else{
        //5 업로드된 파일사이즈(500kb)를 체크해서 넘어버리면 돌려보낸다.
        if($main_img_copy_size1>2000000){
            alert_back('2. 파일사이즈가 500KB이상입니다.');
        }
    }

    //7. 임시저장소에 있는 파일을 서버에 지정한 위치로 이동한다.
    if(!move_uploaded_file($main_img_copy_tmp_name1, $uploaded_file1)){
      alert_back('이미지가 없습니다!');
    }

}else{
    $main_img_copy1 = "";
}
if(!empty($_FILES['p_main_img2'])){
    //1. $_FILES['upfile']로부터 5가지 배열명을 가져와서 저장한다.
    $main_img_copy2 = $_FILES['p_main_img2'];//한개파일업로드정보(5가지정보배열로들어있음)
    $main_img_copy_name2= $_FILES['p_main_img2']['name'];//f03.jpg
    $main_img_copy_type2= $_FILES['p_main_img2']['type'];//image/gif  file/txt
    $main_img_copy_tmp_name2= $_FILES['p_main_img2']['tmp_name'];
    $main_img_copy_error2= $_FILES['p_main_img2']['error'];
    $main_img_copy_size2= $_FILES['p_main_img2']['size'];
    // echo "<script>alert('$upfile_tmp_name');history.go(-1);</script>";
    //2. 파일명과 확장자를 구분해서 저장한다.
    $file2 = explode(".", $main_img_copy_name2); //파일명과 확장자구분에서 배열저장
    $file_name2 = $file2[0];              //파일명
    $file_extension2 = $file2[1];         //확장자

    //3.업로드될 폴더를 지정한다.
    $upload_dir ="../../common/lib/editor/data/"; //업로드된파일을 저장하는장소지정

    //4.파일업로드가성공되었는지 점검한다. 성공:0 실패:1
    //파일명이 중복되지 않도록 임의파일명을 정한다.
    if(!$main_img_copy_error2){
      $new_file_name2=date("Y_m_d_H_i_s");
      $new_file_name2 = $new_file_name2."_"."1";
      $copied_file_name2= $new_file_name2.".".$file_extension2;
      $uploaded_file2 = $upload_dir.$copied_file_name2;
      // $uploaded_file = "./data/2019_04_22_15_09_30_0.jpg";
    }

    //5 업로드된 파일확장자를 체크한다.  "image/gif"
    $type2=explode("/", $main_img_copy_type2);

    if($type2[0]=='image'){
      switch ($type2[1]) {
        case 'gif': case 'jpg': case 'png': case 'jpeg':
          case 'pjpeg': break;
          default:alert_back('3. gif jpg png 확장자가아닙니다.');
        }
        //6 업로드된 파일사이즈(2mb)를 체크해서 넘어버리면 돌려보낸다.
        if($main_img_copy_size2>10000000){
          alert_back('2. 이미지파일사이즈가 2MB이상입니다.');
        }
    }else{
        //5 업로드된 파일사이즈(500kb)를 체크해서 넘어버리면 돌려보낸다.
        if($main_img_copy_size2>2000000){
            alert_back('2. 파일사이즈가 500KB이상입니다.');
        }
    }

    //7. 임시저장소에 있는 파일을 서버에 지정한 위치로 이동한다.
    if(!move_uploaded_file($main_img_copy_tmp_name2, $uploaded_file2)){
      alert_back('이미지가 없습니다!');
    }

}else{
    $main_img_copy2 = "";
    echo "<script>alert('메인 이미지2을 선택하세요');history.go(-1);</script>";
}
if(!empty($_FILES['p_main_img3'])){
    //1. $_FILES['upfile']로부터 5가지 배열명을 가져와서 저장한다.
    $main_img_copy3 = $_FILES['p_main_img3'];//한개파일업로드정보(5가지정보배열로들어있음)
    $main_img_copy_name3= $_FILES['p_main_img3']['name'];//f03.jpg
    $main_img_copy_type3= $_FILES['p_main_img3']['type'];//image/gif  file/txt
    $main_img_copy_tmp_name3= $_FILES['p_main_img3']['tmp_name'];
    $main_img_copy_error3= $_FILES['p_main_img3']['error'];
    $main_img_copy_size3= $_FILES['p_main_img3']['size'];
    // echo "<script>alert('$upfile_tmp_name');history.go(-1);</script>";
    //2. 파일명과 확장자를 구분해서 저장한다.
    $file3 = explode(".", $main_img_copy_name3); //파일명과 확장자구분에서 배열저장
    $file_name3 = $file3[0];              //파일명
    $file_extension3 = $file3[1];         //확장자

    //3.업로드될 폴더를 지정한다.
    $upload_dir ="../../common/lib/editor/data/"; //업로드된파일을 저장하는장소지정

    //4.파일업로드가성공되었는지 점검한다. 성공:0 실패:1
    //파일명이 중복되지 않도록 임의파일명을 정한다.
    if(!$main_img_copy_error3){
      $new_file_name3=date("Y_m_d_H_i_s");
      $new_file_name3 = $new_file_name3."_"."2";
      $copied_file_name3= $new_file_name3.".".$file_extension3;
      $uploaded_file3 = $upload_dir.$copied_file_name3;
      // $uploaded_file = "./data/2019_04_22_15_09_30_0.jpg";
    }

    //5 업로드된 파일확장자를 체크한다.  "image/gif"
    $type=explode("/", $main_img_copy_type3);

    if($type3[0]=='image'){
      switch ($type3[1]) {
        case 'gif': case 'jpg': case 'png': case 'jpeg':
          case 'pjpeg': break;
          default:alert_back('3. gif jpg png 확장자가아닙니다.');
        }
        //6 업로드된 파일사이즈(2mb)를 체크해서 넘어버리면 돌려보낸다.
        if($main_img_copy_size3>10000000){
          alert_back('2. 이미지파일사이즈가 2MB이상입니다.');
        }
    }else{
        //5 업로드된 파일사이즈(500kb)를 체크해서 넘어버리면 돌려보낸다.
        if($main_img_copy_size3>2000000){
            alert_back('2. 파일사이즈가 500KB이상입니다.');
        }
    }

    //7. 임시저장소에 있는 파일을 서버에 지정한 위치로 이동한다.
    if(!move_uploaded_file($main_img_copy_tmp_name3, $uploaded_file3)){
      alert_back('이미지가 없습니다!');
    }

}else{
    $main_img_copy3 = "";
    echo "<script>alert('메인 이미지3을 선택하세요');history.go(-1);</script>";
}
if(!empty($_POST['p_bus'])){
    $bus = $_POST['p_bus'];
}else{
    $bus = "";
    echo "<script>alert('버스를 선택하세요');history.go(-1);</script>";
    return false;
}

  $package_str = "";
      for($i=0;$i<2;$i++) {
          $capi = rand()%26+65;
          $package_str .= chr($capi);
      }
  $package_num = mt_rand(100000, 999999);
// echo "<script>alert($p_place)</script>";
  if($p_place=="1"){
    $airplane_number="0";
  }else if($p_place=="2"){
  $airplane_number = $package_str . $package_num;
}else{
  echo "<script>alert('종류를 입력하세요');history.go(-1);</script>";
  return false;
}

$bus_sql="INSERT INTO `santteut`.`bus`(`b_code`)VALUES('$code')";

mysqli_query($conn, $bus_sql) or die(mysqli_error($conn));
$sql= "INSERT INTO `package`
(`p_code`,
`p_name`,
`p_period`,
`p_dp_date`,
`p_dp_day`,
`p_dp_time`,
`p_arr_time`,
`p_pay`,
`p_add_pay`,
`p_free_time`,
`p_dp_city`,
`p_arr_mt`,
`p_detail_content`,
`p_main_img1`,
`p_main_img2`,
`p_main_img3`,
`p_main_img_copy1`,
`p_main_img_copy2`,
`p_main_img_copy3`,
`p_airplane_num`,
`p_bus`)";

$sql.= "values ('$code', '$name', '$period', '$dp_date', '$dp_day', '$dp_time', '$arr_time', $pay, '$add_pay', '$free_time', '$dp_city','$arr_mt', '$detail_content', '$main_img_copy_name1', '$main_img_copy_name2', '$main_img_copy_name3', '$copied_file_name1', '$copied_file_name2', '$copied_file_name3', '$airplane_number', '$bus')";

mysqli_query($conn, $sql) or die(mysqli_error($conn));

mysqli_close($conn);
echo "<script>alert('패키지가 등록되었습니다.')</script>";
echo '<script>location.href="admin_add_package.php";</script>';

?>
