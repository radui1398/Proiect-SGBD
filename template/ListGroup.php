<?php
/**
 * Created by PhpStorm.
 * User: radu
 * Date: 07.03.2019
 * Time: 15:30
 */

class ListGroup
{
    private $list;
    private $title;

    public function __construct($title, $list)
    {
        $this->title = $title;
        $this->list = $list;
    }

    public function generateGroup(){
        echo '
        <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action active" disabled>
        '.$this->title.'
        </button>';
        foreach($this->list as $item=>$link)
                    echo '<a class="list-group-item list-group-item-action" href="?page='.$link.'">'.$item.'</a>';
        echo '</div>';
    }
}