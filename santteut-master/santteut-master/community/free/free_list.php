
<?php
session_start();
// isset함수는 불리언값을 리턴 true or false
// 회원 or 비회원이면 권한없음, 관리자일때만 입장
if(!isset($_SESSION['id'])){
  echo "<script>alert('권한없음.');history.go(-1);</script>";
  exit;
}
//0-0. 인클루드 디비
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
//0-1. 인클루드 크리테이블
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/create_table_base.php";
//1. 게시물수 정의
define('ROW_SCALE', 10);
define('PAGE_SCALE', 5);
//2. 변수정의
// $view_num 보여지는번호, $num은 DB에서 프라이머리키 번호
// $total_record 전체 게시물수, $start_record 한 페이지의 처음 게시물
// $record 는 게시물1개, $total_pages는 전체 페이지를 의미
$sql=$result=$total_record=$total_pages=$start_record=$row="";
$total_record=0;
//3. 검색모드를 세팅(제목,내용)
if(isset($_GET["mode"])&&$_GET["mode"]=="search"){

  // find_option 는 select의 값들 문자열로 받아옴
  $find_option = test_input($_POST["find_option"]);

  // find_input 는 input의 값을 문자열로 받아옴
  $find_input = test_input($_POST["find_input"]);
  $q_find_input = mysqli_real_escape_string($conn, $find_input);

  if(empty($find_input)){
  echo "<script>alert('검색어를 입력하세요');history.go(-1);</script>";

  }

  $sql="SELECT * from `free` where $find_option like '%$q_find_input%';";
}else{
  $sql="SELECT * from `free` order by num desc";
}

// 쿼리문실행문장
$result=mysqli_query($conn,$sql);

$total_record=mysqli_num_rows($result);

// 조건?참:거짓
$total_pages=ceil($total_record/ROW_SCALE);

// 페이지가 없으면 디폴트 페이지 1페이지
// if(empty($_GET['page'])){$page=1; }else{ $page=$_GET['page']; }
$page=(empty($_GET['page']))?1:$_GET['page'];

// 현재 블럭의 시작 페이지 = (ceil(현재페이지/블럭당 페이지 제한 수)-1) * 블럭당 페이지 제한 수 +1
//[[  EX) 현재 페이지 5일 때 => ceil(5/3)-1 * 3  +1 =  (2-1)*3 +1 = 4 ]]
$start_page= (ceil($page / PAGE_SCALE ) -1 ) * PAGE_SCALE +1 ;

// 현재페이지 시작번호 계산함.
//[[  EX) 현재 페이지 1일 때 => (1 - 1)*10 -> 0   ]]
//[[  EX) 현재 페이지 5일 때 => (5 - 1)*10 -> 40  ]]
$start_record=($page -1) * ROW_SCALE;

// 현재 블럭 마지막 페이지
// 전체 페이지가 (시작 페이지+페이지 스케일) 보다 크거나 같으면 마지막 페이지는 (시작페이지 + 페이지 스케일) -1 / 아니면 전체페이지 수 .
//[[  EX) 현재 블럭 시작 페이지가 6/ 전체페이지 : 10 -> '10 >= (6+10)' 성립하지 않음 -> 10이 현재블럭의 가장 마지막 페이지 번호  ]]
$end_page= ($total_pages >= ($start_page + PAGE_SCALE)) ? $start_page + PAGE_SCALE-1 : $total_pages;


// 리스트에 보여줄 번호를 최근순으로 부여함.
// 출력될 숫자
$view_num = $total_record - $start_record;

?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/community/free/css/free_list.css?ver=5">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <title>자유게시판</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#free_mini").css("font-weight","bold");
        $("#free_mini").css("color","black");
      });
      </script>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/commu_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>

    <section id="free" style="height: 700px; max-height:2000px;">
      <form name="free_form" action="free_list.php?mode=search" method="post">
        <div class="free_list_search">
          <!-- <li id="total_title"><b>total <?=$total_record?></b></li> -->
          <li id="search_option">
            <select name="find_option">
            <option value="title">제목</option>
            <option value="content">내용</option>
            <option value="name">작성자</option>
          </select>
          <input type="text" name="find_input" value="">
          <button type="submit" name="button">검색</button>
        </li>
      </div>
      </form>

      <!--게시물 제목-->
      <table id="list_tbl">
        <tr>
          <th>번호</th>
          <th id="free_list_title" style="width:600px;">제목</th>
          <th>작성자</th>
          <th>작성일</th>
          <th>조회</th>
        </tr>

      <!--게시물 내용-->
      <?php
        for ($record = $start_record; $record  < $start_record+ROW_SCALE && $record<$total_record; $record++){
          mysqli_data_seek($result,$record);
          $row=mysqli_fetch_array($result);
          $num=$row['num'];
          $name=$row['name'];
          $title=$row['title'];
          $regist_day= substr($row['regist_day'],0,10);
          $hit=$row['hit'];
          $title=str_replace("\n", "<br>",$title);
          $title=str_replace(" ", "&nbsp;",$title);
      ?>
        <tr>
          <!--번호-->
          <td><?=$view_num?></td>
          <!--제목-->
          <td style="text-align: left;"><a style="text-decoration: none;" href="./free_view.php?num=<?=$num?>&present_page=<?=$page?>&hit=<?=$hit+1?>"><?=$title?></a></td>
          <!--작성자-->
          <td><?=$name?></td>
          <!--작성일-->
          <td><?=$regist_day?></td>
          <!--조회-->
          <td><?=$hit?></td>
        </tr>
        <?php
          $view_num--;
         }//end of for
        ?>
      </table>

<?php
if(!empty($_SESSION['id'])){
  echo '<a href="free_form.php"><button id="admin_write_btn" type="button" name="button">
  글쓰기</button></a>';
}
?>

<!--$page 는 현재페이지를 의미 x / 각 페이지를 의미-->
      <div class="page_button_group">
        <?php
        //현재 블럭의 시작 페이지가 페이지 스케일 보다 클 때 -> 처음으로 버튼 생성 + 이전 블럭 존재
        //[ex]  page가 9개 있고 현재 페이지가 6페이지인 경우  / 12345/ 6789     =>  <<(처음으로) <(이전) 6 7 8 9
        if( $start_page > PAGE_SCALE ){
          // echo( '<a href='free_list.php?page=1'> << </a>' );
          echo( '<a href="free_list.php?page=1"><button type="button" name="button" title="처음으로"><<</button></a>' );

          // 이전 블럭 클릭 시 -> 현재 블럭의 시작 페이지 - 페이지 스케일
          // 현재 6 page 인 경우 '<(이전블럭)' 클릭 -> $pre_page = 6-PAGE_SCALE  -> 1 페이지로 이동
          $pre_block= $start_page - PAGE_SCALE;
          if(isset($_GET['mode']) && $_GET['mode']=="search"){
            echo( '<a href="free_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
          }else{
            echo( '<a href="free_list.php?page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
          }
        }


        //현재 블럭에 해당하는 페이지 나열
        for( $i = $start_page; $i <= $end_page; $i++ ){
            //현재 블럭에 현재 페이지인 버튼
            if ( $i == $page ){
              echo( '<a href="#"><button type="button" name="button" style="background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">'.$i.'</button></a>' );
            }else if(isset($_GET['mode']) && $_GET['mode']=="search"){
              echo( '<a href="qna_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
            }else{
              echo( '<a href="qna_list.php?page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
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
            echo( '<a href="free_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$next_block.'"><button type="button" name="button">></button></a>' );
          }else{
            echo( '<a href="free_list.php?page='.$next_block.'"><button type="button" name="button" title="다음">></button></a>' );
          }

          //맨끝페이지로 이동
          echo( '<a href="free_list.php?page='.$total_pages.'"><button type="button" name="button" title="맨끝으로">>></button></a>' );
        }
        ?>
      </div>
    </section>

    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
