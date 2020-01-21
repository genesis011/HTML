<?php
session_start();
if(!isset($_SESSION['id'])){
  echo "<script>alert('권한없음!');history.go(-1);</script>";
  exit;
}
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$userid = $_SESSION['id'];
$username = $_SESSION['name'];
$title = $_POST["title"];
$content = $_POST["content"];
$image = $_POST["del"];
$day=date("Y-m-d (H:i)");
$hit = $_POST["hit"];
if ($_FILES['upfile']['name']){
      if (!$_FILES['upfile']['error']) {
          $name=date("Y_m_d_H_i_s");
          $ext = explode('.', $_FILES['upfile']['name']);
          $filename = $name . '.' . $ext[1];
          $destination = './upload/' . $filename;//change this directory
          $location = $_FILES["upfile"]["tmp_name"];
          $upfilename = $_FILES["upfile"]["name"];
          $file_type= $_FILES['upfile']['type'];
          move_uploaded_file($location, $destination);
          }
          else
          {
          echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
          }
        }
        if(isset($_GET["mode"])&&$_GET["mode"]=="insert"){
        $sql="INSERT INTO `free` VALUES (null,'$userid','$username','$title','$content','$destination','$upfilename','$file_type','$image','$day',0);";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
          alert_back('Error: ' . mysqli_error($conn));
          // die('Error: ' . mysqli_error($conn));
        }
        $sql="SELECT num from `free` where id ='$userid' order by num desc limit 1;";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
          alert_back('Error: 6' . mysqli_error($conn));
          // die('Error: ' . mysqli_error($conn));
        }
        $row=mysqli_fetch_array($result);
        $num=$row['num'];
        mysqli_close($conn);

        echo "<script>location.href='./free_view.php?num=$num&hit=0';</script>";
      }else if(isset($_GET["mode"])&&$_GET["mode"]=="update"){
        $num = $_POST["num"];
        $sql="SELECT `destination` from `free` where num ='$num';";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
          alert_back('Error: ' . mysqli_error($conn));
        }
        $row=mysqli_fetch_array($result);
        $delimg=$row['destination'];
        if($_POST['del_file'] =='1'){
        if(!empty($delimg)){unlink($delimg);}
        $sql="UPDATE `free` SET `file_name` ='', `file_type` ='', `destination`='' WHERE `num`=$num;";
        $result = mysqli_query($conn,$sql);}
        if ($_FILES['upfile']['name']){
        if(!empty($delimg)){unlink($delimg);}
        $sql="UPDATE `free` SET `title`='$title', `content` ='$content', `del` ='$image', `file_name` ='$upfilename', `file_type` ='$file_type', `regist_day` ='$day', `destination`='$destination' WHERE `num`=$num;";
        $result = mysqli_query($conn,$sql);
      }else{
        $sql="UPDATE `free` SET `title`='$title', `content` ='$content', `del` ='$image', `regist_day` ='$day' WHERE `num`=$num;";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
          die('Error: ' . mysqli_error($conn));
        }
      }
        echo "<script>location.href='./free_view.php?num=$num&hit=$hit';</script>";


      }else if(isset($_GET["mode"])&&$_GET["mode"]=="delete"){

        $num = $_GET["num"];
        $sql="SELECT * from `free` where num ='$num';";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
          alert_back('Error: ' . mysqli_error($conn));
          // die('Error: ' . mysqli_error($conn));
        }
        $row=mysqli_fetch_array($result);
        $del=$row['del'];
        $route=$row['destination'];
        $delarry=explode("!",$del);
        if(!empty($del)){
            for ($i=0; $i<=count($delarry); $i++) {
              unlink($delarry[$i]);
          } }
        if(!empty($route)){
          unlink($route);
        }

        $sql ="DELETE FROM `free` WHERE `num`='$num';";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
          die('Error: ' . mysqli_error($conn));
        }

        $sql ="DELETE FROM `free_ripple` WHERE parent=$num";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
          die('Error: ' . mysqli_error($conn));
        }

        mysqli_close($conn);
        echo "<script>location.href='./free_list.php';</script>";




      }else if(isset($_GET["mode"])&&$_GET["mode"]=="insert_ripple"){
        if(empty($_POST["ripple_content"])){
          echo "<script>alert('내용입력요망!');history.go(-1);</script>";
          exit;
        }//덧글 다는사람은 로그인 해야한다.

          $content = test_input($_POST["ripple_content"]);
          $page = test_input($_POST["page"]);
          $parent = test_input($_POST["parent"]);
          $hit = test_input($_POST["hit"]);
          $q_username = mysqli_real_escape_string($conn, $_SESSION['name']);
          $q_content = mysqli_real_escape_string($conn, $content);
          $q_parent = mysqli_real_escape_string($conn, $parent);
          $regist_day=date("Y-m-d (H:i)");
          $sql="INSERT INTO `free_ripple` VALUES (null,'$q_parent','$userid','$q_username','$q_content','$regist_day')";
          $result = mysqli_query($conn,$sql);
          if (!$result) {
            die('Error: ' . mysqli_error($conn));
          }
          mysqli_close($conn);
          echo "<script>location.href='./free_view.php?num=$parent&page=$page&hit=$hit';</script>";


      }else if(isset($_GET["mode"])&&$_GET["mode"]=="delete_ripple"){
        $page= test_input($_GET["page"]);
        $hit= test_input($_GET["hit"]);
        $num = test_input($_POST["num"]);
        $parent = test_input($_POST["parent"]);
        $q_num = mysqli_real_escape_string($conn, $num);

        $sql ="DELETE FROM `free_ripple` WHERE num = $q_num";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
          die('Error: ' . mysqli_error($conn));
        }
        mysqli_close($conn);
        echo "<script>location.href='./free_view.php?page=$page&hit=$hit&num=$parent';</script>";

      }

 ?>
