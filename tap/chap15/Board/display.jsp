<%@ page import="java.sql.*" %>
<%@ page language="java" contentType="text/html;charset=utf-8"
		pageEncoding="utf-8"%>
<% request.setCharacterEncoding("utf-8"); %>
<html>
  <head><title> 게시글 표시</title></head>
  <body> 
     <h3> 게시글 내용 </h3>
     <%
	       String subject="", memo="", name="", time="", email="";
         int id = Integer.parseInt(request.getParameter("id"));

	Connection con=null;
	Statement stmt=null;
         try {
               Class.forName("com.mysql.jdbc.Driver");
               String url = "jdbc:mysql://localhost:3306/board";
               con = DriverManager.getConnection(url, "root", "1234");
	}
         catch(Exception e) {
               out.println("데이터베이스 접속에 문제가 있습니다.<hr>");
               out.println(e.getMessage()); 
		e.printStackTrace(); 
         }
               stmt = con.createStatement();
               String sql = "select * from message where id = " + id;
               ResultSet rs = stmt.executeQuery(sql);

	 while(rs.next())  {
	       subject = rs.getString("subject");
	       memo = rs.getString("memo");
	       name = rs.getString("name");
	       time = rs.getString("time");
	       email = rs.getString("email");
	}
    %>     
  <table border="2">
      <tr>
        <td>제목 </td>
        <td><%= subject %></td>
     </tr>
     <tr>
        <td>작성자 </td>
        <td><%= name %></td>
     </tr>  
     <tr>
        <td>내용 </td>
        <td><%= memo %></td>
     </tr>
     <tr>
     </tr>    
     <tr>
        <td>날짜 </td>
        <td><%= time %></td>
     </tr>
     <tr>
        <td>이메일 </td>
        <td><%= email %></td>
     </tr>
   </table><br><br>
    <a href="list.jsp"> 게시글 리스트 보기 </a>
  </body>
</html>