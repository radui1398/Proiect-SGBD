<?php


class Form
{
    private $form;
    private $labels = null;

    public function create($table_name)
    {
        $query = 'select * from USER_TAB_COLUMNS where TABLE_NAME LIKE \''.$table_name.'\'';
        Database::getInstance();
        $stid = oci_parse(Database::getConn(), $query);
        oci_execute($stid);

        $form = "<form>";
        $i = 0;
        while ($row = oci_fetch_array($stid)) {
            $column_name = oci_result($stid, "COLUMN_NAME");
            if($this->labels){
                foreach($this->labels as $oldLabel => $newLabel){
                    if($column_name == $oldLabel)
                        $column_name = $newLabel;
                }
            }
            if($column_name != "ID") {
                ($i%2==0) ? $form .= '<div class="form-row">' : $form .= '';
                $form .= '<div class="form-group col-md-6">';
                $form .= '<label for="form_' . $column_name . '">' . $column_name . '</label>';
                $form .= '<input type="text" class="form-control" id="form_' . $column_name . '" name="form_' . $column_name . '">';
                $form .= '</div>';
                ($i%2==1) ? $form .= '</div>' : $form .= '';
                $i++;
            }
        }
        ($i%2 == 1) ? $form .='</div>' : $form .='';
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

    public function generate(){
        echo $this->form;
    }
}