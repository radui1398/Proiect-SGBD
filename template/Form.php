<?php


class Form
{
    private $form;
    private $labels = null;
    private $dataToInsert = array();
    private $table_name;
    private $postColumn = array();
    private $idName;

    public function create($table_name,$idName)
    {
        $this->idName = $idName;
        $this->table_name = $table_name;
        $query = 'select * from USER_TAB_COLUMNS where TABLE_NAME LIKE \'' . $table_name . '\'';
        Database::getInstance();
        $stid = oci_parse(Database::getConn(), $query);
        oci_execute($stid);

        $form = "<form method='post'>";
        $i = 0;
        while ($row = oci_fetch_array($stid)) {
            $column_name = oci_result($stid, "COLUMN_NAME");
            array_push($this->dataToInsert, $column_name);
            if ($this->labels) {
                foreach ($this->labels as $oldLabel => $newLabel) {
                    if ($column_name == $oldLabel)
                        $column_name = $newLabel;
                }
            }
            if ($column_name != $idName) {
                array_push($this->postColumn, $column_name);
                ($i % 2 == 0) ? $form .= '<div class="form-row">' : $form .= '';
                $form .= '<div class="form-group col-md-6">';
                $form .= '<label for="form_' . $column_name . '">' . $column_name . '</label>';
                $form .= '<input type="text" class="form-control" id="' . $this->getPostName($column_name) . '" name="' . $this->getPostName($column_name) . '">';
                $form .= '</div>';
                ($i % 2 == 1) ? $form .= '</div>' : $form .= '';
                $i++;
            } else {
                array_pop($this->dataToInsert);
            }
        }
        ($i % 2 == 1) ? $form .= '</div>' : $form .= '';
        $form .= '<button type="submit" class="btn btn-primary custom-button">Trimite</button>';
        $form .= '</form>';
        $this->form = $form;
    }

    /**
     * @param null $labels
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;
    }


    /**
     * @return string
     */
    public function getForm()
    {
        return $this->form;
    }

    public function generate()
    {
        echo $this->form;
    }

    public function waitForPost()
    {
        if (!empty($_POST)) {


            $postData = array();
            foreach ($this->postColumn as $column) {
                array_push($postData, $_POST[$this->getPostName($column)]);
            }



        $sql = "BEGIN manager.insert_into_table(:table, :id, :columns, :data, :result ); END;";
        Database::getInstance();
        $stmt = oci_parse(Database::getConn(), $sql);

        $result = "";
        oci_bind_by_name($stmt, ':table', $this->table_name, 50);
        oci_bind_by_name($stmt, ':id', $this->idName, 50);
        oci_bind_by_name($stmt, ':result', $result, 100);
        oci_bind_array_by_name($stmt, ":columns", $this->dataToInsert, count($this->dataToInsert), -1, SQLT_CHR);
        oci_bind_array_by_name($stmt, ":data", $postData, count($postData), -1, SQLT_CHR);


            // bind the ref cursor
        // $refcur = oci_new_cursor(Database::getConn());
        //oci_bind_by_name($stmt, ':REFCUR', $refcur, -1, OCI_B_CURSOR);

        // execute the statement
        ini_set('display_errors', '0');
        oci_execute($stmt);
        if (oci_error($stmt))
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Eroare:</strong> ' . oci_error($stmt)['message'] . '
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
        else
            echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  '.$result.'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
            ini_set('display_errors', '1');
        }

        // treat the ref cursor as a statement resource
        //oci_execute($refcur, OCI_DEFAULT);
        //oci_fetch_all($refcur, $employeerecords, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        // return the results
        //return ($employeerecords);
    }

    private function getPostName($string)
    {
        return 'form_' . preg_replace('/\s+/', '', $string);
    }
}