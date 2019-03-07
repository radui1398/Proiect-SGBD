<?php
/**
 * Created by PhpStorm.
 * User: radu
 * Date: 07.03.2019
 * Time: 14:05
 */

class Menu
{
    private $menuOptions = array("Home","About Us","Contact");
    private $menuType;

    public function __construct($type){
        $this->menuType = $type;
    }

    public function generateMenu($active){
        if($this->menuType == 1){
            echo '
            <ul class="ul-menu">';
            $i=1;
            foreach($this->menuOptions as &$opt) {
                if($active == $i){
                    $activeOpt = "active";
                }
                else{
                    $activeOpt = "";
                }
                $i++;
                echo '
                    <li class="li-menu ' . $activeOpt . '">
                        <a href="#">' . $opt . '</a>
                    </li>                   
                ';
            }
            echo '</ul>';
        }
    }
}