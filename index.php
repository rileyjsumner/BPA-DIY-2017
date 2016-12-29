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
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <meta charset="UTF-8">
        <title>Home</title>
    </head>
    <body>
        <div class="header">
            <img src="Pictures/header.png" width="100%" alt=""/>
        </div>
        <nav class="nav">
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
                <li><a href="login-register.php">Login/Register</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>   
        </nav>
        <div class='row'>
            <div class='col-1'>
                <script type='text/javascript'>
                $(document).ready(function() {
                    $(".expander").click(function() {
                        $("#details").toggleClass("hidden");
                    });
                });
                </script>
                <?php 
                    $sql = "SELECT `follow` FROM `follows` WHERE `user`='".$_SESSION['name']."';";
                    $result = mysqli_query($conn, $sql); 
                    $following = array();
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $following[] = $row["follow"];
                        }
                    }
                    $posts = array();
                    foreach($following as $userFollow) {
                        $sql2 = "SELECT * FROM `posts` WHERE `user` = '$userFollow';";
                        $result2 = mysqli_query($conn, $sql2);
                        if(mysqli_num_rows($result2) > 0) {
                            while($row2 = mysqli_fetch_assoc($result2)) {
                                $posts[$row2["timestamp"]] = array("title"=>$row2["title"], 
                                                                    "user"=>$row2["user"], 
                                                                    "description"=>$row2["description"], 
                                                                    "steps"=>$row2["steps"],
                                                                    "materials"=>$row2["materials"],
                                                                    "tips"=>$row2["tips"],
                                                                    "time"=>$row2["estTime"],
                                                                    "cost"=>$row2["estCost"],
                                                                    "reviews"=>$row2["ratings"],
                                                                    "rating"=>$row2["rated"],
                                                                    "tags"=>$row2["tags"],
                                                                    "postID"=>$row2["postID"]);
                                
                            }
                        }
                    }
                    ksort($posts);
                    foreach(array_reverse($posts) as $elem) { ?>
                        <div class='project'>
                            <h2><?php echo $elem["title"]; ?></h2>
                            <p><?php echo $elem["description"]; ?></p>
                            
                            <a class="expander" href="#">click me</a>
                            <div class='hidden' id='details'>
                                <?php echo $elem["steps"]; ?>
                            </div>
                        </div>
                        <div class='comments'>
                            <?php 
                                $sqlCom = "SELECT * FROM `comments` WHERE `postID`=".$elem["postID"]." ORDER BY `timestamp` ASC;";
                                $resultCom = mysqli_query($conn, $sqlCom);
                                
                                $comm = array();
                                if(mysqli_num_rows($resultCom) > 0) {
                                    while($row3 = mysqli_fetch_assoc($resultCom)) {
                                        echo "<p>".$row3["user"].": ".$row3["message"]." -posted ".$row3["timestamp"]."</p>";
                                    }
                                }
                            ?>
                            <form role='form' method='post'>
                                <input type='text' name ='comment' value=''>
                                <input type='hidden' name='postID' value='<?php echo $elem["postID"] ?>'>
                                <input type='submit' value='comment' name='commentSub'>
                            </form>
                            <?php 
                                if($_POST["commentSub"]) {
                                    $comment = Input::get("comment");
                                    $post = Input::get("postID");
                                    $sqlCom2 = "INSERT INTO `comments` (`postID`, `user`, `message`) VALUES ($post, '".$_SESSION["name"]."', '$comment');";
                                    $resultCom2 = mysqli_query($conn, $sqlCom2);
                                }
                            ?>
                        </div>
                    <?php }
                    
                ?>
            </div>
        </div>
    </body>
</html>

