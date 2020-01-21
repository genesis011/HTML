
<script type="text/javascript">
  function control_display(){
      var con = document.getElementById("side_bar");
      if(con.style.display=='none'){
          con.style.display = 'block';
      }else{
          con.style.display = 'none';
      }
  }
</script>
<?php
  $menu1="none.png";$mt1="최근 본 상품이 없습니다.";$color1="";
  $menu2="none.png";$mt2="최근 본 상품이 없습니다.";$color2="";
  $menu3="none.png";$mt3="최근 본 상품이 없습니다.";$color3="";
  if(isset($_COOKIE["cookie1"])){
    $cookie1=$_COOKIE["cookie1"];
    $sql_side1="SELECT * from `package` where `p_code`='$cookie1';";
    $side_result1 = mysqli_query($conn,$sql_side1) or die("실패원인1: ".mysqli_error($conn));
    $row1 = mysqli_fetch_array($side_result1);
    $menu1 = $row1['p_main_img_copy1'];
    $mt1 = $row1['p_arr_mt'];
    $color1="color:blue;";
  }
  if(isset($_COOKIE["cookie2"])){
    $cookie2=$_COOKIE["cookie2"];
    $sql_side2="SELECT * from `package` where `p_code`='$cookie2';";
    $side_result2 = mysqli_query($conn,$sql_side2) or die("실패원인1: ".mysqli_error($conn));
    $row2 = mysqli_fetch_array($side_result2);
    $menu2 = $row2['p_main_img_copy1'];
    $mt2 = $row2['p_arr_mt'];
    $color2="color:blue;";
  }
  if(isset($_COOKIE["cookie3"])){
    $cookie3=$_COOKIE["cookie3"];
    $sql_side3="SELECT * from `package` where `p_code`='$cookie3';";
    $side_result3 = mysqli_query($conn,$sql_side3) or die("실패원인1: ".mysqli_error($conn));
    $row3 = mysqli_fetch_array($side_result3);
    $menu3 = $row3['p_main_img_copy1'];
    $mt3 = $row3['p_arr_mt'];
    $color3="color:blue;";
  }
 ?>
<script type="text/javascript">
</script>
<!-- 사이드바 컨트롤러 -->
<div id="side_bar_control">
  <button title="산뜻바 열기" id="side_bar_open_btn" type="button" name="button" onclick="control_display()"><b>+</b></button><br>
  <a href="#"><button title="맨 위로" id="side_bar_top_btn"  type="button" name="button"><b>▲</b></button></a>
</div>
<!-- 사이드바 -->
<div id="side_bar" style="display: none;">
  <!-- 비로그인->로그인//회원가입 or 로그인  ->장바구니//예약내역,결제내역  -->
  <div id="side_bar_top">
    <a href="../../tour/cart/cart_list.php"><img title="장바구니" id="side_bar_cart_img" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/img/cart.jpg"></a>
    <a href="../../tour/reserve/reserve_list.php"><img title="예약/결제확인" id="side_bar_confirm_img" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/img/reserve_payment.png"></a>
  </div>
    <!-- 사진경로  변수로 설정해주셔야 합니다 -->
  <div id="side_bar_recent">
    <br><br><p style="display:block">최근 본 상품</p>
    <a href="../../tour/package/package_view.php?mode=<?=$cookie1?>"><img class="side_bar_recent_img" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/lib/editor/data/<?=$menu1?>"></a>
    <div class="side_bar_recent_val"><a href="../../tour/package/package_view.php?mode=<?=$cookie1?>" style=" text-decoration:none;font-size:0.7em; color:gray; <?=$color1?>"><?=$mt1?></a></div>
    <a href="../../tour/package/package_view.php?mode=<?=$cookie1?>"><img class="side_bar_recent_img" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/lib/editor/data/<?=$menu2?>"></a>
    <div class="side_bar_recent_val"><a href="../../tour/package/package_view.php?mode=<?=$cookie2?>" style="text-decoration:none; font-size:0.7em; color:gray; <?=$color2?>"><?=$mt2?></a></div>
    <a href="../../tour/package/package_view.php?mode=<?=$cookie1?>"><img class="side_bar_recent_img" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/lib/editor/data/<?=$menu3?>"></a>
    <div class="side_bar_recent_val"><a href="../../tour/package/package_view.php?mode=<?=$cookie3?>" style="text-decoration:none; font-size:0.7em; color:gray; <?=$color3?>"><?=$mt3?></a></div>
  </div>
  <div class="side_bar_middle">
  <br>
   <a class="side_bar_qna" href="../../introduction/history.php">소개</a><br>
   <a class="side_bar_qna" href="../../customer_support/faq/faq.php">자주하는 질문</a><br>
   <a class="side_bar_qna" href="../../community/free/free_list.php">커뮤니티</a><br>
   <br>
  </div>
  <div class="side_bar_bottom">
    <a href="#"><button title="맨 위로" id="side_bar_top_btn"  type="button" name="button"><b>▲</b></button></a>
    <button title="산뜻바 닫기" id="side_bar_cancel_btn"  type="button" name="button" onclick="control_display()"><b>X</b></button>
    <br><p>TEL:02-000-0000</p>
  </div>
</div>
