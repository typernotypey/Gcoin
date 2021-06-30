<?PHP

include 'config/db_connect.php';

//write query from Gcoin database
$sql = 'SELECT name, password, id FROM users';

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

        if(!$loggedInAs == null){
            print_r($loggedInAs);
            $loggedInAsFile = fopen("loggedInAsFile.php", "w");
            fwrite($loggedInAsFile, '$loggedInAs = [\'name => ' . $loggedInAs['name'] . ', password\']');
            fclose($loggedInAsFile);
        }
    }

?>

<!DOCTYPE html>
<?PHP include 'templates/header.php' ?>
    <section>
        <form action="add.php" method="POST">
            <Label><h1>Login</h1></Label>
            <Label>Your Name:</Label>
            <input type="text" name="name" autocomplete="off" value=<?PHP echo htmlspecialchars($name); ?>>
            <div><?PHP echo $errors['name'] ?></div>
            <Label>Your Password:</Label>
            <input type="text" name="password" autocomplete="off" value=<?PHP echo htmlspecialchars($password); ?>>
            <div><?PHP echo $errors['password'] ?></div>
            <div>
                <input type="submit" name="submit" value="submit">
            </div>
        </form>
    </section>
<?PHP include 'templates/footer.php' ?>
</html>