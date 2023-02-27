<?php
function getUniqueName($extension)
{
    date_default_timezone_set('America/Mexico_City');
    $name = "img_";
    $name .= date("YmdHis");
    $name .= substr(md5(rand(0, PHP_INT_MAX)), 10);
    $name .= "." . $extension;
    return $name;
}
?>