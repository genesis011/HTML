<?php
    session_start();
    $id=$_SESSION['id'];
    include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
    if(isset($_GET["r_pk"])){
      $r_pk=$_GET["r_pk"];
    }
    $bill_status_sql = "SELECT `p_pay`,`p_name`,`p_code`,`p_period`,`p_dp_date`,`p_dp_time`,`p_arr_time`,`r_id`,`r_adult`,`r_kid`,`r_baby`,`r_pay`,`p_bus`
    from `package` inner join `reserve` on `package`.`p_code` = `reserve`.`r_code` where `reserve`.`r_pk` = '$r_pk';";
    $result=mysqli_query($conn,$bill_status_sql);
    $row=mysqli_fetch_array($result);
    $p_pay=$row['p_pay'];
    $p_name=$row['p_name'];
    $p_code=$row['p_code'];
    $p_period=$row['p_period'];
    $p_dp_date=$row['p_dp_date'];
    $p_dp_time=$row['p_dp_time'];
    $p_arr_time=$row['p_arr_time'];
    $r_id=$row['r_id'];
    $r_adult=$row['r_adult'];
    $r_kid=$row['r_kid'];
    $r_baby=$row['r_baby'];
    $r_pay=$row['r_pay'];
    $p_bus=$row['p_bus'];
    $timestamp = strtotime("$p_dp_date +$p_period days");
    $p_arr_date1 = date('y-m-d', $timestamp);
    $p_arr_date2 = "20".$p_arr_date1;
    $yoil = array("일","월","화","수","목","금","토");
    $day = $yoil[date('w', strtotime($p_dp_date))];
    $day2 = $yoil[date('w', strtotime($p_arr_date2))];
    $dp_date=explode("-", $p_dp_date);
    $dp_date2=explode("-", $p_arr_date2);
    $member_sql = "SELECT * from `member` where `id`='$r_id';";
    $result2=mysqli_query($conn,$member_sql);
    $row2=mysqli_fetch_array($result2);
    $m_name=$row2['name'];
    $m_hp1=$row2['hp1'];
    $m_hp2=$row2['hp2'];
    $m_email=$row2['email'];
    $hp=$m_hp1.$m_hp2;
    $p_pay=(int)$p_pay;
    $bus_sql = "SELECT * from `bus` where `b_pk`='$r_pk';";
    $result3=mysqli_query($conn,$bus_sql);
    $row3=mysqli_fetch_array($result3);
    $b_seat=$row3['b_seat'];
 ?>
