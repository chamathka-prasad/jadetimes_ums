<?php
class Database
{
    public static function operation($q, $type)
    {
      
       

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
