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

    public function selectBank($cnp){
        Database::getInstance();
        $stmt = oci_parse(Database::getConn(), "begin manager.bank_cnp(:cnp,:result); end;");
        oci_bind_by_name($stmt, ':result', $result, 100);
        oci_bind_by_name($stmt, ':cnp', $cnp, 100);
        executeOci($stmt,0);
        echo '
                <div class="alert '.(($result=="Acest client nu exista.")?('alert-danger'):('alert-success')).' alert-dismissible fade show mt-3" role="alert">
                  <strong>Clientul apartine bancii:</strong> '.$result.'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
    }

    public function selectATM(){
        Database::getInstance();
        $arr = array();
        $stid = oci_parse(Database::getConn(), "begin manager.top_used_atm(:arr); end;");
        oci_bind_array_by_name($stid, ":arr", $arr, 11, 100, SQLT_CHR);
        executeOci($stid,0);
        $this->selectArray = $arr;
    }

    public function generateATM($title){
        echo '<h5>'.$title.':</h5>';
        echo '<table class="table table-hover ">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">ID_ATM</th>
              <th scope="col">Adresa ATM</th>
              <th scope="col">Nr. Tranzactii</th>
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
    public function selectTopBank(){
        Database::getInstance();
        $arr = array();
        $stid = oci_parse(Database::getConn(), "begin manager.top_bank(:arr); end;");
        oci_bind_array_by_name($stid, ":arr", $arr, 11, 10000, SQLT_CHR);
        executeOci($stid,0);
        $this->selectArray = $arr;
    }

    public function generateTopBank($title){
        echo '<h5>'.$title.':</h5>';
        echo '<table class="table table-hover ">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nume Banca</th>
              <th scope="col">Adresa Bancii</th>
              <th scope="col">Nr. Conturi</th>
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

    public function deleteBank(){
        Database::getInstance();
        $arr = array();
        $stid = oci_parse(Database::getConn(), "begin manager.delete_low_bank(); end;");
        executeOci($stid,"Stergerea a reusit!");
        $this->selectArray = $arr;
    }
    public function deleteOldTransaction(){
        Database::getInstance();
        $arr = array();
        $stid = oci_parse(Database::getConn(), "begin manager.delete_old_transactions(12); end;");
        executeOci($stid,"Stergerea a reusit!");
        $this->selectArray = $arr;
    }
}