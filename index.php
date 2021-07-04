<?PHP 

include 'config/db_connect.php';

//write query from Gcoin database
$sql = 'SELECT name, password, id, token FROM users';

//make query and get results
$result = mysqli_query($conn, $sql);

//fetch resulting rows as an array
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

date_default_timezone_set('America/New_York');

//run genGraph.py
//shell_exec('cd c:\windows\system32 && cd.. && d: && cd D:\xampp\htdocs\Gcoin && python genGraph.py');

$loggedInAs = null;

if($_COOKIE['token']){
	for($i = 0; $i < count($users); $i++){
		if($_COOKIE['token'] == $users[$i]['token']){
			echo 'found user as ' . $users[$i]['name'];
			$loggedInAs = $users[$i];
		}
	}
}else{
	header('location: add.php');
	echo 'no token';
}

?>

<DOCTYPE html>
<html>
    <?PHP include 'templates/header.php' ?>
    <h1 class="font-arial-sansserif align-center">Contents</h1>
    <?PHP include 'templates/footer.php' ?>
</html>
