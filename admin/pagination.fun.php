<?php

function totalPages($sql,$pageSize){
    $result = mysql_fetch_array(mysql_query($sql));
    $totalPages = ceil($result[0]/$pageSize);
    return $totalPages;
}