<?php
class Database
{
    public static function operation($q, $type)
    {
      
         $connection = new mysqli("62.72.58.224", "ums1", "ums@12345678","jade-times-db", "3306");
        //  $connection = new mysqli("localhost", "root", "12345678","jade_times", "3306");

        if ($type == "iud") {
            $connection->query($q);
            $connection->close();
        } else {
            $resultset = $connection->query($q);
            $connection->close();
            return $resultset;
        }
    }
}
