<?php
/**
 * Created by PhpStorm.
 * User: radu
 * Date: 12.03.2019
 * Time: 10:21
 */


function getVarFromPage($name){
    if(isset($_GET[$name])){
        return $_GET[$name];
    }
    else return "";
}

function getActive(){
    switch(getVarFromPage("page")){
        case "":
            return "Home";
            break;
        case "join":
            return "Join";
            break;
    }
}