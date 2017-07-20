<?php

//处理各种ajax请求


require_once 'connect.fun.php';

header("Content-Type: text/html;charset=utf-8"); 

// print_r($_GET);

$conn = connect_mysql();

mysql_query("set names 'utf8'"); 
mysql_select_db('credit',$conn);
// $sql = "SELECT * FROM `cheater` WHERE `name` LIKE '".$_POST['info']."' ORDER BY `wechaid` ASC";
// $sql = "SELECT * FROM cheater WHERE '".$_POST['select']."' LIKE '%".$_POST['info']."%'";
// $sql2 = "SELECT * FROM cheater";




//用来搜索的sql
$sql2 = "SELECT * FROM cheater WHERE ".$_GET['select']." LIKE '%".$_GET['info']."%'";



$result = mysql_query($sql2);

    

if(mysql_num_rows($result) == 0){
    //query得不到结果显示没有
    echo '<h2>没有查询结果</h2>';
}else{
    echo '<table class="table">';
    echo '<tr>';
    echo    '<th>姓名</th>';
    echo    '<th>微信号</th>';
    echo    '<th>电话</th>';
    echo    '<th>护照号</th>';
    echo '</tr>';
    echo '</table>';
    //把每条数据输出
    while($row = mysql_fetch_assoc($result)){
        echo '<table class="table">';
        echo '<tr>';
        echo    '<td class="danger">'.$row['name'].'</td>';
        echo    '<td class="danger">'.$row['wechaid'].'</td>';
        echo    '<td class="danger">'.$row['phone'].'</td>';
        echo    '<td class="danger">'.$row['passport'].'</td>';
        echo '</tr>';
        echo '</table>';
    }
}



mysql_close();

