// $(document).ready(function() {
//   var pObject = null, container = null;
//   $("p").css({"backgroundColor":"yellow"});
//   $(".container").css({"height":"80px", "width": "200px", "border": "1px solid red"});
// });

// 위 코드와 같음
// 이 코드는 속도를 개선시키는 방법이다.
$(document).ready(function() {
  var $p = $("p"),
    $container = $(".container"),
    $button1 = $("#button1"),
    $button2 = $("#button2");
  $p.css({
    "background-color": "yellow"
  });

  $container.css({
    "height": "80px",
    "width": "200px",
    "border": "1px solid teal"
  });

  //마우스를 가져다주는 정보를 event에 저장
  $container.mouseover(function(event) {
    $container.css({
      "border-color": "blue"
    });
  });

  $button1.click(function() {
    $container.remove();
  });

  $button2.click(function() {
    $container.empty();
  });

});
