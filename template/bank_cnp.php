<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form class="form-inline" method="GET">
                    <div class="form-group mr-3">
                        <input type="password" class="form-control" id="cnp" placeholder="CNP">
                    </div>
                    <button type="submit" class="btn btn-primary custom-button">Submit</button>
                </form>
                <?php
                require_once("template/Proceduri.php");
                $print = new Proceduri();
                $print->selectTransactions();
                $print->generateTransaction("Ultimele 10 Tranzactii");
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                Sidebar
            </div>
        </div>

    </div>

</div>