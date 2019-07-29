<div class="card">
    <div class="card-body">
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['delete'])){
                Database::getInstance();
                $table = $_POST['table_del'];
                $stid = oci_parse(Database::getConn(), "DELETE FROM ".$table." WHERE ".$_POST['ident_del']." = :id");
                oci_bind_by_name($stid, ":id", $_POST['id_del'],100);
                executeOci($stid,0);
                echo'
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  Stergerea a reusit!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
            }
        }
        require_once("template/View.php");
        $view = new View(getVarFromPage("table"));
        $view->getActualPage();
        $view->getTotal();
        $view->runView();
        $view->generateView();

        ?>
    </div>
</div>
</div>
