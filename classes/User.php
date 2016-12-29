<?php

class User {
    
    static $material = 0;
    static $step = 0;
    static $id = null;
    
    public function getID($conn, $username) {
        $sql = "SELECT `userID` FROM `users` WHERE `username`='$username';";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                return $row["userID"];
            }
        } 
    }
    public function islogin($conn, $username) {
        $sql = "SELECT `login` FROM `users` WHERE `username`='$username';";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                return $row["login"] == "true" ? true : false;
            }
        }
    }
    public function follow($conn, $user, $follow) {
        $sql = "INSERT INTO `follows` (`user`, `follow`) VALUES ('$user', '$follow');";
        $result = mysqli_query($conn, $sql);
        return $result ? true : false;
    }
    public function unfollow($conn, $user, $follow) {
        $sql = "DELETE FROM `follows` WHERE `user`='$user' AND `follow`='$follow';";
        $result = mysqli_query($conn, $sql);
        return $result ? true : false;
    }
    public function deletePost($conn, $postID) {
        $sql = "DELETE FROM `posts` WHERE `postID`=$postID;";
        $result = mysqli_query($conn, $sql);
        return $result ? true : false;
    }
    public function login($conn, $username, $password) {
        $sql = "SELECT * FROM `users` WHERE `username`='$username';";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            if($row = mysqli_fetch_assoc($result)) {
                $salt = $row["salt"];
                $pass = Hash::make($password, $salt);
                $len = strlen($row["password"]);
                $check = Hash::check($password, $salt);
                if(substr($check, 0, $len) == $row["password"]) {
                    
                    $sql2 = "UPDATE `users` SET `login`='true' WHERE `username`='$username';";
                    $result2 = mysqli_query($conn, $sql2);
                    return true;
                } 
            }
            return false;
        } else {
            $sql3 = "SELECT * FROM `users` WHERE `email`='$username';";
            $result3 = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result3) > 0) {
                if($row2 = mysqli_fetch_assoc($result3)) {
                    $salt2 = $row2["salt"];
                    $pass2 = Hash::make($password, $salt2);
                    $len2 = strlen($row2["password"]);
                    $check2 = Hash::check($password, $salt2);
                    if(substr($check2, 0, $len2) == $row2["password"]) {

                        $sql4 = "UPDATE `users` SET `login`='true' WHERE `email`='$username';";
                        $result4 = mysqli_query($conn, $sql2);
                        return true;
                    } 
                }
            } else {
                //fail
            }
        }
    }
    
    public function insert($conn, $table, $col = array(), $val = array()) {
        // INSERT INTO `table` (`row1`) VALUES (`data1`);
        $sql="INSERT INTO `$table` (";
        $len1 = count($col);
        for($x = 0; $x < $len1-1; $x++) {
            $sql.="`$col[$x]`,";
        }
        $len1--;
        $sql.="`$col[$len1]`) VALUES (";
        $len2 = count($val);
        for($y = 0; $y < $len2-1; $y++) {
            $sql.="'$val[$y]',";
        }
        $len2--;
        $sql.="'$val[$len2]');";
        echo $sql;
        return mysqli_query($conn, $sql)? true: false;
    }
    public function select($conn, $table, $col = array()) {
        // SELECT `row` FROM `table` WHERE (`row1`)=1;
        $sql = "SELECT ";
        $len = count($col);
        for($x = 0; $x<$len-1; $x++) {
            $sql.="`$col[$x]`,";
        }
        $len--;
        $sql.="`$col[$len]`";
        $sql.=" FROM `$table`;";
        
        $len++;
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            $returnData = array();
            while($row = mysqli_fetch_assoc($result)) {
                for($y = 0;$y<$len;$y++) {
                    $returnData[] = $row[$col[$y]];
                }
            }
        }
        
        return $returnData;
        
    }
    public function update() {
        // UPDATE `table` SET `row1`='value' WHERE `row1`='value');
        
    }
    public function setPostID($paramid) {
        self::$id = $paramid; 
    }
    public function getPostID() {
        return self::$id;
    }
}
