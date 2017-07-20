<!--后台-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <table class="table">
            <tr>
                <!--<th>ID</th>-->
                <th>姓名</th>
                <th>微信号</th>
                <th>电话</th>
                <th>护照号</th>
                <th>操作</th>
            </tr>
<?php
    require_once 'connect.fun.php';

    $conn = connect_mysql();
    mysql_query("set names 'utf8'"); 
    mysql_select_db('credit',$conn);
    $sql = "SELECT * FROM cheater";
    if(isset($_GET['id'])){
        //删除sql
        $delsql = "DELETE FROM cheater WHERE id = '".$_GET['id']."'";
        mysql_query($delsql);
    }
    $result = mysql_query($sql);
    while ($row = mysql_fetch_assoc($result)) {
        echo "<tr>";  
        //打印出$row这一行  
?>
        <td><?php echo $row['name'] ?></td>
        <td><?php echo $row['wechaid'] ?></td>
        <td><?php echo $row['phone'] ?></td>
        <td><?php echo $row['passport'] ?></td>
<?php
        echo '<td><a class="btn btn-danger" href = "'.$_SERVER['PHP_SELF'].'?id='.$row['id'].'">删除</a></td>'; 
        echo "</tr>";  
    } 
?>
        </table>
    </div>

</body>
</html>
