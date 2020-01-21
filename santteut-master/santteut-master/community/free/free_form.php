<!DOCTYPE html>
<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
if(!isset($_SESSION['id'])){echo "<script>alert('권한없음!');history.go(-1);</script>";
exit;}
$mode="insert";
$update="";
$num=$id=$title=$content=$day=$hit=$content="";

if(isset($_GET["mode"])&&$_GET["mode"]=="update"){
    $mode="update";
    $num=$_GET['num'];
    $sql="SELECT * from `free` where num ='$num';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $id=$row['id'];
    $name=$row['name'];
    $title=$row['title'];
    $content= $row['content'];
    $update= $row['del'];
    $day=$row['regist_day'];
    $file_name=$row['file_name'];
    $hit=$row['hit'];


}
?>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/community/free/css/free_form.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $("#free_mini").css("font-weight","bold");
      $("#free_mini").css("color","black");
    });
    </script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      var del = "";
       $('#summernote').summernote({
               height: 1000,
               minHeight: null,
               maxHeight: null,
               focus: true,
               callbacks: {
                 onImageUpload : function(files, editor, welEditable){
                  sendFile(files[0], editor, welEditable);
                }
               }
             });
               function sendFile(file,editor,welEditable){
                 data = new FormData();
                 data.append("file", file);
                 $.ajax({
                   data: data,
                   type: "POST",
                   url: "./saveimage.php",
                   cache: false,
                   contentType: false,
                   processData: false,
                   success: function(url) {
                     del = $('#del').val();
                     del = del.concat("!"+url);
                     $('#del').val(del);
                     var html = '<img src="'+url+'">';
                     $('#summernote').summernote('pasteHTML', html);
                     $('#summernote').summernote('insertImage', url, filename);
                   }
       });
     }
    });
    </script>
  </head>
    <title>자유게시판</title>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/commu_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>

    <section id="free">
      <form class="free_insert_form" action="free_query.php?mode=<?=$mode;?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="num" value="<?=$num?>">
        <input type="hidden" name="hit" value="<?=$hit?>">
        <input type="hidden" id="del" name="del" value="<?=$update?>">
      <table border="1">
        <tr>
          <th>작성자</th>
          <td style="width:600px; text-align:center;"><?= $name; ?></td>
        </tr>
        <tr>
          <th>제목</th>
          <td><input type="text" style="font-size:15px; width:700px;" name="title" value="<?=$title?>"></td>
        </tr>
        <tr>
          <th>내용</th>
          <td><textarea style="width:700px;" name="content" id="summernote"><?=$content?></textarea></td>
        </tr>
        <tr>
          <th>파일</th>
          <td style="text-align:center;">
            <input type="file" name="upfile" value="<?=$file_name?>">
            <?php
            if($mode=="update" && !empty($file_name)){
              echo "$file_name 파일등록";
              echo '<input type="checkbox" id="del_file" name="del_file" value="1">삭제';
              echo '<div class="clear"></div>';
            }
            ?>
          </td>
        </tr>
      </table>
        <div class="admin">
          <button id="admin_write_btn" style="margin-left: 72.5%;"  type="submit" name="button">완료</button>
          <a href="./free_list.php"><button id="admin_write_btn" type="button" name="button">목록</button></a>
        </div>
      </form>
    </section>
    <br><br>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
</html>
