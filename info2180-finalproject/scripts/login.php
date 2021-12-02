<?php
session_start();

require_once 'connectdb.php';

if(isset($_POST["login"])) {
    if ($_POST['email'] != '' && $_POST['password'] != ''){
            $query = "SELECT * from `users` where `email`=:email";

            $sql = $conn->prepare($query);
            $sql->execute(
                array(
                    'email' => $_POST['email'],
                )
            );
            $count = $sql->rowCount();

            $data   = $sql->fetch(PDO::FETCH_ASSOC);

            if($count == 1 && password_verify($_POST['password'], $data['password'])){
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['id'] = $data['id'];
                $_SESSION['firstname'] = $data['firstname'];
                header('location:home.php');
                $logg = $_SESSION['id'];
            }
            else{
                $errorMsg = '<label style="color: orange ;"> Invalid email or password! Try again.</label>';
            }

        }

    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title> BugMe Issue Tracker</title>
        <script type="text/javascript" src="scripts/login_validation.js"></script>
		<link rel="stylesheet" href="../styles/login.css">
	</head>
    <body>
        <header>
        <div class="header-container"> 
            <img src="../bugicon.png" alt="a bug" class="bug">

		    <h1>BugMe Issue Tracker Login</h1>
        </div>
		</header>
        <div class="form-layout">
        <form method="POST" onsubmit="return validateForm()"></form>
            <div class="form-container">
                <label for= "email"> Username </label>
                <input type="email" placeholder="Email Address" name="email" id="email" required>
                <br>
                <label for= "password"> Password </label>
                <input type="password" placeholder="Password" name="password" id="password" required>

                <?php
                if(isset($errorMsg)){
                    echo $errorMsg;
                }
                ?>
                <br>
                <div class="bttn">
                <button type="submit" name="submit_form" id="submit_form">Login</button>
                </div>
            </div>
        </form>
        </div>
    </body>

</html>