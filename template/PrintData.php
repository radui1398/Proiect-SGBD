<?php


class PrintData
{
    private $selectArray;
    public function __construct()
    {

    }

    public function generate($title){
        echo '<h5>'.$title.':</h5>';
        foreach($this->selectArray as $selOpt){
            echo '<p>'.$selOpt.'</p>';
        }
    }

    public function select(){
        $this->selectArray = array("1. Tada","2. Aha");
    }
}