<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5>Data ultimei tranzactii</h5>
                <form class="form-inline" method="GET" action="index.php">
                    <input type="hidden" name="page" value="atm_last_transaction">
                    <div class="form-group mr-3">
                        <input type="number" class="form-control" id="atm_id" name="atm_id" placeholder="ID ATM">
                    </div>
                    <button type="submit" class="btn btn-primary custom-button">Submit</button>
                </form>
                <?php
                if(isset($_GET['atm_id'])){
                    require_once("template/PFunc.php");
                    $print = new PFunc();
                    $print->atm_last_transaction($_GET['atm_id']);
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="map"></div>
            </div>
        </div>

    </div>

</div>