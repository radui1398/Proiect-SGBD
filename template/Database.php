<?php


class Database
{
    private static $instance = null;
    private static $conn = null;

    private function __construct()
    {
        $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))))";
        $conn = oci_connect("BMS", "BMS",$db);
        if (!$conn) {
            $m = oci_error();
            echo $m['message']. PHP_EOL;
            exit;
        }
        else {
            self::$conn = $conn;
        }

    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * @return false|resource
     */
    public static function getConn()
    {
        return self::$conn;
    }

}