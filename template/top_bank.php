<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php
                require_once("template/Proceduri.php");
                $print = new Proceduri();
                $print->selectTopBank();
                $print->generateTopBank("TOP 5 Banci");
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