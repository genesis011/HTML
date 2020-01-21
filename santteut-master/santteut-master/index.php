<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/create_table.php";
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./search.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <title>산뜻 :: 즐거운 산행</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  </head>

  <body>

    <!--로그인 회원가입 로그아웃-->
    <div id="wrap">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>

    <!--검색(국가명/도시명/산이름)-->
      <div id="main_search">
        <br><br><br><br><br><br><br>
        <div id="search1" >
        <form name="main_search_form" action="./tour/package/main_search_list.php" method="post" style=" margin-left: 32%;">
          <div class="search_center" style="background-color: rgba(22, 43, 62, 0.48); width: 50%; height: 150px;">
            <div id="search_div" style="width:95%; padding: 20px;">
              <input type="text" id="tex1" style="margin-right: 1%; text-align:center;" onkeydown="JavaScript:main_search2()"  name="search" size="30" placeholder="국가명 / 도시명 / 산 이름으로 검색">

              <input type="hidden" name="main_search_word" id="main_search_word" value="">
              <i class='fas fa-search' style='font-size:36px' onclick="main_search()"></i>

            </div>
            <b style="color: white; margin-left: 3%; font-weight:normal;">추천산행 :</b>
            <?php
            define('SCALE', 3);
            $divide_flag="";
            $best3_sql = "SELECT * ,sum(`r_adult`+`r_kid`+`r_baby`) from `reserve` join `package` on `reserve`.`r_code`=`package`.`p_code` $divide_flag group by `r_code` order by sum(`r_adult`+`r_kid`+`r_baby`) desc limit 3;";
            $best3_result=mysqli_query($conn,$best3_sql);
            for ($best3_record=0; $best3_record < SCALE ; $best3_record++) {
              $row = mysqli_fetch_array($best3_result);
              $p_arr_mt=$row['p_arr_mt'];
              $p_code=$row['p_code'];
              echo '<a id="recomend_mt" href="http://'.$_SERVER['HTTP_HOST'].'/santteut/tour/package/package_view.php?mode='.$p_code.'">'.$p_arr_mt.'</a>&nbsp;&nbsp;';
            }
              ?>

          </div >
        </form>
        </div>
      </div>

    <script type="text/javascript">
      function main_search(){
        var tex1 = document.getElementById('tex1');
        var word = document.getElementById('main_search_word');
        word.value = tex1.value;
        document.main_search_form.submit();
      }


      function main_search2(){
        if(event.keyCode == 13){
          var tex1 = document.getElementById('tex1');
          var word = document.getElementById('main_search_word');
          word.value = tex1.value;
          document.main_search_form.submit();
        }
      }

    </script>

<br>
<br>
<br>
    <!--인기 산행 일정 TOP3-->
    <div id="main_big3">
      <h2>산뜻에서 산행을 시작하세요!</h2>
      <div id="best3">
        <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/best3.php";?>
      </div>
    </div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        <h2 style="float:left; margin-right:1%; margin-left:37.5%;">인기 산행상품이 더 보고싶으신가요?</h2>

      <div class="more_chart_div" style="float:left; margin-top: 1%;">
        <a href="./common/lib/best10_reserve.php"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/img/pie_chart.png" alt="예약TOP10" title="예약TOP10"></a>
        <a href="./common/lib/best10_review.php"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/img/bar_chart.png" alt="평점TOP10" title="평점TOP10"></a>
      </div>
<br><br><br><br><br><br><br><br>
    <footer id="foo">
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>

    </div>

  </body>
</html>
