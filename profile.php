<!DOCTYPE html>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <meta charset="UTF-8">
        <title>Home</title>
    </head>
    <body>
        <div class="header">
            <img src="Pictures/BPA-Banner.png" width="100%" alt=""/>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
                <li><a href="login-register.php">Login/Register</a></li>
                <li class="active"><a href="profile.php">Profile</a></li>
        </nav>
        <div class="row">
            <div class='col-2'>
                <?php
                    if(Token::check(Verify::get('token'))) { 
                        $profile = $_GET["User"];
                        if($profile == null) {
                            $profile = $_SESSION["name"];
                        }

                        $sql = "SELECT * FROM `users` WHERE `username`='$profile';";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            if($row = mysqli_fetch_assoc($result)) { ?>
                                <h1><?php echo $row["username"];?></h1>
                                <ol>
                                    <li><a href="http://www.facebook.com/<?php echo $row["facebook"]; ?>" target="_blank">Facebook</a></li>
                                    <li><a href="http://www.twitter.com/<?php echo $row["twitter"];?>" target="_blank">Twitter</a></li>
                                    <li><a href="http://www.instagram.com/<?php echo $row["instagram"]; ?>" target="_blank">Instagram</a></li>
                                    <li><a href="http://www.pinterest.com/<?php echo $row["pinterest"]; ?>" target="_blank">Pinterest</a></li>
                                    <li><a href="http://www.snapchat.com/add/<?php echo $row["snapchat"]; ?>" target="_blank">Snapchat</a></li>
                                    <li><a href="http://plus.google.com/<?php echo $row["google"]; ?>" target="_blank">Google+</a></li>
                                </ol>
                            <?php }
                        } ?>
                        <script>
                        function myAjax() {
                              $.ajax({
                                   type: "POST",
                                   url: '/ajax.php',
                                   data:{action:'follow'},
                                   success: function() {
                                       console.log("called");
                                   }
                              });
                         }
                        </script>
                        <button type='button' name='follow' id='follow' onclick='myAjax()'>Follow @<?php echo $profile ?></button>
                        
                    <?php }
                ?>
            </div>
        </div>
    </body>
</html>
