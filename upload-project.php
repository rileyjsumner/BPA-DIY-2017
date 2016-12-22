<!DOCTYPE html>
<?php 
    require_once 'init.php';
    $conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $user = new User();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </head>
    <body>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
            </ul>
        </nav>
        <div id="main">
            <div class="col-1">
                    <form>
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
                    </form>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                    <form class="my-form" role="form" method="post">
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
                        <script type="text/javascript">
                            jQuery(document).ready(function() {
                                $('.my-form .add-box').click(function() {
                                  var n = $('.text-box').length + 1;

                                  var box_html = $('<tr><td><p class="text-box"><input type="text" name="materials" value="" id="materials' + n + '" /></p></td><td><p class="text-box"> <input type="text" name="url' + n + '" value="" id="url' + n + '" /><a href="#" class="remove-box">Remove</a></p></td></tr>');
                                  box_html.hide();
                                  $('.my-form .materialstab tr:last').after(box_html);
                                  box_html.fadeIn('slow');
                                  return false;
                                });
                                $('.my-form').on('click', '.remove-box', function(){
                                    $(this).parent().css( 'background-color', '#FF6C6C' );
                                    $(this).parent().fadeOut("slow", function() {
                                        $(this).remove();
                                        $('.box-number').each(function(index){
                                            $(this).text( index + 2 );
                                        });
                                    });
                                    return false;
                                });
                            });
                            $(document).ready( function () {

                                var nbtextbox = $('input[name="materials"]').length;
                                var box_2 = $('<input type="hidden" name="elem1" value="'+nbtextbox+'">');
                                $('.my-form p.text-box:last').after(box_2);

                           });
                        </script>
                    </form>
                    <form>
                        <p class="text-box">
                            <label for="steps">Steps</label>
                            <input type="text" name="steps" value="" />
                            <a class="add-box2" href="#">Add More</a>
                        </p>
                        <!--<script type="text/javascript">
                        jQuery(document).ready(function($){
                            $('.my-form .add-box2').click(function(){
                                var n = $('.text-box').length + 1;

                                var box_html = $('<p class="text-box"><input type="text" name="steps" value="" id="steps' + n + '" /> <a href="#" class="remove-box">Remove</a></p>');
                                box_html.hide();
                                $('.my-form p.text-box:last').after(box_html);
                                box_html.fadeIn('slow');
                                return false;
                            });
                            $('.my-form').on('click', '.remove-box', function(){
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
                        $(document).ready( function () {

                            var nbtextbox = $('input[name="steps"]').length;
                            var box_2 = $('<input type="hidden" name="elem2" value="'+nbtextbox+'">');
                            $('.my-form p.text-box:last').after(box_2);

                       });
                        </script>-->
                    </form>
                    <form>  
                        <label for="facebook">Facebook</label><input type="text" name="facebook" value=""><br>
                        <label for="twitter">Twitter</label><input type="text" name="twitter" value=""><br>
                        <label for="instagram">Instagram</label><input type="text" name="instagram" value=""><br>
                        <label for="pinterest">Pinterest</label><input type="text" name="pinterest" value=""><br>
                        <label for="snapchat">Snapchat</label><input type="text" name="snapchat" value=""><br>
                        <label for="google">Google+</label><input type="text" name="google" value=""><br>
                        <p><input type="submit" value="Submit" name="save" /></p>
                    </form>
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>

                    <?php
                    $file = "";
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "File is not an image.";
                            $uploadOk = 0;
                        }
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 500000) {
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
                            $file.=basename( $_FILES["fileToUpload"]["name"]);
                            echo "The file ". $file . " has been uploaded.";
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                    ?>
                    <?php 
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

                        $_SESSION['title'] = Input::get();
                        $_SESSION['description'] = Input::get();
                        $_SESSION['materials'] = Input::get();
                        $_SESSION['steps'] = Input::get();
                        $_SESSION['facebook'] = Input::get();
                        $_SESSION['twitter'] = Input::get();
                        $_SESSION['instagram'] = Input::get();
                        $_SESSION['pinterest'] = Input::get();
                        $_SESSION['snapchat'] = Input::get();
                        $_SESSION['google'] = Input::get();
                    }
                    ?>
                </div>
            </div>
    </body>
</html>
