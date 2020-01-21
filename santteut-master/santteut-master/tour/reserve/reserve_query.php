<?php
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
  session_start();
  $id = $_SESSION['id'];
  $code=$_POST['code'];
  $seat=$_POST['seat'];
  $member_num=$_POST['member_num'];
  $adult=$_POST['adult'];
  $kid=$_POST['kid'];
  $baby=$_POST['baby'];

  $money=$_POST['money'];
  $money= str_replace(",","",$money);

  // echo $money;

  $pk=date("Y-m-d-H-i-s",time());
  srand((double)microtime()*1000000); //난수값 초기화
  $mil=rand(100000,999999);
  $pk=$pk."-".$mil;



  $sql_bus="INSERT INTO `bus`
  VALUES(
  '$pk',
  '$id',
  '$code',
  '$member_num',
  '$seat')";



  $date =date("Y-m-d");
  $cancel="0";
  $sql_reserve="INSERT INTO `reserve`
  VALUES(
  '$pk',
  '$code',
  '$id',
  '$date',
  '',
  '$adult',
  '$kid',
  '$baby',
  '$cancel',
  '$money'
  )";
  mysqli_query($conn,$sql_bus);
  mysqli_query($conn,$sql_reserve);
  // echo $date;
  $total=0;
  $sql_bill = "SELECT sum(`r_adult`+`r_kid`+`r_baby`),`p_bus` from `package` inner join `reserve` on `package`.`p_code` = `reserve`.`r_code` where `package`.`p_code` = '$code';";
  $result=mysqli_query($conn,$sql_bill);
  for($i=0;$i<mysqli_num_rows($result);$i++){
    $row1 = mysqli_fetch_array($result);
    $sum = $row1['sum(`r_adult`+`r_kid`+`r_baby`)'];
    $p_bus = $row1['p_bus'];
    $total +=$sum;
  }
  if($total>=$p_bus/2){
    //예약가능상태
    $status="결제가능";
    echo'[{"status":"'.$status.'","r_pk":"'.$pk.'"}]';
  }else{
    $status="예약완료";
    echo'[{"status":"'.$status.'","r_pk":"'.$pk.'"}]';
  }

 ?>
