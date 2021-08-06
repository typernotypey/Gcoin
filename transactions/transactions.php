<?PHP

include 'D:/xampp/htdocs/Gcoin/config/db_connect.php';

$loggedInAs = null;

if($_COOKIE['token']){
	for($i = 0; $i < count($users); $i++){
		if($_COOKIE['token'] == $users[$i]['token']){
			//echo 'found user as ' . $users[$i]['name'];
			$loggedInAs = $users[$i];
		}
	}
}else{ // if there is an issue
	header('location: add.php');
	echo 'issue finding account, please contact server admin(contacts shown at bottom of page)';
}

if($loggedInAs != null){
    
}

//free $result
mysqli_free_result($result);

//close connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    helo
</body>
</html>