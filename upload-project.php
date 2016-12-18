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
        <script type="text/javascript" src="//code.jquery.com/jquery-latest.js"></script>
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
            
            <div class="my-form">
                <form role="form" method="post">
                    <p class="text-box">
                        <label for="box1">Materials</label>
                        <input type="text" name="materials" value="" />
                        <a class="add-box" href="#">Add More</a>
                    </p>
                    <p><input type="submit" value="Submit" /></p>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        jQuery(document).ready(function($){
            $('.my-form .add-box').click(function(){
                var n = $('.text-box').length + 1;
                
                var box_html = $('<p class="text-box"><input type="text" name="materials' + n + '" value="" id="materials' + n + '" /> <a href="#" class="remove-box">Remove</a></p>');
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
        </script>
    </body>
</html>
