<!DOCTYPE html>
<?php 
    session_start();
    require_once 'init.php';
    
    if(!session_start()) {
        die("Session start fail");
    }
    $conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $user = new User();
    
    if(Token::check(Verify::get('token')) && $user->islogin($conn, $_SESSION["name"])) {
        
        $userID = $_SESSION["id"];
        $sql = "SELECT `username` FROM `users` WHERE `userID`=$userID;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $userName = $row['username'];
            }
        }
        
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="diy.css" type="text/css">
        <meta charset="UTF-8">
        <title>Home</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </head>
    <body>
         <div class="header">
        <img src="Pictures/header.png" width="100%" alt=""/>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="active"><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
                <li><a href="login-register.php">Login/Register</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="view-ideas.php">View Ideas</a></li>
            </ul>  
        </nav>
        <div class="row">
            <div class="col-2">
                <?php 
                date_default_timezone_set('America/New_York');
                if(Token::check(Verify::get('token')) && $user->islogin($conn, $userName)) {
                    if($_GET['action'] == "title" || $_GET['action'] == null) { 
                        if($_GET["action"] == null) {
                            unset($_SESSION["postID"]);
                        }
                        $_GET['action'] = "title"; 
                        $sqlTD = "SELECT `title`, `description` FROM `posts` WHERE `postID`=".$_SESSION['postID'].";";
                        $resultTD = mysqli_query($conn, $sqlTD);
                        if(mysqli_num_rows($resultTD) > 0) {
                            while($rowTD = mysqli_fetch_assoc($resultTD)) {
                                $titleDB = $rowTD["title"];
                                $descDB = $rowTD["description"];
                            }
                        }
                        ?>
                        <form class="smart-green" method="POST" role="form" class="title" method="POST" action="?action=materials">
                            <table width='500'>
                                <tr>
                                    <td>
                                        <label for="title">Project Title</label>
                                        <input type="text" name="title" value="<?php if($titleDB !== null) { echo "$titleDB";} else if ($_GET["Title"] !== null) {echo $_GET["Title"];} ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="description">Description</label>
                                        <textarea name="description"><?php if($descDB !== null) { echo "$descDB";} else if ($_GET["Description"] !== null) {echo $_GET["Description"];} ?></textarea>
                                    </td>
                                </tr>
                            </table>
                            <input type="submit" name="submit" value="next>">
                        </form>
                <?php } else if($_GET['action'] == "materials") { 
                    $title = Input::get("title");
                    $description = Input::get('description');

                    $sql1 = "INSERT INTO `posts` (`title`, `description`, `user`) VALUES ('$title', '$description', '$userName');";
                    $result = mysqli_query($conn, $sql1);
                    
                    $sql2 = "SELECT `postID` FROM `posts` WHERE `title`='$title' AND `description`='$description' AND `user`='$userName';";
                    $result2 = mysqli_query($conn, $sql2);
                    
                    if(mysqli_num_rows($result2) > 0) {
                        while($row2 = mysqli_fetch_assoc($result2)) {
                            $_SESSION["postID"] = $row2["postID"];
                        }
                    }
                    ?>
                    <form class="smart-green" method="POST" role="form" class="my-form" role="form" method="POST" >
                        <table class="materialstab" style="border:1px solid;" cellpadding="5">
                            <tr>
                                <td>
                                    <p class="text-box">
                                      <label for="materials">Materials</label>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-box">
                                        <label for="url">URL</label>
                                    </p>
                                </td>
                                <td>
                                    <p class='text-box'>
                                        <a class="add-box" href="#">Add Material</a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <button type="submit" name="prev" id="btnsbmit1" formaction="?action=title">Previous</button>
                        <button type="submit" name="next" id="btnsbmit2" formaction="?action=steps">Next</button>
                        <script type="text/javascript">
                            jQuery(document).ready(function() {
                                $('.smart-green .add-box').click(function() { //add box
                                  var n = $('.text-box').length + 1;
                                  console.log(n);
                                  var box_html = $('<tr>' + 
                                          '<td><p class="text-box"><input class="materials" type="text" name="materials'+ n +'" value="" id="materials' + n + '" /></p></td>' + 
                                          '<td><p class="text-box"><input type="text" placeholder="include \'www\' " name="url' + n + '" value="" id="url' + n + '" /></p></td>' + 
                                          '<td><p class="text-box"><a href="#" class="remove-box">Remove</a></p></td></tr>');
                                  
                                  box_html.hide();
                                  $('.smart-green .materialstab tr:last').after(box_html);
                                  box_html.fadeIn('slow');
                                  return false;
                                });
                                $('.smart-green').on('click', '.remove-box', function(){ //remove box
                                    $(this).parents('tr').css( 'background-color', '#FF6C6C' );
                                    $(this).parents('tr').fadeOut("slow", function() {
                                        $(this).parents('tr').remove;
                                        $('.box-number').each(function(index){
                                            $(this).text( index + 1 );
                                        });
                                    });
                                    return false;
                                });
                            });
                            $("#btnsbmit2").click( function () { //calculate # of elements, set form data

                                var textboxcount = document.getElementsByClassName("materials").length;
                                console.log(textboxcount);
                                var box = $('<input type="hidden" name="elem1" value="'+textboxcount+'">');
                                $('.smart-green p.text-box:last').after(box);

                           });
                        </script>
                    </form>
                <?php } else if($_GET['action'] == "steps") { 
                    $elem1 = Input::get("elem1");
                    $dbString = "";
                    $y = 4;
                    for($x = 1; $x < $elem1; $x++) {
                        $dbString.= "+".Input::get("url".$y).",".Input::get("materials".$y);
                        $y+=3;
                    }
                    
                    $sql3 = "UPDATE `posts` SET `materials`='$dbString' WHERE `postID` =".$_SESSION['postID'].";";
                    $result3 = mysqli_query($conn, $sql3);
                    
                    ?>
                    <form class="smart-green" role="form" action="?action=socialmedia" method="POST">
                        <table class="materialstab" method="POST" role="form" class="materialstab" style="border:1px solid">
                            <tr>
                                <td>
                                    <p class="text-box">
                                        <label for="steps">Steps</label>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-box">
                                        <a class="add-box" href="#">Add More</a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <button type="submit" name="prev" id="btnsbmit3" formaction="?action=materials">Previous</button>
                        <button type="submit" name="next" id="btnsbmit4" formaction="?action=socialmedia">Next</button>
                        <script type="text/javascript">
                        jQuery(document).ready(function() {
                            $('.smart-green .add-box').click(function(){
                                var n = $('.text-box').length + 1;
                                console.log(n);
                                var box_html = $('<tr>' +
                                        '<td><p class="text-box"><input class="steps" type="text" name="steps' + n + '" value="" id="steps' + n + '" /></td>' + 
                                        '<td><p class="text-box"><a href="#" class="remove-box">Remove</a></p></td></tr>');
                                box_html.hide();
                                $('.smart-green .materialstab tr:last').after(box_html);
                                box_html.fadeIn('slow');
                                return false;
                            });
                            $('.smart-green').on('click', '.remove-box', function(){
                                $(this).parents('tr').css( 'background-color', '#FF6C6C' );
                                $(this).parents('tr').fadeOut("slow", function() {
                                    $(this).parents('tr').remove;
                                    $('.box-number').each(function(index){
                                        $(this).text( index + 1 );
                                    });
                                });
                                return false;
                            });

                        });
                        $("#btnsbmit4").click( function () { //calculate # of elements, set form data

                            var textboxcount2 = document.getElementsByClassName("steps").length;
                            var box_2 = $('<input type="hidden" name="elem2" value="'+textboxcount2+'">');
                            $('.smart-green p.text-box:last').after(box_2);

                        });
                        </script>
                    </form>
                <?php } else if($_GET['action'] == "socialmedia") { 
                        $elem2 = Input::get("elem2");
                        $dbString2 = "";
                        $y2 = 3;
                        for($x2 = 0; $x2 < $elem2; $x2++) {
                            $dbString2.= "+".Input::get("steps".$y2);
                            $y2+=2;
                        }
                        $sql4 = "UPDATE `posts` SET `steps`='$dbString2' WHERE `postID` =".$_SESSION['postID'].";";
                        $result4 = mysqli_query($conn, $sql4);
                    
                        $getSM = "SELECT * FROM `users` WHERE `userID`=$userID;";
                        $resultSM = mysqli_query($conn, $getSM);
                        if(mysqli_num_rows($resultSM) > 0) {
                            while($row = mysqli_fetch_assoc($resultSM)) {
                                $fb = $row["facebook"];
                                $tw = $row["twitter"];
                                $ig = $row["instagram"];
                                $pi = $row["pinterest"];
                                $sc = $row["snapchat"];
                                $go = $row["google"];
                            }
                        }
                    ?>
                    <form class="smart-green" role="form" action="?action=images" method="POST">  
                        <label for="facebook">Facebook</label><input type="text" name="facebook" placeholder="http://facebook.com/" value="<?php if($fb !== null) {echo $fb;} ?>"><br>
                        <label for="twitter">Twitter</label><input type="text" name="twitter" placeholder="@" value="<?php if($tw !== null) {echo $tw;} ?>"><br>
                        <label for="instagram">Instagram</label><input type="text" name="instagram" placeholder="@" value="<?php if($ig !== null) {echo $ig;} ?>"><br>
                        <label for="pinterest">Pinterest</label><input type="text" name="pinterest" placeholder="http://www.pinterest.com/" value="<?php if($pi !== null) {echo $pi;} ?>"><br>
                        <label for="snapchat">Snapchat</label><input type="text" name="snapchat" placeholder="@" value="<?php if($sc !== null) {echo $sc;} ?>"><br>
                        <label for="google">Google+</label><input type="text" name="google" placeholder="plus.google.com/" value="<?php if($go !== null) {echo $go;} ?>"><br>
                        <button type="submit" name="prev" id="btnsbmit5" formaction="?action=steps">Previous</button>
                        <button type="submit" name="next" id="btnsbmit6" formaction="?action=images">Next</button>
                    </form>
                <?php } else if($_GET['action'] == "images") { 
                    $facebook = Input::get("facebook");
                    $twitter = Input::get("twitter");
                    $instagram = Input::get("instagram");
                    $pinterest = Input::get("pinterest");
                    $snapchat = Input::get("snapchat");
                    $google = Input::get("google");

                    $sql4 = "UPDATE `users` SET "
                            . "`facebook`='$facebook', "
                            . "`twitter`='$twitter', "
                            . "`instagram`='$instagram',"
                            . "`pinterest`='$pinterest',"
                            . "`snapchat`='$snapchat',"
                            . "`google`='$google'"
                            . " WHERE `userID`=$userID";

                    $result4 = mysqli_query($conn, $sql4);
                    ?>
                    <form class="smart-green" role="form" method="post" enctype="multipart/form-data">
                        <table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
                            <tr> 
                                <td width="246">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                    <input name="fileToUpload" type="file" id="fileToUpload"> 
                                </td>
                                <td width="80"><button type="submit" name="upload" id="btnsbmit8" formaction="?action=socialmedia">Previous</button></td>
                                <td width="80"><button type="submit" name="upload" id="btnsbmit8" formaction="?action=estimates">Next</button></td>
                            </tr>
                        </table>
                    </form>
                <?php }
                    if(isset($_POST["upload"]) && $_FILES['fileToUpload']['size'] > 0)
                    {
                        $target_dir = "uploads/";
                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                        // Check if image file is a actual image or fake image
                        if(isset($_POST["upload"])) {
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                            if($check !== false) {
                                echo "File is an image - " . $check["mime"] . ".";
                                $uploadOk = 1;
                            } else {
                                echo "File is not an image.";
                                $uploadOk = 0;
                            }
                        }
                        // Check file size
                        if ($_FILES["fileToUpload"]["size"] > 2000000) {
                            echo "Sorry, your file is too large.";
                            $uploadOk = 0;
                        }
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $uploadOk = 0;
                        }
                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";
                        // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                $photoSQL = "INSERT INTO `upload` (`postID`, `imgLoc`) VALUES (".$_SESSION["postID"]." , '".$_FILES["fileToUpload"]["name"]."');";
                                echo $photoSQL;
                                $result = mysqli_query($conn, $photoSQL);
                                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    
                    } 
                    if($_GET["action"] == "estimates") { ?>
                        <form class="smart-green" role="form" method="post"> 
                            <label for="cost">Estimated Project Cost</label>
                            <input type="number" name="cost" value="">
                            <label for="time">Estimated Completion Time</label>
                            <input type="number" name="time" value="" placeholder="(in minutes)">
                            <button type="submit" name="images" id="btnsbmit9" formaction="?action=images">Previous</button>
                            <button type="submit" name="tips" id="btnsbmit10" formaction="?action=tips">Next</button>
                        </form>
                    <?php }
                    if($_GET["action"] == "tips") {
                        $sql5 = "UPDATE `posts` SET `estTime`='".$_POST["time"]."', `estCost`=".$_POST["cost"]." WHERE `postID`=".$_SESSION["postID"].";";
                        $result5 = mysqli_query($conn, $sql5); ?>
                <form class="smart-green" role="form" method="post">
                    <input type="text" name="tips" value="" placeholder="Project Tips"> 
                    <input type="text"name="tags"placeholder="enter tags, separated by a ','" value=''>
                    <button type="submit" name="tips" id="btnsbmit11" formaction="?action=estimates">Previous</button>
                    <button type="submit" name="preview" id="btnsbmit12" formaction="?action=preview">Next</button>
                </form>
                    <?php }
                    if($_GET["action"]=="preview"){
                        $sql6="UPDATE `posts` SET `tips`='".Input::get("tips")."', `tags`='".Input::get("tags")."' WHERE `postID`=".$_SESSION["postID"].";";
                        $result6 = mysqli_query($conn, $sql6);
                        
                        $sqlPrev = "SELECT * FROM `posts` WHERE `postID`=".$_SESSION["postID"].";";
                        $resultPrev = mysqli_query($conn, $sqlPrev);
                        
                        if(mysqli_num_rows($resultPrev) > 0) {
                            while($row = mysqli_fetch_assoc($resultPrev)) {
                                $title = $row["title"];
                                $user = $row["user"];
                                $desc = $row["description"];
                                $step = $row["steps"];
                                $material = $row["materials"];
                                $tips = $row["tips"];
                                $time = $row["estTime"];
                                $cost = $row["estCost"];
                                $tags = $row["tags"];
                            }
                        } ?>
                <h2><a href='?action=title'><?php echo $title; ?></a></h2>
                <p><a>By <?php echo $user; ?></a></p>
                <p><a href='?action=title'><?php echo $desc; ?></a></p>
                <?php 
                $newMat = explode("+", $material);
                $matArr = array();
                foreach($newMat as $mat) {
                    $newURL = explode(",", $mat);
                    $matArr[] = $newURL[0];
                    $matArr[] = $newURL[1];
                }
                print_r($matArr);
                ?>
                <?php }
                }
                ?>
            </div>
        </div>
    </body>
</html>
