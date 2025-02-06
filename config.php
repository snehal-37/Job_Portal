<?php 
$h='';//write your hostname here
$u='';//write your username here
$p='';//write your password here
$db='jboard';

$conn=mysqli_connect($h,$u,$p,$db);

if(!$conn){
    die("Not Connected").mysqli_connect_error();
}

?>