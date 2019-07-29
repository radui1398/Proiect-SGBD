<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h6>SAFE</h6>
                <h6>Introduceti un ID pentru a afisa numele unei banci.</h6>
                <form class="form-inline" method="post">
                    <div class="form-group mb-2">
                        <label class="sr-only" for="sqltrue">SQL</label>
                        <input type="text" class="form-control" id="sqltrue" placeholder="SQL Here" name="sql">
                    </div>
                    <button type="submit" name="sqltrue" class="btn btn-primary custom-button mb-2 ml-2">RUN SQL</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h6>NOT SAFE</h6>
                <h6>A' AND 1=2 UNION SELECT FNAME FROM CLIENTS WHERE ID='5</h6>
                <form class="form-inline" method="post">
                    <div class="form-group mb-2">
                        <label class="sr-only" for="sqlfalse">SQL</label>
                        <input type="text" class="form-control" id="sqlfalse" placeholder="SQL Here" name="sql">
                    </div>
                    <button type="submit" name="sqlfalse" class="btn btn-primary custom-button mb-2 ml-2">RUN SQL</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_POST['sqlfalse'])){
    $id = $_POST['sql'];
    $query = 'BEGIN manager.sql_injection(:id,:result); END;';
    Database::getInstance();
    $stid = oci_parse(Database::getConn(), $query);
    oci_bind_by_name($stid, ':id', $id, 100);
    oci_bind_by_name($stid, ':result', $result, 100);
    oci_execute($stid);
    echo '<h3 class="mt-3">',$result,'</h3>';
}
if(isset($_POST['sqltrue'])){
    $id = $_POST['sql'];
    $query = 'BEGIN manager.sql_not_injection(:id,:result); END;';
    Database::getInstance();
    $stid = oci_parse(Database::getConn(), $query);
    oci_bind_by_name($stid, ':id', $id, 100);
    oci_bind_by_name($stid, ':result', $result, 100);
    oci_execute($stid);
    echo '<h3 class="mt-3">',$result,'</h3>';
}
?>