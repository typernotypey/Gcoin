<?php 

include 'config/db_connect.php';

//write query from Gcoin database
$sql = 'SELECT id, name, password, token FROM users';

//make query and get results
$result = mysqli_query($conn, $sql);

//fetch resulting rows as an array
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);



$name = '';
$password = '';
$confirmPassword = '';
$errors = [
    'name' => '',
    'password' => '',
    'confirmPassword' => '',
];

if(isset($_POST['submit'])){ // check if form has been submitted

    if(empty($_POST['password'])){ //check if password is empty
        $errors['password'] = 'there is not a password given <br>';
    } else{ // if password is not empty run it by the regex
        $password = $_POST['password'];
        if(!preg_match('/^[a-zA-Z0-9]+$/', $password)){
            $errors['password'] = 'password bust be letters or numbers <br>';
        }
    }

    if(empty($_POST['name'])){ // check if name is empty
        $errors['name'] = 'there is not a name given <br>';
    } else{ // if name is not empty run it by the regex and see if it already exists
        $name = $_POST['name'];
        if(!preg_match('/^[a-zA-Z]+$/', $name)){
            $errors['name'] =  'Name can only be letters, sorry!';
        }
        for($i = 0; $i < count($users); $i++){
            if($name == $users[$i]['name']){
                $errors['name'] = 'this name is taken';
                break;
            }
        }
    }

    if(empty($_POST['confirmPassword'])){ //check if confirm password is empty
        $errors['confirmPassword'] = 'there is not a password confirmation given';
    }else{ //check confirm password = password
        $confirmPassword = $_POST['confirmPassword'];
        if(!$password == $confirmPassword){
            $errors['confirmPassword'] = 'passwords do not match';
        }
    }
    if($errors['name'] == '' and $errors['password'] == '' and $errors['confirmPassword'] == ''){
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $token = rand(0, 32767);
        for($i = 0; $i < count($users); $i++){
            if($users[$i]['token'] == $token){
                $token = rand(0, 32767);
                $i = 0;
            }
        }
        $token = mysqli_real_escape_string($conn, $token);

        //sql
        $sql = "INSERT INTO users(name, password, token) VALUES('$name', '$password', '$token')";

        if(!mysqli_query($conn, $sql)){
            echo 'there was an error, please contact server administrator';
        }
        
    }
}

//free $result
mysqli_free_result($result);

//close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
    <?php include 'templates/header.php' ?>
    <section>
        <div class='align-center'>
            <label class='font-arial-sansserif size-2rem'><h1>Sign up</h1></label>

            <form action="signup.php" method='POST'>
                <!--input for name-->
                <label for="name" class="font-arial-sansserif size-2rem">Your Name:</label><br>
                <input type="text" name="name" autocomplete="off" class='size-2rem' value=<?PHP echo htmlspecialchars($name); ?>><br>
                <div class='size-2rem'><?PHP echo $errors['name'] ?></div>

                <!--input for password-->
                <Label for='password' class='font-arial-sansserif size-2rem'>Your Password:</Label><br>
                <input type="text" name="password" autocomplete="off" class='size-2rem' value=<?PHP echo htmlspecialchars($password); ?>><br>
                <div class='size-2rem'><?PHP echo $errors['password'] ?></div>

                <!--input for confirm password-->
                <Label for='confirmPassword' class='font-arial-sansserif size-2rem'>Confirm Your Password:</Label><br>
                <input type="text" name="confirmPassword" autocomplete="off" class='size-2rem' value=<?PHP echo htmlspecialchars($confirmPassword); ?>><br>
                <div class='size-2rem'><?PHP echo $errors['confirmPassword'] ?></div>

                <!--submit-->
                <div>
                    <input type="submit" name="submit" value="submit" class='submit-buttons align-center'>
                </div>
            </form>
        </div>
    </section>
    <?php include 'templates/footer.php' ?>
</html>