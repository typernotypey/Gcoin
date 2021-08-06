<?PHP 

include 'config/db_connect.php';

//run genGraph.py
//shell_exec('cd c:\windows\system32 && cd.. && d: && cd D:\xampp\htdocs\Gcoin && python genGraph.py');

//defines $loggedInAs as nothing
$loggedInAs = null;

//"decodes" token and sets $loggedInAs
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
	//put code here
}

//free $result
mysqli_free_result($result);

//close connection
mysqli_close($conn);

?>

<DOCTYPE html>
<html>
    <?PHP include 'templates/header.php' ?>
    <h1 class="font-arial-sansserif align-center"><?php echo "hello " . $loggedInAs['name'] ?></h1>
	<div class="currency-info">
		<img src="misc/Gcoin1080p.png" alt="Gcoin image" class="width-50p">
		<h1 class="margin-auto font-arial-sansserif"><?php echo "current price is estimated to be " . $prices[count($prices) - 1]["price"] ?></h1>

		<h1><a href="transactions/transactions.php" class = 'link_buttons font-arial-sansserif'>transactions</a></h1>
		
	</div>
    <?PHP include 'templates/footer.php' ?>
</html>