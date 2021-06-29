<?php

//establish connection
$conn = mysqli_connect('localhost', 'Griffin', 'monty2jasper', 'Gcoin');

//check connection
if(!$conn){
echo 'connection error:' . mysqli_connect_error();
}

?>