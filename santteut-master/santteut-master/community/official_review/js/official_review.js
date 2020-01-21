function check_delete(num,id){
    var result = confirm("삭제하시겠습니까?");
    if(result){
      window.location.href='./official_review_query.php?mode=delete&num='+num;
    }
}
