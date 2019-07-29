<?php


class PFunc
{
    private $selectArray;

    public function atm_last_transaction($atm_id){
        Database::getInstance();
        $sql = "BEGIN :transaction := manager.atm_last_transaction(:atm_id); END;";
        $stmt = oci_parse(Database::getConn(),$sql);

        oci_bind_by_name($stmt, ":atm_id", $atm_id);
        oci_bind_by_name($stmt, ":transaction", $result, 500, SQLT_CHR);

        executeOci($stmt,0);
        echo '
                <div class="alert '.(($result=="ID-ul ATM-ului este invalid sau nu au fost realizate tranzactii.")?('alert-danger'):('alert-success')).' alert-dismissible fade show mt-3" role="alert">
                  <strong>Data ultimei tranzactii:</strong> '.$result.'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
    }


    public function responsible_manager(){
        Database::getInstance();
        $sql = "BEGIN :result := manager.responsible_manager(); END;";
        $stmt = oci_parse(Database::getConn(),$sql);

        oci_bind_by_name($stmt, ":result", $result, 500, SQLT_CHR);

        executeOci($stmt,0);
        echo '
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                  <strong>Cel mai responsabil manager:</strong> '.$result.'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
    }

    public function get_no_transactions($cnp){
        Database::getInstance();
        $sql = "BEGIN :result := manager.get_no_transactions(:cnp); END;";
        $stmt = oci_parse(Database::getConn(),$sql);

        oci_bind_by_name($stmt, ":cnp", $cnp);
        oci_bind_by_name($stmt, ":result", $result, 38, SQLT_NUM);

        executeOci($stmt,0);
        echo '
                <div class="alert '.(($result==6710334)?('alert-warning'):('alert-success')).' alert-dismissible fade show mt-3" role="alert">
                  <strong>Numarul de tranzactii:</strong> '.(($result==6710334)?('Client inexistent/fara tranzactii.'):($result)).'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
    }

    public function select_exp_transactions(){
        Database::getInstance();
        $arr = array();
        $stid = oci_parse(Database::getConn(), "begin :arr := manager.get_rejected_transactions(); end;");
        oci_bind_array_by_name($stid, ":arr", $arr, 100000, 1000, SQLT_CHR);
        executeOci($stid,0);
        $this->selectArray = $arr;
    }

    public function generate_exp_transactions($title){
        echo '<h5>'.$title.':</h5>';
        echo '<input type="text" id="searchByName" onkeyup="searchCardByName()" placeholder="Cauta dupa ID Tranzactie">';
        echo '<table class="table table-hover " id="cardTable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">ID Tranzactie</th>
              <th scope="col">Data EXP Card</th>
              <th scope="col">Data Tranzactiei</th>
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
}