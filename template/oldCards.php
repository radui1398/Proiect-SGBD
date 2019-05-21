<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php
                require_once("template/Proceduri.php");
                $print = new Proceduri();
                $print->selectOldCards();
                $print->generateOldCards("Carduri Expirate");
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