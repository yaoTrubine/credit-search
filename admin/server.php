<?php

//处理各种ajax请求
require_once 'connect.fun.php';
require_once 'validatafrom.fun.php';
header("Content-Type: text/html;charset=utf-8"); 
//连接数据库
$conn = connect_mysql();
mysql_query("set names 'utf8'"); 
mysql_select_db('credit',$conn);
// $sql = "SELECT * FROM `cheater` WHERE `name` LIKE '".$_POST['info']."' ORDER BY `wechaid` ASC";
// $sql = "SELECT * FROM cheater WHERE '".$_POST['select']."' LIKE '%".$_POST['info']."%'";
// $sql_search = "SELECT * FROM cheater";



//ajax为get
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //用来搜索的sql
	$sql_search = "SELECT * FROM cheater WHERE ".$_GET['select']." LIKE '%".$_GET['info']."%'";
    $result = mysql_query($sql_search);

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
//ajax为post
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    /*
     *验证提交
     *
     */
    //微信号
    //"SELECT * FROM cheater WHERE wechaid LIKE '".$_POST['wechaid']."'";
    //电话
    //"SELECT * FROM cheater WHERE phone LIKE '".$_POST['phone']."'";
    //护照
    //"SELECT * FROM cheater WHERE passport LIKE '".$_POST['passport']."'";
    
    $sql_match_wechat = "SELECT * FROM cheater WHERE wechaid LIKE '".$_POST['wechaid']."'";
    $sql_match_phone = "SELECT * FROM cheater WHERE phone LIKE '".$_POST['phone']."'";
    $sql_match_passport = "SELECT * FROM cheater WHERE passport LIKE '".$_POST['passport']."'";
    
    if(validataArray($sql_match_wechat)){
        echo '{"success":false,"msg":"微信号已被使用！"}';
        exit;
    }elseif(validataArray($sql_match_phone)){
        echo '{"success":false,"msg":"电话已被使用！"}';
        exit;
    }elseif(validataArray($sql_match_passport)){
        echo '{"success":false,"msg":"护照已被使用！"}';
        exit;
    }else{
        /*
        *插入数据库
        */ 
        $sql_insert = "INSERT INTO cheater (name, wechaid, phone, passport) VALUES ('".$_POST['name']."', '".$_POST['wechaid']."', '".$_POST['phone']."', '".$_POST['passport']."')";

        $result_2 = mysql_query($sql_insert);
        if(mysql_affected_rows($result_2) != -1){
            echo '{"success":true,"msg":"信息保存成功！"}';
        }else{
            echo '{"success":false,"msg":"信息保存失败！"}';
        }
    }
}





mysql_close();

