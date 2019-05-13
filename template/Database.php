<?php


class Database
{
    private static $instance = null;
    private static $conn = null;

    private function __construct()
    {
        phpinfo();
        $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 000.000.000.000)(PORT = 1521)))(CONNECT_DATA=(SID=XXX)))";
        $conn = oci_connect("BMS", "BMS",$db);
        if (!$conn) {
            $m = oci_error();
            echo $m['message']. PHP_EOL;
            exit;
        }
        else {
            print "Oracle database connection online". PHP_EOL;
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