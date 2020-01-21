<%@ page import="java.sql.*" %>
<%@ page import="java.text.*" %>
<%@ page language="java" contentType="text/html;charset=utf-8"
		pageEncoding="utf-8"%>
<% request.setCharacterEncoding("utf-8"); %>

<html>
  <body>
  <%
    String name, email, subject, memo, time; 	
    name = request.getParameter("name");
    email = request.getParameter("email");
    time = request.getParameter("time");
    subject = request.getParameter("subject");
    memo = request.getParameter("memo");

    ResultSet rs = null;
	String sql;
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

	
    sql = "insert into message "+
	"(subject, name, time, memo, email) " +
	
	 "values (" + "'" +subject + "', '"+ name + "', '"  + 
		time + "','" +memo + "','" + email + "' );";
    try {
	         stmt.executeUpdate(sql); 
    }
    catch(Exception e) {
            out.println("데이터베이스 삽입 연산이 실패하였습니다.<hr> ");
               out.println(e.getMessage()); 
		e.printStackTrace(); 
    }
  %>
    <h3> 게시글이 등록되었습니다.</h3>
    <a href="list.jsp"> 게시글 리스트 보기 </a>
 </body>
</html>
