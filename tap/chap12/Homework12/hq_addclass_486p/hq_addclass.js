$(document).ready(function() {
  var $div1 = $("div1");
  $("button").click(function() {
    $("#div1").addClass("warning");
    $div1.css({
      "border": "1px solid black"
      // "background-color": "yellow"
    })
  });
});
