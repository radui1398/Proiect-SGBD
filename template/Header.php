<?php
/**
 * Created by PhpStorm.
 * User: radu
 * Date: 07.03.2019
 * Time: 13:51
 */

class Header
{
    private $pageName;

    public function __construct($name)
    {
        $this->pageName = $name;
    }

    public function generateHeader()
    {
        echo '
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>'.$this->pageName.'</title>
                <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
                <link rel="stylesheet" href="css/main.css">
            </head>';
    }
}