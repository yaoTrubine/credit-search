<?php


function connect_mysql($server = 'localhost',$name='root',$password='8876'){
    $con = mysql_connect($server,$name,$password);
    if (!$con)
    {
      die('Could not connect: ' . mysql_error());
    }
    return $con;
}