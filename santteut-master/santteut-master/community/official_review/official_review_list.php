<?php
//******************************************************************
$mode=$find=$search=$q_search=$sql=$result=$name="";
$page=$i=$row=$num=$title=$content=$regist_day=$main_img="";
$total_pages=$start_record=$end_page=$start_page="";
$total_record=0;
//******************************************************************
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
//1. 게시물수 정의
define('ROW_SCALE', 3);
define('PAGE_SCALE', 5);
//2. 변수정의
// $view_num 보여지는번호, $num은 DB에서 프라이머리키 번호
// $total_record 전체 게시물수, $start_record 한 페이지의 처음 게시물
// $record 는 게시물1개, $total_pages는 전체 페이지를 의미
if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
  //find_option 은 select의 값들을 문자열로 받아옴
  $find_option = test_input($_POST["find_option"]);

  //find_input 은 input의 값을 문자열로 받아옴
  $find_input = test_input($_POST["find_input"]);
  $q_find_input = mysqli_real_escape_string($conn, $find_input);

  if(empty($find_input)){
    echo ("<script>window.alert('검색할 단어를 입력해 주세요.');history.go(-1);</script>");
    exit;
  }

  $sql = "SELECT * FROM `official_review` WHERE `$find_option` like '%$q_find_input%';";

}else{
  $sql = "SELECT * FROM `official_review` order by num desc";
}

//쿼리문 실행 문장
$result = mysqli_query($conn,$sql);
$total_record = mysqli_num_rows($result);

//조건?참:거짓
$total_pages = ceil($total_record/ROW_SCALE);

//페이지가 없으면 디폴트 페이지 1페이지
$page = (empty($_GET['page']))?1:$_GET['page'];

$start_page = (ceil($page/ PAGE_SCALE) -1) * PAGE_SCALE +1;

$start_record = ($page-1) * ROW_SCALE;

$end_page= ($total_pages >= ($start_page + PAGE_SCALE)) ? $start_page + PAGE_SCALE-1 : $total_pages;

// 출력될 숫자
$view_num = $total_record - $start_record;


?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>공식산행후기</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/community/official_review/css/official_review_list.css?ver=0">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#official_mini").css("font-weight","bold");
        $("#official_mini").css("color","black");
      });
      </script>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/commu_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>
    <div class="community_section">
      <section>
        <form name="board_form" action="official_review_list.php?mode=search" method="post">
          <table>
            <!-- <input type="hidden" name="mode" value="search"> -->
            <ul id="list_search">
              <li id="list_search1">total <?=$total_record?></li>

              <li id="list_search3">
                <select name="find_option">
                  <option value="title">제목</option>
                  <option value="title">내용</option>
                </select>
                <input id="list_search4" type="text" name="find_input">
                <input id="list_search5" type="submit" value="검색">
              </li>
            </ul>
          </table>
        </form>
      </section>
      <section>
        <?php
          $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

          for($i = $start_record; $i <$start_record+ROW_SCALE && $i< $total_record; $i++){
            mysqli_data_seek($result,$i);
            $row=mysqli_fetch_array($result);
            $num = $row['num'];
            $title = $row['title'];
            $content = $row['content'];
            $regist_day = $row['regist_day'];
            $main_img = $row['main_img'];
            ?>
              <div class="review">
                <a href="./official_review_view.php?num=<?=$num?>" id="review_a">
              <div class="review_img"><img src="./img/<?=$main_img?>" width="350px" height="400px"></div>
              <div class="review_title"><b><?=$title?></b></div><br>
            </a>
              </div>
            <?php
            }
            ?>
      </section>
    </div>

    <?php
    if(!empty($_SESSION['id'])){
      echo '<a href="official_review_form.php"><button id="write_but" type="button" name="button">
      글쓰기</button></a>';
    }
     ?>
    <div class="page_button_group">
      <?php
      //현재 블럭의 시작 페이지가 페이지 스케일 보다 클 때 -> 처음으로 버튼 생성 + 이전 블럭 존재
      //[ex]  page가 9개 있고 현재 페이지가 6페이지인 경우  / 12345/ 6789     =>  <<(처음으로) <(이전) 6 7 8 9
      if( $start_page > PAGE_SCALE ){
        // echo( '<a href='notice_list.php?page=1'> << </a>' );
        echo( '<a href="official_review_list.php?page=1"><button type="button" name="button" title="처음으로"><<</button></a>' );
        // 이전 블럭 클릭 시 -> 현재 블럭의 시작 페이지 - 페이지 스케일
        // 현재 6 page 인 경우 '<(이전블럭)' 클릭 -> $pre_page = 6-PAGE_SCALE  -> 1 페이지로 이동
        $pre_block= $start_page - PAGE_SCALE;
        if(isset($_GET['mode']) && $_GET['mode']=="search"){
          echo( '<a href="official_review_list.php?mode=search&find_input=$find_input&page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
        }else{
          echo( '<a href="official_review_list.php?page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
        }
      }
      //현재 블럭에 해당하는 페이지 나열
      for( $j = $start_page; $j <= $end_page; $j++ ){
          //현재 블럭에 현재 페이지인 버튼
          if ( $j == $page ){
            echo( '<a href="#"><button type="button" name="button" style="background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">'.$j.'</button></a>' );
          }else if(isset($_GET['mode']) && $_GET['mode']=="search"){
            echo( '<a href="official_review_list.php?mode=search&find_input=$find_input&page='.$j.'"><button type="button" name="button">'.$j.'</button></a>' );
          }else{
            echo( '<a href="official_review_list.php?page='.$j.'"><button type="button" name="button">'.$j.'</button></a>' );
          }
      }
      // 현재 블럭의 마지막 페이지 보다 총 페이지 수가 큰 경우, >(다음) 버튼 / >>(맨끝으로) 버튼 생성
      //[ex]  page가 9개 있고 현재 페이지가 6페이지인 경우  / 12345/ 6789     =>  <<(처음으로) <(이전) 6 7 8 9
      //[ex]  page가 9개 있고 현재 페이지가 1페이지인 경우  / 12345/ 6789     =>  1 2 3 4 5 >(다음) >>(맨끝으로)
      if( $total_pages > $end_page ){
        // 다음블럭 => 현재 블럭의 시작페이지 + 스케일
        // 클릭 시 다음 블럭의 첫 번째 페이지로 이동
        // [ex]  총 page 9개 있고 페이지가 3인  경우 / >(다음) 버튼 누르면 '6'으로 이동
        $next_block= $start_page + PAGE_SCALE;

        if(isset($_GET['mode']) && $_GET['mode']=="search"){
          echo( '<a href="official_review_list.php?mode=search&find_input=$find_input&page='.$next_block.'"><button type="button" name="button">></button></a>' );
        }else{
          echo( '<a href="official_review_list.php?page='.$next_block.'"><button type="button" name="button" title="다음">></button></a>' );
        }
        //맨끝페이지로 이동
        echo( '<a href="official_review_list.php?page='.$total_pages.'"><button type="button" name="button" title="맨끝으로">>></button></a>' );
      }
      ?>
    </div>

    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
