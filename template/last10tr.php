<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
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
                <div id="map"></div>
            </div>
        </div>

    </div>

</div>