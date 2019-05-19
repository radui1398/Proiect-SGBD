<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php
                $form = new Form();
                $form->setLabels(array("NAME" => "Numele Bancii", "ADDRESS" => "Adresa Bancii"));
                $form->create("ATM","ATM_NO");
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