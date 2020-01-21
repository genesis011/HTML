$(document).ready(function() {
  $("#button1").click(function() {
    var color = $("#div1").css("background-color");
    $("#result").text("background-color: " + color);
  });

  $("#button2").click(function() {
    $("#div1").css("background-color", "red");
  });

});
