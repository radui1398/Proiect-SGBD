<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php
                require_once("template/PFunc.php");
                $print = new PFunc();
                $print->select_exp_transactions();
                $print->generate_exp_transactions("Tranzactii invalide");
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