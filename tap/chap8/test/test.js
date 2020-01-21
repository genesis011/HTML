
  // function calc() {
  //   var x = document.getElementById("x").value;
  //
  //   var y = document.getElementById("y").value;
  //   var sum;
  //
  //   sum = parseInt(x) parseInt(y);
  //   document.getElementById("sum").value = sum;
  // }

  function calc() {
    var num1 =document.getElementById("num1").value;
    var num2 =document.getElementById("num2").value;
    var sum =document.getElementById("sum").value;
    var calc = parseInt(num1) + parseInt(num2);
    document.getElementById("sum").value = calc;
  }
