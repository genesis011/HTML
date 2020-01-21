<html>
<head>
  <title>request 매개변수 출력 예제</title>
</head>
<body>
  <h3>좋아하는 과일을 선택하시오(복수 선택 가능):</h3>
  <form method="get">
    <input type="checkbox" name="fruit" value="Apple">Apple
    <input type="checkbox" name="fruit" value="Banana">Banana
    <input type="checkbox" name="fruit" value="Strawberry">Strawberry
    <input type="submit" value="제출">
  </form>
 
  <%
  String[] fruits = request.getParameterValues("fruit");
  if (fruits != null) {
  %>
    <h3>당신이 선택한 과일은: </h3>
    <ul>
  <%
      for (int i = 0; i < fruits.length; ++i) {
  %>
        <li><%= fruits[i] %></li>
  <%
      }
  %>
    </ul>
    <a href="<%= request.getRequestURI() %>">다시 시도</a>
  <%
  }
  %>
</body>
</html>