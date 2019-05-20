<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php
                $form = new Form();
                $form->setLabels(array("CARD_ID" => "ID Card", "ATM_ID" => "ID ATM", "SUM" => "Suma","TRANSACTION_DATE"=>"sysdate", "TRANSACTION_TYPE"=>"Tipul tranzactiei"));
                $form->create("TRANSACTION","ID");
                $form->waitForPost();
                $form->generate(); ?>
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