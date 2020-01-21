<?php
//***************************************************************************
$page=$num=$q_num=$sql=$result=$row=$title=$content=$file_name_0=$file_copied_0=$file_type_0="";
$file_name_1=$file_copied_1=$file_type_1=$file_name_2=$file_copied_2=$file_type_2="";
$file_name_3=$file_copied_3=$file_type_3=$file_name_4=$file_copied_4=$file_type_4="";
$regist_day="";
//***************************************************************************
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/create_table.php";
include $_SERVER['DOCUMENT_ROOT']."/santteut/community/official_review/lib/official_review_func.php";
create_table($conn, 'official_review_ripple');
if(empty($_GET['page'])){
  $page=1;
}else{
  $page=$_GET['page'];
}
if(isset($_GET["num"])&&!empty($_GET["num"])){
  $num = test_input($_GET["num"]);
  $q_num = mysqli_real_escape_string($conn, $num);

  $sql = "SELECT * FROM `official_review` WHERE num='$q_num';";
  $result = mysqli_query($conn,$sql);
  if(!$result){
    die('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $title=htmlspecialchars($row['title']);
  $title=str_replace("\n","<br>",$title);
  $title=str_replace(" ","&nbsp;",$title);

  $content=$row['content'];
  $file_name_0=$row['file_name_0'];
  $file_copied_0=$row['file_copied_0'];
  $file_type_0=$row['file_type_0'];
  $file_name_1=$row['file_name_1'];
  $file_copied_1=$row['file_copied_1'];
  $file_type_1=$row['file_type_1'];
  $file_name_2=$row['file_name_2'];
  $file_copied_2=$row['file_copied_2'];
  $file_type_2=$row['file_type_2'];
  $file_name_3=$row['file_name_3'];
  $file_copied_3=$row['file_copied_3'];
  $file_type_3=$row['file_type_3'];
  $file_name_4=$row['file_name_4'];
  $file_copied_4=$row['file_copied_4'];
  $file_type_4=$row['file_type_4'];
  $regist_day=$row['regist_day'];
}
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/community/official_review/css/official_review_view.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#official_mini").css("font-weight","bold");
        $("#official_mini").css("color","black");
      });
      </script>
        <script src="./js/official_review.js?ver=0"></script>
    <title><?=$title?></title>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php"; ?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/commu_menu.php";?>

    </header>

    <section id="notice">
      <table border="1">
        <tr>
          <th>작성자</th>
          <td style="width:689px; text-align:center;">관리자</td>
        </tr>
        <tr>
          <th>제목</th>
          <td><input type="text" name="title" value="<?=$title?>" style="font-size:15px; width:700px;" readonly></td>
        </tr>
        <tr>
          <th>내용</th>
          <td style="width:700px; height:600px;">
            <?php
            $content=str_replace('<p>','', $content);
            $content=str_replace('</p>','', $content);
            echo $content;
            if(!empty($file_copied_0)){
                //1. 해당된 가입자이고, 파일이 있으면, 파일명, 파일사이즈, 실제위치 정보확인
                $file_path = "./data/".$file_copied_0;
                $file_size = filesize($file_path);
                //2. 업로드된 이름을 보여주고 [저장] 할 것인지 선택한다.
                echo ("
                  첨부파일 : $file_name_0 ($file_size Byte)
                  &nbsp;
                  <a href='official_review_download.php?mode=download&num=$q_num&file_copied=$file_copied_0&file_name=$file_name_0'>저장</a><br>
                ");
              }
              if(!empty($file_copied_1)){
                  //1. 해당된 가입자이고, 파일이 있으면, 파일명, 파일사이즈, 실제위치 정보확인
                  $file_path = "./data/".$file_copied_1;
                  $file_size = filesize($file_path);
                  //2. 업로드된 이름을 보여주고 [저장] 할 것인지 선택한다.
                  echo ("
                    첨부파일 : $file_name_1 ($file_size Byte)
                    &nbsp;
                    <a href='official_review_download.php?mode=download&num=$q_num&file_copied=$file_copied_1&file_name=$file_name_1'>저장</a><br>
                  ");
                }
                if(!empty($file_copied_2)){
                    //1. 해당된 가입자이고, 파일이 있으면, 파일명, 파일사이즈, 실제위치 정보확인
                    $file_path = "./data/".$file_copied_2;
                    $file_size = filesize($file_path);
                    //2. 업로드된 이름을 보여주고 [저장] 할 것인지 선택한다.
                    echo ("
                      첨부파일 : $file_name_2 ($file_size Byte)
                      &nbsp;
                      <a href='official_review_download.php?mode=download&num=$q_num&file_copied=$file_copied_2&file_name=$file_name_2'>저장</a><br>
                    ");
                  }
                  if(!empty($file_copied_3)){
                      //1. 해당된 가입자이고, 파일이 있으면, 파일명, 파일사이즈, 실제위치 정보확인
                      $file_path = "./data/".$file_copied_3;
                      $file_size = filesize($file_path);
                      //2. 업로드된 이름을 보여주고 [저장] 할 것인지 선택한다.
                      echo ("
                        첨부파일 : $file_name_3 ($file_size Byte)
                        &nbsp;
                        <a href='official_review_download.php?mode=download&num=$q_num&file_copied=$file_copied_3&file_name=$file_name_3'>저장</a><br>
                      ");
                    }
                    if(!empty($file_copied_4)){
                        //1. 해당된 가입자이고, 파일이 있으면, 파일명, 파일사이즈, 실제위치 정보확인
                        $file_path = "./data/".$file_copied_4;
                        $file_size = filesize($file_path);
                        //2. 업로드된 이름을 보여주고 [저장] 할 것인지 선택한다.
                        echo ("
                          첨부파일 : $file_name_4 ($file_size Byte)
                          &nbsp;
                          <a href='official_review_download.php?mode=download&num=$q_num&file_copied=$file_copied_4&file_name=$file_name_4'>저장</a><br>
                        ");
                      }
             ?>
          </td>
        </tr>
      </table>
      <div id="view_button">
        <?php
        //관리자일경우 수정,삭제가 가능하도록 설정
        if(!empty($_SESSION['id']) && ($_SESSION['id']=="admin")){
        echo ('<a href="./official_review_form.php?mode=update&num='.$num.'"><input type="button" value="수정">&nbsp;</a>&nbsp;');
        echo ('<input type="button" value="삭제" onclick="check_delete('.$num.')">&nbsp;</a>&nbsp;');
        echo ('<a href="./official_review_list.php?page='.$page.'"><input type="button" value="목록">&nbsp;</a>');
      }else{
        echo ('<div class="mt_list" style="margin-left: 25.5%;">
          <a href="./official_review_list.php?page='.$page.'"><input type="button" value="목록">&nbsp;</a>
          </div>');
      }
        ?>
      </div><!--end of view_button -->
      <table id="ripple_tb" border="1">
        <th>댓글</th>
        <td>
          <?php
            $sql="SELECT * FROM `official_review_ripple` where parent=$q_num;";
            $ripple_result = mysqli_query($conn,$sql);
            while($ripple_row=mysqli_fetch_array($ripple_result)){
              $ripple_num=$ripple_row['num'];
              $ripple_parent=$ripple_row['parent'];
              $ripple_id=$ripple_row['id'];
              $ripple_name=$ripple_row['name'];
              $ripple_date=$ripple_row['regist_day'];
              $ripple_content=$ripple_row['content'];
              $ripple_content=str_replace("\n", "<br>", $ripple_content);
              $ripple_content=str_replace(" ", "&nbsp;", $ripple_content);
          ?>
          <div id="ripple_title">
              <ul>
                <li><?=$ripple_name."&nbsp;&nbsp;".$ripple_date?></li>
                <li id="mdi_del">
                <?php
                 $message = official_review_ripple_delete($ripple_id,$ripple_num,'official_review_query.php',$q_num);
                 echo $message;
                ?>
                </li>
              </ul>
            </div>
            <div id="ripple_content">
              <?=$ripple_content?>
            </div>
            <?php
            }//end of while
            ?>
            <form name="ripple_form" action="official_review_query.php?mode=insert_ripple" method="post">
            <input type="hidden" name="parent" value="<?=$q_num?>">
            <div id="ripple_insert">
            <div id="ripple_textarea"><textarea name="ripple_content" rows="3" cols="80"></textarea></div>
            <div id="ripple_button"><input type="submit" value="댓글입력"></div>
            </div><!--end of ripple_insert  -->
            </form>
        </td>
      </table>

    </section>
    <br>
    <br>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
