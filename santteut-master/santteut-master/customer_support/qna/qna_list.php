<?php
  session_start();

  if(!isset($_SESSION['id'])){
    echo "<script>alert('회원가입 후 이용해주세요.');history.go(-1);</script>";
    exit;
  }
  $name = $_SESSION['name'];
  if(!isset($conn)){include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";}
  define('ROW_SCALE', 10);
  define('PAGE_SCALE', 5);
  $sql=$result=$total_record=$total_page=$start_record=$row="";
  $total_record=0;
  if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
    //제목, 내용, 작성자
    $find_option = test_input($_POST["find_option"]);
    $find_input = test_input($_POST["find_input"]);
    $q_find_input = mysqli_real_escape_string($conn, $find_input);

    if(empty($find_input)){
      echo ("<script>window.alert('검색할 단어를 입력해 주세요')history.go(-1)</script>");
      exit;
    }
    $sql="SELECT num, groupnum, depth, ord, name, title, content, regist_day, hit, pw from `qna` inner join member on `qna`.`id` = `member`.`id` where $find_option like '%$q_find_input%' order by num desc;";
  }else{
    $sql="SELECT num, groupnum, depth, ord, name, title, content, regist_day, hit, pw FROM `qna` inner join member on `qna`.`id` = `member`.`id` order by `groupnum` desc, `ord` asc;";
  }
  $result=mysqli_query($conn,$sql);
  $total_record=mysqli_num_rows($result);
  $total_pages=ceil($total_record/ROW_SCALE);
  $page=(empty($_GET['page']))?1:$_GET['page'];
  $start_page= (ceil($page / PAGE_SCALE ) -1 ) * PAGE_SCALE +1 ;
  $start_record=($page -1) * ROW_SCALE;
  $end_page= ($total_pages >= ($start_page + PAGE_SCALE)) ? $start_page + PAGE_SCALE-1 : $total_pages;
  $view_num = $total_record - $start_record;
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/customer_support/qna/css/qna_list.css?ver=5">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <title>문의하기</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#qna_mini").css("font-weight","bold");
        $("#qna_mini").css("color","black");
      });
    </script>
    <script type="text/javascript">
      function modal_alert(msg1,msg2){
        var modal = document.getElementById('myModal');
        $("#modal-content").html("");
        $("#modal-content").append("<form name='pw_check_form' id='pw_check_form' action='qna_modal_query.php?mode=pass' method='post'>");
        $("#pw_check_form").append("<h2>"+msg1+"</h2>");
        $("#pw_check_form").append("<h3>"+msg2+"</h3>");
        $("#pw_check_form").append('<div class="button-8" id="button-3">');
        $("#button-3").append('<div class="eff-8"></div>');
        $("#button-3").append("<a class=\'btn\' onclick=\'document.pw_check_form.submit()\' ><span>확인</span></a>");
        $("#button-3").append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=\'btn\' onclick=\'modal_close();\' ><span>취소</span></a>");
        $("#pw_check_form").append("</div>");
        $("#modal-content").append("</form>");
        modal.style.display="block";
      }
      function modal_close(){
        var modal = document.getElementById('myModal');
        modal.style.display="none";
      }
      window.onclick = function(event) {
        if (event.target == "modal") {
          var modal = document.getElementById('myModal');
            modal.style.display = "none";
        }
      };
    </script>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/custom_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>
    <section id="qna" style="height: 700px; max-height:2000px;">
      <div class="qna_list_search">
        <form name="board_form" action="qna_list.php?mode=search" method="post">
          <select name="find_option">
            <option value="title">제목</option>
            <option value="content">내용</option>
            <option value="name">작성자</option>
          </select>
          <input type="text" name="find_input">
          <input id ="search_btn" type="submit" value="검색"></input>
        </form>
      </div>
      <br>
      <table border="1">
        <tr>
          <th>번호</th>
          <th id="qna_list_title" style="width:490px;">제목</th>
          <th>작성자</th>
          <th>작성일</th>
          <th>조회</th>
          <th style="width:50px;">공개</th>
        </tr>
        <?php
          for ($record = $start_record; $record  < $start_record+ROW_SCALE && $record<$total_record; $record++){
            mysqli_data_seek($result,$record );
            $row=mysqli_fetch_array($result);
            $num=$row['num'];
            $name=$row['name'];
            $pw=$row['pw'];
            if(empty($pw)){$secret="공개";}else{$secret="비공개";}
            $hit=$row['hit'];
            $regist_day= substr($row['regist_day'],0,10);
            $title=$row['title'];
            $title=str_replace("\n", "<br>",$title);
            $title=str_replace(" ", "&nbsp;",$title);
            $depth=(int)$row['depth'];//공간을 몆칸을 띄어야할지 결정하는 숫자임
            $space="";
            for($j=0;$j<$depth;$j++){$space="&nbsp;&nbsp;".$space;}
        ?>
          <tr>
            <td><?=$view_num?></td>
            <td style="text-align:left;">
              <script type="text/javascript">
                function view_pw(num_val,page,hit){
                  $.ajax({
                    url: 'qna_modal.php?mode=pass',
                    type: 'POST',
                    data: {
                      num: num_val
                    }
                  })
                  .done(function(result) {
                  // php코드를 자바스크립트에서 쓰고 싶을때 json_encode
                    var id = <?=json_encode($_SESSION['id'])?>;
                    if(id=="admin"){
                      location.href="./qna_view.php?num="+num_val+"&hit="+hit;
                      return false;
                    }
                    switch (result) {
                      case 'public':
                      location.href="./qna_view.php?num="+num_val+"&hit="+hit;
                        break;
                      default:
                      modal_alert('비밀번호를 입력해주세요','<input style=\'height:34px;width:220px;\' type=\'password\' name=\'pw\'><input type=\"hidden\" name=\"num\" value=\''+num_val+'\'>');
                      break;
                    }
                    console.log("success");
                  })
                  .fail(function() {console.log("error");})
                  .always(function() {console.log("complete");});
                }
              </script>

              <!--메인글의 경우(depth가 0일 경우) bold두껍게 처리-->
              <?php
                if($depth==0){
                  echo '<a style="font-weight:bold;" onclick="view_pw('.$num.','.$page.','.($hit+1).')">'.$space.$title.'</a>';
                }else{
                  echo '<a onclick="view_pw('.$num.','.$page.','.($hit+1).')">'.$space.$title.'</a>';
                }
               ?>
            </td>
            <td><?=$name?></td>
            <td><?=$regist_day?></td>
            <td><?=$hit?></td>
            <td><?=$secret?></td>
          </tr>
          <?php
            $view_num--;
           }//end of for
          ?>
      </table>
      <?php
      if(!empty($_SESSION['id'])){
        echo '<a href="qna_form.php"><button id="admin_write_btn" type="button" name="button">
        글쓰기</button></a>';
      }
      ?>
      <br>
            <div class="page_button_group">
              <?php
              if( $start_page > PAGE_SCALE ){
                echo( '<a href="qna_list.php?page=1"><button type="button" name="button" title="처음으로"><<</button></a>' );
                $pre_block= $start_page - PAGE_SCALE;
                if(isset($_GET['mode']) && $_GET['mode']=="search"){
                  echo( '<a href="qna_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
                }else{
                  echo( '<a href="qna_list.php?page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
                }
              }
              for( $i = $start_page; $i <= $end_page; $i++ ){
                  if ( $i == $page ){
                    echo( '<a href="#"><button type="button" name="button" style="background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">'.$i.'</button></a>' );
                  }else if(isset($_GET['mode']) && $_GET['mode']=="search"){
                    echo( '<a href="qna_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
                  }else{
                    echo( '<a href="qna_list.php?page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
                  }
              }
              if( $total_pages > $end_page ){
                $next_block= $start_page + PAGE_SCALE;
                if(isset($_GET['mode']) && $_GET['mode']=="search"){
                  echo( '<a href="qna_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$next_block.'"><button type="button" name="button">></button></a>' );
                }else{
                  echo( '<a href="qna_list.php?page='.$next_block.'"><button type="button" name="button" title="다음">></button></a>' );
                }
                echo( '<a href="qna_list.php?page='.$total_pages.'"><button type="button" name="button" title="맨끝으로">>></button></a>' );
              }
              ?>
            </div>
          </section>
        </body>
        <footer>
          <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
        </footer>
      </html>
