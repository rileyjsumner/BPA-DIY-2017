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
        <link rel='stylesheet' type='text/css'href='diy.css'>
        <meta charset="UTF-8">
        <title>Home</title>
    </head>
    <body>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
            </ul>
        </nav>
        <?php
            $sql = "SELECT * FROM `ideas`;";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                echo '<table>';
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr><td>'.$row["name"].'</td><td>'.$row["description"].'</td></tr>';
                }
                echo '</table>';
            }
        ?>
    </body>
</html>
