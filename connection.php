<?php
class Database
{
    public static function operation($q, $type)
    {
        $connection = new mysqli("localhost", "jadetime_crm_root", "ri9g7xDYGCcv","jadetime_ums", "3306");
       

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
