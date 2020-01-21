<?php
  session_start();

  if(!(isset($_SESSION['id']) &&  $_SESSION['id']=="admin")){
    echo "<script>alert('권한없음!');history.go(-1);</script>";
    exit;
  }

  $name = $_SESSION['name'];

  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

  define('ROW_SCALE', 10);
  define('PAGE_SCALE', 5);

  $sql=$result=$total_record=$total_pages=$start_record=$row="";
  $total_record=0;

  if(isset($_GET["mode"])&&$_GET["mode"]=="search"){

    $find_option = test_input($_POST["find_option"]);

    $find_input = test_input($_POST["find_input"]);
    $q_find_input = mysqli_real_escape_string($conn, $find_input);

    if(empty($find_input)){
      echo ("<script>window.alert('검색할 단어를 입력해 주세요')
      location.href='member_admin_list.php';
      </script>");
      exit;
    }

    $sql="SELECT id, name, address1, address2, hp1, hp2, email from `member` where $find_option like '%$q_find_input%';";
  }else{
    $sql="SELECT id, name, address1, address2, hp1, hp2, email from `member`";
  }

  $result=mysqli_query($conn,$sql);
  $total_record=mysqli_num_rows($result);
  $total_pages=ceil($total_record/ROW_SCALE);
  $start_page= (ceil($page / PAGE_SCALE ) -1 ) * PAGE_SCALE +1 ;
  $start_record=($page -1) * ROW_SCALE;
  $end_page= ($total_pages >= ($start_page + PAGE_SCALE)) ? $start_page + PAGE_SCALE-1 : $total_pages;
  $view_num = $total_record - $start_record;
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/admin/css/member_admin_list.css?ver=0">
    <script type="text/javascript" src="./js/member_admin_del.js?ver=1"></script>
    <title>회원관리</title>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>
    <hr>
    <h2 id="member_title">회원관리</h2>
    <hr>
    <section id="notice" style="height:700px; max-height:1500px;">
      <form name="notice_form" action="member_admin_list.php?mode=search" method="post">
        <div class="notice_list_search">
          <li id="total_title"><b>총 <?=$total_record?> 명</b></li>
          <li id="search_option">
            <select name="find_option">
              <option value="id">아이디</option>
              <option value="name">이름</option>
              <option value="email">이메일</option>
            </select>
          <input type="text" name="find_input" value="">
          <button type="submit" name="button" >검색</button>
          </li>
        </div>
      </form>
      <script type="text/javascript">
        function delete_submit(){
          var check = document.getElementsByName('select_del');
          var del_value = '';
          for (var i = 0; i < check.length; i++) {
            // check가 되어있으면 삭제
            // check된 체크박스의  value = id
            if(check[i].checked){
              // 체크된 아이디들의  배열 생성
              // ex) admin/wooju00/minji/
              del_value += check[i].value +"/";
            }
          }
          // member_admin_query.php 로 넘기기 위한 작업
          document.getElementsByName('del_value')[0].value = del_value;
          document.del_form.submit();
        }
      </script>
      <form name="del_form" action="member_admin_query.php?mode=delete" method="post">
        <!-- delete 하고 싶은 멤버들 -->
        <input type="hidden" name="del_value" value="">
      <table id="list_tbl" border="1">
        <tr>
          <th>선택</th>
          <th>아이디</th>
          <th>이름</th>
          <th>주소1</th>
          <th>주소2</th>
          <th>전화번호</th>
          <th>이메일</th>
          <th>정보수정</th>
        </tr>
      <?php
        for ($record = $start_record; $record  < $start_record+ROW_SCALE && $record<$total_record; $record++){
          mysqli_data_seek($result,$record);
          $row=mysqli_fetch_array($result);
          $id=$row['id'];
          $name=$row['name'];
          $address1=$row['address1'];
          $address2=$row['address2'];
          $hp1=$row['hp1'];
          $hp2=$row['hp2'];
          $email=$row['email'];
      ?>
        <tr>
          <td> <input type="checkbox" id="" name="select_del" value="<?=$id?>"> </td>
          <td><?=$id?></td>
          <td><?=$name?></td>
          <td><?=$address1?></td>
          <td><?=$address2?></td>
          <td><?=$hp1?><?=$hp2?></td>
          <td><?=$email?></td>
          <td><a href="http://<?=$_SERVER['HTTP_HOST']?>/santteut/member/join/join_edit.php?id=<?=$id?>" class="hov">
          <button type="button" name="button">정보수정</button></a></td>
        </tr>
        <?php
          $view_num--;
         }//end of for
        ?>
      </table>
      <div class="another_btn">
      <?php
        if(!empty($_SESSION['id'])){
          echo ('<a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/join/join_member.php" class="hov"><button id="admin_write_btn" style="margin-left:72.3%; margin-right:1%;" type="button" name="button">
          회원등록</button></a>');
          echo ('<button id="admin_write_btn" onclick="delete_submit()" type="button" name="button">
          회원삭제</button>');
        }
      ?>
      </div>
      <br>
    </form>
    <br>
      <div class="page_button_group">
        <?php
        if( $start_page > PAGE_SCALE ){
          echo( '<a href="member_admin_list.php?page=1"><button type="button" name="button" title="처음으로"><<</button></a>' );
          $pre_block= $start_page - PAGE_SCALE;
          if(isset($_GET['mode']) && $_GET['mode']=="search"){
            echo( '<a href="member_admin_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
          }else{
            echo( '<a href="member_admin_list.php?page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
          }
        }
        for( $i = $start_page; $i <= $end_page; $i++ ){
            if ( $i == $page ){
              echo( '<a href="#"><button type="button" name="button" style="background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">'.$i.'</button></a>' );
            }else if(isset($_GET['mode']) && $_GET['mode']=="search"){
              echo( '<a href="member_admin_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
            }else{
              echo( '<a href="member_admin_list.php?page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
            }
        }
        if( $total_pages > $end_page ){
          $next_block= $start_page + PAGE_SCALE;
          if(isset($_GET['mode']) && $_GET['mode']=="search"){
            echo( '<a href="member_admin_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$next_block.'"><button type="button" name="button">></button></a>' );
          }else{
            echo( '<a href="member_admin_list.php?page='.$next_block.'"><button type="button" name="button" title="다음">></button></a>' );
          }
          echo( '<a href="member_admin_list.php?page='.$total_pages.'"><button type="button" name="button" title="맨끝으로">>></button></a>' );
        }
        ?>
      </div>
    </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
  </footer>
  </body>
</html>
