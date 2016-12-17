<?php 

class Config {
    public function create($conn, $date, $start, $end, $location, $notes) {
        $sql = "INSERT INTO `appt` (`date`, `start`, `end`, `location`, `notes`) VALUES ('{$date}', '{$start}', '{$end}', '{$location}', '{$notes}');";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
    public function checkdate($apptDate, $currentDate) {
        return ($apptDate < $currentDate) ? false : true;
    }
}