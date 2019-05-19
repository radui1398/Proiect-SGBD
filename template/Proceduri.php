<?php


class Proceduri
{
    private $selectArray;
    public function __construct()
    {

    }

    public function generateTransaction($title){
        echo '<h5>'.$title.':</h5>';
        echo '<table class="table table-hover ">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Card ID</th>
              <th scope="col">ATM ID</th>
              <th scope="col">Data tranzactiei</th>
              <th scope="col">Suma</th>
            </tr>
          </thead>
          <tbody>';
        foreach ($this->selectArray as $key=>$data){
            $newArr = explode('%',$data);
            echo '<tr>';
            echo '<th scope="row">'.($key+1).'</th>';
            foreach($newArr as $td){
                echo '<td>'.$td.'</td>';
            }
            echo '</tr>';
        }
        echo '
          </tbody>
        </table>';
    }

    public function selectTransactions(){
        Database::getInstance();
        $arr = array();
        $stid = oci_parse(Database::getConn(), "begin manager.show_last_transactions(:arr); end;");
        oci_bind_array_by_name($stid, ":arr", $arr, 11, 100, SQLT_CHR);
        executeOci($stid,0);
        $this->selectArray = $arr;
    }

    public function selectOldCards(){
        Database::getInstance();
        $arr = array();
        $stid = oci_parse(Database::getConn(), "begin manager.show_due_date(:arr); end;");
        oci_bind_array_by_name($stid, ":arr", $arr, 10000, 100, SQLT_CHR);
        executeOci($stid,0);
        $this->selectArray = $arr;
    }

    public function generateOldCards($title){
        echo '<h5>'.$title.':</h5>';
        echo '<input type="text" id="searchByName" onkeyup="searchCardByName()" placeholder="Cauta dupa Nume">';
        echo '<table class="table table-hover " id="cardTable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nume Client</th>
              <th scope="col">Card ID</th>
              <th scope="col">Data EXP</th>
            </tr>
          </thead>
          <tbody>';
        foreach ($this->selectArray as $key=>$data){
            $newArr = explode('%',$data);
            echo '<tr>';
            echo '<th scope="row">'.($key+1).'</th>';
            foreach($newArr as $td){
                echo '<td>'.$td.'</td>';
            }
            echo '</tr>';
        }
        echo '
          </tbody>
        </table>';
    }

    public function generateInput()
}