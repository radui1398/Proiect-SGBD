<?php


class View
{
    private $selectArray;
    private $table;
    private $total;
    private $limit=100;
    private $pages;
    private $actualPage;
    private $offset;
    private $start;
    private $ident;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function getTotal(){
        Database::getInstance();
        $stid = oci_parse(Database::getConn(), "begin :total := manager.no_of_lines(:table); end;");
        oci_bind_by_name($stid, ":table", $this->table);
        oci_bind_by_name($stid, ":total", $this->total, 8, SQLT_INT);
        executeOci($stid,0);

        $this->pages = ceil($this->total / $this->limit);
        $this->offset = ($this->actualPage-1)*$this->limit;
    }

    public function getActualPage(){
        $this->actualPage = getVarFromPage("pageNr");
    }

    public function runView(){
        Database::getInstance();
        $arr = array();
        $start = $this->offset;
        $this->start = $start;
        $end = min(($this->offset + $this->limit), $this->total);
        $stid = oci_parse(Database::getConn(), "begin manager.select_data(:table,:start,:end,:arr); end;");
        oci_bind_by_name($stid, ":table", $this->table);
        oci_bind_by_name($stid, ":start", $start);
        oci_bind_by_name($stid, ":end", $end);

        oci_bind_array_by_name($stid, ":arr", $arr, 1000, 1000, SQLT_CHR);
        executeOci($stid,0);
        $this->selectArray = $arr;
    }

    public function generateView(){
        echo '<h5>Vizualizare tabela '.$this->table.':</h5>';
        echo '<table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>';
            $tableHead = explode('%',$this->selectArray[0]);
            array_shift($this->selectArray);
            $this->ident = $tableHead[0];
                foreach($tableHead as $th){
                    echo '<th>'.$th.'</th>';
                }
            echo '
                <th>Operatii</th>
            </tr>
          </thead>
          <tbody>';
        foreach ($this->selectArray as $key=>$data){
            $newArr = explode('%',$data);
            echo '<tr>';
            echo '<th scope="row">'.($this->start+$key + 1).'</th>';
            foreach($newArr as $td){
                echo '<td>'.$td.'</td>';
            }
            echo '<td style="display:flex;">
                <form method="POST" name="delete">
                  <input type="hidden" value="'.$this->ident.'" name="ident_del">
                  <input  type="hidden" value="'.$newArr[0].'" name="id_del">
                  <input  type="text" hidden value="'.$this->table.'" name="table_del">
                  <button type="submit" name="delete" class="btn btn-primary btn-sm mr-2">DELETE</button>
                </form>
                <form method="POST" name="update" action="index.php?page=update">
                  <input  type="hidden" value="'.$newArr[0].'" name="id">
                  <input  type="hidden" value="'.$this->table.'" name="table">
                  <input type="hidden" value="'.$this->ident.'" name="ident">';
            foreach($newArr as $inKey=>$input){
                echo '<input type="hidden" value="'.$input.'" name="'.$inKey.'">';
            }
            echo '
                  <button type="submit" name="update" class="btn btn-primary btn-sm">UPDATE</button>
                </form>
               </td></tr>';
        }
        echo '
          </tbody>
        </table>';

        echo '<div id="paging"><p>', ' Pagina ', $this->actualPage, ' din ', $this->pages , ' pagini', ' </p></div>';
        $prevlink = ($this->actualPage > 1) ? '<li class="page-item"><a class="page-link" href="?page='.getVarFromPage("page").'&table='.$this->table.'&pageNr='.($this->actualPage - 1).'">Prev</a></li>'
            :'<li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>';
        $first = ($this->actualPage > 1) ? '<li class="page-item"><a class="page-link" href="?page='.getVarFromPage("page").'&table='.$this->table.'&pageNr='.(1).'">First</a></li>'
            :'<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
        $nextlink = ($this->actualPage < $this->pages) ? '<li class="page-item"><a class="page-link" href="?page='.getVarFromPage("page").'&table='.$this->table.'&pageNr='.($this->actualPage + 1).'">Next</a></li>'
            :'    <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
        $last= ($this->actualPage < $this->pages) ? '<li class="page-item"><a class="page-link" href="?page='.getVarFromPage("page").'&table='.$this->table.'&pageNr='.($this->pages).'">Last</a></li>'
            :'    <li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';

        echo '
        <nav aria-label="Page navigation example">
          <ul class="pagination">'.
            $first.$prevlink.$nextlink.$last.'
          </ul>
        </nav>';
    }
}