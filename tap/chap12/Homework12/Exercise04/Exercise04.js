$(document).ready(function() {
  $("#button").click(function() {
    $("#box").animate({
      left: '+=50px'
    }, 1000);
    $("#box").css({
      "width": "300px",
      "height": "300px",
      "border": "5px solid red"
    });
    $("#ptag").css({
      "fontSize": "50px"

    });
  });
});
