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
    
    if(Token::check(Verify::get('token'))) {
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </head>
    <body>
         <div class="header">
        <img src="Pictures/DIY header.jpg" alt=""/>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="active"><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
                <li><a href="login-register.php">Login/Register</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>  
        </nav>
        <div class="row">
            <div class="col-2">
                <?php 
                    if($_GET['action'] == "title" || $_GET['action'] == null) { 
                        $_GET['action'] = "title"; ?>
                        <form class="smart-green" method="POST" role="form" class="title" method="POST" action="?action=materials">
                            <table>
                                <tr>
                                    <td>
                                        <label for="title">Project Title</label>
                                        <input type="text" name="title" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="description">Description</label>
                                        <textarea name="description"></textarea>
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

                                  var box_html = $('<tr><td><p class="text-box"><input type="text" name="materials" value="" id="materials' + n + '" /><a href="#" class="remove-box">Remove</a></p></td><td><p class="text-box"> <input type="text" name="url' + n + '" value="" id="url' + n + '" /><a href="#" class="remove-box">Remove</a></p></td></tr>');
                                  box_html.hide();
                                  $('.smart-green .materialstab tr:last').after(box_html);
                                  box_html.fadeIn('slow');
                                  return false;
                                });
                                $('.smart-green').on('click', '.remove-box', function(){ //remove box
                                    $(this).parent().css( 'background-color', '#FF6C6C' );
                                    $(this).parent().fadeOut("slow", function() {
                                        $(this).remove();
                                        $('.box-number').each(function(index){
                                            $(this).text( index + 1 );
                                        });
                                    });
                                    return false;
                                });
                            });
                            $("#btnsbmit2").click( function () { //calculate # of elements, set form data

                                var textboxcount = document.getElementsByName("materials").length;
                                var box = $('<input type="hidden" name="elem1" value="'+textboxcount+'">');
                                $('.smart-green p.text-box:last').after(box);

                           });
                        </script>
                    </form>
                <?php } else if($_GET['action'] == "steps") { 
                    $elem1 = Input::get("elem1");
                    ?>
                    <form class="smart-green" role="form" action="?action=socialmedia" method="POST">
                        <table class="materialstab" method="POST" role="form" class="materialstab" style="border:1px solid">
                            <tr>
                                <td>
                                    <p class="text-box">
                                        <label for="steps">Steps</label>
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

                                var box_html = $('<tr><td><p class="text-box"><input type="text" name="steps" value="" id="steps' + n + '" /> <a href="#" class="remove-box">Remove</a></p></td></tr>');
                                box_html.hide();
                                $('.smart-green .materialstab tr:last').after(box_html);
                                box_html.fadeIn('slow');
                                return false;
                            });
                            $('.smart-green').on('click', '.remove-box', function(){
                                $(this).parent().css( 'background-color', '#FF6C6C' );
                                $(this).parent().fadeOut("slow", function() {
                                    $(this).remove();
                                    $('.box-number').each(function(index){
                                        $(this).text( index + 1 );
                                    });
                                });
                                return false;
                            });

                        });
                        $("#btnsbmit4").click( function () { //calculate # of elements, set form data

                            var textboxcount2 = document.getElementsByName("steps").length;
                            var box_2 = $('<input type="hidden" name="elem2" value="'+textboxcount2+'">');
                            $('.smart-green p.text-box:last').after(box_2);

                        });
                        </script>
                    </form>
                <?php } else if($_GET['action'] == "socialmedia") { 

                    ?>
                    <form class="smart-green" role="form" action="?action=images" method="POST">  
                        <label for="facebook">Facebook</label><input type="text" name="facebook" value=""><br>
                        <label for="twitter">Twitter</label><input type="text" name="twitter" value=""><br>
                        <label for="instagram">Instagram</label><input type="text" name="instagram" value=""><br>
                        <label for="pinterest">Pinterest</label><input type="text" name="pinterest" value=""><br>
                        <label for="snapchat">Snapchat</label><input type="text" name="snapchat" value=""><br>
                        <label for="google">Google+</label><input type="text" name="google" value=""><br>
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

                    $sql4 = "UPDATE `users` WHERE `userID`=$userID SET "
                            . "`facebook`='$facebook', "
                            . "`twitter`='$twitter', "
                            . "`instagram`='$instagram'"
                            . "`pinterest`='$pinterest'"
                            . "`snapchat`='$snapchat'"
                            . "`google`='$google'";

                    $result4 = mysqli_query($conn, $sql4);
                    ?>
                    <form class="smart-green" role="form" action="preview.php" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <button type="submit" name="prev" id="btnsbmit7" formaction="?action=socialmedia">Previous</button>
                        <button type="submit" name="preview" id="btnsbmit8" formaction="preview.php">Preview</button>
                    </form>
                <?php } 
                $file = "";
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) { 
                        $uploadOk = 1;
                    } else {
                        $uploadOk = 0;
                    }
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $file.=basename( $_FILES["fileToUpload"]["name"]);
                    } 
                }
                if(Input::get("submit")) {
                    /*$imgData = file_get_contents($file);
                    $size = getimagesize($file);

                    $sql = sprintf("INSERT INTO `images` (image_type, image, image_size, image_name) VALUES ('%s', '%s', '%d', '%s')",
                        mysqli_real_escape_string($conn, $size['mime']), mysqli_real_escape_string($conn, $imgData), $size[3], mysqli_real_escape_string($conn, $_FILES['userfile']['name'])
                    );
                    mysqli_query($conn, $sql);

                    $sql2 = "SELECT image FROM `images` WHERE image_id=0";
                    $result = mysqli_query($conn, "$sql2");
                    header("Content-type: image/jpeg");
                    echo mysqli_result($conn, $result, 0);*/

                    for($x = 1; $x < Input::get('elem1'); $x++) {

                    }
                }
                ?>

            </div>
        </div>
    </body>
</html>
