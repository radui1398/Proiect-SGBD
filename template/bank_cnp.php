<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5>Afiseaza banca clientului</h5>
                <form class="form-inline" method="GET" action="index.php">
                    <input type="hidden" name="page" value="bank_cnp">
                    <div class="form-group mr-3">
                        <input type="number" min="1000000000000" max="2999999999999" class="form-control" id="cnp" name="cnp" placeholder="CNP">
                    </div>
                    <button type="submit" class="btn btn-primary custom-button">Submit</button>
                </form>
                <?php
                if(isset($_GET['cnp'])){
                    require_once("template/Proceduri.php");
                    $print = new Proceduri();
                    $print->selectBank($_GET['cnp']);
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