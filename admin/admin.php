<!--后台-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <style>
        *{margin:0;padding:0;}
        .btn-default{margin-right:10px;margin-left:10px;}
        label{padding-right:10px;}
        .title button {float:right;margin:10px;}
        .page{text-align:center;}
        .page a,.page p,.page form{float:left;}
    </style>
     <script language="JavaScript" type="text/javascript">
    //导出execl
        var idTmr;
        function  getExplorer() {  
          var explorer = window.navigator.userAgent ;  
          //ie  
          if (explorer.indexOf("MSIE") >= 0) {  
              return 'ie';  
          }  
          //firefox  
          else if (explorer.indexOf("Firefox") >= 0) {  
              return 'Firefox';  
          }  
          //Chrome  
          else if(explorer.indexOf("Chrome") >= 0){  
              return 'Chrome';  
          }  
          //Opera  
          else if(explorer.indexOf("Opera") >= 0){  
              return 'Opera';  
          }  
          //Safari  
          else if(explorer.indexOf("Safari") >= 0){  
              return 'Safari';  
          }  
      }
      function method5(tableid){
        if(getExplorer() == 'ie'){
                var curTbl = document.getElementById(tableid);  
                var oXL = new ActiveXObject("Excel.Application");  
                var oWB = oXL.Workbooks.Add();  
                var xlsheet = oWB.Worksheets(1);  
                var sel = document.body.createTextRange();  
                sel.moveToElementText(curTbl);  
                sel.select();  
                sel.execCommand("Copy");  
                xlsheet.Paste();  
                oXL.Visible = true;  
  
                try {  
                    var fname = oXL.Application.GetSaveAsFilename("Excel.xls", "Excel Spreadsheets (*.xls), *.xls");  
                } catch (e) {  
                    print("Nested catch caught " + e);  
                } finally {  
                    oWB.SaveAs(fname);  
                    oWB.Close(savechanges = false);  
                    oXL.Quit();  
                    oXL = null;  
                    idTmr = window.setInterval("Cleanup();", 1);  
                }  
        }
        else 
        {
          tableToExecl(tableid);
        }
      } 
      function Cleanup() {
        window.clearInterval(idTmr);
        CollectGarbage();
      } 
      var tableToExecl = (function(){
          var uri = 'data:application/vnd.ms-excel;base64,',  
                      template = '<html><head><meta charset="UTF-8"></head><body><table>{table}</table></body></html>',  
                      base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },  
                      format = function(s, c) {  
                          return s.replace(/{(\w+)}/g,  
                                  function(m, p) { return c[p]; }) }  
              return function(table, name) {  
                  if (!table.nodeType) table = document.getElementById(table)  
                  var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}  
                  window.location.href = uri + base64(format(template, ctx))  
              }  
      })();
  </script>
</head>
<body>
    <div class="container">
        <div class="title">
            <button type="button" class="btn btn-success" onclick="method5('tableExcel')">导出execl</button>
        </div>
        <table id="tableExcel" class="table">
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>微信号</th>
                <th>电话</th>
                <th>护照号</th>
                <th>操作</th>
            </tr>
<?php
    require_once 'connect.fun.php';
    require_once 'pagination.fun.php';
    $conn = connect_mysql();
    mysql_query("set names 'utf8'"); 
    mysql_select_db('credit',$conn);

    //传入页码
    $page = $_GET['page'];
    $pageSize = 10;
    $pageLimit = ($page - 1) * 10;


    $url = $_SERVER['PHP_SELF'];
    $sql = "SELECT * FROM cheater LIMIT $pageLimit,$pageSize";
    if(isset($_GET['id'])){
        //删除sql
        $delsql = "DELETE FROM cheater WHERE id = '".$_GET['id']."'";
        mysql_query($delsql);
    }
    
    
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
        echo "<tr>";  
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['wechaid']}</td>";
        echo "<td>{$row['phone']}</td>";
        echo "<td>{$row['passport']}</td>";
        echo '<td><a class="btn btn-danger" href = "'.$_SERVER['PHP_SELF'].'?id='.$row['id'].'">删除</a></td>'; 
        echo "</tr>";  
    } 

    if($page == 'all'){
        $result = mysql_query('SELECT * FROM cheater');
        while ($row = mysql_fetch_array($result)) {
        echo "<tr>";  
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['wechaid']}</td>";
        echo "<td>{$row['phone']}</td>";
        echo "<td>{$row['passport']}</td>";
        echo '<td><a class="btn btn-danger" href = "'.$_SERVER['PHP_SELF'].'?id='.$row['id'].'">删除</a></td>'; 
        echo "</tr>";  
        } 
    }
    echo "</table>";


    $total_sql = "SELECT COUNT(*) FROM cheater";
    $total_pages = totalPages($total_sql,$pageSize);

    mysql_free_result($result);
    mysql_close($conn);
    $page_banner = "<nav aria-label='Page navigation'><ul class='pager'>";
    if($page > 1){
        $page_banner .= "<li><a href=$url?page=1>首页</a></li>";
        $page_banner .= "<li><a href=$url?page=".($page-1).">上一页</a></li>";
    }
    if($page < $total_pages){
        $page_banner .= "<li><a href=$url?page=".($page+1).">下一页</a></li>";
        $page_banner .= "<li><a href=$url?page={$total_pages}>尾页</a></li>";
    }
    
    $page_banner .= "<p>共{$total_pages}页</p>";
    $page_banner .= "<form class='form-inline' action='admin.php' method='get'>";
    $page_banner .= "<input type='text' id='input_jump' name='page' placeholder='页数'>";
    $page_banner .= "<input class='btn btn-info' type='submit' value='提交'>";
    $page_banner .= "</form>";
    $page_banner .= "<a class='btn btn-default' href=$url?page=all>显示全部</a></ul></nav>";
    echo $page_banner;


// echo "<nav aria-label='...'>";
// echo "<ul class='pager'>";
// echo "<li><a href='#'>上一页</a></li>";
// echo "<li><a href='#'>下一页</a></li>";
// echo "</ul>";
// echo "</nav>";

// echo "<nav aria-label='Page navigation'>";
// echo "<ul class='pagination'>";
// echo "<li>";
// echo "<a href='#' aria-label='Previous'>";
// echo "<span aria-hidden='true'>首页</span>";
// echo "</a>";
// echo "</li>";
// echo "<li>";
// echo "<a href='#' aria-label='Previous'>";
// echo "<span aria-hidden='true'>上一页</span>";
// echo "</a>";
// echo "</li>";
// echo "<li><a href='#'>1</a></li>";    
// echo "<li><a href='#'>2</a></li>";
// echo "<li><a href='#'>3</a></li>";
// echo "<li><a href='#'>4</a></li>";
// echo "<li><a href='#'>5</a></li>";
// echo "<li>";
// echo "<a href='#' aria-label='Next'>";
// echo "<span aria-hidden='true'>下一页</span>";
// echo "</a>";
// echo "</li>";
// echo "</ul>";
// echo "</nav>";
    
?>
</div>

</body>
</html>
