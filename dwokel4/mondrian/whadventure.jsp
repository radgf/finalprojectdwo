<%@ page session="true" contentType="text/html; charset=ISO-8859-1" %>
<%@ taglib uri="http://www.tonbeller.com/jpivot" prefix="jp" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jstl/core" %>


<jp:mondrianQuery id="query01" jdbcDriver="com.mysql.jdbc.Driver" 
jdbcUrl="jdbc:mysql://localhost/whadventure?user=root&password=" catalogUri="/WEB-INF/queries/whadventure.xml">

select {[Measures].[TaxAmt],[Measures].[SubTotal]} ON COLUMNS,
 {([Customer],[Waktu].[All Times],[Vendor],[Lokasi],[Produk].[All Products])} ON ROWS
from [FaktaPenjualan]


</jp:mondrianQuery>





<c:set var="title01" scope="session">Query WHADVENTURE using Mondrian OLAP</c:set>
