<?php 
    session_start();
    require_once 'init.php';
    $conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $user = new User();
?>
<html>
    <head>
        <link rel="stylesheet" href="diy.css" type="text/css">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="header">
        <img src="Pictures/DIY header.jpg" alt=""/>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
                <li class="active"><a href="login-register.php">Login/Register</a></li>
            </ul>   
        </nav>
        <form class="smart-green" action="" method="POST">
            <p>Username</p>
            <input type="text" name="user" value="">
            <p>Password</p>
            <input type="password" name="pass" value="">
            <input type="hidden" value="<?php Token::generate(); ?>">
            <input type="submit" name="login" value="login">
        </form>
        <form class="smart-green" action="" method="POST">
            <p>Username</p>
            <input type="text" name="username" value="">
            <p>Password</p>
            <input type="password" name="password" value="">
            <p>Verify</p>
            <input type="password" name="verify" value="">
            <input type="hidden" value="<?php Token::generate(); ?>">
            <input type="submit" name="register" value="Register">
        </form>
        <?php
            if(Input::get("register")) {
                $username = Input::get("username");
                $password = Input::get("password");
                $verify = Input::get("verify");
                if(!(empty($username) || empty($password) || empty($verify))) {
                        if(strcmp($verify, $password) == 0) {
                            $salt = Hash::salt(64);
                            $newpass = Hash::make($password, $salt);
                            $sql = "INSERT INTO `users` (`username`, `password`, `salt`) VALUES ('$username', '$newpass', '$salt');";
                            if(mysqli_query($conn, $sql)) {
                                echo "login success";
                            } else {
                                echo "fail";
                            }
                        }
                        else {
                            echo "passwords do not match";
                        }
                } else {
                    echo "all fields are required";
                }
            } else if(Input::get("login")) {
                $username = Input::get("user");
                $password = Input::get("pass");
                
                if($user->login($conn, $username, $password)) {
                    $_SESSION["id"] = $user->getID($conn, $username);
                    $_SESSION["name"] = $username;
                } else {
                    echo "login failed";
                }
            } else {
                echo "no request";
            }
        ?>
    </body>
</html>
