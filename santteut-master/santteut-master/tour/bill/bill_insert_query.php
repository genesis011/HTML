<?php
      if(isset($_GET["r_pay"])){
        $r_pay=$_GET["r_pay"];
        $r_pay= str_replace(",","",$r_pay);
      }else{
        $r_pay="";
      }

      if(isset($_GET["p_code"])){
        $p_code=$_GET["p_code"];
      }else{
        $p_code="";
      }

      if(isset($_GET["p_name"])){
        $p_name=$_GET["p_name"];
      }else{
        $p_name="";
      }

      if(isset($_GET["bank"])){
        $bank=$_GET["bank"];
      }else{
        $bank="";
      }

      if(isset($_GET["b_seat"])){
        $b_seat=$_GET["b_seat"];
      }else{
        $b_seat="";
      }

      if(isset($_GET["r_pk"])){
      $r_pk=$_GET["r_pk"];
      }else{
        $r_pk="";
      }

      if(isset($_GET["way"])){
      $way=$_GET["way"];
      if($way=="2"){
        include $_SERVER['DOCUMENT_ROOT']."/santteut/tour/bill/bil_query.php";
        session_start();
      }
      }else{
        $way="";
      }


      if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
      }else{
        $id="";
      }

      $date=date("Y-m-d");


      $sql_bill="INSERT INTO `bill`
      VALUES(
      '$r_pk',
      '$p_code',
      '$id',
      '$date',
      '$way',
      '$r_pay'
      );";
      mysqli_query($conn, $sql_bill) or die(mysqli_error($conn));
      if($way=="2"){
      echo '<script>location.href="../../index.php";</script>';
      }
 ?>
