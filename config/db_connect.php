<?php

//establish connection
$conn = mysqli_connect('localhost', 'Griffin', 'monty2jasper', 'Gcoin');

//check connection
if(!$conn){
echo 'connection error:' . mysqli_connect_error();
}

//write query from Gcoin database
$sql = 'SELECT id, name, password, token, balance, Gcoin FROM users';

//make query and get results
$result = mysqli_query($conn, $sql);

//fetch resulting rows as an array
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

//write query from prices database
$sql = 'SELECT id, price, created_at FROM prices';

//make query and get results
$result = mysqli_query($conn, $sql);

//fetch resulting rows as an array
$prices = mysqli_fetch_all($result, MYSQLI_ASSOC);

//write query from prices database
$sql = 'SELECT id, value, buyer, seller, created_at FROM transactions';

//make query and get results
$result = mysqli_query($conn, $sql);

//fetch resulting rows as an array
$transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>