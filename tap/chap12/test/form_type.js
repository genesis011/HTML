$(document).ready(function() {
  $("input").focus(function() {
    $(this).css("background-color", "yellow")
  });

  $("input").blur(function() {
    $(this).css("background-color", "white")
  });

  $("button.show").click(function(){
    $("#dog").show("slow");
  });

  $("button.hide").click(function(){
    $("#dog").hide("slow");
  });

  $("button.slideUp").click(function(){
    // $("#dog").slideUp("slidUp");
    $("#dog").slideUp(3000);
  });

  $("button.slideDown").click(function(){
    // $("#dog").slideUp("slidUp");
    $("#dog").slideDown(3000);
  });

  $("button.animate").click(function(){
    // $("#dog").slideUp("slidUp");
    $("#dog").animate({left: '+=100px', top: '50px'}, 3000);
  });

  $("button.fadein").click(function(){
    $("#dog").fadeIn(3000);
  });

  $("button.fadeout").click(function(){
    $("#dog").fadeOut(3000);
  });

});

$(document).mouseover(function(e) {
      $("#log").text("<h2>e.pageX:" + e.pageX + "e.pageY:" + e.pageY + "</h2>");
        console.dir(e);
});
