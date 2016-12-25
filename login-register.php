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
        <img src="Pictures/header.png" width="100%" alt=""/>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
                <li class="active"><a href="login-register.php">Login/Register</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>   
        </nav>
        <div class="row">
            <div class="col-1">
                <form class="smart-green" action="" method="POST">
                    
                    <p>Username</p>
                    <input type="text" name="user" placeholder="Username" value="">
                    <p>Password</p>
                    <input type="password" name="pass" placeholder="Password" value="">
                    <input type="hidden" value="<?php echo Token::generate(); ?>">
                    <input type="submit" name="login" value="login">
                </form>
            </div>
            <div class="col-1">
                <form class="smart-green" action="" method="POST">
                    <p>Username</p>
                    <input type="text" name="username" placeholder="Username" value="">
                    <p>Email</p>
                    <input type="email" name="email" placeholder="yourname@example.com" value="">
                    <p>Password</p>
                    <input type="password" name="password" placeholder="Password" value="">
                    <p>Verify</p>
                    <input type="password" name="verify" placeholder="Verify Password" value="">
                    <input type="hidden" value="<?php echo Token::generate(); ?>">
                    <input type="submit" name="register" value="Register">
                </form>
            </div>
        </div>
        <?php
            if(Input::get("register")) {
                $username = Input::get("username");
                $password = Input::get("password");
                $email = Input::get("email");
                $verify = Input::get("verify");
                if(!(empty($username) || empty($password) || empty($verify) || empty($email))) {
                        if(strcmp($verify, $password) == 0) {
                            $salt = Hash::salt(64);
                            $newpass = Hash::make($password, $salt);
                            $sql = "INSERT INTO `users` (`username`, `email` , `password`, `salt`) VALUES ('$username', '$email' ,'$newpass', '$salt');";
                            if(mysqli_query($conn, $sql)) {
                                echo "<p>login success</p>";
                            } else {
                                echo "<p>an error occured</p>";
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
                } 
            } 
        ?>
    </body>
</html>
