$(document).ready(function(){

  $("#right").click(function(){
    $("#box").animate({
      right: '-=100px'
    }, 1000);
  });

  $("#left").click(function(){
    $("#box").animate({
      right: '+=100px'
    }, 1000);

  });

});
