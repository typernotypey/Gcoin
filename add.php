<?PHP

include 'config/db_connect.php';

//write query from Gcoin database
$sql = 'SELECT id, name, password, token FROM users';

//make query and get results
$result = mysqli_query($conn, $sql);

//fetch resulting rows as an array
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

//free $result
mysqli_free_result($result);

//close connection
mysqli_close($conn);

    $loggedInAs = null;
    $name = '';
    $password = '';
    $errors = [
        'name' => '',
        'password' => '',
    ];

    if(isset($_POST['submit'])){
        if(empty($_POST['password'])){
            $errors['password'] = 'there is not a password given <br>';
        } else{
            $password = $_POST['password'];
            if(!preg_match('/^[a-zA-Z0-9]+$/', $password)){
                $errors['password'] = 'password bust be letters or numbers <br>';
            }
        }

        if(empty($_POST['name'])){
            $errors['name'] = 'there is not a name given <br>';
        } else{
            $name = $_POST['name'];
            if(!preg_match('/^[a-zA-Z]+$/', $name)){
                $errors['name'] =  'Name can only be letters, sorry!';
            }
            for($i = 0; $i < count($users); $i++){
                if(in_array($name, $users[$i])){
                    if(in_array($password, $users[$i])){
                        print_r('name and password are correct');
                        $loggedInAs = $users[$i];
                        if($_POST['rememberMe']){
                            setcookie('token', $users[$i]['token'], strtotime( '30 days' ));
                            header('location: index.php');
                        } else{
                            setcookie('token', $users[$i]['token'], 0);
                            header('location: index.php');
                        }
                    } else{
                        $errors['password'] = 'password is incorrect';
                    }
                    break;
                }
                if($i == count($users)){
                    $errors['name'] = 'name is incorrect';
                }
            } 
        }

    }

?>

<!DOCTYPE html>
<?PHP include 'templates/header.php' ?>
    <section>
        <div class='align-center'>
            <Label class='font-arial-sansserif size-2rem'><h1 >Login</h1></Label>
            <form action="add.php" method="POST">
                <Label for='name'class='font-arial-sansserif size-2rem'>Your Name:</Label><br>
                <input type="text" name="name" autocomplete="off" class='size-2rem' value=<?PHP echo htmlspecialchars($name); ?>>
                <div><?PHP echo $errors['name'] ?></div>
                <Label for='password' class='font-arial-sansserif size-2rem'>Your Password:</Label><br>
                <input type="text" name="password" autocomplete="off" class='size-2rem' value=<?PHP echo htmlspecialchars($password); ?>>
                <div><?PHP echo $errors['password'] ?></div>
                <label class="font-arial-sansserif size-2rem" for="rememberMe">Remember for 30 days?</label><br>
                <input class ="widthHeight-2rem" type="checkbox" name="rememberMe">
                <br>
                <br>
                <div>
                    <input type="submit" name="submit" value="submit" class='submit-buttons align-center'>
                </div>
            </form>
        </div>
    </section>
<?PHP include 'templates/footer.php' ?>
</html>
