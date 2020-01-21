<?php
@session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$id = $_SESSION['id'];
if(isset($_GET["mode"])){
  $p_code=$_GET["mode"];
  $str='';
  $sql="SELECT * from `package` where `p_code` = '$p_code';";
  $member_sql="SELECT * from `member` where `id` = '$id';";
  $bus_sql="SELECT * from `bus` where `b_code`='$p_code';";
  $reserve_status_sql = "SELECT sum(`r_adult`+`r_kid`+`r_baby`),`p_bus` from `package` inner join `reserve` on `package`.`p_code` = `reserve`.`r_code` where `package`.`p_code` = '$p_code';";
  $bus_result = mysqli_query($conn,$bus_sql) or die("실패원인1: ".mysqli_error($conn));
  while($row = mysqli_fetch_array($bus_result)){
    $b_seat = $row['b_seat'];       //좌석정보를 가져옴 /1/2
    $str .= $b_seat;      //예약된 좌석번호 누적해서 변수에 저장 ex) "/4/5/6" + "/1/2/3"+ "/65/78"
  }
  $b_seat = explode("/", $str);

    foreach ($b_seat as $key => $val) {
        $seat[$val] = $val;
    }
}
// 쿼리문실행문장

$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
$p_name=$row['p_name'];
$p_dp_date=$row['p_dp_date'];
$p_dp_time=$row['p_dp_time'];
$p_dp_city=$row['p_dp_city'];
$p_arr_time=$row['p_arr_time'];
$p_pay=$row['p_pay'];
$p_add_pay=$row['p_add_pay'];
$p_free_time=$row['p_free_time'];
$p_main_img_copy1=$row['p_main_img_copy1'];
$p_main_img_copy2=$row['p_main_img_copy2'];
$p_main_img_copy3=$row['p_main_img_copy3'];
$p_arr_mt=$row['p_arr_mt'];
$p_period=$row['p_period'];
$p_detail_content=$row['p_detail_content'];
$timestamp = strtotime("$p_dp_date +$p_period days");
$p_arr_date1 = date('y-m-d', $timestamp);
$p_arr_date2 = "20".$p_arr_date1;
$city = substr($p_dp_city, 0,6);
if($p_add_pay=="1"){
  $p_add_pay="포함";
}else{
  $p_add_pay="불포함";
}

if($p_free_time=="1"){
  $p_free_time="포함";
}else{
  $p_free_time="불포함";
}
  $yoil = array("일","월","화","수","목","금","토");
  $day = $yoil[date('w', strtotime($p_dp_date))];
  $day2 = $yoil[date('w', strtotime($p_arr_date2))];
  $dp_date=explode("-", $p_dp_date);
  $dp_date2=explode("-", $p_arr_date2);
  $p_bus=$row['p_bus'];
  $member_result=mysqli_query($conn,$member_sql);
  $member_row=mysqli_fetch_array($member_result);
  $name=$member_row['name'];
  $hp1=$member_row['hp1'];
  $hp2=$member_row['hp2'];
  $email=$member_row['email'];
  $hp=$hp1.$hp2;
  $email=explode("@", $email);
  $result_status_sql=mysqli_query($conn,$reserve_status_sql);
  $total=0;
  $status ="예약가능";
  $status2 ="예약완료";
  for($i=0;$i<mysqli_num_rows($result_status_sql);$i++){
    $row1 = mysqli_fetch_array($result_status_sql);
    $sum = $row1['sum(`r_adult`+`r_kid`+`r_baby`)'];
    $p_bus = $row1['p_bus'];
    $p_bus_half =(ceil($p_bus / 2));
    $total +=$sum;
  }
  if($total>=$p_bus_half){
    $status="출발가능";
    $status2="결제하기";
  }
  if($total==$p_bus){
    $status="예약마감";
    $status2="예약마감";
  }
  if($p_dp_date<= date("Y-m-d")){ $status="마감";}

 ?>
