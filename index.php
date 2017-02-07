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
                <li><a href="view-ideas.php">View Ideas</a></li>
            </ul>   
        </nav>
        <script type='text/javascript'>
            function expander(x){
                var tempScrollTop = $(window).scrollTop();
                console.log(tempScrollTop);
                console.log(x);
                $(window).scrollTop(tempScrollTop);
                $("#"+x).toggleClass("hidden");
            }
        </script>
        <?php 
            function page_redirect($location)
            {
              echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
              exit; 
            }
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
                        $posts[$row2["timestamp"]] = array("title"=>$row2["title"], //
                                                            "user"=>$row2["user"], //
                                                            "description"=>$row2["description"], //
                                                            "steps"=>$row2["steps"],//
                                                            "materials"=>$row2["materials"],//
                                                            "tips"=>$row2["tips"],//
                                                            "time"=>$row2["estTime"],
                                                            "cost"=>$row2["estCost"],
                                                            "reviews"=>$row2["ratings"],//
                                                            "rating"=>$row2["rated"],//
                                                            "tags"=>$row2["tags"],//
                                                            "postID"=>$row2["postID"],//
                                                            "stamp"=>$row2["timestamp"]);//

                    }
                }
            }
            ksort($posts);
            $x = 0;
            foreach(array_reverse($posts) as $elem) { 
                $photoSQL = "SELECT * FROM `upload` WHERE `postID`=".$elem["postID"].";";
                $resultPhoto = mysqli_query($conn, $photoSQL);
                $photoURL = "";
                if(mysqli_num_rows($resultPhoto) > 0) {
                    while($row3 = mysqli_fetch_assoc($resultPhoto)) {
                        $photoURL = $row3["imgLoc"];
                    }
                }
                ?>
            <div class="row">
                <div class="col-3">
                    <div class='project'>
                        <h2><?php echo $elem["title"]; ?></h2>
                        <p><?php echo $elem["description"]; ?></p>
                        <p>Rating: <?php if($elem["rating"] !== null){ echo $elem["rating"], " stars"; } else { echo "Be the first to rate this project!"; } ?></p>
                        <p><?php echo "<a href=profile.php?User=".$elem["user"].">".$elem["user"]."</a>"; ?></p>
                        <?php if($photoURL !== ""){ ?>
                        <img src="uploads/<?php echo $photoURL; ?>"/>
                        <?php } ?>
                        <p>Estimated Time: <?php echo $elem["time"], " minutes"; ?></p>
                        <p>Estimated Cost: <?php echo "$", $elem["cost"]; ?></p>
                        <a id="expander<?php echo $x;?>" onclick="expander('details<?php echo $x; ?>')" href="javascript:void(0)">click me</a>
                        <div class='hidden' id='details<?php echo $x; ?>'>
                            <p>Materials List:</p>
                            <?php 
                                $steps = explode("+", $elem["steps"]);
                                $items = explode("+", $elem["materials"]);
                                echo '<ul>';
                                for($z = 1; $z < sizeof($items); $z++) {
                                    $contents = explode(",", $items[$z]);
                                    echo "<li><a href='".$contents[0]."'>".$contents[1]."</a></li>";
                                }
                                echo '</ul>';
                            ?>
                            <p>Procedure:</p>
                            <?php 
                                
                                echo '<ol>';
                                for($y = 1; $y < sizeof($steps); $y++) {
                                    echo '<li>'.$steps[$y].'</li>';
                                }
                                echo '</ol>';
                            ?>
                            <p>Tips: <?php echo $elem["tips"]; ?></p>
                            
                            <p><?php echo date("F j, Y @ g:i a", strtotime($elem["stamp"])); ?></p>

                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class='comments'>
                        <?php 
                            $sqlCom = "SELECT * FROM `comments` WHERE `postID`=".$elem["postID"].";";
                            $resultCom = mysqli_query($conn, $sqlCom);

                            $comm = array();
                            if(mysqli_num_rows($resultCom) > 0) {
                                echo '<ul>';
                                while($row3 = mysqli_fetch_assoc($resultCom)) {
                                    $timeStr = date("F j, Y @ g:i a", strtotime($row3["timestamp"]));
                                    echo "<li>".$row3["user"].": ".$row3["message"]." -posted ".$timeStr."</li>";
                                }
                                echo '</ul>';
                            }
                        ?>
                        <form role='form' method='post' action="index.php">
                            <input type='text' name ='comment' value=''>
                            <input type='hidden' name='postID' value='<?php echo $elem["postID"] ?>'>
                            <input type='submit' value='comment' name='commentSub'>
                        </form>
                        <script>
                            function updateTextInput(val) {
                              document.getElementById('textInput').value=val; 
                            }
                        </script>
                        <form role="form" method="post" action="index.php">
                            <input type="range" name="rating" min="1" max="5" id="rating" onchange="updateTextInput(this.value);">
                            <input type="text" id="textInput" value="" maxlength="4" size="4">
                            <input type="submit" name="rate" value="Rate This Project">
                        </form>
                        
                    </div>
                </div>
            <?php 
            $x++;
            ?> </div> <?php
                }
                if($_POST["commentSub"]) {
                    $comment = Input::get("comment");
                    $post = Input::get("postID");
                    $sqlCom2 = "INSERT INTO `comments` (`postID`, `user`, `message`) VALUES ($post, '".$_SESSION["name"]."', '$comment');";
                    $resultCom2 = mysqli_query($conn, $sqlCom2);
                    page_redirect("index.php");
                }
                if($_POST["rate"]) {
                    $rating = Input::get("rating");
                    $sqlGetRate = "SELECT `ratings` FROM `posts` WHERE `postID`=".$elem["postID"].";";
                    $resultR = mysqli_query($conn, $sqlGetRate);
                    if(mysqli_num_rows($resultR) > 0){
                        while($rowR = mysqli_fetch_assoc($resultR)) {
                            if($rowR["ratings"] == null) {
                                $ratings = $rowR["ratings"];
                            }
                            else {
                                $ratings = $rowR["ratings"]."-";
                            }
                        }
                    } else {
                        $ratings = "";
                    }
                    $sqlRate = "UPDATE `posts` SET `ratings`='".$ratings.$rating."' WHERE `postID`=".$elem["postID"].";";
                    $resultRate = mysqli_query($conn, $sqlRate);
                    
                    $vals = explode("-", $elem["reviews"]);
                    $rateVal = 0;
                    if(strpos($elem["reviews"], "-") == 1) {
                        for($a = 0; $a <= sizeof($vals); $a++) {
                        $rateVal += $vals[$a];
                        }
                    } else {
                        $rateVal=$rating;
                    }
                    $ovr = $rateVal/sizeof($vals);
                    $sqlOvr = "UPDATE `posts` SET `rated`=".$ovr." WHERE `postID`=".$elem["postID"].";";
                    $resultOvr = mysqli_query($conn, $sqlOvr);
                    page_redirect("index.php");
                }
            ?>
    </body>
</html>

