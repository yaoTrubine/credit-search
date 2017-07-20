<?php

function validataArray($sql){
    $result = mysql_query($sql);
    return is_array(mysql_fetch_array($result));
}