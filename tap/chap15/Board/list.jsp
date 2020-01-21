<%@ page import="java.sql.*" %>
<%@ page language="java" contentType="text/html;charset=utf-8"
		pageEncoding="utf-8"%>
<% request.setCharacterEncoding("utf-8"); %>

<html>
  <head><title> 게시판 </title></head>
  <body>
 <h3> 게시글 리스트 </h3>
     <table border="2">
      <tr>
	  <td> 번호 </td>
	  <td> 제목 </td>
	  <td> 작성자 </td>
	  <td> 날짜 </td>
	  <td> 이메일 </td>
      </tr>

      <%		
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
               String sql = "select * from message order by id asc ";
               ResultSet rs = stmt.executeQuery(sql);

	if( rs != null) {
  	 while(rs.next())
	 {
	       int id = Integer.parseInt(rs.getString("id"));
      %>

      <tr>
         <td> <%= id %></td>
         <td>    <a href=display.jsp?id=<%= id %>>  
                        <%=rs.getString("subject")%></a></td>
         <td> <%= rs.getString("name") %></td>
         <td> <%= rs.getString("time") %></td>
         <td><%= rs.getString("email") %></td>
      </tr>

      <%
	 }
	}
      %>

    </table>

    <a href="write.jsp"> 게시글 쓰기 </a>
    <% 
       if( stmt!= null ) stmt.close();
       if( con!= null ) con.close();
    %>
  </body>
</html>